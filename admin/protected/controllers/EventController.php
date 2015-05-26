<?php

class EventController extends Controller
{

    public function actionList()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'status = :status';
        $criteria->params = [
            'status' => STATUS_LIVE
        ];
        $dataProvider = new CActiveDataProvider('Event', [
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => ADMIN_PAGE_SIZE
            ],
            'criteria' => $criteria
        ]);
        
        $template = '';
        $template .= $this->checkAccess(MODIFY_EVENT) ? '{update}' : '';
        $template .= $this->checkAccess(DEL_EVENT) ? ' {delete}' : '';
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
                'name' => 'desc',
            ],
//             [
//                 'name' => 'status',
//                 'header' => '状态',
//                 'value' => 'Yii::app()->controller->formatStatus($data->status)'
//             ],
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
            '网站活动管理'
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
            '网站活动管理' => [
                '/event/list'
            ],
            '新建活动'
        ];
        
        $model = new Event();
        $hash['model'] = $model;
        $this->saveEvent($model);
    }

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '网站活动管理' => [
                '/event/list'
            ],
            '修改活动'
        ];
        $model = Event::model()->findByPk($id);
        $this->saveEvent($model);
    }

    private function saveEvent($model)
    {
        if (isset($_POST['Event'])) {
            $model->attributes = $_POST['Event'];
            $cover = CUploadedFile::getInstance($model, 'cover');
            $model->cover = $this->renameUploadFile($cover, 'cover');
            $content_img = CUploadedFile::getInstance($model, 'content_img');
            $model->content_img = $this->renameUploadFile($content_img, 'content_img');
            if ($model->save()) {
                $this->saveUploadFile($cover, DEFAULT_UPLOAD_PATH . $model->cover);
                $this->saveUploadFile($content_img, DEFAULT_UPLOAD_PATH . $model->content_img);
                $this->redirect('/event/list');
            }
        }
        $hash['model'] = $model;
        $this->render('form', $hash);
    }

    public function actionDel($id)
    {
        $model = Event::model()->findByPk($id);
        $model->status = STATUS_DEL;
        $model->save(false);
        $this->redirect('/event/list');
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
                    VIEW_EVENT
                ]
            ],
            [
                'allow',
                'actions' => [
                    'modify'
                ],
                'roles' => [
                    MODIFY_EVENT
                ]
            ],
            [
                'allow',
                'actions' => [
                    'create'
                ],
                'roles' => [
                    NEW_EVENT
                ]
            ],
            [
                'allow',
                'actions' => [
                    'del'
                ],
                'roles' => [
                    DEL_EVENT
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