<?php

class PageController extends Controller
{

    public function init()
    {
        parent::init();
        //$this->layout = '//layouts/promotion';
    }

    public function beforeAction($action) {
        return true;
    }
    
    public function actionHelp()
    {
        $this->title = '帮助中心';
        $this->render('help');
    }

    public function actionService()
    {
        $this->title = '收费详情';
        $this->render('service');
    }

    public function actionQuestion()
    {
        $this->title = '常见问题';
        $this->render('question');
    }

    public function actionDownload()
    {
        $this->layout = '//layouts/download';
        $this->render('download');
    }
    
    public function actionAbout()
    {
        $this->title = '关于众择';
        $this->render('about');
    }

    public function actionAd()
    {
        $this->layout = false;
        $jssdk = new jssdk(WECHAT_APP_ID, WECHAT_APP_SECRET);
        $signPackage = $jssdk->GetSignPackage();
        
        $openid = Yii::app()->session['openid'];//$openid='oA7kOtw-NcEWHPlc-bGUQMx8azY8';
        if ($openid)
            $hash['openid'] = $openid;
        else {
            // 微信获取openid
            if (! isset($_GET['code'])) {
                $url = urlencode('http://m.vip-car.com.cn/'.$this->id.'/'.$this->action->id);
                $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WECHAT_APP_ID.'&redirect_uri=' . $url . '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
                $this->redirect($url);
            } else {
                $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.WECHAT_APP_ID.'&secret='.WECHAT_APP_SECRET.'&code=' . $_GET['code'] . '&grant_type=authorization_code';
                $output = $this->gettohost($url);
                $output = json_decode($output);
                $openid = $output->openid;
                Yii::app()->session['openid'] = $openid;
                $hash['openid'] = $openid;
            }
        }
        $this->pageStatistics($openid);
        $hash['signPackage'] = $signPackage;
        $this->render('ad', $hash);
    }
        
    public function pageStatistics($openid) {
        $model = new WxStatistics();
        $model->open_id = $openid;
        $model->action = '/' . $this->id . '/' . $this->action->id;
        $model->save();
    }
    
    public function actionAjax() {
        $ad_type = $_POST['ad_type'];
        $open_id = $_POST['openid'];
        $attributes = [
            'open_id' => $open_id,
            'ad_type' => $ad_type
        ];
        $model = WxExpand::model()->findByAttributes($attributes);
        if (!$model) {
            $expand = new WxExpand();
            $expand->ad_type = $ad_type;
            $expand->open_id = $open_id;
            $expand->save();
        }
    }
}