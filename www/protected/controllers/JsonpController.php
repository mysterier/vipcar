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
    
    /**
     * 取消待分配订单
     */
    public function actionCancelzero() {
        $id = $this->getParam('id');
        $model = Orders::model()->findByPk($id);       
        $model->status = (string) ORDER_STATUS_CANCEL;
        $model->last_update = time();
        if ($model->save(false)) {
            $output = [
                'error_code' => 0
            ];
        } else {
            $output = [
                'error_code' => -1
            ];
        }
                     
        echo json_encode($output);
    }
    
    /**
     * 取消已分配订单
     */
    public function actionCancelone() {
        $id = $this->getParam('id');
        $confirm = $this->getParam('confirm');
        $model = Orders::model()->findByPk($id);
             
        $pickup_time = strtotime($model->pickup_time);
        $len = $pickup_time - time();
        if ($len < 7200) {
            if ($confirm) {
                $output = [
                    'error_code' => 1
                ];
                echo json_encode($output);
                Yii::app()->end();
            }
            // 开启事务处理
            $transaction = Yii::app()->db->beginTransaction();
            //扣除20%费用
            // 修改账户余额
            $client_obj = Clients::model()->findByPk($this->uid);
            $payment = ($model->estimated_cost)*0.2;
            $client_obj->account_balance = $client_obj->account_balance - $payment;
            $client_obj->last_update = time();
            $client_obj->setScenario('modify_balance');
            if ($client_obj->save()) {
                // 支付记录
                $palylog = new PayLog();
                $palylog->uid = $this->uid;
                $palylog->amount = $payment;
                $palylog->order_id = $id;
                if (!$palylog->save())
                    $transaction->rollback();
            } else
                $transaction->rollback();
        }                   
    
        $model->status = (string) ORDER_STATUS_CANCEL;
        $model->last_update = time();
        if ($model->save(false)) {
            //司机变更为空闲 加百度推送
            Drivers::model()->modifyFlag(DRIVER_FLAG_FREE, $model);
            // 给司机发送通知
            Yii::import('common.pushmsg.*');
            $attributes = [
                'client_id' => $model->driver_id,
                'type' => USER_TYPE_DRIVER
            ];
            $tpl = 'driver_new_order';
            $option = [
                'description' => '订单' . $model->order_no . '，用户已取消，请耐心等待下一单吧。'
            ];
            PushMsg::action()->pushMsg($attributes, $tpl, $option);
            $transaction->commit();
            $output = [
                'error_code' => 0
            ];
        } else {
            $transaction->rollback();
            $output = [
                'error_code' => -1
            ];
        }
         
        echo json_encode($output);
    }
        
    public function afterAction($action) {
        Yii::app()->end();
    }
    public function accessRules() {
        return [];
    }
}