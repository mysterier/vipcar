<?php

class CouponController extends Controller
{

    public function actionIndex()
    {
        
    }
    
    public function actionGetticket() {
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
            if($model->ticket) {
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
    
    public function actionList() {
        $attributes = [
            'client_id' => $this->uid,
            'status' => CLIENT_TICKET_ACTIVED            
        ];
        $model = ClientTicket::model()->with('ticket')->findAllByAttributes($attributes);
        $tickets = [];
        if ($model) {           
            foreach ($model as $coupon) {
                if ($coupon->ticket) {
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
        $this->result['coupons'] = $tickets;
    }
    
    public function actionHistory() {
        $sid = $this->getParam('coupon_last_sid');
        
        $criteria = new CDbCriteria();
        $criteria->condition = 't.client_id=:client_id and t.status=:status and t.id > :id';
        $criteria->params = [
            'client_id' => $this->uid,
            'status' => CLIENT_TICKET_USED,
            'id' => $sid
        ];
        $model = ClientTicket::model()->with('order', 'ticket')->findAll($criteria);
        $tickets = [];
        if ($model) {
            foreach ($model as $coupon) {
                $income = $coupon->order ? $coupon->order->order_income : 0;
                $ticket = $coupon->ticket ? $coupon->ticket->name : '';
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
        $this->result['coupons'] = $tickets;
    }
    
    /**
     * 得到抵扣金额
     * 
     * @param $income 订单费用
     * @param $ticket 优惠方式 例如500 , 20%
     * 
     * @return $deduction 实际抵扣金额
     */
    private function getDeduction($income, $ticket) {
        if (!$income || !$ticket)
            return 0; 
        
        if ($income >= $ticket)
            return $ticket;
        
        if ($income < $ticket)
            return $income;
        
        return 0;
    }
}