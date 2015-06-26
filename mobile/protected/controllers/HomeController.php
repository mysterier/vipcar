<?php

class HomeController extends Controller
{
    
    public function actionIndex() {
        $this->title = '微信页面调试';
        $this->render('index');
    }
    
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
    public function actionBindmobile() {
        $this->layout = '//layouts/promotion';
        $this->title = '手机绑定';
        $client = $this->hasClient();
        if ($_POST && !$client) {
            $mobile = $this->getParam('mobile');
            $msg_code = $this->getParam('msg_code');
            $attributes = [
                'mobile' => $mobile,
            ];
            $client = Clients::model()->findByAttributes($attributes);
            if ($client) {
                $client->setScenario('wechat');               
            } else {                
                $client = new Clients('wechat');
                $client->mobile = $mobile;
                $client->status = (string) CLIENT_ACTIVED;
                $client->password = 'todo';
            }
            $client->open_id = $this->openid;
            $client->msg_code = $msg_code;
            if ($client->save()) {
                //同步网站订单和微信订单
                Orders::model()->updateAll(['open_id'=>$this->openid],'client_id=:uid',['uid'=>$client->id]);
                Orders::model()->updateAll(['client_id'=>$client->id],'open_id=:openid',['openid'=>$this->openid]);
                //赠送50优惠券
                $client->getticket();
                $redirect = Yii::app()->session['redirect_url'];
                if ($redirect) {
                    $this->redirect($redirect);
                }
            }               
        }
        $hash['client'] = $client;
        $this->render('bindmobile', $hash);
    }
    
    public function bindorders() {
        $model = Orders::model()->updateAll($attributes,$condition,$params);
    }
    
    public function actionAdvice() {
        $this->layout = '//layouts/promotion';
        $this->title = '建议反馈';
        if ($_POST) {
            $model = new WxAdvice();
            $model->open_id = $this->openid;
            $model->content = $this->getParam('content');
            if ($model->save()) {
                $this->redirect('/order/airportpickup');
            }
        }
        $this->render('advice');
    }
    
    public function actionSendcode() {
        $mobile = $this->getParam('mobile');
        if (!$this->sRedisGet($mobile.'issend_from_wechat')) {
            //发送验证短信
            Yii::import('common.sms.sms');
            $code = $this->getVerifyCode();
            $content = sms::getSmsTpl(SMS_VERIFY_CODE, [$code, VERIFY_CODE_EXPIRE/60]);
            sms::addSmsToQueue($mobile, SMS_VERIFY_CODE, $content, [0, USER_TYPE_CLIENT]);
            $this->sRedisSet($mobile, $code, VERIFY_CODE_EXPIRE);
            $this->sRedisSet($mobile.'issend_from_wechat', 1, VERIFY_CODE_RESEND);
            $output = [
                'error_code' => 0
            ];
        } else {
            $output = [
                'error_code' => -1,
                'error_msg' => ERROR_VERIFY_CODE_RESEND
            ];
        }
        echo json_encode($output);
    }
}