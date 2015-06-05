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
    
    // 微信openid
    public $openid;

    public $title;

    public function beforeAction($action)
    {       
        $openid = Yii::app()->session['openid'];
        if ($openid)
            $this->openid = $openid;
        else {
            // 微信获取openid            
            if (! isset($_GET['code'])) {
                $url = urlencode('http://m.vip-car.com.cn/'.$this->id.'/'.$this->action->id);
                $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WECHAT_APP_ID.'&redirect_uri=' . $url . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
                $this->redirect($url);
            } else {
                $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.WECHAT_APP_ID.'&secret='.WECHAT_APP_SECRET.'&code=' . $_GET['code'] . '&grant_type=authorization_code';
                $output = $this->gettohost($url);
                $output = json_decode($output);
                $openid = $output->openid;
                Yii::app()->session['openid'] = $openid;
                $this->openid = $openid;
           }
        }        
        if ($this->openid)
            return true;
    }

    public function gettohost($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        
        $res = curl_exec($curl);
        curl_close($curl);
        
        return $res;
    }
    
    //发放优惠券（转发+关注的用户）
    public function checkExpand() {
        //这里可加判断是否订阅公众号
        $attributes = [
            'open_id' => $this->openid,
            'grant' => 0
        ];
        $model = WxExpand::model()->findAllByAttributes($attributes);
        if ($model) {
            foreach ($model as $value) {
                switch ($value->ad_type) {
                    case 1:
                        $coupon = new WxCoupon();
                        $coupon->open_id = $this->openid;
                        $coupon->value = 50;
                        $coupon->scope = 3;
                        $coupon->save();
                        break;
                }
            }
            WxExpand::model()->updateAll(['grant' => 1], "open_id=:open_id and `grant`=0", ['open_id' => $this->openid]);
        }
    }
}