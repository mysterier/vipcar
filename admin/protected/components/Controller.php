<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    /**
     *
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     *      meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     *
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = [];

    /**
     *
     * @var array the breadcrumbs of the current page. The value of this property will
     *      be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     *      for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init()
    {
        $this->menu = [
            [
                'label' => '控制面板',
                'active' => $this->id == 'site' ? true : false,
                'items' => [
                    [
                        'label' => '工作台',
                        'url' => [
                            'product/new',
                            'tag' => 'new'
                        ]
                    ],
                    [
                        'label' => '车辆监控',
                        'url' => [
                            'product/index',
                            'tag' => 'popular'
                        ]
                    ],
                    [
                        'label' => '投诉处理',
                        'url' => [
                            'product/index',
                            'tag' => 'popular'
                        ]
                    ]
                ]
            ]
        ];
        // 订单管理
        if ($this->checkAccess(VIEW_ORDER)) {
            $items = [];
            if ($this->checkAccess(VIEW_ORDER))
                $items[] = [
                    'label' => '订单处理(驾控)',
                    'url' => [
                        'order/list'
                    ]
                ];
            
            if ($this->checkAccess([
                MODIFY_ORDER,
                DEL_ORDER
            ]))
                $items[] = [
                    'label' => '后台管理(客服)',
                    'url' => [
                        'order/process',
                        'status' => ORDER_STATUS_NOT_DISTRIBUTE
                    ]
                ];
            
            $this->menu[] = [
                'label' => '订单管理',
                'active' => $this->id == 'order' ? true : false,
                'items' => $items
            ];
        }
        
        // 用户管理
        if ($this->checkAccess([
            VIEW_VEHICLE,
            VIEW_CLIENT,
            VIEW_DRIVER
        ])) {
            $items = [];
            if ($this->checkAccess(VIEW_VEHICLE))
                $items[] = [
                    'label' => '车辆管理',
                    'url' => [
                        'vehicle/list'
                    ]
                ];
            
            if ($this->checkAccess(VIEW_CLIENT))
                $items[] = [
                    'label' => '客户管理',
                    'url' => [
                        'client/list'
                    ]
                ];
            
            if ($this->checkAccess(VIEW_DRIVER))
                $items[] = [
                    'label' => '司机管理',
                    'url' => [
                        'driver/list'
                    ]
                ];
            $this->menu[] = [
                'label' => '账户管理',
                'active' => in_array($this->id, [
                    'driver',
                    'vehicle'
                ]) ? true : false,
                'url' => '/',
                'items' => $items
            ];
        }
        
        // 财务管理
        $this->menu[] = [
            'label' => '财务管理',
            'active' => $this->id == 'finance' ? true : false,
            'items' => [
                [
                    'label' => '财务总览',
                    'url' => [
                        'product/new',
                        'tag' => 'new'
                    ]
                ],
                [
                    'label' => '订单结算',
                    'url' => [
                        'product/new',
                        'tag' => 'new'
                    ]
                ],
                [
                    'label' => '客户充值',
                    'url' => [
                        'product/new',
                        'tag' => 'new'
                    ]
                ],
                [
                    'label' => '客户退款啊',
                    'url' => [
                        'product/new',
                        'tag' => 'new'
                    ]
                ],
                [
                    'label' => '司机扣款',
                    'url' => [
                        'product/new',
                        'tag' => 'new'
                    ]
                ],
                [
                    'label' => '优惠券',
                    'url' => [
                        'product/new',
                        'tag' => 'new'
                    ]
                ]
            ]
        ];
        
        // 统计报表
        if (true) {
            $this->menu[] = [
                'label' => '统计报表',
                'active' => $this->id == 'statistics' ? true : false,
                'items' => [
                    [
                        'label' => '报表总览',
                        'url' => [
                            'product/new',
                            'tag' => 'new'
                        ]
                    ],
                    [
                        'label' => '订单报表',
                        'url' => [
                            'product/new',
                            'tag' => 'new'
                        ]
                    ],
                    [
                        'label' => '客户报表',
                        'url' => [
                            'product/new',
                            'tag' => 'new'
                        ]
                    ]
                ]
            ];
        }
             
        //网站管理
        if ($this->checkAccess([VIEW_NOTICE,VIEW_EVENT,VIEW_MAGAZINE])) {
            $items = [];
            if ($this->checkAccess(VIEW_NOTICE))
                $items[] = [
                        'label' => '网站公告',
                        'url' => [
                            'notice/list'
                        ]
                    ];
            if ($this->checkAccess(VIEW_EVENT))
                $items[] = [
                        'label' => '网站活动',
                        'url' => [
                            'event/list'
                        ]
                    ];
            if ($this->checkAccess(VIEW_MAGAZINE))
                $items[] = [
                        'label' => '网站杂志',
                        'url' => [
                            'magazine/list'
                        ]
                    ];
            
            $this->menu[] = [
                'label' => '网站管理',
                'active' => ($this->id == 'event' || $this->id == 'magazine' || $this->id == 'notice') ? true : false,
                'items' => $items
            ];
        }
    
        // 系统设置
        if ($this->checkAccess([
            VIEW_ADMIN,
            VIEW_AUTH
        ])) {
            $items = [];
            if ($this->checkAccess(VIEW_ADMIN))
                $items[] = [
                    'label' => '后台用户',
                    'url' => [
                        '/user/list'
                    ]
                ];
            if ($this->checkAccess(VIEW_AUTH))
                $items[] = [
                    'label' => '权限管理',
                    'url' => [
                        '/user/auth'
                    ]
                ];
            $this->menu[] = [
                'label' => '系统设置',
                'active' => $this->id == 'user' ? true : false,
                'items' => $items
            ];
        }
        
        $this->menu[] = [
            'label' => '登出 (' . Yii::app()->user->name . ')',
            'url' => [
                '/site/logout'
            ],
            'visible' => ! Yii::app()->user->isGuest
        ];
    }

    public function checkAccess($items)
    {
        if (!is_array($items))
            return  Yii::app()->user->checkAccess($items);
        
        $res = false;
        foreach ($items as $item)
            $res = $res || Yii::app()->user->checkAccess($item);
        return $res;
    }

    /**
     * 重命名上传文件
     *
     * @param obj $file_model
     *            上传的文件对象
     * @param string $attribute
     *            对应的库表字段
     * @return string 保存路径
     * @author lqf
     */
    public function renameUploadFile($file_model, $attribute)
    {
        $path = '';
        if (is_object($file_model) && get_class($file_model) === 'CUploadedFile') {
            $dir = '/' . $this->id . '/' . date('Y') . '/' . date('m');
            if (! is_dir(DEFAULT_UPLOAD_PATH . $dir))
                mkdir(DEFAULT_UPLOAD_PATH . $dir, 0777, true);
            $path = $dir . '/' . $attribute . '_' . date('d') . '_' . time() . '_' . rand(0, 9999) . '.' . $file_model->extensionName;
        }
        return $path;
    }

    /**
     * 保存上传文件
     *
     * @param string $attribute
     *            对应的库表字段
     * @param
     *            string 保存路径
     * @author lqf
     */
    public function saveUploadFile($file_model, $path)
    {
        if (is_object($file_model) && get_class($file_model) === 'CUploadedFile') {
            $file_model->saveAs($path);
        }
    }

    /**
     * 密码加密
     *
     * @param string $password            
     * @return string
     * @author lqf
     */
    public function encryptPasswd($password = DEFAULT_PASSWORD)
    {
        $pass = md5($password);
        $pass = 'suxian' . $pass;
        $pass = md5($pass);
        return $pass;
    }

    /**
     * 获取post参数
     *
     * @param string $param            
     * @author lqf
     */
    public function getParam($param)
    {
        return (isset($_POST[$param]) && (strval($_POST[$param]) != '')) ? trim(strval($_POST[$param])) : '';
    }

    /**
     * 判断是否来自移动端
     *
     * @author lqf
     */
    public function is_mobile()
    {
        if (stripos($_SERVER['HTTP_USER_AGENT'], "android") != flase || stripos($_SERVER['HTTP_USER_AGENT'], "ios") != flase || stripos($_SERVER['HTTP_USER_AGENT'], "wp") != flase)
            return true;
        else
            return false;
    }

    public function filters()
    {
        return [
            'accessControl'
        ];
    }

    public function accessRules()
    {
        return [
            [
                'allow',
                'users' => [
                    '@'
                ]
            ],
            [
                'allow',
                'actions' => [
                    'login'
                ],
                'users' => [
                    '*'
                ]
            ],
            [
                'deny',
                'users' => [
                    '*'
                ]
            ]
        ];
    }
}