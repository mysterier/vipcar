<?php
Yii::import('common.pushmsg.sdk.*');

/**
 * Yii::import('common.pushmsg.*');
 * $token = '20b6c4bf037d0aaf4f5387a8590cb29561';
 * $tpl = SMS_VERIFY_CODE;
 * $a = PushMsg::action()->pushMsg($token, $tpl);
 * 
 * @author lqf
 *
 */
class PushMsg
{

    private static $_instance;

    private $_channel;

    private function __construct()
    {
        $this->_channel = new Channel(CHANNEL_API_KEY, CHANNEL_SECRET_KEY);
    }

    public static function action()
    {
        if (! (self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * 推送消息
     *
     * @param string $token            
     * @param string $tpl            
     * @param array $options
     *            options 的 key值push_type
     */
    public function pushMsg($token, $tpl, $options = [])
    {
        $msg_tpl = include COMMON . "/pushmsg/msg_tpl.php";
        extract($options);
        if (! isset($push_type))
            $push_type = 1;
            // 推送消息到某个user，设置push_type = 1;
            // 推送消息到一个tag中的全部user，设置push_type = 2;
            // 推送消息到该app中的全部user，设置push_type = 3;
        switch ($push_type) {
            case 1:
                $attributes = is_array($token) ? $token : [
                    'token' => $token
                ];
                
                $model = Token::model()->findByAttributes($attributes);
                if (! $model)
                    return false;
                
                $optional[Channel::USER_ID] = $model->user_id;
                $optional[Channel::CHANNEL_ID] = $model->channel_id;
                break;
            case 2:
                if (! isset($tag))
                    return false;
                $optional[Channel::TAG_NAME] = $tag;
                break;
        }
        
        isset($device_type) ? $optional[Channel::DEVICE_TYPE] = $device_type : '';
        
        $optional[Channel::MESSAGE_TYPE] = isset($message_type) ? $message_type : 1;
        
        $message = $msg_tpl[$tpl];
        isset($description) ? $message['description'] = $description : '';
        $message = json_encode($message);
        $message_key = time();
        $ret = $this->_channel->pushMessage($push_type, $message, $message_key, $optional);
        if (false === $ret) {
            $output = 'WRONG, ' . __FUNCTION__ . " ERROR!!!!! \n";
            $output .= 'ERROR NUMBER: ' . $this->_channel->errno() . "\n";
            $output .= 'ERROR MESSAGE: ' . $this->_channel->errmsg() . "\n";
            $output .= 'REQUEST ID: ' . $this->_channel->getRequestId() . "\n";
            $this->writeIntoFile($output);
            return false;
        }
        return true;
    }

    /**
     * 记录日志
     *
     * @param string $text            
     * @author lqf
     */
    public function writeIntoFile($text)
    {
        $dir = realpath(SYSTEM_PATH) . '/api/protected/runtime/pushmsglogs/';
        $dir .= date('Y') . '/' . date('m');
        if (! is_dir($dir))
            mkdir($dir, 0777, true);
        
        $logFile = $dir . '/' . date('Y-m-d');
        file_put_contents($logFile, $text, FILE_APPEND | LOCK_EX);
    }
}