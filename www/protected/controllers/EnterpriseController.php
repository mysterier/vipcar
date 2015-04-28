<?php

class EnterpriseController extends Controller
{    

    public function actionShow() {
        $model = new LoginForm();
        $hash['model'] = $model;
        $this->render('show', $hash);
    }
    
    public function accessRules()
    {
        return [];
    }
    //===========================
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
    
    public function actionNew() {
        $model = new InvoiceAddress();
        $hash['model'] = $model;
        $this->render('form', $hash);
    }
    
    public function actionCreate()
    {
        $model = new InvoiceAddress();
        $model->attributes = $_POST['InvoiceAddress'];
        $this->changeDefault();
        if ($model->save()) {
            $this->redirect('/address/index');
        }
        $this->render('form', $hash);
    }
    
    public function actionUpdate($id) {
        $model = InvoiceAddress::model()->findByPk($id);
        if ($model && $model->uid == $this->uid) {
            $model->attributes = $_POST['InvoiceAddress'];
            $this->changeDefault();
            if ($model->save()) {
                $this->redirect('/address/index');
            }
            $this->render('form', $hash);
        }
        $this->redirect('/address/index');
    }
    
    public function actionDestory($id) {
        $address = InvoiceAddress::model()->findByPk($id);
        $address->status = STATUS_DEL;
        if ($address->save()) {
            $this->redirect('/address/index');
        }
    }
    
    private function changeDefault() {
        $is_common_use = $this->getParam('is_common_use');
        if ($is_common_use) {
            $attributes = [
                'uid' => $this->uid,
                'is_common_use' => $is_common_use
            ];
            $model = InvoiceAddress::model()->findByAttributes($attributes);
            if ($model) {
                $model->is_common_use = 0;
                $model->save();
            }
        }
    }
}