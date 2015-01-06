<?php

class SendcodeController extends Controller
{

    public function actionIndex()
    {
        $token = $this->getParam('token');
        if (!$this->sRedisGet($token.'issend')) {
            $model = Clients::model()->findByPk($this->uid); 
            //发送验证短信
            Yii::import('common.sms.sms');
            $code = $this->getVerifyCode();
            $content = sms::getSmsTpl(SMS_VERIFY_CODE, [$code, VERIFY_CODE_EXPIRE]);
            sms::addSmsToQueue($model->mobile, SMS_VERIFY_CODE, $content, [$this->uid, USER_TYPE_CLIENT]);
            $this->sRedisSet($token, $code, VERIFY_CODE_EXPIRE);
            $this->sRedisSet($token.'issend', 1, VERIFY_CODE_RESEND);
            
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';           
        } else {
            $this->result['error_msg'] = ERROR_VERIFY_CODE_RESEND;
        }        
    }
}