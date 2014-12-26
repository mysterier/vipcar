<?php

class VehicleController extends Controller
{
    // public $brea
    public function actionIndex()
    {}

    public function actionList()
    {
        $model = Vehicle::model()->with('model')->findAll();
        
        $dataProvider = new CArrayDataProvider($model);
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
            ],
            [
                'htmlOptions' => [
                    'nowrap' => 'nowrap'
                ],
                'header' => '操作',
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("modify", ["id" => $data->id])',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("del", ["id" => $data->id])'
            ]
        ];
        $this->breadcrumbs = [
            '车辆管理'
        ];
        $this->render('list', $hash);
    }

    public function formatStatus($status)
    {
        switch ($status) {
            case VEHICLE_STATUS_ON:
                return VEHICLE_MSG_STATUS_ON;
                break;
            case VEHICLE_STATUS_OFF:
                return VEHICLE_MSG_STATUS_OFF;
                break;
        }
    }

    public function actionNew()
    {
        $this->breadcrumbs = [
            '车辆管理' => [
                '/vehicle/list'
            ],
            '新建车辆'
        ];
        
        $model = new Vehicle();
        $this->saveVehicle($model);
    }

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '车辆管理' => [
                '/vehicle/list'
            ],
            '修改车辆'
        ];
        $model = Vehicle::model()->findByPk($id);
        $this->saveVehicle($model);
    }

    private function saveVehicle($model)
    {
        if (isset($_POST['Vehicle'])) {
            $model->attributes = $_POST['Vehicle'];
            $vehicle_license = CUploadedFile::getInstance($model, 'vehicle_license_path');
            $policy = CUploadedFile::getInstance($model, 'policy_path');
            $model->vehicle_license_path = $this->renameUploadFile($vehicle_license, 'vehicle_license_path');
            $model->policy_path = $this->renameUploadFile($policy, 'policy_path');
            
            if ($model->save()) {
                $this->saveUploadFile($vehicle_license, $model->vehicle_license_path);
                $this->saveUploadFile($policy, $model->policy_path);
                $this->redirect('/vehicle/list');
            }
        }
        $data = [];
        $type = VehicleModel::model()->findAll();
        foreach ($type as $v)
            $data[$v->id] = $v->make . '-' . $v->model;
        $hash['type'] = $data;
        $hash['model'] = $model;
        $this->render('vehicleform', $hash);
    }

    public function actionDel($id)
    {
        echo 123;
        // var_dump(Yii::app()>request>urlReferrer);
    }

    public function actionModellist()
    {
        $this->breadcrumbs = [
            '车辆管理' => [
                '/vehicle/list'
            ],
            '车型管理'
        ];
        
        $model = VehicleModel::model()->with('type')->findAll();
        
        $dataProvider = new CArrayDataProvider($model);
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
                'name' => 'make',
                'header' => '品牌名称'
            ],
            [
                'name' => 'model',
                'header' => '型号'
            ],
            [
                'name' => 'type.vehicle_type',
                'header' => '汽车分类'
            ],
            [
                'htmlOptions' => [
                    'nowrap' => 'nowrap'
                ],
                'header' => '操作',
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("modifymodel", ["id" => $data->id])',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delmodel", ["id" => $data->id])'
            ]
        ];
        $this->render('list', $hash);
    }

    public function actionNewmodel()
    {
        $this->breadcrumbs = [
            '车辆管理' => [
                '/vehicle/list'
            ],
            '车型管理' => [
                '/vehicle/modellist'
            ],
            '新建车型'
        ];
        
        $model = new VehicleModel();
        $this->saveModel($model);
    }

    public function actionModifymodel($id)
    {
        $this->breadcrumbs = [
            '车辆管理' => [
                '/vehicle/list'
            ],
            '车型管理' => [
                '/vehicle/modellist'
            ],
            '修改车型'
        ];
        $model = VehicleModel::model()->findByPk($id);
        $this->saveModel($model);
    }

    private function saveModel($model)
    {
        if (isset($_POST['VehicleModel'])) {
            $model->attributes = $_POST['VehicleModel'];
            
            if ($model->save())
                $this->redirect('/vehicle/modellist');
        }
        $type = VehicleType::model()->findAll();
        $data = [];
        if ($type) {
            foreach ($type as $v)
                $data[$v->id] = $v->vehicle_type;
        }
        $hash['type'] = $data;
        $hash['model'] = $model;
        $this->render('modelform', $hash);
    }
}