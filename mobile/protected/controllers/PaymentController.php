<?php

class PaymentController extends Controller
{

    public function actionIndex()
    {
        
    }
    
    public function beforeAction($action) {
        return true;
    }
    public function actionNotify()
    {
        include_once (COMMON . "/wxpay/WxPayPubHelper.php");

        // 使用通用通知接口
        $notify = new Notify_pub();
        
        // 存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        
        // 验证签名，并回应微信。
        // 对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        // 微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        // 尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if ($notify->checkSign() == FALSE) {
            $notify->setReturnParameter("return_code", "FAIL"); // 返回状态码
            $notify->setReturnParameter("return_msg", "签名失败"); // 返回信息
        } else {
            $notify->setReturnParameter("return_code", "SUCCESS"); // 设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;
        
        // ==商户根据实际情况设置相应的处理流程，此处仅作举例=======
        
        // 以log文件形式记录回调信息
        $this->writeIntoFile("【接收到的notify通知】:\n" . $xml . "\n");
        
        if ($notify->checkSign() == TRUE) {
            if ($notify->data["return_code"] == "FAIL") {
                $this->writeIntoFile("【通信出错】:\n" . $xml . "\n");
            } elseif ($notify->data["result_code"] == "FAIL") {
                $this->writeIntoFile("【业务出错】:\n" . $xml . "\n");
            } else {
                $util = new Common_util_pub();
                $array = $util->xmlToArray($xml);
                $attributes = [
                    'open_id' => $array['openid'],
                    'order_no' => $array['out_trade_no']
                ];
                $model = Orders::model()->findByAttributes($attributes);
                if ($model && $model->status == ORDER_STATUS_HAND) {
                    $model->status = ORDER_STATUS_NOT_DISTRIBUTE;
                    if ($model->save()) {
                        $attributes = [
                            'open_id' => $array['openid'],
                            'order_id' => $model->id
                        ];
                        $coupon = WxCoupon::model()->findByAttributes($attributes);
                        if ($coupon) {
                            $coupon->status = 2;
                            $coupon->save();
                            if ($coupon->value == 50)
                                $this->sendCoupon($model);
                        } else {
                            $this->sendCoupon($model);
                        }
                        
                        //发送验证短信
                        Yii::import('common.sms.sms');
                        $data = [
                            $model->contacter_name,
                            $model->contacter_phone,
                            $model->pickup_time,
                            $model->pickup_place,
                            $model->drop_place
                        ];
                        $content = sms::getSmsTpl(SMS_WX_NOTIFY, $data);
                        $mobiles = [
                            '15021843860',
                            '13801939692'
                        ];
                        foreach ($mobiles as $mobile) {
                            sms::addSmsToQueue($mobile, SMS_WX_NOTIFY, $content);
                        }                       
                    }
                }
                $this->writeIntoFile("【支付成功】:\n" . $xml . "\n");
            }
        }
    }
    
    public function sendCoupon(Orders $order) {
        $coupon = new WxCoupon();
        $coupon->open_id = $order->open_id;
        $coupon->value = 450;
        $coupon->scope = ($order->type == ORDER_TYPE_AIRPORTPICKUP) ? ORDER_TYPE_AIRPORTSEND : ORDER_TYPE_AIRPORTPICKUP;
        $coupon->save();
    }
    
    /**
     * 记录调用接口日志
     *
     * @param string $text
     * @author lqf
     */
    public function writeIntoFile($text)
    {        
        $dir = realpath(SYSTEM_PATH) . '/mobile/protected/runtime/wxpaylogs/';
        $dir .= date('Y') . '/' . date('m');
        if (! is_dir($dir))
            mkdir($dir, 0777, true);
    
        $logFile = $dir . '/' . date('Y-m-d');
        file_put_contents($logFile, $text, FILE_APPEND | LOCK_EX);
    }
}