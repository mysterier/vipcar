<?php

class LoginController extends Controller
{

    public function actionIndex()
    {
        $model = new ApiLoginForm('driver');
        $model->attributes = $_POST;
        if ($model->validate() && $model->login()) {
            $this->result['code'] = 1;
            $this->result['error_msg'] = '';
        } else {
            $this->add_errors($model);
        }
    }
}