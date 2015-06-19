<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    /**
     *
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     *      meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';

    /**
     *
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     *
     * @var array the breadcrumbs of the current page. The value of this property will
     *      be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     *      for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public $uid;
    public $type;

    public function init()
    {
        $detect = Yii::app()->mobileDetect;
        if ($detect->isMobile()) {
            $maps = [
                '/contact' => '/page/contactus',
                '/help/billing' => '/page/service',
                '/appdown' => '/page/download',
                '/help/car' => '/page/help',
                '/about' => '/page/about'
            ];
            $url = Yii::app()->request->getUrl();
            if (isset($maps[$url])) {
                $url = $maps[$url];
                $this->redirect('http://m.vip-car.com.cn' . $url);
                Yii::app()->end();
            }            
        }
        parent::init();
        
        $this->uid = Yii::app()->user->id;
        $this->type = Yii::app()->user->getState('type');
    }

    /**
     * 密码加密
     *
     * @param string $password            
     * @return string
     * @author lqf
     */
    public function encryptPasswd($password = DEFAULT_PASSWORD)
    {
        $pass = md5($password);
        $pass = 'suxian' . $pass;
        $pass = md5($pass);
        return $pass;
    }

    /**
     * 获取post参数
     *
     * @param string $param            
     * @author lqf
     */
    public function getParam($param, $default = null)
    {
        return Yii::app()->request->getParam($param, $default);
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
    

    public function filters()
    {
        return [
            'accessControl'
        ];
    }

    public function accessRules()
    {
        return [
            
            [
                'deny',
                'users' => [
                    '?'
                ],
                'deniedCallback' => function ($rule) {
                    Yii::app()->user->loginRequired();
                    //header("location: /login");
                }
            ]
        ];
    }
}