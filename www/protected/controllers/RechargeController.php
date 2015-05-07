<?php

class RechargeController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = '//layouts/account';
    }
    
    public function actionIndexs()
    {
        require_once (COMMON . "/alipay/alipay.config.php");
        require_once (COMMON . "/alipay/lib/alipay_core.function.php");
        require_once (COMMON . "/alipay/lib/alipay_rsa.function.php");
        $recharge_no = 'rcg' . time();
        $total_fee = $this->getParam('total_fee');
        $subject = $this->getParam('subject');
        $body = $this->getParam('body');
        $params['partner'] = $alipay_config['partner'];
        $params['seller_id'] = 'jackyren@subaozuche.com';
        $params['out_trade_no'] = $recharge_no;
        $params['subject'] = $subject;
        $params['body'] = $body;
        $params['total_fee'] = $total_fee;
        $params['notify_url'] = 'http://' . DEFAULT_API_SITE . '/client/recharge/notify';
        $params['service'] = 'mobile.securitypay.pay';
        $params['payment_type'] = '1';
        $params['_input_charset'] = 'utf-8';
        $params['it_b_pay'] = '30m';
        $link = $this->getLink($params);
        $sign = rsaSign($link, $alipay_config['private_key_path']);
        $sign = urlencode($sign);
        $params['sign'] = $sign;
        $params['sign_type'] = $alipay_config['sign_type'];
        $pay_info = $this->getLink($params);
        $model = new RechargeLog();
        $model->uid = $this->uid;
        $model->recharge_no = $recharge_no;
        $model->amount = $total_fee;
        $model->subject = $subject;
        $model->body = $body;
        if ($model->save()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
            $this->result['pay_info'] = $pay_info;
        }
    }

    public function actionIndex()
    {
        $status = $this->getParam('status');
        $from = $this->getParam('from');
        $to = $this->getParam('to');
        $criteria = new CDbCriteria();
        $criteria->addCondition('uid=' . $this->uid);
        if($status)
            $criteria->addCondition('status=' . $status);
        if($from)
            $criteria->addCondition("pickup_time>'{$from}'");
        if($to)
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

    public function actionNotify()
    {
        require_once (COMMON . "/alipay/alipay.config.php");
        require_once (COMMON . "/alipay/lib/alipay_notify.class.php");
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if ($verify_result) {
            // 交易状态
            $trade_status = $this->getParam('trade_status');
            
            if ($trade_status !== 'TRADE_FINISHED') {
                $this->common();
            } elseif ($trade_status == 'TRADE_SUCCESS') {
                $this->common();
            }   
        } else {
            // 验证失败
            echo "fail";
        }
        Yii::app()->end();
    }

    private function common()
    {
        // 商户订单号
        $out_trade_no = $this->getParam('out_trade_no');        
        // 支付宝交易号        
        $trade_no = $this->getParam('trade_no');
        
        $recharge_obj = RechargeLog::model()->findByAttributes(['recharge_no' => $out_trade_no]);
        if ($recharge_obj) {
            if ($recharge_obj->status == 1) {
                echo "success";
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
                        echo 'success';
                    } else {
                        $transaction->rollback();
                        echo 'fail';
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
}