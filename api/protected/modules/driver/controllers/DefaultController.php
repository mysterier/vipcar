<?php

class DefaultController extends Controller
{

    public function actionIndex()
    {
        echo 'hello world';
    }

    public function actionPushmsg()
    {
        Yii::import('common.pushmsg.*');
        $attributes = $this->getParam('token');
        $tpl = 'order_confirm';
        $option = [
            'description' => '您的订单1234已被确认，司机正向您火速奔来。'
        ];
        PushMsg::action()->pushMsg($attributes, $tpl, $option);
        echo 'success';
        exit();
    }
}