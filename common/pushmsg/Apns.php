<?php
Yii::import('common.pushmsg.ApnsPHP.*');

class Apns
{

    private static $_instance;

    private function __construct()
    {
        Yii::registerAutoloader(['Apns', 'ApnsPHP_Autoload']);
    }

    public static function action()
    {
        if (! (self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public static function ApnsPHP_Autoload($sClassName)
    {
        if (empty($sClassName)) {
            throw new Exception('Class name is empty');
        }
        
        $sPath = dirname(__FILE__);
        if (empty($sPath)) {
            throw new Exception('Current path is empty');
        }
        
        $sFile = sprintf('%s%s%s.php', $sPath, DIRECTORY_SEPARATOR, str_replace('_', DIRECTORY_SEPARATOR, $sClassName));
        if (is_file($sFile) && is_readable($sFile)) {
            require_once $sFile;
        }
    }
    
    public function pushMsg() {
        $push = new ApnsPHP_Push(
            ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
            'server_certificates_bundle_sandbox.pem'
        );
        var_dump($push);exit();
    }
}