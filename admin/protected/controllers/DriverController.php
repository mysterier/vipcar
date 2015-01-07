<?php

class DriverController extends Controller
{
    // public $brea
    public function actionIndex()
    {}

    public function actionList()
    {
        $model = Drivers::model()->findAll();
        
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
                'template' => '{update} {delete}',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("modify", ["id" => $data->id])',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("del", ["id" => $data->id])'
            ]
        ];
        $this->breadcrumbs = [
            '司机管理'
        ];
        $this->render('list', $hash);
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
                $this->saveUploadFile($id_card, $model->id_card_path);
                $this->saveUploadFile($license, $model->license_path);
                $this->saveUploadFile($avatar, $model->avatar);
                $this->redirect('/driver/list');
            }
        }
        $hash['model'] = $model;
        $this->render('driverform', $hash);
    }

    public function actionDel($id)
    {
        echo 123;
        //var_dump(Yii::app()>request>urlReferrer);
    }
}