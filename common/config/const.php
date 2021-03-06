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
define('VEHICLE_STATUS_ON', 1);
define('VEHICLE_MSG_STATUS_ON', '正常');
define('VEHICLE_STATUS_OFF', 0);
define('VEHICLE_MSG_STATUS_OFF', '异常');
define('ORDER_STATISTIC', 0);
define('ORDER_MSG_STATISTIC', '无订单记录！');
define('SEX_DEFAULT', 0);
define('SEX_MSG_DEFAULT', '-');
define('SEX_MALE', 1);
define('SEX_MSG_MALE', '男');
define('SEX_FEMALE', 2);
define('SEX_MSG_FEMALE', '女');
define('FILE_TOOLARGE', '文件大于10M，上传失败！请上传小于10M的文件！');
define('DEFAULT_UPLOAD_PATH', '/workdisk/workdata/www/upload');
define('DEFAULT_CDN_URL', 'cdn.vip-car.com.cn');
define('ERROR_MSG_UPLOAD', '上传失败');
define('ID_CARD_EXISTED', '身份证号码已被注册');
define('LICENSE_NO_EXISTED', '车牌号已经存在');
define('ENGINE_NO_EXISTED', '发动机号已经存在');
define('FRAME_NO_EXISTED', '车架号已经存在');
define('DEFAULT_PASSWORD', '888888');
define('CLIENT_ACTIVED', 1);
define('CLIENT_MSG_ACTIVED', '激活');
define('CLIENT_NOT_ACTIVED', 0);
define('CLIENT_MSG_NOT_ACTIVED', '未激活');
define('CLIENT_TITLE_MALE', '先生');
define('CLIENT_TITLE_FEMALE', '女士');
define('EMAIL_EXISTED', '邮箱已被注册');
define('VERIFY_CODE_EXPIRE', 1800);
define('VERIFY_CODE_RESEND', 60);
define('ADMIN_PAGE_SIZE', 10);
define('DEFAULT_API_SITE', 'api.vip-car.com.cn:8080');
define('STATUS_DEL', 0);
define('STATUS_LIVE', 1);
//汽车费用
define('BASE_DURATION', 2);
define('BASE_DISTANCE', 50);
define('FARE_PER_HOUR', 50);
define('FARE_PER_KM', 4);
define('COMFORTABLE_LOW', 280);
define('COMFORTABLE_HIGH', 380);
define('BUSINESS_LOW', 280);
define('BUSINESS_HIGH', 380);
define('LUXURY_LOW', 680);
define('LUXURY_HIGH', 880);

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
define('ERROR_VERIFY_CODE_RESEND', '重发验证码太频繁！');

// Global success
define('SUCCESS_DEFAULT', 1);
define('NO_RECORD', 0);
define('NO_RECORD_MSG', '无记录！');

// Orders status
define('ORDER_STATUS_END', 6);
define('ORDER_STATUS_NOT_DISTRIBUTE', 0);
define('ORDER_STATUS_DISTRIBUTE', 1);
define('ORDER_STATUS_RUN', 2);
define('ORDER_STATUS_HAND', 3);
define('ORDER_STATUS_RUSH', 4);
define('ORDER_STATUS_PAY', 5);
define('ORDER_STATUS_CANCEL', 7);
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
define('API_MAINTAIN_RECHARGE', 0);
define('API_MAINTAIN_USER_INFO', 0);
define('API_MAINTAIN_MESSAGE', 0);
define('API_MAINTAIN_MESSAGE_MSG', '消息未更新！');

// Driver
define('DRIVER_TYPE_OFF', 0);
define('DRIVER_MSG_OFF', '下线');
define('DRIVER_TYPE_ON', 1);
define('DRIVER_MSG_ON', '在线');
define('DRIVER_FLAG_FREE', 0);
define('DRIVER_FLAG_DISTRIBUTED', 1);

//Client
define('CLIENT_ERROR_NOT_ACTIVED', -201);
define('CLIENT_ERROR_MSG_NOT_ACTIVED', '账号未激活！');
define('CLIENT_ERROR_MSG_ACTIVED', '账号已经激活！');
define('CLIENT_ERROR_REGISTERED', -202);
define('CLIENT_ERROR_MSG_REGISTERED', '该号码已被注册！');
define('CLIENT_ERROR_COUPON', -203);
define('CLIENT_MSG_COUPON_NOT_EXIST', '该优惠码不存在或已被使用');
define('CLIENT_MSG_COUPON_NOT_ACTIVED', '该优惠码不可用');
define('CLIENT_TICKET_DEL', 0);
define('CLIENT_TICKET_ACTIVED', 1);
define('CLIENT_TICKET_USED', 2);
define('CLIENT_TICKET_DONATE', 3);
define('CLIENT_ERROR_NOT_EXISTED', -204);
define('CLIENT_ERROR_MSG_NOT_EXISTED', '该用户不存在');
define('CLIENT_ERROR_NOT_SUFFICIENT_FUNDS', -205);
define('CLIENT_ERROR_MSG_NOT_SUFFICIENT_FUNDS', '订单余额不足');

//Coupon
define('COUPON_PREFIX', 2015);
define('COUPON_CHECK_CODE', 201501);
define('WX_COUPON_STATUS_ON', 1);
define('WX_COUPON_STATUS_OFF', 2);
define('COUPON_COMMON', '99');
define('COUPON_PICKUP', '5');
define('COUPON_COMFORTABLE_PICKUP', '51');
define('COUPON_BUSINESS_PICKUP', '52');
define('COUPON_LUXURY_PICKUP', '53');
define('COUPON_SEND', '6');
define('COUPON_COMFORTABLE_SEND', '61');
define('COUPON_BUSINESS_SEND', '62');
define('COUPON_LUXURY_SEND', '63');

//sms_tpl
define('SMS_VERIFY_CODE', 'verify_code');
define('SMS_WX_NOTIFY', 'wx_notify');

//===========RBAC=============
//roles
define('ADMINISTRATOR', 'administrator');
//tasks
define('ORDER_MANAGER', 'order_manager');
define('VEHICLE_MANAGER', 'vehicle_manager');
define('CLIENT_MANAGER', 'client_manager');
define('DRIVER_MANAGER', 'driver_manager');
define('AUTH_MANAGER', 'auth_manager');
define('ADMIN_MANAGER', 'admin_manager');
define('NOTICE_MANAGER', 'notice_manager');
define('EVENT_MANAGER', 'event_manager');
define('MAGAZINE_MANAGER', 'magazine_manager');
//operation
define('VIEW_ORDER', 'view_order');
define('MODIFY_ORDER', 'modify_order');
define('DEL_ORDER', 'del_order');
define('VIEW_VEHICLE', 'view_vehicle');
define('NEW_VEHICLE', 'new_vehicle');
define('MODIFY_VEHICLE', 'modify_vehicle');
define('DEL_VEHICLE', 'del_vehicle');
define('VIEW_CLIENT', 'view_client');
define('NEW_CLIENT', 'new_client');
define('MODIFY_CLIENT', 'modify_client');
define('DEL_CLIENT', 'del_client');
define('VIEW_DRIVER', 'view_driver');
define('NEW_DRIVER', 'new_driver');
define('MODIFY_DRIVER', 'modify_driver');
define('DEL_DRIVER', 'del_driver');
define('VIEW_AUTH', 'view_auth');
define('MODIFY_AUTH', 'modify_auth');
define('NEW_ROLE', 'new_role');
define('DEL_ROLE', 'del_role');
define('VIEW_ADMIN', 'view_admin');
define('NEW_ADMIN', 'new_admin');
define('MODIFY_ADMIN', 'modify_admin');
define('DEL_ADMIN', 'del_admin');
define('ADMIN_ROLE', 'admin_role');
define('VIEW_NOTICE', 'view_notice');
define('NEW_NOTICE', 'new_notice');
define('MODIFY_NOTICE', 'modify_notice');
define('DEL_NOTICE', 'del_notice');
define('VIEW_EVENT', 'view_event');
define('NEW_EVENT', 'new_event');
define('MODIFY_EVENT', 'modify_event');
define('DEL_EVENT', 'del_event');
define('VIEW_MAGAZINE', 'view_magazine');
define('NEW_MAGAZINE', 'new_magazine');
define('MODIFY_MAGAZINE', 'modify_magazine');
define('DEL_MAGAZINE', 'del_magazine');

