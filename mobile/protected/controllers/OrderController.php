<?php

class OrderController extends Controller
{
    public $flight_date;
    
    public function actionAirportpickup()
    {
        $this->title = '接机';
        
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
        $this->render('airportsend');
    }
    
    public function actionProcess($id) {
        $this->layout = '//layouts/page';
        $wechat = new WechatOrders();
        $wechat->attributes = $_POST;
        $wechat->order_no = 'wx'.time();
        $wechat->type = (string)$id;
        $wechat->save();
        $this->render('success');
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
               $dep_time = strtotime($output->result->dep_time);
               $arr_time = strtotime($output->result->arr_time);
               if ($arr_time < $dep_time) {
                   $date = strtotime($date .' +1 day');
                   $date = date('Y-m-d', $date);
               }
               $pickup_time .= $date . ' ' . $output->result->arr_time;
               $text = '<span class="title">航班时间选择</span>';
               $text .= $output->result->dep . '&nbsp;&nbsp;&nbsp;&nbsp;至 &nbsp;&nbsp;&nbsp;&nbsp;' . $output->result->arr . '&nbsp;&nbsp;&nbsp;&nbsp;到达时间：'. $output->result->arr_time;
               
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
}