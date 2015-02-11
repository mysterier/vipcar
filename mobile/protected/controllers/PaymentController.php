<?php

class PaymentController extends Controller
{

    public function actionIndex()
    {
        
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
                // 此处应该更新一下订单状态，商户自行增删操作
                $this->writeIntoFile("【通信出错】:\n" . $xml . "\n");
            } elseif ($notify->data["result_code"] == "FAIL") {
                // 此处应该更新一下订单状态，商户自行增删操作
                $this->writeIntoFile("【业务出错】:\n" . $xml . "\n");
            } else {
                // 此处应该更新一下订单状态，商户自行增删操作
                $this->writeIntoFile("【支付成功】:\n" . $xml . "\n");
            }
            
            // 商户自行增加处理流程,
            // 例如：更新订单状态
            // 例如：数据库操作
            // 例如：推送支付完成信息
        }
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