#!/usr/bin/php
<?php
$yii = realpath(__DIR__ . '/../yii/yii.php');
$config = __DIR__ . '/config/console.php';

define('SYSTEM_PATH', __DIR__ . '/../');
define('COMMON', realpath(SYSTEM_PATH . 'common'));

include (COMMON . '/config/config.php');
include (COMMON . '/config/const.php');

require_once ($yii);
Yii::createConsoleApplication($config)->run();