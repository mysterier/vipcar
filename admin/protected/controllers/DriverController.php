<?php

class DriverController extends Controller
{
    // public $brea
    public function actionIdex()
    {}

    public function actionList()
    {
        $model = Drivers::model()->findAll();
        if ($model) {
            foreach ($model as $driver) {
                switch ($driver->sex) {
                    case '0':
                        $driver->sex = SEX_DEFAULT;
                        break;
                    case '1':
                        $driver->sex = SEX_MALE;
                        break;
                    case '2':
                        $driver->sex = SEX_FEMALE;
                        break;
                    default:
                        $driver->sex = SEX_DEFAULT;
                }
                
                switch ($driver->status) {
                    case '0':
                        $driver->status = DRIVER_MSG_OFF;
                        break;
                    case '1':
                        $driver->status = DRIVER_MSG_ON;
                        break;
                }
            }
        }
        
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
                'header' => '性别'
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
                'header' => '状态'
            ],
            [
                'htmlOptions' => [
                    'nowrap' => 'nowrap'
                ],
                'class' => 'booster.widgets.TbButtonColumn',
                'viewButtonUrl' => null,
                'updateButtonUrl' => null,
                'deleteButtonUrl' => null
            ]
        ];
        $this->render('list', $hash);
    }
    
    public function actionNew() {
        
    }
}