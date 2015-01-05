<?php

class sms
{

    private static $data;

    /**
     * 发送短信
     *
     * @param string $tpl            
     * @param string $mobile            
     * @param string $data            
     *
     * @author lqf
     */
    public static function sendSms($mobile, $msg)
    {       
        $msg = mb_convert_encoding($msg, 'GB2312', 'UTF-8');
        $params = [
            'uid' => mb_convert_encoding(SMS_UID, 'GB2312', 'UTF-8'),
            'pwd' => md5(SMS_PWD),
            'mobile' => $mobile,
            'msg' => $msg,
            'dtime' => '',
            'linkid' => ''
        ];
        
        self::posttohost($params);
    }

    /**
     * 获取短信模板
     * 
     * @param string $tpl
     * @param array $data
     * @return string 短信
     * 
     * @author lqf
     */
    public static function getSmsTpl($tpl, $data)
    {
        $sms_tpl = include COMMON . '/sms/sms_tpl.php';
        $msg = $sms_tpl[$tpl];
        
        self::$data = $data;
        $msg = preg_replace_callback('/{(\d+)}/', function ($matches)
        {
            return self::$data[$matches[1]];
        }, $msg);
        
        return $msg;
    }

    public function posttohost($params)
    {
        $url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send_md5/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $output = curl_exec($ch);
        if ($output === FALSE) 
            $output = "cURL Error: " . curl_error($ch) . "\n";
        else
            $output = mb_convert_encoding($output, 'UTF-8', 'GB2312') . "\n";
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        $output .= 'mobile:' . $params['mobile'] . "\n";
        $output .= 'msg:' .  mb_convert_encoding($params['msg'], 'UTF-8', 'GB2312') . "\n";
        $output .= '总耗时:' . $info['total_time'] . "\n";
        $output .= '等待连接耗时 :' . $info['connect_time'] . "\n";
        $output .= "====================\n";
        
        self::writeIntoFile($output);
        echo $output;
    }

    /**
     * 记录日志
     *
     * @param string $text            
     * @author lqf
     */
    public function writeIntoFile($text)
    {
        $dir = realpath(SYSTEM_PATH) . '/commands/runtime/smslogs/';
        $dir .= date('Y') . '/' . date('m');
        if (! is_dir($dir))
            mkdir($dir, 0777, true);
        
        $logFile = $dir . '/' . date('Y-m-d');
        file_put_contents($logFile, $text, FILE_APPEND | LOCK_EX);
    }
}