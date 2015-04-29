<?php

class JsonpController extends Controller
{

    
    public function actionUpload() {
        var_dump($_FILES);
    }
    
    public function actionComment() {
        $star = $this->getParam('star');
        $id = $this->getParam('order_id');
        $model = Orders::model()->findByPk($id);
        $model->setScenario('webcomment');
        $model->star = $star;
        if ($model->save())
            echo 1;
        echo 0;
    }
    
    public function afterAction($action) {
        Yii::app()->end();
    }
    public function accessRules() {
        return [];
    }
}