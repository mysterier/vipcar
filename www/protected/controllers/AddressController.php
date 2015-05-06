<?php

class AddressController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = '//layouts/account';
    }

    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid=:uid and status=:status';
        $criteria->params = [
            'uid' => $this->uid,
            'status' => STATUS_LIVE
        ];
        $criteria->order = 'is_common_use DESC,id DESC';
        $model = InvoiceAddress::model()->findAll($criteria);
        $hash['model'] = $model;
        
        $this->render('index', $hash);
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
        $model->uid = $this->uid;
        if ($model->save()) {
            $this->redirect('/address/index');
        }
        $hash['model'] = $model;
        $this->render('form', $hash);
    }

    public function actionEdit($id) {
        $model = InvoiceAddress::model()->findByPk($id);
        $hash['model'] = $model;
        $this->render('form', $hash);
    }
    
    public function actionUpdate() {
        $id = $this->getParam('id');
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
        $is_common_use = $_POST['InvoiceAddress']['is_common_use'];
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