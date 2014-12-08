<?php

// Global
define('USER_TYPE_CLIENT', 1);
define('USER_TYPE_DRIVER', 2);
define('USER_CLIENT_ACTIVED', 1);
define('USER_CLIENT_NOT_ACTIVED', 0);

// Global error
define('ERROR_DEFAULT', - 1);
define('ERROR_MSG_DEFAULT', 'params error');
define('ERROR_MSG_CHECK_POST', 'Please POST first!');
define('ERROR_MSG_SSO', '账号在其他地方登陆');
define('ERROR_MSG_USER_TYPE', '用户类型有误');
define('ERROR_MSG_DB', '数据查询有误');

// Global success
define('SUCCESS_DEFAULT', 1);

// Orders status
define('ORDER_TYPE_END', 0);
define('ORDER_TYPE_NEW', 1);
define('ORDER_TYPE_RUN', 2);
define('ORDER_TYPE_HAND', 3);
define('ORDER_TYPE_RUSH', 4);
define('ORDER_TYPE_AUTO_END', 5);
define('ORDER_TYPE_FINISHED', 0);
define('ORDER_TYPE_UNFINISHED', 1);

// API
define('API_ORDER_NEW_FLAG', 2);
define('API_ORDER_UPDATE_FLAG', 1);
define('API_UPDATE_DRIVER_INFO', 1);
define('API_MAINTAIN_DRIVER_INFO', 0);
define('API_MAINTAIN_MESSAGE', 0);
define('API_MAINTAIN_MESSAGE_MSG', '消息未更新！');

// Driver
define('DRIVER_TYPE_OFF', 0);
define('DRIVER_TYPE_ON', 1);

//Client
define('CLIENT_EORROR_NOT_ACTIVED', -2);
define('CLIENT_EORROR_MSG_NOT_ACTIVED', '账号未激活！');
define('CLIENT_EORROR_MSG_ACTIVED', '账号已经激活！');