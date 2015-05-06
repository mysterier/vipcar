<?php

class ClientController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = '//layouts/account'; 
    }
    
    public function actionEditpwd() {
        $model = new Clients();
        $hash['model'] = $model;
        $this->render('pwdform', $hash);
    }

    public function actionUpdatepwd() {
        $model = Clients::model()->findByPk($this->uid);
        $model->setScenario('webeditpwd');
        $model->attributes = $_POST['Clients'];
        if ($model->validate()) {
            $model->password = $this->encryptPasswd($model->password);
            if($model->save(false))
                $this->redirect('/');
        }          
        $hash['model'] = $model;
        $this->render('pwdform', $hash);
    }
    
    public function actionEdit() {
        $model = Clients::model()->findByPk($this->uid);
        $hash['model'] = $model;
        $this->render('infoform', $hash);
    }
    
    public function actionUpdate() {
        $model = Clients::model()->findByPk($this->uid);
        $model->setScenario('webedit');
        $model->attributes = $_POST['Clients'];
        if ($model->save())
            $this->redirect('/client/edit');
        $hash['model'] = $model;
        $this->render('infoform', $hash);
    }
}