<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '众择后台管理',
    'timezone' => 'Asia/Shanghai',
    
    // 别名
    'aliases' => array(
        'common' => COMMON
    ),
    
    // preloading 'log' component
    'preload' => array(
        'log',
        'booster'
    ),
    
    // autoloading model and component classes
    'import' => array(
        'common.models.*',
        'application.models.*',
        'application.components.*'
    ),
    
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array(
                '192.168.1.102',
                '::1'
            )
        )
    ),
    
    // application components
    'components' => array(
        'user' => array(
            
            // enable cookie-based authentication
            'allowAutoLogin' => true
        ),
        'authManager' => [
            'class' => 'CDbAuthManager',
        ],
        // uncomment the following to enable URLs in path-format
        
        'urlManager' => array(
            'showScriptName' => false,
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<view:about>' => 'site/page',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
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
            'enableProfiling' => true
        ),
        
        // uncomment the following to use a MySQL database
        'errorHandler' => array(
            
            // use 'site/error' action to display errors
            'errorAction' => 'site/error'
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
                    'ipFilters' => array(
                        '127.0.0.1',
                        '192.168.1.102'
                    )
                ),
//                 array(
//                 'class'=>'CWebLogRoute',
//                 ),
            )         
        ),
        'booster' => array(
            'class' => 'common.booster.components.Booster'
        )
    ),
    
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com'
    )
);