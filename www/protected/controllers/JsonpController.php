<?php

class JsonpController extends Controller
{

    
    public function actionUpload() {
        if (!$_FILES)
            return false;
        $isSuc = false;
        $path = '/client/' . date('Y') . '/' . date('m') . '/';
        if (($pos = strrpos($_FILES["avatar"]["name"], '.')) !== false)
            $extensionName = (string) substr($_FILES["avatar"]["name"], $pos + 1);
        
        $name = 'avatar_' . date('d') . '_' . time() . '_' . rand(0, 9999) . '.' . $extensionName;
        $desFilePath;
        $tmpFilePath;
        
        
        if (in_array($_FILES["avatar"]["type"], [
            'image/gif',
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/pjpeg'
        ]) && $_FILES["avatar"]["size"] < (1024 * 1024 * 10)) {
            if ($_FILES["avatar"]["error"] > 0) {
                $isSuc = false;
            } else {
                $tmpFilePath = $_FILES["avatar"]["tmp_name"];
                $desFilePath =  DEFAULT_UPLOAD_PATH . $path;
                if (! is_dir($desFilePath))
                    mkdir($desFilePath, 0777, true);
                
                $desFilePath = $desFilePath . $name;
                move_uploaded_file($tmpFilePath, $desFilePath);
                $isSuc = $path . $name;
            }
        }
        
        if ($isSuc) {
            $model = Clients::model()->findByPk($this->uid);
            $model->setScenario('avatar');
            $model->avatar = $isSuc;
            $model->last_update = time();
            if ($model->save()) {
                $result['error_code'] = SUCCESS_DEFAULT;
                $result['avatar_path'] = $isSuc;
            } else {
                $result['error_code'] = ERROR_DEFAULT;
                $result['error_msg'] = ERROR_MSG_UPLOAD;
            }
        } else {
            $result['error_code'] = ERROR_DEFAULT;
            $result['error_msg'] = ERROR_MSG_UPLOAD;
        }
        echo json_encode($result);
    }
    
    public function actionComment() {
        $star = $this->getParam('star');
        $id = $this->getParam('order_id');
        $model = Orders::model()->findByPk($id);
        $model->setScenario('webcomment');
        $model->star = $star;
        if ($model->save())
            echo 1;
        echo 0;
    }
    
    public function actionGetflight() {
        $flight = $this->getParam('flight');
        $date = $this->getParam('date');
        $date = preg_match('/\d{4}-\d{2}-\d{2}/', $date, $m) ? $m[0] : '';
        $contacter_name = '';
        $contacter_phone = '';
        $fdate = str_replace('-', '', $date);
    
        $params = [
            'key' => '7e6e711ef3304a058decf5fb38c50ab4',
            'flightNo' => $flight,
            'date' => $fdate
        ];
        $url = "http://apis.haoservice.com/plan/InternationalFlightQueryByFlightNo";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $output = curl_exec($ch);
        if ($output === FALSE) {
            $output = [
                'error_code' => -1
            ];
        } else {
            $output = json_decode($output);
            $pickup_time = $html = '';
            if ($output->result) {
                if(isset($output->result->stops)) {
                    foreach ($output->result->stops as $stop) {
                        if (preg_match('/浦东国际机场T1/', $stop->title)) {
                            $output->result->dep_time = $stop->dep_time;
                            $output->result->arr_time = $stop->arr_time;
                            $output->result->arr = '浦东国际机场T1';
                            break;
                        }
                        
                        if (preg_match('/浦东国际机场T2/', $stop->title)) {
                            $output->result->dep_time = $stop->dep_time;
                            $output->result->arr_time = $stop->arr_time;
                            $output->result->arr = '浦东国际机场T2';
                            break;
                        }
                        
                        if (preg_match('/虹桥国际机场T1/', $stop->title)) {
                            $output->result->dep_time = $stop->dep_time;
                            $output->result->arr_time = $stop->arr_time;
                            $output->result->arr = '虹桥国际机场T1';
                            break;
                        }
                        
                        if (preg_match('/虹桥国际机场T2/', $stop->title)) {
                            $output->result->dep_time = $stop->dep_time;
                            $output->result->arr_time = $stop->arr_time;
                            $output->result->arr = '虹桥国际机场T2';
                            break;
                        }
                    }
                }
                
                $dep_time = preg_match('/\d{2}:\d{2}/', $output->result->dep_time, $m) ? $m[0] : '';
                $arr_time = preg_match('/\d{2}:\d{2}/', $output->result->arr_time, $m) ? $m[0] : '';
                if (strtotime($arr_time) < strtotime($dep_time)) {
                    $date = strtotime($date .' +1 day');
                    $date = date('Y-m-d', $date);
                }
                $pickup_time .= $date . ' ' . $arr_time;
                $output = [
                    'error_code' => 0,
                    'pickup_place' => $output->result->arr,
                    'pickup_time' => $pickup_time
                ];
            } else {
                $output = [
                    'error_code' => -1,
                ];
            }            
        }
        curl_close($ch);
        $res = json_encode($output);
        echo $res;
    }
    
    public function actionSendcode() {
        $mobile = $this->getParam('mobile');
        if (!$this->sRedisGet($mobile.'issend_from_web')) {
            //发送验证短信
            Yii::import('common.sms.sms');
            $code = $this->getVerifyCode();
            $content = sms::getSmsTpl(SMS_VERIFY_CODE, [$code, VERIFY_CODE_EXPIRE/60]);
            sms::addSmsToQueue($mobile, SMS_VERIFY_CODE, $content, [0, USER_TYPE_CLIENT]);
            $this->sRedisSet($mobile, $code, VERIFY_CODE_EXPIRE);
            $this->sRedisSet($mobile.'issend_from_web', 1, VERIFY_CODE_RESEND);
            $output = [
                'error_code' => 0
            ];
        } else {
            $output = [
                'error_code' => -1,
                'error_msg' => ERROR_VERIFY_CODE_RESEND
            ];
        }
        echo json_encode($output);
    }
    
    public function actionCancelorder() {
        $id = $this->getParam('id');
        $model = Orders::model()->findByPk($id);
        if (!$model) {
            $output = [
                'error_code' => -1
            ];
            echo json_encode($output);
            Yii::app()->end();
        }
        if ($model->status == ORDER_STATUS_RUN) {
            $confirm = $this->getParam('confirm');
            switch ($model->cancelone($id, $confirm, $this->uid)) {
                case 1:
                    $output = [
                        'error_code' => 0
                    ];
                    break;
                case 2:
                    $output = [
                        'error_code' => 1
                    ];
                    break;
                case 3:
                    $output = [
                        'error_code' => -1
                    ];
                    break;
            }
        } else {
            switch ($model->cancelzero($id)) {
                case 1:
                    $output = [
                        'error_code' => 0
                    ];
                    break;
                case 3:
                    $output = [
                        'error_code' => -1
                    ];
                    break;
            }
        }
        
        $this->setApiLastUpdate($this->uid, 'client');
        if ($model->driver_id)
            $this->setApiLastUpdate($this->driver_id, 'driver');
        echo json_encode($output);
    }      

    /**
     * 设置api最后更新时间
     * 主要针对orderlist接口
     *
     *
     * @return string
     * @author lqf
     */
    public function setApiLastUpdate($uid, $utype)
    {
        $api = $utype . '_order_list';
        $url = '/' . $utype . '/order/list';
        $utype = ($utype == 'driver') ? USER_TYPE_DRIVER : USER_TYPE_CLIENT;
    
        $c = new CDbCriteria();
        $c->condition = 'uid =:uid and utype=:utype and url=:url';
        $c->params = [
            'uid' => $uid,
            'utype' => $utype,
            'url' => $url
        ];
        $model = ApiLastupdate::model()->find($c);
        if (! $model)
            $model = new ApiLastupdate();
    
        $model->attributes = [
            'last_update' => time(),
            'uid' => $uid,
            'utype' => $utype,
            'api' => $api,
            'url' => $url
        ];
        return $model->save();
    }
    
    /**
     * 生成充值订单
     */
    public function actionGetAliform() {
        $fee = $this->getParam('fee');
        require_once(COMMON . "/alipay_direct/alipay.config.php");
        require_once(COMMON . "/alipay_direct/lib/alipay_submit.class.php");
        
        $recharge_no = 'rcg' . time();
        
        /**************************请求参数**************************/
        
        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = "http://".Yii::app()->homeUrl."/recharge/notify";
        
        //页面跳转同步通知页面路径
        $return_url = "http://".Yii::app()->homeUrl."/recharge/return";
        
        //商户订单号
        $out_trade_no = $recharge_no;
        //商户网站订单系统中唯一订单号，必填
        
        //订单名称
        $subject = '账号充值';
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
        
        
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"post", "确认");
        echo $html_text;
        
    }
    
    public function actionRecharge() {
        $model = new RechargeLog();
        $model->uid = $this->uid;
        $model->recharge_no = $this->getParam('trade_no');
        $model->amount = $this->getParam('fee');
        $model->subject = $this->getParam('subject');
        $model->body = $this->getParam('body');
        if ($model->save())
            echo json_encode(['status' => '1']);
        else 
            echo json_encode(['status' => '0']);
    }
    
    public function actionGetticket() {
        $vehicle_type = $this->getParam('vehicle_type');
        $order_type = $this->getParam('order_type');
        switch ($order_type) {
            case 'pickup':
                $order_type = '5';
                break;
            case 'send':
                $order_type = '6';
                break;
            default:
                $order_type = '5';
        }
        $type = $order_type . ($vehicle_type-1);
        $criteria = new CDbCriteria();
        $criteria->condition = 't.client_id=:client_id and t.status=:status and expire > :expire';
        $criteria->addCondition('(coupon_type='.COUPON_COMMON.' or coupon_type='.$order_type.' or coupon_type='.$type.')');
        $criteria->order = 't.id asc';
        $criteria->params = [
            'client_id' => $this->uid,
            'status' => CLIENT_TICKET_ACTIVED,
            'expire' => time()
        ];
        $model = ClientTicket::model()->with('ticket')->findAll($criteria);
        $html = '';
        if ($model) {
            $html .= '<select class="form-control mycoupon" name="coupon_id">';
            $html .= '<option>您有' . count($model) . '张优惠券</option>';
            foreach ($model as $item) {
                $html .= '<option value="' . $item->id . '" coupon_cost="' . $item->ticket->name . '">' . $item->ticket->name .'元优惠券</option>';
            }
            $html .= '</select>';
        }
        echo $html;
    }
    
    public function afterAction($action) {
        Yii::app()->end();
    }
    public function accessRules() {
        return [];
    }
}