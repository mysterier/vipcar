<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    public $layout = '//layouts/column1';

    public $menu = array();

    public $breadcrumbs = array();

    public $uid;

    public $result = [
        'error_code' => ERROR_DEFAULT,
        'error_msg' => ERROR_MSG_DEFAULT
    ];

    protected function beforeAction($action)
    {
        if ($this->module && $this->action->id != 'notify') {
            if (! count($_POST)) {
                
                $this->result['error_msg'] = ERROR_MSG_CHECK_POST;
                $result = json_encode($this->result);
                echo $result;
                return false;
            }
            
            //检查token 
            if (! in_array($this->id, [
                'login',
                'register',
                'login1_1'
            ]) && ! in_array($this->action->id, [
                'forgetpass',
                'notify',
                'login'
            ]) && ! $this->checkToken())
                
                return false;
            
            //检查是否激活
            if ($this->action->id != 'forgetpass' && $this->action->id != 'notify' && $this->module->id == 'client' && ! in_array($this->id, [
                'regvalidate',
                'register',
                'login',
                'sendcode',
                'login1_1'
            ])) {
                if (! $this->isActived())
                    return false;
            }
            $this->writeIntoFile();
        }
        
        return true;
    }

    protected function afterAction($action)
    {
        $result = json_encode($this->result);
        echo $result;
    }

    public function checkToken()
    {
        $obj_token = new Token('check');
        $obj_token->attributes = $_POST;
        if (! $obj_token->validate()) {
            $this->result['error_code'] = ERROR_TOKEN;
            $this->result['error_msg'] = ERROR_MSG_SSO;
            $result = json_encode($this->result);
            echo $result;
            return false;
        }
        $this->uid = $this->getUid($this->getParam('token'));
        return true;
    }

    /**
     * 判断用户是否激活
     *
     * @author lqf
     */
    public function isActived()
    {
        $token = $this->getParam('token');
        $uid = $this->getUid($token);
        $model = Clients::model()->findByPk($uid);
        if (! $model || $model->status == USER_CLIENT_NOT_ACTIVED) {
            $this->result['error_code'] = CLIENT_ERROR_NOT_ACTIVED;
            $this->result['error_msg'] = CLIENT_ERROR_MSG_NOT_ACTIVED;
            $result = json_encode($this->result);
            echo $result;
            return false;
        }
        return true;
    }

    /**
     * 增加错误信息
     *
     * @param obj $model            
     * @author lqf
     */
    public function addErrors($model)
    {
        $error_str = '';
        if ($model->hasErrors()) {
            $errors = $model->getErrors();
            foreach ($errors as $error) {
                $error = implode(' ', $error);
                switch ($error) {
                    case ERROR_MSG_MOBILE:
                        $code = ERROR_MOBILE;
                        break;
                    case CLIENT_ERROR_MSG_NOT_ACTIVED:
                        $code = CLIENT_ERROR_NOT_ACTIVED;
                        break;
                    case CLIENT_ERROR_MSG_REGISTERED:
                        $code = CLIENT_ERROR_REGISTERED;
                        break;
                    default:
                        $code = ERROR_DEFAULT;
                }
                $this->result['error_code'] = $code;
                $error_str .= $error . ' ';
            }
        }
        $this->result['error_msg'] = $error_str;
    }

    /**
     * 获取post参数
     *
     * @param string $param            
     * @author lqf
     */
    public function getParam($param)
    {
        return (isset($_POST[$param]) && (strval($_POST[$param]) != '')) ? trim(strval($_POST[$param])) : '';
    }

    /**
     * 根据token获取uid
     *
     * @param string $token            
     * @author lqf
     */
    public function getUid($token)
    {
        $module = $this->module->id;
        $module = ($module == 'driver') ? USER_TYPE_DRIVER : USER_TYPE_CLIENT;
        $type = substr($token, 0, 1);
        if ($module != $type) {
            $this->result['error_msg'] = ERROR_MSG_USER_TYPE;
            $result = json_encode($this->result);
            echo $result;
            Yii::app()->end();
        }
        
        $uid = substr($token, 33);
        return $uid;
    }

    /**
     * 获取api最后更新时间
     * 主要针对orderlist接口
     *
     * @return string
     * @author lqf
     */
    public function getApiLastUpdate()
    {
        $url = $this->getUrl();
        
        $c = new CDbCriteria();
        $c->select = 'last_update';
        $c->condition = 'uid =:uid and utype=:utype and url=:url';
        $c->params = [
            'uid' => $this->uid,
            'utype' => ($this->module->id == 'driver') ? USER_TYPE_DRIVER : USER_TYPE_CLIENT,
            'url' => $url
        ];
        $model = ApiLastupdate::model()->find($c);
        if ($model)
            return $model->last_update;
        return 0;
    }

    /**
     * 设置api最后更新时间
     * 主要针对orderlist接口
     *
     * @return string
     * @author lqf
     */
    public function setApiLastUpdate($controller = '', $module = '', $uid = '')
    {
        $controller = $controller ? $controller : $this->id;
        $module = $module ? $module : $this->module->id;
        $api = $module . '_' . $controller . '_list';
        $url = '/' . $module . '/' . $controller . '/list';
        $utype = ($module == 'driver') ? USER_TYPE_DRIVER : USER_TYPE_CLIENT;
        
        $c = new CDbCriteria();
        $c->condition = 'uid =:uid and utype=:utype and url=:url';
        $c->params = [
            'uid' => $uid ? $uid : $this->uid,
            'utype' => $utype,
            'url' => $url
        ];
        $model = ApiLastupdate::model()->find($c);
        if (! $model)
            $model = new ApiLastupdate();
        
        $model->attributes = [
            'last_update' => time(),
            'uid' => $uid ? $uid : $this->uid,
            'utype' => $utype,
            'api' => $api,
            'url' => $url
        ];
        return $model->save();
    }

    /**
     * 去除url最后一个横杠
     *
     * @return mixed
     * @author lqf
     */
    public function getUrl()
    {
        $url = Yii::app()->request->url;
        $url = preg_replace('/\/$/', '', $url);
        return $url;
    }

    /**
     * 记录调用接口日志
     *
     * @param string $text            
     * @author lqf
     */
    public function writeIntoFile()
    {
        $text = [
            'uid' => $this->uid,
            'url' => $this->getUrl(),
            'post' => $_POST,
            'time' => date('Y-m-d H:i:s')
        ];
        $text = json_encode($text) . "\n";
        
        $dir = realpath(SYSTEM_PATH) . '/api/protected/runtime/apilogs/';
        $dir .= date('Y') . '/' . date('m');
        if (! is_dir($dir))
            mkdir($dir, 0777, true);
        
        $logFile = $dir . '/' . date('Y-m-d');
        file_put_contents($logFile, $text, FILE_APPEND | LOCK_EX);
    }

    /**
     * 更新ios_token
     *
     * @author lqf
     */
    public function chiostoken()
    {
        $model = token::model()->findByAttributes([
            'token' => $this->getParam('token')
        ]);
        $model->ios_token = $this->getParam('apple_token');
        if ($model->save()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        }
    }

    /**
     * 简单redis存储
     */
    public function sRedisSet($key, $value, $expire = REDIS_EXPIRE)
    {
        Yii::app()->redis->getClient()->set($key, $value);
        if ($expire)
            Yii::app()->redis->getClient()->expire($key, $expire);
    }

    public function sRedisGet($key)
    {
        return Yii::app()->redis->getClient()->get($key);
    }

    public function getVerifyCode()
    {
        $code = rand(100000, 999999);
        return $code;
    }

    /**
     * 绑定百度推送通道
     *
     * @author lqf
     */
    public function bindchannel()
    {
        $model = token::model()->findByAttributes([
            'token' => $this->getParam('token')
        ]);
        $model->user_id = $this->getParam('user_id');
        $model->channel_id = $this->getParam('channel_id');
        if ($model->save()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        }
    }
}