<?php

class RegisterController extends Controller
{

    public function actionIndex()
    {
        $mobile = $this->getParam('client_mobile');
        $pass = $this->getParam('client_pass');
        
        $model = new Clients('reg');
        $model->attributes = ['mobile' => $mobile, 'password' => $pass, 'last_update' => time()];
        $uid = $model->save();
        if ($uid) {
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
            }
        } else {
            $this->addErrors($model);
        }          
    }
}