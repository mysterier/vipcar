<?php

class MagazineController extends Controller
{

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('Magazine', [
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
            '众择杂志管理'
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
            '众择杂志管理' => [
                '/magazine/list'
            ],
            '新建杂志'
        ];
        
        $model = new Magazine();
        $hash['model'] = $model;
        $this->saveMagazine($model);
    }

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '众择杂志管理' => [
                '/magazine/list'
            ],
            '修改杂志'
        ];
        $model = Magazine::model()->findByPk($id);
        $this->saveMagazine($model);
    }

    private function saveMagazine($model)
    {
        if (isset($_POST['Magazine'])) {
            $model->attributes = $_POST['Magazine'];
            $cover = CUploadedFile::getInstance($model, 'cover');
            $model->cover = $this->renameUploadFile($cover, 'cover');
            echo $model->cover;
            exit();
            if ($model->save()) {
                $this->saveUploadFile($cover, $model->cover);
                $this->redirect('/magazine/list');
            }
        }
        $hash['model'] = $model;
        $this->render('form', $hash);
    }

    public function actionDel($id)
    {
        Magazine::model()->deleteByPk($id);
        $this->redirect('/magazine/list');
    }
}