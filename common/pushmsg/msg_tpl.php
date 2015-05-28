<?php
/**
 * 属性说明：
 * 参数名称 	                                                       数据类型 	说明
 * title 	                  string 	通知标题，可以为空；如果为空则设为appid对应的应用名；
 * 
 * description 	              string 	通知文本内容，不能为空；
 * 
 * notification_builder_id 	  int 	    Android客户端自定义通知样式，如果没有设置默认为0;(具体使用方法参照管理控制台页面)
 * 
 * notification_basic_style   int 	    notification_basic_style:只有notification_builder_id为0时才有效，才需要设置；该属性是整型，每一位代表一种基本样式，基本样式用二进制位表示如下
 *                                      响铃：0100B=0x04
 *                                      振动：0010B=0x02
 *                                      可清除：0001B=0x01
 *                                      如果需要同时设置多种基本样式，可以对上述三种基本样式做“或”运算，例如要设置通知为响铃、振动和可清除、则notification_basic_style 值为：
 *                                      notification_basic_style=0100B | 0010B | 0001B= 0111B=0x07
 *                                      
 * open_type 	              int 	            点击通知后的行为
 *                                      1: 表示打开Url
 *                                      2: 表示打开应用  
 *                                      i.如果pkg_content有定义，则按照自定义行为打开应用 
 *                                      ii.如果pkg_content无定义，则启动app的launcher activity
 *                                      
 * url 	                      string 	只有open_type为1时才有效，为需要打开的url地址；
 * 
 * user_confirm 	          int 	            只有open_type为1时才有效
 *                                      1: 表示打开url地址时需要经过用户允许 
 *                                      0：默认值，表示直接打开url地址不需要用户允许 
 * 
 * pkg_content 	              string 	只有open_type为2时才有效, 
 *                                      Android端SDK会把pkg_content字符串转换成Android Intent,通过该Intent打开对应app组件，所以pkg_content字符串格式必须遵循Intent uri格式，最简单的方法可以通过Intent方法toURI()获取
 *
 * custom_content 	          object 	只有open_type为2时才有效,
 *                                      自定义内容，键值对，Json对象形式(可选)；在android客户端，这些键值对将以Intent中的extra进行传递。 
 */
return  [
    SMS_VERIFY_CODE => [
        'title' => '众择租车',
        'description' => '租车一起租啊租',
        'notification_basic_style' => 7,
        'open_type' => 2,
        'custom_content' => [
            'key' => 'value'
        ]
    ],
    'order_confirm' => [
        'title' => '众择租车来消息啦',
        'description' => '您的订单xxxxx已被确认，司机正向您火速奔来。',
        'notification_basic_style' => 7,
        'open_type' => 2,
        'custom_content' => [
            'key' => 'value'
        ]
    ],
    'order_finished' => [
        'title' => '众择租车来消息啦',
        'description' => '订单xxxxx已完成，感谢您的乘坐，众择用车只做最专业的接送机服务。',
        'notification_basic_style' => 7,
        'open_type' => 2,
        'custom_content' => [
            'key' => 'value'
        ]
    ],
    'bill_confirm' => [
        'title' => '众择租车来消息啦',
        'description' => '订单xxxxx的账单已生成，请您核实查验：xx机场接送机服务xx型xxx元，额外费用：xxxx，xxx元，共计xxx元。',
        'notification_basic_style' => 7,
        'open_type' => 2,
        'custom_content' => [
            'key' => 'value'
        ]
    ],
    'driver_new_order' => [
        'title' => '众择租车来消息啦',
        'description' => '叮咚，您有新的分配订单，请注意查阅。',
        'notification_basic_style' => 7,
        'open_type' => 2,
        'custom_content' => [
            'key' => 'value'
        ]
    ],
    'driver_bill_payed' => [
        'title' => '众择租车来消息啦',
        'description' => '订单xxxxx，用户已付款结单，接下去，能量满满地工作吧。',
        'notification_basic_style' => 7,
        'open_type' => 2,
        'custom_content' => [
            'key' => 'value'
        ]
    ],
    'driver_cancel_order' => [
        'title' => '众择租车来消息啦',
        'description' => '订单xxxxx，用户已取消，请耐心等待下一单吧。',
        'notification_basic_style' => 7,
        'open_type' => 2,
        'custom_content' => [
            'key' => 'value'
        ]
    ]
];