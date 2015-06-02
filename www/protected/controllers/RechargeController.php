<?php

class RechargeController extends Controller
{

    public function init()
    {
        parent::init();
        $this->layout = '//layouts/account';
    }

    public function actionIndex()
    {
        $status = $this->getParam('status');
        $from = $this->getParam('from');
        $to = $this->getParam('to');
        $criteria = new CDbCriteria();
        $criteria->addCondition('uid=' . $this->uid);
        if ($status)
            $criteria->addCondition('status=' . $status);
        if ($from)
            $criteria->addCondition("pickup_time>'{$from}'");
        if ($to)
            $criteria->addCondition("pickup_time<'{$to}'");
        $criteria->order = 'id DESC';
        $count = RechargeLog::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->applyLimit($criteria);
        
        $model = RechargeLog::model()->findAll($criteria);
        $hash['model'] = $model;
        $hash['pages'] = $pages;
        $this->render('index', $hash);
    }

    public function actionCash()
    {
        $this->render('cash');
    }

    public function actionNotify()
    {
        require_once (COMMON . "/alipay_direct/alipay.config.php");
        require_once (COMMON . "/alipay_direct/lib/alipay_notify.class.php");
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if ($verify_result) {
            // 交易状态
            $trade_status = $this->getParam('trade_status');
            
            if ($trade_status !== 'TRADE_FINISHED') {
                echo $this->common();
            } elseif ($trade_status == 'TRADE_SUCCESS') {
                echo $this->common();
            }
        } else {
            // 验证失败
            echo "fail";
        }
        Yii::app()->end();
    }
    
    public function actionReturn() {
        require_once(COMMON . "/alipay_direct/alipay.config.php");
        require_once (COMMON . "/alipay_direct/lib/alipay_notify.class.php");
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result) {
            // 交易状态
            $trade_status = $this->getParam('trade_status');
        
            if ($trade_status !== 'TRADE_FINISHED') {
                $this->common();
            } elseif ($trade_status == 'TRADE_SUCCESS') {
                $this->common();
            }
        } 
        $this->redirect('/recharge/index');
    }

    private function common()
    {
        // 商户订单号
        $out_trade_no = $this->getParam('out_trade_no');
        // 支付宝交易号
        $trade_no = $this->getParam('trade_no');
        
        $recharge_obj = RechargeLog::model()->findByAttributes([
            'recharge_no' => $out_trade_no
        ]);
        if ($recharge_obj) {
            if ($recharge_obj->status == 1) {
                return "success";
            } else {
                $recharge_obj->status = 1;
                $recharge_obj->trade_no = $trade_no;
                
                $transaction = Yii::app()->db->beginTransaction();
                if ($recharge_obj->save()) {
                    $model = Clients::model()->findByPk($recharge_obj->uid);
                    $model->setScenario('update_balance');
                    $model->account_balance = $model->account_balance + $recharge_obj->amount;
                    $model->last_update = time();
                    if ($model->save()) {
                        $transaction->commit();
                        return 'success';
                    } else {
                        $transaction->rollback();
                        return 'fail';
                    }
                }
            }
        } else {
            echo 'fail';
        }
    }

    private function getLink($para)
    {
        $arg = "";
        while (list ($key, $val) = each($para)) {
            $arg .= $key . "=\"" . $val . "\"&";
        }
        // 去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);
        
        return $arg;
    }

    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => [
                    'notify',
                    'return'
                ],
                'users' => [
                    '*'
                ]
            ],           
            [
                'deny',
                'users' => [
                    '?'
                ],
                'deniedCallback' => function ($rule) {
                    Yii::app()->user->loginRequired();
                }
            ]
        ];
    }
}