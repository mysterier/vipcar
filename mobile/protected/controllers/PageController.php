<?php

class PageController extends Controller
{

    public function init() {
        parent::init();
        //$this->layout = '//layouts/page';
    }
    
    public function actionHelp()
    {
        $this->title = '帮助中心';
        $this->render('help');
    }
    
    public function actionService() {
        $this->title = '收费详情';
        $this->render('service');
    }
}