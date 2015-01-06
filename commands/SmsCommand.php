<?php
/**
 * 短信相关脚本
 * 
 * @author lqf
 *
 */
class SmsCommand extends CConsoleCommand
{
    /**
     * 发送短信
     * 命令：cli.php send
     * 
     * @author lqf
     */
    public function actionSend() {
        Yii::import('common.sms.sms');
        $model = SmsQueue::model()->findAllByAttributes(['status' => 0]);
        if ($model) {
            foreach ($model as $sms) {
                 sms::sendSms($sms->mobile, $sms->content);
            }
            SmsQueue::model()->updateAll(['status' => 1], 'status=0');      
        }
    }
}