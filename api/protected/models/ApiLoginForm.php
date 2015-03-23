<?php

class ApiLoginForm extends CFormModel
{

    public $driver_mobile;

    public $driver_pass;

    public $client_mobile;

    public $client_pass;

    public $apple_token;

    public $dynamic_pass;

    private $user_id;

    public function rules()
    {
        return [
            
            [
                'driver_mobile, driver_pass',
                'required',
                'on' => 'driver'
            ],
            
            [
                'driver_mobile',
                'match',
                'pattern' => '/^(?:(?:1(?:3[4-9]|5[012789]|8[78])\d{8}|1(?:3[0-2]|5[56]|8[56])\d{8}|18[0-9]\d{8}|1[35]3\d{8})|14[57]\d{8}|170[059]\d{7}|17[67]\d{8})$/',
                'on' => 'driver'
            ],
            
            [
                'driver_pass',
                'authenticate',
                'on' => 'driver'
            ],
            
            [
                'dynamic_pass',
                'authenticatev1',
                'on' => 'clientv1'
            ],
            
            [
                'client_mobile, client_pass',
                'required',
                'on' => 'client'
            ],
            
            [
                'client_mobile, dynamic_pass',
                'required',
                'on' => 'clientv1'
            ],
            
            [
                'client_mobile',
                'match',
                'pattern' => '/^(?:(?:1(?:3[4-9]|5[012789]|8[78])\d{8}|1(?:3[0-2]|5[56]|8[56])\d{8}|18[0-9]\d{8}|1[35]3\d{8})|14[57]\d{8}|170[059]\d{7}|17[67]\d{8})$/',
                'on' => [
                    'client',
                    'clientv1'
                ]
            ],
            
            [
                'client_pass',
                'authenticate',
                'on' => 'client'
            ],
            
            [
                'apple_token',
                'safe'
            ]
        ];
    }

    /**
     * 密码验证
     *
     * @author lqf
     */
    public function authenticate($attribute, $params)
    {
        $scenario = $this->getScenario();
        $mobile = $scenario . '_mobile';
        $password = $scenario . '_pass';
        
        $attributes = [
            'mobile' => $this->$mobile,
            'password' => $this->$password
        ];
        
        $static = ucwords($scenario) . 's';
        
        $criteria = new CDbCriteria();
        $criteria->condition = 'mobile=:mobile and password=:password';
        $criteria->params = $attributes;
        $this->user_id = $static::model()->find($criteria);
        if ($this->user_id) {
            if ($scenario == 'client' && $this->user_id->status == USER_CLIENT_NOT_ACTIVED) {
                $this->addError('login', CLIENT_ERROR_MSG_NOT_ACTIVED);
                Yii::app()->controller->result['error_code'] = CLIENT_ERROR_NOT_ACTIVED;
                $token = $this->generateToken($this->user_id->id, USER_TYPE_CLIENT);
                if (! $token)
                    return false;
                Yii::app()->controller->result['token'] = $token;
            }
        } else
            $this->addError('password', 'Incorrect username or password.');
    }
    
    public function authenticatev1($attribute, $params) {
        $captcha = Yii::app()->redis->getClient()->get($this->client_mobile);
        if ($captcha != $this->dynamic_pass)
            $this->addError('dynamic_pass', '动态码不正确！');
    }

    /**
     * api登陆
     *
     * token规则：type+md5(time()+uid+type)+uid
     *
     * @return boolean
     * @author lqf
     */
    public function login()
    {
        $scenario = $this->getScenario();
        
        $uid = $this->user_id->id;
        $type = ($scenario == 'driver') ? USER_TYPE_DRIVER : USER_TYPE_CLIENT;
        $token = $this->generateToken($uid, $type);
        if (! $token)
            return false;
        Yii::app()->controller->result['id'] = $uid;
        Yii::app()->controller->result['token'] = $token;
        return true;
    }

    public function loginv1()
    {
        $client = Clients::model()->findByAttributes(['mobile' => $this->client_mobile]);
        $token = $this->generateToken($client->id, USER_TYPE_CLIENT);
        if (! $token)
            return false;
        Yii::app()->controller->result['id'] = $client->id;
        Yii::app()->controller->result['token'] = $token;
        return true;
    }

    private function generateToken($uid, $type)
    {
        $token = $type . md5(time() . $uid . $type) . $uid;
        $attributes = [
            'client_id' => $uid,
            'type' => $type
        ];
        
        $tstatic = Token::model()->findByAttributes($attributes);
        if ($tstatic) {
            if (! Token::model()->updateByPk($tstatic->id, [
                'token' => $token,
                'ios_token' => $this->apple_token
            ]))
                return false;
        } else {
            $tobj = new Token();
            $tobj->attributes = [
                'client_id' => $uid,
                'type' => $type,
                'token' => $token,
                'ios_token' => $this->apple_token
            ];
            
            if (! $tobj->save())
                return false;
        }
        return $token;
    }
}
