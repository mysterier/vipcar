<?php

class AirportpickupController extends Controller
{

    public function actionIndex()
    {
        $attributes = $_POST;
        $order_no = 'su' . time();
        $attributes['order_no'] = $order_no;
        $attributes['contacter_phone'] = $this->getParam('contacter_mobile');
        $attributes['vehicle_type'] = $this->getParam('car_type');
        $attributes['summary'] = $this->getParam('order_summary');
        $attributes['type'] = $this->getParam('order_type');
        $attributes['client_id'] = $this->uid;
        $attributes['coordinate'] = $this->getParam('pickup_longitude') . ',' . $this->getParam('pickup_latitude') . ',' . $this->getParam('drop_longitude') . ',' . $this->getParam('drop_latitude');
        
        $model = new Orders();
        $model->attributes = $attributes;
        if ($model->checkBalance()) {
            //开启事物
            $transaction = Yii::app()->db->beginTransaction();
            $client = Clients::model()->findByPk($this->uid);
            $client->freeze += $model->estimated_cost;
            $client->last_update = time();
            $client->save();
            $coupon_id = $this->getParam('coupon_sid');
            $ticket_fee = $model->useTicket($coupon_id);
            $model->ticket_fee = $ticket_fee ? $ticket_fee : 0;
            if ($model->save()) {
                // 记录联系人历史
                $contacter = new Contacter();
                $contacter->setContacter();
            
                $transaction->commit();
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
                $this->result['order_sid'] = $model->id;
                $this->result['order_no'] = $order_no;
                $this->result['order_date'] = date('Y-m-d H:i:s');
            } else {
                $transaction->rollback();
                $this->addErrors($model);
            }
        } else {
            $this->result['error_code'] = CLIENT_ERROR_NOT_SUFFICIENT_FUNDS;
            $this->result['error_msg'] = CLIENT_ERROR_MSG_NOT_SUFFICIENT_FUNDS;
        }       
    }
}