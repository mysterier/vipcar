<?php

class DriverController extends Controller
{
    // public $brea
    public function actionIndex()
    {}

    public function actionList()
    {
        $criteria = new CDbCriteria();
        $criteria->with = 'vehicle.model';
        $dataProvider = new CActiveDataProvider('Drivers', [
            'criteria' => $criteria,
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => ADMIN_PAGE_SIZE
            ]
        ]);
        
        $template = '';
        $template .= $this->checkAccess(MODIFY_DRIVER) ? '{update}' : '';
        $template .= $this->checkAccess(DEL_DRIVER) ? ' {delete}' : '';
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
                'name' => 'name',
                'header' => '司机名称'
            ],
            [
                'name' => 'mobile',
                'header' => '手机'
            ],
            [
                'name' => 'sex',
                'header' => '性别',
                'value' => 'Yii::app()->controller->formatSex($data->sex)'
            ],
            [
                'name' => 'level',
                'header' => '等级'
            ],
            [
                'name' => 'contacter',
                'header' => '紧急联系人'
            ],
            [
                'header' => '座驾',
                'type' => 'raw',
                'value' => 'Yii::app()->controller->formatVehicle($data)'
            ],
            
            [
                'name' => 'flag',
                'header' => '工作状态',
                'value' => 'Yii::app()->controller->formatFlag($data->flag)'
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
            '司机管理'
        ];
        $this->render('list', $hash);
    }

    public function formatFlag($flag)
    {
        switch ($flag) {
            case DRIVER_FLAG_DISTRIBUTED:
                return '有订单';
                break;
            case DRIVER_FLAG_FREE:
                return '空闲';
                break;
        }
    }

    public function formatStatus($status)
    {
        switch ($status) {
            case DRIVER_TYPE_OFF:
                return DRIVER_MSG_OFF;
                break;
            case DRIVER_TYPE_ON:
                return DRIVER_MSG_ON;
                break;
        }
    }

    public function formatSex($sex)
    {
        switch ($sex) {
            case SEX_DEFAULT:
                return SEX_MSG_DEFAULT;
                break;
            case SEX_MALE:
                return SEX_MSG_MALE;
                break;
            case SEX_FEMALE:
                return SEX_MSG_FEMALE;
                break;
            default:
                return SEX_MSG_DEFAULT;
        }
    }

    public function formatVehicle($data)
    {
        $vehicles = $data->vehicle;
        $vehicle = '';
        $ids = [];
        if ($vehicles) {
            foreach ($vehicles as $v) {
                $ids[] = $v->id;
                if ($v->model) {
                    $vehicle = $v->model->make . '-' . $v->model->model;
                }
            }
        }
        $vehicle .= CHtml::link('分配座驾', $this->createUrl('/driver/distribute/' . $data->id . '?vehicle=' . implode(',', $ids)), [
            'style' => 'margin-left:10px'
        ]);
        return $vehicle;
    }

    public function actionNew()
    {
        $this->breadcrumbs = [
            '司机管理' => [
                '/driver/list'
            ],
            '新建司机'
        ];
        
        $model = new Drivers();
        $this->saveDrivers($model);
    }

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '司机管理' => [
                '/driver/list'
            ],
            '修改司机'
        ];
        $model = Drivers::model()->findByPk($id);
        $this->saveDrivers($model);
    }

    /**
     * 分配座驾
     *
     * @param int $id            
     *
     * @author lqf
     */
    public function actionDistribute($id)
    {
        $criteria = new CDbCriteria();
        $criteria->with = 'model';
        $dataProvider = new CActiveDataProvider('Vehicle', [
            'criteria' => $criteria
        ]);
        $hash['gridDataProvider'] = $dataProvider;
        $hash['gridColumns'] = [
            [
                'class' => 'CCheckBoxColumn',
                'value' => '$data->id',
                'checkBoxHtmlOptions' => [
                    'name' => 'ids[]'
                ],
                'checked' => 'Yii::app()->controller->isChecked($data->id)'
            ],
            [
                'name' => 'id',
                'header' => '序号',
                'htmlOptions' => [
                    'style' => 'width: 60px'
                ]
            ],
            [
                'name' => 'model.make',
                'header' => '品牌'
            ],
            [
                'name' => 'model.model',
                'header' => '型号'
            ],
            [
                'name' => 'license_no',
                'header' => '车牌'
            ],
            [
                'name' => 'ltd_name',
                'header' => '归属公司'
            ],
            [
                'header' => '保单信息',
                'class' => 'CLinkColumn',
                'label' => '查看',
                'urlExpression' => 'Yii::app()->controller->createUrl("show", ["id" => $data->policy_path])'
            ],
            [
                'name' => 'status',
                'header' => '车辆状态',
                'value' => 'Yii::app()->controller->formatStatus($data->status)'
            ]
        ];
        $this->breadcrumbs = [
            '司机管理' => [
                '/driver/list'
            ],
            '分配座驾'
        ];
        $this->render('distributeform', $hash);
    }

    public function actionSavevehicle($id)
    {
        $ids = $_POST['ids'];
        if ($ids) {
            $new = new DriverVehicle();
            $model = DriverVehicle::model()->deleteAll('driver_id=' . $id);
            foreach ($ids as $v) {
                $new->driver_id = $id;
                $new->vehicle_id = $v;
                $new->save();
            }
        }
        $this->redirect('/driver/list');
    }

    private function saveDrivers($model)
    {
        if (isset($_POST['Drivers'])) {
            $model->attributes = $_POST['Drivers'];
            $id_card = CUploadedFile::getInstance($model, 'id_card_path');
            $license = CUploadedFile::getInstance($model, 'license_path');
            $avatar = CUploadedFile::getInstance($model, 'avatar');
            $model->id_card_path = $this->renameUploadFile($id_card, 'id_card_path');
            $model->license_path = $this->renameUploadFile($license, 'license_path');
            $model->avatar = $this->renameUploadFile($avatar, 'avatar');
            
            $password = isset($_POST['Drivers']['password']) ? trim(strval($_POST['Drivers']['password'])) : DEFAULT_PASSWORD;
            $model->password = $model->password == $password ? $model->password : $this->encryptPasswd($password);
            $model->last_update = time();
            
            if ($model->save()) {
                $this->saveUploadFile($id_card, DEFAULT_UPLOAD_PATH . $model->id_card_path);
                $this->saveUploadFile($license, DEFAULT_UPLOAD_PATH . $model->license_path);
                $this->saveUploadFile($avatar, DEFAULT_UPLOAD_PATH . $model->avatar);
                $this->redirect('/driver/list');
            }
        }
        $hash['model'] = $model;
        $this->render('driverform', $hash);
    }

    public function isChecked($id)
    {
        $ids = $_GET['vehicle'] ? explode(',', $_GET['vehicle']) : [];
        if (in_array($id, $ids))
            return true;
        return false;
    }

    public function actionDel($id)
    {
        echo 123;
        // var_dump(Yii::app()>request>urlReferrer);
    }
    
    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => [
                    'list'
                ],
                'roles' => [
                    VIEW_DRIVER
                ]
            ],
            [
                'allow',
                'actions' => [
                    'modify',
                    'distribute',
                    'savevehicle'
                ],
                'roles' => [
                    MODIFY_DRIVER
                ]
            ],
            [
                'allow',
                'actions' => [
                    'new'
                ],
                'roles' => [
                    NEW_DRIVER
                ]
            ],
            [
                'allow',
                'actions' => [
                    'del'
                ],
                'roles' => [
                    DEL_DRIVER
                ]
            ],
            [
                'deny',
                'users' => [
                    '*'
                ],
                'deniedCallback' => function ($rule) {
                    header("location: /");
                }
            ]
            ];
    }
}