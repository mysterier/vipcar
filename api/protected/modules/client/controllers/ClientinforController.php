<?php

class ClientinforController extends Controller
{

    public function actionIndex()
    {
        $model = Clients::model()->findByPk($this->uid);
        
        if ($model && $model->last_update > $this->getParam('last_update')) {
            $result['error_code'] = API_UPDATE_USER_INFO;
            $result['error_msg'] = '';
            $result['client_name'] = $model->real_name;
            $result['client_score'] = $model->score;
            $result['account_balance'] = $model->account_balance;
            $result['client_avatar'] = $model->avatar;
            $result['client_title'] = $model->client_title;
            $result['client_phone'] = $model->mobile;
            $result['client_email'] = $model->email;
            $result['last_update'] = $model->last_update;
            $this->result = $result;
        } else {
            $this->result['error_code'] = API_MAINTAIN_USER_INFO;
            $this->result['error_msg'] = '';
        }
    }

    public function actionModify()
    {
        $model = Clients::model()->findByPk($this->uid);
        $model->setScenario('modify');
        if ($model) {
            $model->real_name = $this->getParam('name');
            $model->client_title = $this->getParam('client_title');
            $model->email = $this->getParam('client_email');
            $model->last_update = time();
            if ($model->save()) {
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
            }
        }
    }

    public function actionResetpass()
    {
        $old_pass = $this->getParam('old_password');
        $new_pass = $this->getParam('new_password');
        $model = Clients::model()->findByPk($this->uid);        
        if ($model && ($model->password == $old_pass)) {
            $model->setScenario('resetpass');
            $model->password = $new_pass;
            if ($model->save()) {
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
            }
        } else {
            $this->result['error_msg'] = '原始密码错误';
        }
    }
    
    public function actionForgetpass() {
        $mobile = $this->getParam('client_mobile');
        $captcha = $this->sRedisGet($mobile);
        $code = $this->getParam('verify_code');
        $mobile = $this->getParam('client_mobile');
        $password = $this->getParam('new_pass');
        if ($code == $captcha) {
            $model = Clients::model()->findByAttributes(['mobile' => $mobile]);
            if ($model) {
                $model->setScenario('resetpass');
                $model->password = $password;
                if ($model->save()) {
                    $this->result['error_code'] = SUCCESS_DEFAULT;
                    $this->result['error_msg'] = '';
                }
            }
        } else 
            $this->result['error_msg'] = '验证码不正确';
    }
}