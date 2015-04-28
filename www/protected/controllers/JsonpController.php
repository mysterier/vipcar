<?php

class JsonpController extends Controller
{

    
    public function actionUpload() {
        var_dump($_FILES);
        Yii::app()->end();
    }
    
    public function accessRules() {
        
    }
}