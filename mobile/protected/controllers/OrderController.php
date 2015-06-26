<?php

class OrderController extends Controller
{
    public $flight_date;
    
    public function actionAirportpickup()
    {
        $this->layout = '//layouts/promotion';
        $this->title = '接机';
        //$this->checkExpand();
        $contacter = $this->getContacter();
        $hash['flight_no'] = isset($_GET['flight_no']) ? urldecode($_GET['flight_no']) : '';
        $hash['pickup_time'] = isset($_GET['pickup_time']) ? urldecode($_GET['pickup_time']) : '';
        $hash['pickup_place'] = isset($_GET['pickup_place']) ? urldecode($_GET['pickup_place']) : '';
        $hash['drop_place'] = isset($_GET['drop_place']) ? urldecode($_GET['drop_place']) : '';
        $hash['contacter_name'] = isset($_GET['contacter_name']) ? urldecode($_GET['contacter_name']) : $contacter['name'];
        $hash['contacter_phone'] = isset($_GET['contacter_phone']) ? urldecode($_GET['contacter_phone']) : $contacter['tel'];
        $hash['seats'] = isset($_GET['seats']) ? urldecode($_GET['seats']) : 1;
        $this->render('airportpickup', $hash);
    }
    
    public function actionAirportsend()
    {
        $this->layout = '//layouts/promotion';
        $this->title = '送机';
        //$this->checkExpand();
        $contacter = $this->getContacter();
        $hash['is_round_trip'] = isset($_GET['is_round_trip']) ? urldecode($_GET['is_round_trip']) : '';
        $hash['pickup_time'] = isset($_GET['pickup_time']) ? urldecode($_GET['pickup_time']) : '';
        $hash['pickup_place'] = isset($_GET['pickup_place']) ? urldecode($_GET['pickup_place']) : '';
        $hash['drop_place'] = isset($_GET['drop_place']) ? urldecode($_GET['drop_place']) : '';
        $hash['contacter_name'] = isset($_GET['contacter_name']) ? urldecode($_GET['contacter_name']) : $contacter['name'];
        $hash['contacter_phone'] = isset($_GET['contacter_phone']) ? urldecode($_GET['contacter_phone']) : $contacter['tel'];
        $hash['seats'] = isset($_GET['seats']) ? urldecode($_GET['seats']) : 1;
        
        $this->render('airportsend', $hash);
    }
    
    public function getContacter() {
        $contacter = Clients::model()
                        ->with(['contacter' => ['order' => 'contacter.weight desc']])
                        ->with(['contacter.tel' => ['order' => 'tel.weight desc']])
                        ->findByPk($this->uid);
        $res = [
            'name' => '',
            'tel' => ''
        ];
        if ($contacter->contacter) {
            $nameobj = $contacter->contacter[0];
            $res['name'] = $nameobj->name;
            if ($nameobj->tel) {
                $telobj = $nameobj->tel[0];
                $res['tel'] = $telobj->tel;
            }
        } else {
            $res['name'] = $contacter->real_name;
            $res['tel'] = $contacter->mobile;
        }
        return $res;
    }
    
    public function actionProcess($id) {
        $this->title = '确认订单';
        $scenario = ($id == ORDER_TYPE_AIRPORTSEND) ? 'wechat_send' : 'wechat_pickup';
        $wechat = new Orders($scenario);
        $order_no = 'wx'.time();
        $date = $_POST['pickup_time'];
        $_POST['pickup_time'] = date('Y-m-d H:i:s', strtotime($date));
        $wechat->attributes = $_POST;
        $wechat->client_id = $this->uid;
        $wechat->open_id = $this->openid;
        $wechat->order_no = $order_no;
        $wechat->type = (string)$id;
        $wechat->status = (string)ORDER_STATUS_PAY;        
        if ($wechat->save()) {
            //更新对应优惠券
            if (isset($_POST['coupon_id'])) {
                $coupon = ClientTicket::model()->findByPk($_POST['coupon_id']);
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
    
    public function actionAddcontacter() {
        $this->layout = '//layouts/promotion';
        $this->title = '联系人';
        if ($_POST) {
            // 记录联系人历史
            $contacter = new Contacter();
            $contacter->setContacter();
            $query = $this->replaceQuery($_POST);
            $type = $this->getParam('type', ORDER_TYPE_AIRPORTPICKUP);
            $order_type = ($type == ORDER_TYPE_AIRPORTPICKUP) ? 'airportpickup' : 'airportsend';
            $this->redirect('/order/' . $order_type . '?' . $query);
        }
        $get = Yii::app()->request->getRequestUri();
               
        $this->render('addcontacter');
    }
    
    public function replaceQuery(array $items) {
        $query = '';
        if ($_GET) {
            $query_array = $_GET;
            foreach ($items as $k => $v) {
                $query_array[$k] = urlencode($v);
            }
            $temp = [];
            foreach ($query_array as $key => $value) {
                $temp[]= $key . '=' . $value;
            }
            $query = implode('&', $temp);
        }
        return $query;
    }
    
    /**
     * 获取优惠券
     */
    public function actionGetticket() {
        $vehicle_type = $this->getParam('vehicle_type');
        $order_type = $this->getParam('order_type');
        switch ($order_type) {
            case 'airportpickup':
                $order_type = '5';
                break;
            case 'airportsend':
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
            $html .= '<option>您有' . count($model) . '张优惠券</option>';
            foreach ($model as $item) {
                $html .= '<option value="' . $item->id . '" coupon_cost="' . $item->ticket->name . '">' . $item->ticket->name .'元优惠券</option>';
            }
        }
        echo $html;
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
        $unifiedOrder->setParameter("openid","$this->openid");//openid
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
        $date = date('Y-m-d', strtotime($date));
        $contacter_name = $_POST['contacter_name'];
        $contacter_phone = $_POST['contacter_phone'];
        $seats = $_POST['seats'];
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
                $text = '<div class="text-left col-xs-4">' . $output->result->dep . '</div>';
                $text .= '<div class="text-center col-xs-2">至</div>';
                $text .= '<div class="text-center col-xs-4">' . $output->result->arr . '</div>';
                $text .= '<div class="text-right col-xs-2">' . $arr_time . '</div>';
                $text .= '<div class="clearfix"></div>';
               
                $flight = urlencode($flight);
                $pickup_time = urlencode($pickup_time);
                $pickup_place = urlencode($output->result->arr);
                $contacter_name = urlencode($contacter_name);
                $contacter_phone = urlencode($contacter_phone);
               
                $query = "flight_no={$flight}&pickup_time={$pickup_time}&pickup_place={$pickup_place}&contacter_name={$contacter_name}&contacter_phone={$contacter_phone}&seats={$seats}";

                $html .= '<div class="flight-head"><h3>航班时间选择</h3></div>';
                $html .= '<a href="/order/airportpickup?'.$query.'" class="flight-content a-select">';
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
        $this->layout = '//layouts/promotion';
        $this->title = '查询航班号';
        $hash['contacter_name'] = isset($_GET['contacter_name']) ? $_GET['contacter_name'] : '';
        $hash['contacter_phone'] = isset($_GET['contacter_phone']) ? $_GET['contacter_phone'] : '';
        $hash['seats'] = isset($_GET['seats']) ? $_GET['seats'] : '';
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
                $jsApiParameters = $this->getWxParams($model->order_no, (int)$model->estimated_cost);
                $result['jsApiParameters'] = $jsApiParameters;
            }
        }
        $this->render('detail', $result);
    }
    
    public function filters() {
        return [
            'bindMobile + airportpickup, airportsend, list'
        ];
    }
}