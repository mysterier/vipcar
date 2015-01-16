<?php

class CouponController extends Controller
{

    public function actionIndex()
    {}

    public function actionGetticket()
    {
        $code = $this->getParam('coupon_code');
        
        $criteria = new CDbCriteria();
        $criteria->condition = 't.coupon=:code and t.status=:status and t.code_expire > :expire';
        $criteria->params = [
            'code' => $code,
            'status' => '0',
            'expire' => time()
        ];
        
        $model = Coupon::model()->with('ticket')->find($criteria);
        if ($model) {
            if ($model->ticket) {
                $client_ticket = new ClientTicket();
                $client_ticket->client_id = $this->uid;
                $client_ticket->ticket_id = $model->ticket_id;
                $client_ticket->coupon_type = $model->type;
                $client_ticket->expire = $model->ticket_expire;
                
                if ($client_ticket->save()) {
                    $model->status = 1;
                    $model->save();
                    
                    $this->result['error_code'] = SUCCESS_DEFAULT;
                    $this->result['error_msg'] = '';
                    $this->result['coupon_sid'] = $client_ticket->id;
                    $this->result['coupon_ticket'] = $model->ticket->name;
                    $this->result['coupon_type'] = $model->type;
                    $this->result['coupon_expire'] = $model->ticket_expire;
                } else {
                    $this->result['error_code'] = CLIENT_ERROR_COUPON;
                    $this->result['error_msg'] = CLIENT_MSG_COUPON_NOT_ACTIVED;
                }
            } else {
                $this->result['error_code'] = CLIENT_ERROR_COUPON;
                $this->result['error_msg'] = CLIENT_MSG_COUPON_NOT_ACTIVED;
            }
        } else {
            $this->result['error_code'] = CLIENT_ERROR_COUPON;
            $this->result['error_msg'] = CLIENT_MSG_COUPON_NOT_EXIST;
        }
    }

    public function actionList()
    {
        $model = $this->getTicket(CLIENT_TICKET_ACTIVED);
        $last_coupon_sid = 0;
        $tickets = [];
        if ($model) {
            foreach ($model as $coupon) {
                if ($coupon->ticket) {
                    $last_coupon_sid = $coupon->id;
                    $tickets[] = [
                        'coupon_sid' => $coupon->id,
                        'coupon_ticket' => $coupon->ticket->name,
                        'coupon_type' => $coupon->coupon_type,
                        'coupon_expire' => $coupon->expire
                    ];
                }
            }
        }
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        $this->result['last_coupon_sid'] = $last_coupon_sid;
        $this->result['coupons'] = $tickets;
    }

    public function actionHistory()
    {
        $model = $this->getTicket(CLIENT_TICKET_USED);
        $last_coupon_sid = 0;
        $tickets = [];
        if ($model) {
            foreach ($model as $coupon) {
                $income = $coupon->order ? $coupon->order->order_income : 0;
                $ticket = $coupon->ticket ? $coupon->ticket->name : '';
                $last_coupon_sid = $coupon->id;
                $tickets[] = [
                    'coupon_sid' => $coupon->id,
                    'coupon_ticket' => $ticket,
                    'coupon_type' => $coupon->coupon_type,
                    'pickup_place' => $coupon->order ? $coupon->order->pickup_place : '',
                    'drop_place' => $coupon->order ? $coupon->order->drop_place : '',
                    'order_cost' => $income,
                    'deduction' => $this->getDeduction($income, $ticket),
                    'used_date' => $coupon->last_update
                ];
            }
        }
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        $this->result['last_coupon_sid'] = $last_coupon_sid;
        $this->result['coupons'] = $tickets;
    }
    
    private function getTicket($status) {
        $sid = $this->getParam('last_coupon_sid');
        
        $criteria = new CDbCriteria();
        $criteria->condition = 't.client_id=:client_id and t.status=:status and t.id > :id';
        $criteria->order = 't.id asc';
        $criteria->params = [
            'client_id' => $this->uid,
            'status' => $status,
            'id' => $sid
        ];
        $model = ClientTicket::model()->with('order', 'ticket')->findAll($criteria);
        return $model;
    }

    /**
     * 得到抵扣金额
     *
     * @param $income 订单费用            
     * @param $ticket 优惠方式
     *            例如500 , 20%
     *            
     * @return $deduction 实际抵扣金额
     */
    private function getDeduction($income, $ticket)
    {
        if (! $income || ! $ticket)
            return 0;
        
        if ($income >= $ticket)
            return $ticket;
        
        if ($income < $ticket)
            return $income;
        
        return 0;
    }

    public function actionPresent()
    {
        $user_mobile = $this->getParam('user_mobile');
        $coupon_id = $this->getParam('coupon_sid');
        $mobile = Clients::model()->findByAttributes([
            'mobile' => $user_mobile
        ]);
        if ($mobile) {
            $client_id = $mobile->id;
            if ($client_id != $this->uid) {               
                $parent = ClientTicket::model()->findByPk($coupon_id);
                if ($parent && ($this->uid == $parent->client_id)) {
                    // 开启事务处理
                    $transaction = Yii::app()->db->beginTransaction();
                    
                    $parent->status = CLIENT_TICKET_DONATE;
                    $parent->last_update = time();
                    if ($parent->save()) {
                        $model = new ClientTicket();
                        $model->client_id = $client_id;
                        $model->parent_id = $parent->id;
                        $model->ticket_id = $parent->ticket_id;
                        $model->coupon_type = $parent->coupon_type;
                        $model->expire = $parent->expire;
                        if ($model->save()) {
                            $transaction->commit();
                            $this->result['error_code'] = SUCCESS_DEFAULT;
                            $this->result['error_msg'] = '';
                        } else {
                            $transaction->rollback();
                        }
                    }
                }
            } else {
                $this->result['error_code'] = ERROR_DEFAULT;
                $this->result['error_msg'] = '不能转赠给自己';
            }
        } else {
            $this->result['error_code'] = CLIENT_ERROR_NOT_EXISTED;
            $this->result['error_msg'] = CLIENT_ERROR_MSG_NOT_EXISTED;
        }
    }
}