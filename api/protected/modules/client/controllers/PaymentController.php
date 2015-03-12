<?php

class PaymentController extends Controller
{

    public function actionIndex($id)
    {
        $coupon_id = $this->getParam('coupon_sid');
        $coupon_id = $coupon_id ? $coupon_id : 0;
        $order_obj = Orders::model()->findByPk($id);
        if ($order_obj && $order_obj->status == ORDER_STATUS_PAY) {
            $client_obj = Clients::model()->findByPk($this->uid);
            $coupon_obj = ClientTicket::model()->with('ticket')->findByPk($coupon_id);
            $deduction = $order_obj->order_income;
            if ($coupon_obj && $coupon_obj->client_id == $this->uid && $coupon_obj->status == 1 && $coupon_obj->expire > time()) {
                $coupon_name = $coupon_obj->ticket->name;
                $deduction = $order_obj->order_income - $coupon_name;
                $deduction = ($deduction > 0) ? $deduction : 0;               
            } 
            $account_balance = $client_obj->account_balance - $deduction;
            
            if ($account_balance >= 0) {
                // 开启事务处理
                $transaction = Yii::app()->db->beginTransaction();
                // 修改订单状态
                $order_obj->status = ORDER_STATUS_END;
                $order_obj->last_update = time();
                if ($order_obj->save()) {
                    $this->setApiLastUpdate('order', 'driver', $order_obj->driver_id);
                    $this->setApiLastUpdate('order', 'client', $order_obj->client_id);
                    
                    // 修改账户余额
                    $client_obj->account_balance = $account_balance;
                    $client_obj->last_update = time();
                    $client_obj->setScenario('modify_balance');
                    if ($client_obj->save()) {
                        // 支付记录
                        $model = new PayLog();
                        $model->uid = $this->uid;
                        $model->amount = $deduction;
                        $model->order_id = $order_obj->id;
                        $model->coupon_id = $coupon_id;
                        if ($model->save()) {
                            // 修改优惠券状态
                            if ($coupon_obj) {
                                $coupon_obj->status = 2;
                                $coupon_obj->order_id = $order_obj->id;
                                $coupon_obj->last_update = time();
                                if ($coupon_obj->save()) {
                                    $transaction->commit();
                                    $this->result['error_code'] = SUCCESS_DEFAULT;
                                    $this->result['error_msg'] = '';
                                    $this->finishNotify($order_obj);
                                } else
                                    $transaction->rollback();
                            } else {
                                $transaction->commit();
                                $this->result['error_code'] = SUCCESS_DEFAULT;
                                $this->result['error_msg'] = '';
                                $this->finishNotify($order_obj);
                            }
                        } else
                            $transaction->rollback();
                    } else
                        $transaction->rollback();
                }
            } else {
                $this->result['error_msg'] = '余额不足';
            }
        }
    }
    
    private function finishNotify($order) {
        Yii::import('common.pushmsg.*');
        $token = $this->getParam('token');
        $tpl = 'order_finished';
        $option = [
            'description' => '订单' . $order->order_no . '已完成，感谢您的乘坐，众择用车只做最专业的接送机服务。'
        ];
        PushMsg::action()->pushMsg($token, $tpl, $option);
        
        //给司机发送消息
        $attributes = [
            'client_id' => $order->driver_id,
            'type' => USER_TYPE_DRIVER
        ];
        
        $tpl = 'driver_bill_payed';
        $option = [
            'description' => '订单' . $order->order_no . '，用户已付款结单，接下去，能量满满地工作吧。'
        ];
        PushMsg::action(1)->pushMsg($attributes, $tpl, $option);
    }
}