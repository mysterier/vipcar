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
    
    public function actionCash() {
        $this->render('cash');
    }
    
    public function actionGotoali() {
        require_once(COMMON . "/alipay_direct/alipay.config.php");
        require_once(COMMON . "/alipay_direct/lib/alipay_submit.class.php");
        
        $recharge_no = 'rcg' . time();
        
        /**************************请求参数**************************/
        
        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = "http://".Yii::app()->homeUrl."/notify_url.php";
        
        //页面跳转同步通知页面路径
        $return_url = "http:".Yii::app()->homeUrl."/return_url.php";
        
        //商户订单号
        $out_trade_no = $recharge_no;
        //商户网站订单系统中唯一订单号，必填
        
        //订单名称
        $subject = '网页充值';
        //必填
        
        //付款金额
        $total_fee = $this->getParam('fee');;
        //必填
        
        //订单描述
        
        $body = '网页充值';
        //商品展示地址
        $show_url = '';//$_POST['WIDshow_url'];
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        
        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数
        
        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1
        
        
        /************************************************************/
        
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "seller_email" => trim($alipay_config['seller_email']),
            "payment_type"	=> $payment_type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "show_url"	=> $show_url,
            "anti_phishing_key"	=> $anti_phishing_key,
            "exter_invoke_ip"	=> $exter_invoke_ip,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );
        
        $model = new RechargeLog();
        $model->uid = $this->uid;
        $model->recharge_no = $recharge_no;
        $model->amount = $total_fee;
        $model->subject = $subject;
        $model->body = $body;
        //if ($model->save()) {
            //建立请求
            $alipaySubmit = new AlipaySubmit($alipay_config);var_dump($alipaySubmit);exit();
            $alipaySubmit->buildRequestHttp($parameter);
//             $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
//             echo $html_text;
        //}      
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