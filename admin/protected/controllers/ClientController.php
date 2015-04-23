<?php

class ClientController extends Controller
{
    // public $brea
    public function actionIndex()
    {}

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('Clients', [
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => ADMIN_PAGE_SIZE
            ]
        ]);
        
        $template = '';
        $template .= $this->checkAccess(MODIFY_CLIENT) ? '{update}' : '';
        $template .= $this->checkAccess(DEL_CLIENT) ? ' {delete}' : '';
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
                'name' => 'real_name',
                'header' => '客户姓名'
            ],
            [
                'name' => 'mobile',
                'header' => '手机'
            ],
            [
                'name' => 'score',
                'header' => '积分'
            ],
            [
                'name' => 'account_balance',
                'header' => '账户余额'
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
            '客户管理'
        ];
        $this->render('list', $hash);
    }

    public function formatStatus($status)
    {
        switch ($status) {
            case CLIENT_ACTIVED:
                return CLIENT_MSG_ACTIVED;
                break;
            case CLIENT_NOT_ACTIVED:
                return CLIENT_MSG_NOT_ACTIVED;
                break;
        }
    }

    public function actionNew()
    {
        $this->breadcrumbs = [
            '客户管理' => [
                '/client/list'
            ],
            '新建客户'
        ];
        
        $model = new Clients(); // var_dump($model);exit();
        $this->saveClients($model);
    }

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '客户管理' => [
                '/client/list'
            ],
            '修改客户'
        ];
        $model = Clients::model()->findByPk($id);
        $this->saveClients($model);
    }

    private function saveClients($model)
    {
        if (isset($_POST['Clients'])) {
            $model->attributes = $_POST['Clients'];
            $password = isset($_POST['Clients']['password']) ? trim(strval($_POST['Clients']['password'])) : DEFAULT_PASSWORD;
            $model->password = $model->password == $password ? $model->password : $this->encryptPasswd($password);
            $model->last_update = time();
            
            if ($model->save()) {
                $this->redirect('/client/list');
            }
        }
        $hash['model'] = $model;
        $this->render('clientform', $hash);
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
                    VIEW_CLIENT
                ]
            ],
            [
                'allow',
                'actions' => [
                    'modify'
                ],
                'roles' => [
                    MODIFY_CLIENT
                ]
            ],
            [
                'allow',
                'actions' => [
                    'new'
                ],
                'roles' => [
                    NEW_CLIENT
                ]
            ],
            [
                'allow',
                'actions' => [
                    'del'
                ],
                'roles' => [
                    DEL_CLIENT
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