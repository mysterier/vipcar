<?php

class OrderController extends Controller
{

    private $orders = [];

    private $sid;

    private $last_update;

    public function init()
    {
        $this->sid = $this->getParam('last_order_sid');
        $this->last_update = $this->getParam('last_update');
    }

    public function actionIndex()
    {
        echo 'hello world';
    }

    public function actionList()
    {
        $status = $this->getParam('status');
        
        switch ($status) {
            // 请求未完成订单列表
            case ORDER_UNFINISHED:
                $this->getNewOrders();
                break;
            // 请求已完成订单列表
            case ORDER_FINISHED:
                $this->getUpdateOrders();
                break;
            default:
                $this->getNewOrders();
                $this->getUpdateOrders();
        }
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        $this->result['last_order_sid'] = $this->sid;
        $this->result['last_update'] = $this->last_update;
        $this->result['order_list'] = $this->orders;
    }

    public function actionDetail($id)
    {
        $model = Orders::model()->findByPk($id);
        if ($model) {
            $result['error_code'] = SUCCESS_DEFAULT;
            $result['error_msg'] = '';
            $result['order_no'] = $model->order_no;
            $result['order_date'] = $model->last_update ? date('Y-m-d H:i:s', $model->last_update) : $model->created;
            $result['contacter_name'] = $model->contacter_name;
            $result['contacter_phone'] = $model->contacter_phone;
            $result['pickup_place'] = $model->pickup_place;
            $result['drop_place'] = $model->drop_place;
            $coordinate = $model->coordinate;
            $coordinate = explode(',', $coordinate);
            $result['pickup_longitude'] = $coordinate[0];
            $result['pickup_latitude'] = $coordinate[1];
            $result['drop_longitude'] = $coordinate[2];
            $result['drop_latitude'] = $coordinate[3];
            $result['travel_duration'] = $model->travel_duration ? $model->travel_duration : 0;
            $result['travel_distance'] = $model->travel_distance;
            $result['packing_fee'] = $model->packing_fee;
            $result['highway_fee'] = $model->highway_fee;
            $this->result = $result;
        }
    }

    public function actionStatus($id)
    {
        $status = $this->getParam('order_status');
        // 目前只开放司机接单状态
        if ($status == ORDER_STATUS_RUN) {
            $model = Orders::model()->findByPk($id);
            if ($model && ($model->driver_id == $this->uid)) {
                $model->status = $status;
                $model->last_update = time();
                if ($model->save(false)) {
                    $this->setApiLastUpdate();
                    $result['error_code'] = SUCCESS_DEFAULT;
                    $result['error_msg'] = '';
                    $this->result = $result;
                }
            }
        }
    }

    public function actionModify($id)
    {
        $model = Orders::model()->findByPk($id);
        $model->setScenario('driver_modify');
        if ($model && ($model->driver_id == $this->uid)) {
            // 司机端操作此接口，说明订单已经完成
            $order_income = $this->getIncome($model);
            $_POST['order_income'] = $order_income;
            $_POST['status'] = ORDER_STATUS_END;
            $_POST['last_update'] = time();
            $model->attributes = $_POST;
            if ($model->save()) {
                $this->setApiLastUpdate();
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
                $this->result['order_income'] = $order_income;
            }
        }
    }

    /**
     * 获取订单收入
     *
     * @param object $model
     *            订单对象
     * @author lqf
     */
    private function getIncome($model)
    {
        $income = STARTING_FARE + FARE_PER_KM * $model->travel_distance;
        $income += $model->packing_fee;
        $income += $model->highway_fee;
        return $income;
    }

    /**
     * 获取最新增加的订单
     *
     * @return int $sid 最新的订单id
     * @author lqf
     */
    private function getNewOrders()
    {
        $condition = 'driver_id=:uid and id > :id and (status="' . ORDER_STATUS_NEW . '" or status="' . ORDER_STATUS_RUN . '")';
        $params = [
            'uid' => $this->uid,
            'id' => $this->sid
        ];
        
        $this->getOrders($condition, $params, API_ORDER_NEW_FLAG);
        
        // 获取未完成但已经修改过的订单
        $this->getUpdateOrders('driver_id=:uid and (status="' . ORDER_STATUS_NEW . '" or status="' . ORDER_STATUS_RUN . '") and last_update > :last_update');
    }

    /**
     * 获取最新修改的订单
     *
     * @author lqf
     */
    private function getUpdateOrders($condition = '')
    {
        $last_update = $this->last_update;
        $api_last_update = $this->getApiLastUpdate();
        
        if ($api_last_update > $last_update) {
            $condition = $condition ? $condition : 'driver_id=:uid and status="' . ORDER_STATUS_END . '" and last_update > :last_update';
            $params = [
                'uid' => $this->uid,
                'last_update' => $last_update
            ];
            $this->getOrders($condition, $params, API_ORDER_UPDATE_FLAG);
            $this->last_update = $api_last_update;
        }
    }

    /**
     * 根据条件查询订单
     *
     * @param string $condition            
     * @param array $params            
     * @param int $flag            
     * @author lqf
     */
    private function getOrders($condition, $params, $flag)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,order_no,pickup_place,drop_place,order_income,created,last_update';
        $criteria->condition = $condition;
        $criteria->order = 'id asc';
        $criteria->params = $params;
        
        $orders = Orders::model()->findAll($criteria);
        if ($orders) {
            foreach ($orders as $order) {
                $this->orders[] = [
                    'order_sid' => $order->id,
                    'order_no' => $order->order_no,
                    'pickup_place' => $order->pickup_place,
                    'drop_place' => $order->drop_place,
                    'order_income' => $order->order_income,
                    'order_date' => ($flag == API_ORDER_NEW_FLAG) ? $order->created : date('Y-m-d H:i:s', $order->last_update),
                    'order_flag' => $flag
                ];
                if ($flag == API_ORDER_NEW_FLAG)
                    $this->sid = $order->id;
            }
        }
    }
}