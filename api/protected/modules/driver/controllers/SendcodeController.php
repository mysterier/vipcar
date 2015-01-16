<?php

class SendcodeController extends Controller
{

    public function actionIndex()
    {
        $token = $this->getParam('token');
        if (!$this->sRedisGet($token.'issend')) {
            $model = Drivers::model()->findByPk($this->uid); 
            $this->sendSms($token, $model);          
        } else {
            $this->result['error_msg'] = ERROR_VERIFY_CODE_RESEND;
        }        
    }
    
    public function actionForgetpass() {
        $mobile = $this->getParam('driver_mobile');
        if (!$this->sRedisGet($mobile.'issend_driver')) {
            $model = Drivers::model()->findByAttributes(['mobile' => $mobile]);
            if ($model)           
                $this->sendSms($mobile, $model);
            else
                $this->result['error_msg'] = CLIENT_ERROR_MSG_NOT_EXISTED;          
        } else
            $this->result['error_msg'] = ERROR_VERIFY_CODE_RESEND;
    }
    
    private function sendSms($key, $model) {
        //发送验证短信
        Yii::import('common.sms.sms');
        $code = $this->getVerifyCode();
        $content = sms::getSmsTpl(SMS_VERIFY_CODE, [$code, VERIFY_CODE_EXPIRE/60]);
        sms::addSmsToQueue($model->mobile, SMS_VERIFY_CODE, $content, [$model->id, USER_TYPE_DRIVER]);
        $this->sRedisSet($key, $code, VERIFY_CODE_EXPIRE);
        $this->sRedisSet($key.'issend_driver', 1, VERIFY_CODE_RESEND);
        
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
    }
}