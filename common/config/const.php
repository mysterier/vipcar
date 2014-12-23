<?php

// Global
define('USER_TYPE_CLIENT', 1);
define('USER_TYPE_DRIVER', 2);
define('USER_CLIENT_ACTIVED', 1);
define('USER_CLIENT_NOT_ACTIVED', 0);
define('VEHICLE_TYPE_ECONOMY', 1);
define('VEHICLE_TYPE_COMFORTABLE', 2);
define('VEHICLE_TYPE_BUSINESS', 3);
define('VEHICLE_TYPE_LUXURY', 4);
define('ORDER_STATISTIC', 0);
define('ORDER_MSG_STATISTIC', '无订单记录！');
define('SEX_DEFAULT', '-');
define('SEX_MALE', '男');
define('SEX_FEMALE', '女');
define('FILE_TOOLARGE', '文件大于10M，上传失败！请上传小于10M的文件！');
define('DEFAULT_UPLOAD_PATH', '/workdisk/upload');
define('ID_CARD_EXISTED', '身份证号码已被注册');
define('DEFAULT_PASSWORD', '888888');
//汽车费用
define('STARTING_FARE', 25);
define('FARE_PER_KM', 4);

// Global error
define('ERROR_DEFAULT', - 1);
define('ERROR_MSG_DEFAULT', 'params error');
define('ERROR_MSG_CHECK_POST', 'Please POST first!');
define('ERROR_TOKEN', - 102);
define('ERROR_MSG_SSO', 'token不匹配，可能账号在其他地方登陆');
define('ERROR_MSG_USER_TYPE', '用户类型有误');
define('ERROR_MSG_DB', '数据查询有误');
define('ERROR_MOBILE', - 101);
define('ERROR_MSG_MOBILE', '手机格式错误！');

// Global success
define('SUCCESS_DEFAULT', 1);
define('NO_RECORD', 0);
define('NO_RECORD_MSG', '无记录！');

// Orders status
define('ORDER_STATUS_END', 0);
define('ORDER_STATUS_NEW', 1);
define('ORDER_STATUS_RUN', 2);
define('ORDER_STATUS_HAND', 3);
define('ORDER_STATUS_RUSH', 4);
define('ORDER_STATUS_AUTO_END', 5);
define('ORDER_FINISHED', 0);
define('ORDER_UNFINISHED', 1);

//Orders type
define('ORDER_TYPE_AIRPORTPICKUP', 1);
define('ORDER_TYPE_AIRPORTSEND', 2);
define('ORDER_TYPE_BOOK_AIRPORTPICKUP', 3);
define('ORDER_TYPE_BOOK_AIRPORTSEND', 4);

// API
define('API_ORDER_NEW_FLAG', 2);
define('API_ORDER_UPDATE_FLAG', 1);
define('API_UPDATE_USER_INFO', 1);
define('API_MAINTAIN_USER_INFO', 0);
define('API_MAINTAIN_MESSAGE', 0);
define('API_MAINTAIN_MESSAGE_MSG', '消息未更新！');

// Driver
define('DRIVER_TYPE_OFF', 0);
define('DRIVER_MSG_OFF', '下线');
define('DRIVER_TYPE_ON', 1);
define('DRIVER_MSG_ON', '在线');

//Client
define('CLIENT_EORROR_NOT_ACTIVED', -201);
define('CLIENT_EORROR_MSG_NOT_ACTIVED', '账号未激活！');
define('CLIENT_EORROR_MSG_ACTIVED', '账号已经激活！');
define('CLIENT_EORROR_REGISTERED', -202);
define('CLIENT_EORROR_MSG_REGISTERED', '手机号码已被注册！');

//Coupon
define('COUPON_PREFIX', 2015);
define('COUPON_CHECK_CODE', 201501);


