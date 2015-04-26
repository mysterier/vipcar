<?php

class OrderController extends Controller
{
   public function init() {
        parent::init();
        $this->layout = '//layouts/account';
        if (!$this->uid)
            $this->redirect('/login');
    }
    
    public function actionIndex()
    {
        $status = $this->getParam('status');
        $from = $this->getParam('from');
        $to = $this->getParam('to');
        $criteria = new CDbCriteria();
        $criteria->addCondition('client_id=' . $this->uid);
        if($status)
            $criteria->addCondition('status=' . $status);
        if($from)
            $criteria->addCondition("pickup_time>'{$from}'");
        if($to)
            $criteria->addCondition("pickup_time<'{$to}'");
        $criteria->order = 'id DESC';
        $count = Orders::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->applyLimit($criteria);
        $model = Orders::model()->findAll($criteria);
        
        $hash['model'] = $model;
        $hash['pages'] = $pages;
        $hash['status'] = $status;
        $this->render('index', $hash);
    }

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('Orders', [
            'sort' => [
                'defaultOrder' => 'id DESC'
            ],
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => ADMIN_PAGE_SIZE
            ]
        ]);
        
        $template = '';
        $template .= $this->checkAccess(MODIFY_ORDER) ? '{update}' : '';
        $template .= $this->checkAccess(DEL_ORDER) ? ' {delete}' : '';
        $hash['gridDataProvider'] = $dataProvider;
        $hash['gridColumns'] = [
            [
                'name' => 'id',
                'header' => '序号',
                'htmlOptions' => [
                    'style' => 'width: 60px'
                ]
            ],
            [
                'name' => 'order_no',
                'header' => '订单号'
            ],
            [
            'name' => 'type',
                'header' => '订单类型',
                'value' => 'Yii::app()->controller->formatType($data->type)'
            ],
            [
            'name' => 'vehicle_type',
                'header' => '服务类型',
                'value' => 'Yii::app()->controller->formatService($data->vehicle_type)'
            ],
            [
                'name' => 'contacter_name',
                'header' => '联系人'
            ],
            [
                'name' => 'pickup_place',
                'header' => '出发地'
            ],
            [
                'name' => 'drop_place',
                'header' => '目的地'
            ],
            [
                'name' => 'created',
                'header' => '创建时间'
            ],
            [
                'name' => 'status',
                'header' => '状态',
                'value' => 'Yii::app()->controller->formatStatus($data->status)'
            ],
            [
                'htmlOptions' => [
                    'nowrap' => 'nowrap'
                ],
                'header' => '操作',
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => $template,
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("modify", ["id" => $data->id])',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("del", ["id" => $data->id])'
            ]
        ];
        $this->breadcrumbs = [
            '订单查询'
        ];
        $this->render('list', $hash);
    }

    public function formatStatus($status)
    {
        $tpl = [
            0 => '未分配',
            1 => '已分配',
            2 => '进行中',
            3 => '人工',
            4 => '紧急',
            5 => '待付款',
            6 => '完成'
        ];
        return $tpl[$status];
    }
    
    public function formatService($service)
    {
        $tpl = [
            VEHICLE_TYPE_ECONOMY => '经济型',
            VEHICLE_TYPE_COMFORTABLE => '舒适型',
            VEHICLE_TYPE_BUSINESS => '商务型',
            VEHICLE_TYPE_LUXURY => '豪华型'
        ];
        return $tpl[$service];
    }

    public function actionNew()
    {
        $this->breadcrumbs = [
            '客户管理' => [
                '/client/list'
            ],
            '新建客户'
        ];
        
        $model = new Clients();
        $this->saveClients($model);
    }

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '订单处理' => [
                '/order/process?status=' . ORDER_STATUS_NOT_DISTRIBUTE
            ],
            '修改订单'
        ];
        $model = Orders::model()->findByPk($id);
        $model->setScenario('process_order');
        $this->saveOrders($model);
    }

    /**
     *
     * @todo 推送 百度老报错
     * @param unknown $model            
     */
    private function saveOrders($model)
    {
        if (isset($_POST['Orders'])) {
            // 如果订单已经分配司机，则将该司机的flag改为free
            Drivers::model()->modifyFlag(DRIVER_FLAG_FREE, $model);
            $driver_id = $_POST['Orders']['driver_id'];
            $driver = Drivers::model()->with('vehicle')->findByPk($driver_id);
            $model->attributes = $_POST['Orders'];
            $model->status = (string) ORDER_STATUS_DISTRIBUTE;
            $model->license_no = $driver->vehicle[0]->license_no;
            $model->last_update = time();
            if ($model->save()) {            
                $this->setApiLastUpdate($model->client_id, 'client');
                $this->setApiLastUpdate($driver_id, 'driver');
                Drivers::model()->modifyFlag(DRIVER_FLAG_DISTRIBUTED, $model);
                // 给司机发送通知
                Yii::import('common.pushmsg.*');
                $attributes = [
                    'client_id' => $driver_id,
                    'type' => USER_TYPE_DRIVER
                ];
                $tpl = 'driver_new_order';
                
                // PushMsg::action()->pushMsg($attributes, $tpl);
                $this->redirect('/order/process?status=' . ORDER_STATUS_NOT_DISTRIBUTE);
            }
        }
        $hash['model'] = $model;
        $drivers = $model->getDriversByVehcileType();
        $tmp = [];
        if ($drivers) {
            $driver = array_shift($drivers);
            $name = $driver->name;
            $vehicle = $driver->vehicle[0];
            $name .= '-->' . $vehicle->model->make . '-' . $vehicle->model->model;
            $tmp[$driver->id] = $name;
        }
        $hash['drivers'] = [
            '' => '--请选择--'
        ] + $tmp;
        $this->render('processform', $hash);
    }

    public function actionDel($id)
    {
        $model = Orders::model()->findByPk($id);
        if ($model) {
            $model->status = 2;
            $model->save();
        }
        Yii::app()->end();
    }

    public function actionProcess()
    {
        $criteria = new CDbCriteria();
        $criteria->with = 'driver.vehicle.model';
        $criteria->condition = 't.status = :status';
        $criteria->params = [
            'status' => $_GET['status']
        ];
        $dataProvider = new CActiveDataProvider('Orders', [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.id DESC'
            ],
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => ADMIN_PAGE_SIZE
            ]
        ]);
        
        $template = '';
        $template .= $this->checkAccess(MODIFY_ORDER) ? '{update}' : '';
        $template .= $this->checkAccess(DEL_ORDER) ? ' {delete}' : '';
        $hash['gridDataProvider'] = $dataProvider;
        $hash['gridColumns'] = [
            [
                'name' => 'id',
                'header' => '序号',
                'htmlOptions' => [
                    'style' => 'width: 60px'
                ]
            ],
            [
                'name' => 'order_no',
                'header' => '订单号'
            ],
            [
            'name' => 'vehicle_type',
                'header' => '服务类型',
                'value' => 'Yii::app()->controller->formatService($data->vehicle_type)'
            ],
            [
            'name' => 'type',
                'header' => '订单类型',
                'value' => 'Yii::app()->controller->formatType($data->type)'
            ],
            [
                'name' => 'contacter_name',
                'header' => '联系人'
            ],
            [
                'name' => 'contacter_phone',
                'header' => '联系电话'
            ],
            [
                'name' => 'pickup_place',
                'header' => '出发地'
            ],
            [
                'name' => 'drop_place',
                'header' => '目的地'
            ],
            [
                'name' => 'created',
                'header' => '下单时间'
            ],
            [
                'name' => 'driver.name',
                'header' => '司机'
            ],
            [
                'name' => 'vehicle',
                'header' => '车型',
                'value' => 'Yii::app()->controller->getVehicle($data)'
            ],
            [
                'name' => 'status',
                'header' => '状态',
                'value' => 'Yii::app()->controller->formatStatus($data->status)'
            ],
            [
                'htmlOptions' => [
                    'nowrap' => 'nowrap'
                ],
                'header' => '操作',
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => $template,
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("modify", ["id" => $data->id])',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("del", ["id" => $data->id])'
            ]
        ];
        $this->breadcrumbs = [
            '订单处理'
        ];
        $this->render('process', $hash);
    }

    public function formatType($type)
    {
        $tpl = [
            ORDER_TYPE_AIRPORTPICKUP => '接机单',
            ORDER_TYPE_AIRPORTSEND => '送机单'
        ];
        return $tpl[$type];
    }
    
    public function getVehicle($obj)
    {
        $string = '';
        $driver = $obj->driver;
        if ($driver && $driver->vehicle) {
            if ($driver->vehicle[0]->model) {
                $string = $driver->vehicle[0]->model->make;
                $string .= ' - ' . $driver->vehicle[0]->model->model;
            }
        }
        return $string;
    }
    
}