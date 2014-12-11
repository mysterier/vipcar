<?php

class AirportsendController extends Controller
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
        
        $model = new Orders('airportsend');
        $model->attributes = $attributes;
        if ($model->save()) {
            //记录联系人历史
            $contacter = new Contacter();
            $contacter->setContacter();
            
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
            $this->result['order_sid'] = $model->id;
            $this->result['order_no'] = $order_no;
        } else {
            $this->addErrors($model);
        }
    }
}
