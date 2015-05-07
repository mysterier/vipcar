<?php

class FavoriteController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = '//layouts/account';
    }
    
    public function actionIndex()
    {
        $model = Clients::model()->findByPk($this->uid);
        $favorite = $model->favorite;
        $favorite = $favorite ? json_decode($favorite, true) : [
            'shutdownac' => '0',
            'slowdrive' => '0',
            'music' => '0',
            'nosay' => '0',
            'firstline' => '0'
        ];
        $hash['favorite'] = $favorite;
        $this->render('index', $hash);
    }
    
    public function actionCreate() {
        $favorite = $this->getParam('favorite');
        $favorite = json_encode($favorite);
        $model = Clients::model()->findByPk($this->uid);
        $model->favorite = $favorite;
        $model->last_update = time();
        $model->save();
        $this->redirect('/favorite/index');
    }
}