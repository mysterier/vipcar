<?php

class OrderController extends Controller
{

    private $orders = [];

    private $sid;

    private $last_update;

    private $bill_cofirm;

    private $fare;

    private $over_distance;

    private $over_duration;

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
        $this->getIncome($model);
        if ($model) {
            if ($model->status == ORDER_STATUS_CANCEL) {
                echo json_encode(['error_code' => '-301']);
                Yii::app()->end();
            }
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
            $result['base_fee'] = $this->fare;
            $result['overtime_fee'] = $this->over_duration;
            $result['overmile_fee'] = $this->over_distance;
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
                if ($model->status == ORDER_STATUS_CANCEL) {
                    echo json_encode(['error_code' => '-301']);
                    Yii::app()->end();
                }
                $model->status = $status;
                $model->last_update = time();
                if ($model->save(false)) {
                    $this->setApiLastUpdate();
                    $this->setApiLastUpdate('order', 'client', $model->client_id);
                    
                    Yii::import('common.pushmsg.*');
                    $attributes = [
                        'client_id' => $model->client_id,
                        'type' => USER_TYPE_CLIENT
                    ];
                    $tpl = 'order_confirm';
                    $option = [
                        'description' => '您的订单' . $model->order_no . '已被确认，司机正向您火速奔来。'
                    ];
                    PushMsg::action()->pushMsg($attributes, $tpl, $option);
                    
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
        if ($model && ($model->driver_id == $this->uid) && $model->status < ORDER_STATUS_PAY) {
            // 司机端操作此接口，说明订单已经完成
            $order_income = $this->getIncome($model);
            $_POST['order_income'] = $order_income;
            $_POST['status'] = strstr($model->order_no, 'wx') ? ORDER_STATUS_END : ORDER_STATUS_PAY; // 配合微信
            $_POST['last_update'] = time();
            $model->attributes = $_POST;
            if ($model->save()) {
                $attributes = [
                    'driver_id' => $this->uid,
                    'status' => ORDER_STATUS_DISTRIBUTE
                ];
                $order = Orders::model()->findByAttributes($attributes);
                //没有未执行订单时才将flag重置
                if (!$order)
                    Drivers::model()->modifyFlag(DRIVER_FLAG_FREE, $model);
                $this->setApiLastUpdate();
                $this->setApiLastUpdate('order', 'client', $model->client_id);
                
                Yii::import('common.pushmsg.*');
                $attributes = [
                    'client_id' => $model->client_id,
                    'type' => USER_TYPE_CLIENT
                ];
                $tpl = 'bill_confirm';
                $option = [
                    'description' => $this->bill_cofirm
                ];
                PushMsg::action()->pushMsg($attributes, $tpl, $option);
                
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
        $fare = '';
        switch ($model->vehicle_type) {
            case VEHICLE_TYPE_COMFORTABLE:
                $vehicle_type = '舒适';
                $fares = [
                    COMFORTABLE_LOW,
                    COMFORTABLE_HIGH
                ];
                break;
            case VEHICLE_TYPE_BUSINESS:
                $vehicle_type = '商务';
                $fares = [
                    BUSINESS_LOW,
                    BUSINESS_HIGH
                ];
                break;
            case VEHICLE_TYPE_LUXURY:
                $vehicle_type = '豪华';
                $fares = [
                    LUXURY_LOW,
                    LUXURY_HIGH
                ];
                break;
            default:
                $vehicle_type = '舒适';
                $fares = [
                    COMFORTABLE_LOW,
                    COMFORTABLE_HIGH
                ];
        }
        
        $type = $model->type;
        if ($type == ORDER_TYPE_AIRPORTPICKUP || $type == ORDER_TYPE_BOOK_AIRPORTPICKUP) {
            $place = $model->pickup_place;
        } elseif ($type == ORDER_TYPE_AIRPORTSEND || $type == ORDER_TYPE_BOOK_AIRPORTSEND) {
            $place = $model->drop_place;
        }
        
        if (strstr($place, '浦东')) {
            $fare = $fares[1];
            $place = '浦东';
        } else {
            $fare = $fares[0];
            $place = '虹桥';
        }
        
        $distance = $this->getParam('travel_distance');
        // 为了兼容订单详情获取超时费和超公里费
        $distance = $distance ? $distance : $model->travel_distance;
        $duration = $this->getParam('travel_duration');
        $duration = $duration ? $duration : $model->travel_duration;
        $duration = substr($duration, 0, 2);
        $over_distance = $distance - BASE_DISTANCE;
        $over_distance = ($over_distance > 0) ? $over_distance * FARE_PER_KM : 0;
        $over_duration = $duration - BASE_DURATION;
        $over_duration = ($over_duration > 0) ? $over_duration * FARE_PER_HOUR : 0;
        $packing_fee = $this->getParam('packing_fee');
        $highway_fee = $this->getParam('highway_fee');
        
        $extra = '';
        $extra .= $packing_fee ? '停车费' . $packing_fee . '元，' : '';
        $extra .= $highway_fee ? '高速费' . $highway_fee . '元，' : '';
        $extra .= $over_distance ? '超公里费' . $over_distance . '元，' : '';
        $extra .= $over_duration ? '超时费' . $over_duration . '元，' : '';
        $extra = $extra ? '额外费用：' . $extra : '';
        
        $income = $fare + $over_distance + $over_duration;
        $income += $packing_fee;
        $income += $highway_fee;
        
        $this->bill_cofirm = '您的订单' . $model->order_no . '的账单已生成，请您核实查验：' . $place . '机场接送机服务' . $vehicle_type . '型' . $fare . '元，' . $extra . '共计' . $income . '元。';
        $this->fare = $fare;
        $this->over_distance = $over_distance;
        $this->over_duration = $over_duration;
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
        $condition = 'driver_id=:uid and id > :id and (status<="' . ORDER_STATUS_RUN . '" or status="' . ORDER_STATUS_CANCEL . '")';
        $params = [
            'uid' => $this->uid,
            'id' => $this->sid
        ];
        
        $this->getOrders($condition, $params, API_ORDER_NEW_FLAG);
        
        // 获取未完成但已经修改过的订单
        $this->getUpdateOrders('driver_id=:uid and status<="' . ORDER_STATUS_RUN . '" and last_update > :last_update');
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
            $condition = $condition ? $condition : 'driver_id=:uid and (status="' . ORDER_STATUS_PAY . '" or status="' . ORDER_STATUS_END . '") and last_update > :last_update';
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
        $criteria->select = 'id,order_no,pickup_place,pickup_time,drop_place,order_income,is_round_trip,created,last_update,status,type';
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
                    'pickup_time' => $order->pickup_time,
                    'drop_place' => $order->drop_place,
                    'order_income' => $order->order_income,
                    'is_round_trip' => $order->is_round_trip,
                    'order_type' => $order->type,
                    'order_date' => ($flag == API_ORDER_NEW_FLAG) ? $order->created : date('Y-m-d H:i:s', $order->last_update),
                    'order_status' => $order->status,
                    'order_flag' => $flag
                ];
                if ($flag == API_ORDER_NEW_FLAG)
                    $this->sid = $order->id;
            }
        }
    }

    /**
     * 司机主动请求订单
     *
     * @author lqf
     */
    public function actionRequest()
    {
        $driver = Drivers::model()->with('vehicle')
            ->with('vehicle.model')
            ->findByPk($this->uid);
        $vehicle_type = '';
        if ($driver->vehicle && $driver->vehicle[0]->model)
            $vehicle_type = $driver->vehicle[0]->model->vehicle_type;
        if ($vehicle_type) {
            $criteria = new CDbCriteria();
            $criteria->condition = 'vehicle_type = :type and status = :status';
            $criteria->order = 'pickup_time ASC';
            $criteria->params = [
                'type' => $vehicle_type,
                'status' => (string) ORDER_STATUS_NOT_DISTRIBUTE
            ];
            $order = Orders::model()->find($criteria);
            if ($order) {
                $attributes = [
                    'driver_id' => $driver->id,
                    'license_no' => $driver->vehicle[0]->license_no,
                    'status' => (string) ORDER_STATUS_DISTRIBUTE,
                    'last_update' => time()
                ];
                $order->attributes = $attributes;
                $order->save();
                
                $this->setApiLastUpdate($this->id,'order', 'client', $order->client_id);
                $this->setApiLastUpdate($this-id, 'driver', $driver->id);
                // 更改司机flag
                if ($driver->flag == DRIVER_FLAG_FREE)
                    Drivers::model()->modifyFlag(DRIVER_FLAG_DISTRIBUTED, $order);
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
            } else {
                $this->result['error_code'] = NO_RECORD;
                $this->result['error_msg'] = '';
            }
        }
    }
}