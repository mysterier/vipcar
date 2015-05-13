<?php

class OrderController extends Controller
{
   public function init() {
        parent::init();
        $this->layout = '//layouts/account';
    }
    
    public function actionIndex()
    {
        $status = $this->getParam('status');
        $from = $this->getParam('from');
        $to = $this->getParam('to');
        $criteria = new CDbCriteria();
        $criteria->addCondition('client_id=' . $this->uid);
        if($status)
            $criteria->addCondition('status=' . $status);
        if($from)
            $criteria->addCondition("pickup_time>'{$from}'");
        if($to)
            $criteria->addCondition("pickup_time<'{$to}'");
        $criteria->order = 'id DESC';
        $count = Orders::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->applyLimit($criteria);
        $model = Orders::model()->findAll($criteria);
        
        $hash['model'] = $model;
        $hash['pages'] = $pages;
        $hash['status'] = $status;
        $this->render('index', $hash);
    }

    
    public function actionComment() {
        $status = $this->getParam('status');
        $criteria = new CDbCriteria();
        $criteria->condition = 'client_id=:client_id and status=:status';
        $criteria->params = [
            'client_id' => $this->uid,
            'status' => (string)ORDER_STATUS_END
        ];

        if ($status)
            $criteria->addCondition('star != ""');
        else
            $criteria->addCondition('star = ""');
        $criteria->order = 'id DESC';
        $count = Orders::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->applyLimit($criteria);
        $model = Orders::model()->findAll($criteria);
        
        $hash['model'] = $model;
        $hash['pages'] = $pages;
        $hash['status'] = $status;
        
        $this->render('comment', $hash);
    }

    public function formatStatus($status)
    {
        $tpl = [
            0 => '未分配',
            1 => '已分配',
            2 => '进行中',
            3 => '人工',
            4 => '紧急',
            5 => '待付款',
            6 => '完成'
        ];
        return $tpl[$status];
    }
    
    public function formatService($service)
    {
        $tpl = [
            VEHICLE_TYPE_ECONOMY => '经济型',
            VEHICLE_TYPE_COMFORTABLE => '舒适型',
            VEHICLE_TYPE_BUSINESS => '商务型',
            VEHICLE_TYPE_LUXURY => '豪华型'
        ];
        return $tpl[$service];
    }


    public function actionPickup() {
        $this->layout = '//layouts/main';
        $model = new Orders('weborder');
        $model->pickup_time = '';//清除数据库的默认值
        if ($_POST) {
            $model->attributes = $_POST['Orders'];
            $model->client_id = $this->uid;
            $model->order_no = 'web' . time();
            $model->type = (string)ORDER_TYPE_AIRPORTPICKUP;
            if ($model->save())
                $this->redirect('/order/index');
        }
        $coupon = $this->getTicket();
        $hash['count_coupon'] = count($coupon);
        $hash['coupon'] = $coupon;
        $hash['model'] = $model;
        $this->render('pickup', $hash);
    }
    
    public function actionSend() {
        $this->layout = '//layouts/main';
        $model = new Orders('weborder');
        $model->pickup_time = '';//清除数据库的默认值
        if ($_POST) {
            $model->attributes = $_POST['Orders'];
            $model->client_id = $this->uid;
            $model->order_no = 'web' . time();
            $model->type = (string)ORDER_TYPE_AIRPORTPICKUP;
            if ($model->save())
                $this->redirect('/order/index');
        }
        $coupon = $this->getTicket();
        $hash['count_coupon'] = count($coupon);
        $hash['coupon'] = $coupon;
        $hash['model'] = $model;
        $this->render('send', $hash);
    }
     
    private function getTicket() {
        $criteria = new CDbCriteria();
        $criteria->condition = 't.client_id=:client_id and t.status=:status';
        $criteria->order = 't.id asc';
        $criteria->params = [
            'client_id' => $this->uid,
            'status' => CLIENT_TICKET_ACTIVED
        ];
        $model = ClientTicket::model()->with('ticket')->findAll($criteria);
        return $model;
    }
}