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
            ],
            [
                'label' => '订单管理',
                'active' => $this->id == 'order' ? true : false,
                'items' => [
                    [
                        'label' => '订单查询',
                        'url' => [
                            'product/new',
                            'tag' => 'new'
                        ]
                    ],
                    [
                        'label' => '订单处理',
                        'url' => [
                            'product/index',
                            'tag' => 'popular'
                        ]
                    ]
                ]
            ],
            [
                'label' => '账户管理',
                'active' => $this->id == 'driver' ? true : false,
                'items' => [
                    [
                        'label' => '车辆管理',
                        'url' => [
                            'product/new',
                            'tag' => 'new'
                        ]
                    ],
                    [
                        'label' => '客户管理',
                        'url' => [
                            'product/new',
                            'tag' => 'new'
                        ]
                    ],
                    [
                        'label' => '司机管理',
                        'url' => [
                            '/driver/list'
                        ]
                    ]
                ]
            ],
            [
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
            ],
            [
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
            ],
            [
                'label' => '系统设置',
                'url' => [
                    '/site/a'
                ],
                'items' => [
                    [
                        'label' => '后台用户',
                        'url' => [
                            'product/new',
                            'tag' => 'new'
                        ]
                    ]
                ]
            ],
            [
                'label' => 'Login',
                'url' => [
                    '/site/login'
                ],
                'visible' => Yii::app()->user->isGuest
            ],
            [
                'label' => 'Logout (' . Yii::app()->user->name . ')',
                'url' => [
                    '/site/logout'
                ],
                'visible' => ! Yii::app()->user->isGuest
            ]
        ];
    }
}