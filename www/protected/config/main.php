<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '众择',
    'timezone' => 'Asia/Shanghai',
    'defaultController' => 'home',
    // 别名
    'aliases' => array(
        'common' => COMMON
    ),
    
    // preloading 'log' component
    'preload' => array(
        'log'
    ),
    
    // autoloading model and component classes
    'import' => array(
        'common.models.*',
        'application.models.*',
        'application.components.*'
    ),
    
    'modules' => array(
    ),
    
    // application components
    'components' => array(
        'user' => array(
            'loginUrl' => '/login',
            // enable cookie-based authentication
            'allowAutoLogin' => true
        ),
        
        // uncomment the following to enable URLs in path-format
        
        'urlManager' => array(
            'showScriptName' => false,
            'urlFormat' => 'path',
            'rules' => array(
                '<action:\w+>' => 'home/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',         
            )
        ),
        
        'db' => array(
            'connectionString' => 'mysql:host=' . DB_HOST_CORE . ';port=' . DB_PORT_CORE . ';dbname=' . DB_NAME_CORE,
            'emulatePrepare' => true,
            'username' => DB_USER_CORE,
            'password' => DB_PASS_CORE,
            'charset' => 'utf8',
            'schemaCachingDuration' => 86400,
            'enableParamLogging' => true,
            'enableProfiling'=>true,
        ),
        
        // uncomment the following to use a MySQL database
        'errorHandler' => array(
            
            // use 'site/error' action to display errors
            'errorAction' => 'home/error'
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning'
                ),
                array(
                    'class' => 'common.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters'=>array('127.0.0.1','192.168.1.102'),
                ),
                // uncomment the following to show log messages on web pages                
//                 array(
//                     'class'=>'CWebLogRoute',
//                     'categories' => 'common.*'
//                 ),
            ),           
        )
    ),
    
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com'
    )
);
