<?php

class RegisterController extends Controller
{

    public function actionIndex()
    {   
        $mobile = $this->getParam('client_mobile');
        $email = $this->getParam('client_email');
        $pass = $this->getParam('client_pass');
        
        $model = new Clients('reg');
        $model->attributes = [
            'mobile' => $mobile,
            'email' => $email,
            'password' => $pass,
            'last_update' => time()
        ];
        
        if ($model->save()) {
            $uid = $model->id;
            $token = USER_TYPE_CLIENT . md5(time() . $uid . USER_TYPE_CLIENT) . $uid;
            $tobj = new Token();
            $tobj->attributes = [
                'client_id' => $uid,
                'type' => USER_TYPE_CLIENT,
                'token' => $token
            ];
            
            if ($tobj->save()) {
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
                $this->result['token'] = $token;
                //发送验证短信
                Yii::import('common.sms.sms');
                $code = $this->getVerifyCode();
                $content = sms::getSmsTpl(SMS_VERIFY_CODE, [$code, VERIFY_CODE_EXPIRE]);
                sms::addSmsToQueue($mobile, SMS_VERIFY_CODE, $content, [$uid, USER_TYPE_CLIENT]);
                $this->sRedisSet($token, $code, VERIFY_CODE_EXPIRE);
                $this->sRedisSet($token.'issend', 1, VERIFY_CODE_RESEND);
            }
        } else {
            $this->addErrors($model);
        }
    }
}