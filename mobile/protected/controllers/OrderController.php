<?php

class OrderController extends Controller
{
    public $flight_date;
    
    public function actionAirportpickup()
    {
        $this->title = '接机';
        $this->checkExpand();
        $coupons = $this->couponlist();
        $hash['coupons'] = $coupons;
        $hash['flight_no'] = isset($_GET['flight_no']) ? urldecode($_GET['flight_no']) : '';
        $hash['pickup_time'] = isset($_GET['pickup_time']) ? urldecode($_GET['pickup_time']) : '';
        $hash['pickup_place'] = isset($_GET['pickup_place']) ? urldecode($_GET['pickup_place']) : '';
        $hash['contacter_name'] = isset($_GET['contacter_name']) ? urldecode($_GET['contacter_name']) : '';
        $hash['contacter_phone'] = isset($_GET['contacter_phone']) ? urldecode($_GET['contacter_phone']) : '';
        $this->render('airportpickup', $hash);
    }
    
    public function actionAirportsend()
    {
        $this->title = '送机';
        $this->checkExpand();
        $coupons = $this->couponlist();
        $hash['coupons'] = $coupons;
        $this->render('airportsend', $hash);
    }
    
    private function couponlist() {
        $scope = ($this->action->id == 'airportsend') ? ORDER_TYPE_AIRPORTSEND : ORDER_TYPE_AIRPORTPICKUP;
        $condition = 'open_id=:open_id and status=:status and (scope=:scope or scope=3)';
        $params = [
            'open_id' => $this->openid,
            'status' => 1,
            'scope' => $scope
        ];
        $model = WxCoupon::model()->findAll($condition, $params);
        return $model;
    }
    
    public function actionProcess($id) {
        $this->title = '确认订单';
        $scenario = ($id == ORDER_TYPE_AIRPORTSEND) ? 'wechat_send' : 'wechat_pickup';
        $wechat = new Orders($scenario);
        $order_no = 'wx'.time();
        $wechat->attributes = $_POST;
        $wechat->open_id = $this->openid;
        $wechat->order_no = $order_no;
        $wechat->type = (string)$id;
        $wechat->status = ORDER_STATUS_HAND; //暂定
        if ($wechat->save()) {
            //更新对应优惠券
            if (isset($_POST['coupon_id'])) {
                $coupon = WxCoupon::model()->findByPk($_POST['coupon_id']);
                if ($coupon) {
                    $coupon->order_id = $wechat->id;
                    $coupon->last_update = time();
                    $coupon->save();
                }
            }
            
            $total_fee = $_POST['estimated_cost'];
            if ($total_fee == 0)
                $this->successForCoupon($wechat, $coupon);
            $total_fee *= 100; 
            $jsApiParameters = $this->getWxParams($order_no, $total_fee);
            $hash = $_POST;
            $hash['jsApiParameters'] = $jsApiParameters;
            $this->render('confirm_order', $hash);
        }   
    }
    
    /**
     * 只有当预付款0元时调用次方法
     * @param unknown $order
     * @param unknown $coupon
     */
    private function successForCoupon($order, $coupon) {
        $order->status = ORDER_STATUS_NOT_DISTRIBUTE;
        $order->save();
        $coupon->status = 2;
        $coupon->save();
        
        //发送验证短信
        Yii::import('common.sms.sms');
        $data = [
            $order->contacter_name,
            $order->contacter_phone,
            $order->pickup_time,
            $order->pickup_place,
            $order->drop_place
        ];
        $content = sms::getSmsTpl(SMS_WX_NOTIFY, $data);
        $mobiles = [
            '15021843860',
            '13801939692'
        ];
        foreach ($mobiles as $mobile) {
            sms::addSmsToQueue($mobile, SMS_WX_NOTIFY, $content);
        }
        
        $this->redirect('/order/success');
    }
    
    public function actionSuccess() {
        $this->layout = '//layouts/page';
        $this->render('success');
    }
    
    private function getWxParams($order_no, $total_fee='1') {
        include_once(COMMON . "/wxpay/WxPayPubHelper.php");
        //使用jsapi接口
        $jsApi = new JsApi_pub();
        
        //=========步骤1：网页授权获取用户openid============
        
        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();
        
        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $unifiedOrder->setParameter("openid","$this->openid");//商品描述
        $unifiedOrder->setParameter("body","订单支付");//商品描述
        $unifiedOrder->setParameter("out_trade_no","$order_no");//商户订单号
        $unifiedOrder->setParameter("total_fee","$total_fee");//总金额
        $unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID
    
        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);
    
        $jsApiParameters = $jsApi->getParameters();
        return $jsApiParameters;
    }
    
    public function actionGetflight() {
        $flight = $_POST['flight'];
        $date = $_POST['date'];
        $contacter_name = $_POST['contacter_name'];
        $contacter_phone = $_POST['contacter_phone'];
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
                'error_code' => 0
            ];
        } else {
            $output = json_decode($output);
            $pickup_time = $html = '';
            if ($output->result) {
               $dep_time = preg_match('/\d{2}:\d{2}/', $output->result->dep_time, $m) ? $m[0] : '';
               $arr_time = preg_match('/\d{2}:\d{2}/', $output->result->arr_time, $m) ? $m[0] : '';
               if (strtotime($arr_time) < strtotime($dep_time)) {
                   $date = strtotime($date .' +1 day');
                   $date = date('Y-m-d', $date);
               }
               $pickup_time .= $date . ' ' . $arr_time;
               $text = '<span class="title">航班时间选择</span>';
               $text .= $output->result->dep . '&nbsp;&nbsp;&nbsp;&nbsp;至 &nbsp;&nbsp;&nbsp;&nbsp;' . $output->result->arr . '&nbsp;&nbsp;&nbsp;&nbsp;到达时间：'. $arr_time;
               
               $flight = urlencode($flight);
               $pickup_time = urlencode($pickup_time);
               $pickup_place = urlencode($output->result->arr);
               $contacter_name = urlencode($contacter_name);
               $contacter_phone = urlencode($contacter_phone);
               
               $query = "flight_no={$flight}&pickup_time={$pickup_time}&pickup_place={$pickup_place}&contacter_name={$contacter_name}&contacter_phone={$contacter_phone}";
                             
               $html .= '<a href="/order/airportpickup?'.$query.'" class="hangban-time">';
               $html .= $text;
               $html .= '</a>';
            }            
            
            $output = [
                'error_code' => $output->error_code,
                'html' => $html
            ];
        }
        curl_close($ch);
        
        
        $res = json_encode($output);
        echo $res;
        Yii::app()->end();
    }
    
    public function actionFlight() {
        $this->title = '查询航班号';
        $hash['contacter_name'] = isset($_GET['contacter_name']) ? $_GET['contacter_name'] : '';
        $hash['contacter_phone'] = isset($_GET['contacter_phone']) ? $_GET['contacter_phone'] : '';
        $this->render('flight', $hash);
    }
    
    public function actionList() {
        $this->title = '我的订单';
        $criteria = new CDbCriteria();
        $criteria->select = 'id,pickup_place,vehicle_type,drop_place,type,status,created,last_update';
        $criteria->condition = 'open_id=:open_id and t.status != :status';
        $criteria->order = 't.id desc';
        $criteria->params = [
            'open_id' => $this->openid,
            'status' => (string)ORDER_STATUS_HAND
        ];
        
        $orders = Orders::model()->with('driver')->with('driver.vehicle')->findAll($criteria);
        $hash['orders'] = $orders;
        $this->render('list', $hash);
    }
    
    public function actionDetail($id)
    {   
        $this->title = '订单详情';
        $result = [];
        $model = Orders::model()->with('driver')->findByPk($id);
        if ($model) {
            $result['pickup_place'] = $model->pickup_place;
            $result['pickup_time'] = $model->pickup_time;
            $result['drop_place'] = $model->drop_place;
            $result['highway_fee'] = $model->highway_fee;
            $result['packing_fee'] = $model->packing_fee;
            $result['all_cost'] = $model->order_income;
            $result['contacter_name'] = $model->contacter_name;
            $result['contacter_mobile'] = $model->contacter_phone;
            $result['is_round_trip'] = $model->is_round_trip;            
            $result['vehicle_type'] = $model->vehicle_type;
            $result['flight_number'] = $model->flight_number;
            $result['summary'] = $model->summary;
            $result['status'] = $model->status;
            
            if ($model->status == ORDER_STATUS_PAY) {
                $jsApiParameters = $this->getWxParams($model->order_no, '1');
                $result['jsApiParameters'] = $jsApiParameters;
            }
        }
        $this->render('detail', $result);
    }
}