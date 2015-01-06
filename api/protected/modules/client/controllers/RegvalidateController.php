<?php

class RegvalidateController extends Controller
{

    public function actionIndex()
    {
        $captcha = $this->sRedisGet($this->getParam('token'));
        $code = $this->getParam('client_code');
        if ($code == $captcha) {
            $attributes = [
                'last_update' => time(),
                'status' => USER_CLIENT_ACTIVED
            ];
            $model = Clients::model()->updateByPk($this->uid, $attributes);
            if ($model) {
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
            }
        }
        $this->result['error_msg'] = '验证码不正确';
    }
}