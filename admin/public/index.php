<?php
$yii = realpath(dirname(__FILE__) . '/../../yii/yii.php');
$config = realpath(dirname(__FILE__) . '/../protected/config/main.php');

define('SYSTEM_PATH', __DIR__ . '/../../');
define('COMMON', realpath(SYSTEM_PATH . 'common'));

include (COMMON . '/config/config.php');
include (COMMON . '/config/const.php');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once ($yii);
Yii::createWebApplication($config)->run();
