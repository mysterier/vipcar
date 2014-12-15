<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'commandPath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SuXian Console',
	'timezone'=>'Asia/Shanghai',

	//别名
	'aliases' => array(
		'common' => COMMON 
	),
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'common.models.*',
	),

	// application components
	'components'=>array(
		
		'db'=>array(
			'connectionString' => 'mysql:host=' . DB_HOST_CORE . ';port=' . DB_PORT_CORE . ';dbname=' . DB_NAME_CORE,
			'emulatePrepare' => true,
			'username' => DB_USER_CORE,
			'password' => DB_PASS_CORE,
			'charset' => 'utf8',
			'schemaCachingDuration'=>86400,
			'enableParamLogging'=>true,
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);