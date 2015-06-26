<?php

class ClientController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = '//layouts/promotion'; 
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionEdit() {
        $model = Clients::model()->findByPk($this->uid);
        $model->client_title = $model->client_title ? $model->client_title : 1;
        $msg = '';
        if ($_POST) {
            $model->setScenario('wxedit');
            $model->attributes = $_POST;
            if ($model->save()) {
                $this->redirect('/client');
            } else {
                $error = $model->getErrors();
                foreach ($error as $v)
                    $msg .= $v[0];               
            }
        }
        $hash['error'] = $msg;
        $hash['model'] = $model;
        $this->render('edit', $hash);
    }
    
    public function actionCoupons() {
        $actived = $this->getTicket(CLIENT_TICKET_ACTIVED);
        $type = [
            '5'=>'接机',
            '51'=>'舒适接机',
            '52'=>'商务接机',
            '53'=>'豪华接机',
            '6'=>'送机',
            '61'=>'舒适送机',
            '62'=>'商务送机',
            '63'=>'豪华送机',
            '99'=>'接送机'
        ];
        $hash['actived'] = $actived;
        $hash['type'] = $type;
        $this->render('coupons', $hash);
    }
    
    private function getTicket($status) {
        $criteria = new CDbCriteria();
        $criteria->condition = 't.client_id=:client_id and t.status=:status';
        $criteria->order = 't.id asc';
        $criteria->params = [
            'client_id' => $this->uid,
            'status' => $status
        ];
        $model = ClientTicket::model()->with('ticket')->findAll($criteria);
        return $model;
    }
    
    public function filters() {
        return [
            'bindMobile + index, edit, coupons'
        ];
    }
}