<?php

class Login1_1Controller extends Controller
{

    public function actionIndex()
    {
        $model = new ApiLoginForm('clientv1');
        $model->attributes = $_POST;
        if ($model->validate() && $model->loginv1()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        } else {
            $this->addErrors($model);
        }
    }
}