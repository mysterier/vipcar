<?php

class LoginController extends Controller
{

    public function actionIndex()
    {
        $model = new ApiLoginForm('driver');
        $model->attributes = $_POST;
        if ($model->validate() && $model->login()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        } else {
            $this->addErrors($model);
        }
    }
}