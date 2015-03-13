<?php

class DefaultController extends Controller
{

    public function actionIndex()
    {
        echo 'hello world';
    }
    
    public function getUid($token)
    {    
        $uid = substr($token, 33);
        return $uid;
    }
    
    public function beforeAction($action) {
        return true;
    }

    public function actionPushmsg()
    {
        $driver = $this->getParam('is_driver');
        $des = $this->getParam('msg');
        Yii::import('common.pushmsg.*');
        $attributes = $this->getParam('token');
        $tpl = 'order_confirm';
        $option = [
            'description' => $des ? $des :'您的订单1234已被确认，司机正向您火速奔来。'
        ];
        PushMsg::action($driver)->pushMsg($attributes, $tpl, $option);
        echo 'success';
        exit();
    }
    
    public function actionHttp() {
        sleep(3);
    }
}