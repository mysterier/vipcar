<?php

class ClientController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = '//layouts/account';
        if (!$this->uid)
            $this->redirect('/login'); 
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
        $model = new Clients();
        $hash['model'] = $model;
        $this->render('infoform', $hash);
    }
}