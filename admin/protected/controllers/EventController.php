<?php

class EventController extends Controller
{

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('Event', [
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => ADMIN_PAGE_SIZE
            ]
        ]);
        
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
                'template' => '{update} {delete}',
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
            if ($model->save()) {
                $this->redirect('/event/list');
            }
        }
        $hash['model'] = $model;
        $this->render('form', $hash);
    }

    public function actionDel($id)
    {
        Event::model()->deleteByPk($id);
        $this->redirect('/event/list');
    }
}