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
            if ($model->save())
                $this->redirect('/order/index');
        }
        $hash['model'] = $model;
        $this->render('pickup', $hash);
    }
    
    public function actionSend() {
        $this->layout = '//layouts/main';
        $this->render('send');
    }
    //================

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '订单处理' => [
                '/order/process?status=' . ORDER_STATUS_NOT_DISTRIBUTE
            ],
            '修改订单'
        ];
        $model = Orders::model()->findByPk($id);
        $model->setScenario('process_order');
        $this->saveOrders($model);
    }

    /**
     *
     * @todo 推送 百度老报错
     * @param unknown $model            
     */
    private function saveOrders($model)
    {
        if (isset($_POST['Orders'])) {
            // 如果订单已经分配司机，则将该司机的flag改为free
            Drivers::model()->modifyFlag(DRIVER_FLAG_FREE, $model);
            $driver_id = $_POST['Orders']['driver_id'];
            $driver = Drivers::model()->with('vehicle')->findByPk($driver_id);
            $model->attributes = $_POST['Orders'];
            $model->status = (string) ORDER_STATUS_DISTRIBUTE;
            $model->license_no = $driver->vehicle[0]->license_no;
            $model->last_update = time();
            if ($model->save()) {            
                $this->setApiLastUpdate($model->client_id, 'client');
                $this->setApiLastUpdate($driver_id, 'driver');
                Drivers::model()->modifyFlag(DRIVER_FLAG_DISTRIBUTED, $model);
                // 给司机发送通知
                Yii::import('common.pushmsg.*');
                $attributes = [
                    'client_id' => $driver_id,
                    'type' => USER_TYPE_DRIVER
                ];
                $tpl = 'driver_new_order';
                
                PushMsg::action()->pushMsg($attributes, $tpl);
                $this->redirect('/order/process?status=' . ORDER_STATUS_NOT_DISTRIBUTE);
            }
        }
        $hash['model'] = $model;
        $drivers = $model->getDriversByVehcileType();
        $tmp = [];
        if ($drivers) {
            $driver = array_shift($drivers);
            $name = $driver->name;
            $vehicle = $driver->vehicle[0];
            $name .= '-->' . $vehicle->model->make . '-' . $vehicle->model->model;
            $tmp[$driver->id] = $name;
        }
        $hash['drivers'] = [
            '' => '--请选择--'
        ] + $tmp;
        $this->render('processform', $hash);
    }
     
}