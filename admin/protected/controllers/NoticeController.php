<?php

class NoticeController extends Controller
{

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('Notice', [
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => ADMIN_PAGE_SIZE
            ]
        ]);
        
        $template = '';
        $template .= $this->checkAccess(MODIFY_NOTICE) ? '{update}' : '';
        $template .= $this->checkAccess(DEL_NOTICE) ? ' {delete}' : '';
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
                'name' => 'title',
                'header' => '标题'
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
            '公告管理'
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

    public function actionCreate()
    {
        $this->breadcrumbs = [
            '网站公告管理' => [
                '/notice/list'
            ],
            '新建公告'
        ];
        
        $model = new Notice();
        $hash['model'] = $model;
        $this->saveNotice($model);
    }

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '网站公告管理' => [
                '/notice/list'
            ],
            '修改公告'
        ];
        $model = Notice::model()->findByPk($id);
        $this->saveNotice($model);
    }

    private function saveNotice($model)
    {
        if (isset($_POST['Notice'])) {
            $model->attributes = $_POST['Notice'];
            if ($model->save()) {
                $this->redirect('/notice/list');
            }
        }
        $hash['model'] = $model;
        $this->render('form', $hash);
    }

    public function actionDel($id)
    {
        Notice::model()->deleteByPk($id);
        $this->redirect('/notice/list');
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
                    VIEW_NOTICE
                ]
            ],
            [
                'allow',
                'actions' => [
                    'modify'
                ],
                'roles' => [
                    MODIFY_NOTICE
                ]
            ],
            [
                'allow',
                'actions' => [
                    'create'
                ],
                'roles' => [
                    NEW_NOTICE
                ]
            ],
            [
                'allow',
                'actions' => [
                    'del'
                ],
                'roles' => [
                    DEL_NOTICE
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