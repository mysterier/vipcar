<?php

class PageController extends Controller
{

    public function init()
    {
        parent::init();
        // $this->layout = '//layouts/page';
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

    public function actionContactus()
    {
        $this->title = '联系我们';
        $this->render('contactus');
    }

    public function actionDownload()
    {
        $this->layout = '//layouts/download';
        $this->render('download');
    }

    public function actionAd()
    {
        $this->layout = false;
        $jssdk = new jssdk(WECHAT_APP_ID, WECHAT_APP_SECRET);
        $signPackage = $jssdk->GetSignPackage();
        $hash['signPackage'] = $signPackage;
        $this->render('ad', $hash);
    }
    
    public function actionAjax() {
        echo 123;
    }
}