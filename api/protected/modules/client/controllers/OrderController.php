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
        $condition_new = 't.client_id=:uid and t.id > :id';
        $params_new = [
            'uid' => $this->uid,
            'id' => $this->sid
        ];
        
        $this->getOrders($condition_new, $params_new, API_ORDER_NEW_FLAG);
        
        $api_last_update = $this->getApiLastUpdate();
        
        if ($api_last_update > $this->last_update) {
            $condition_update = 't.client_id=:uid and t.last_update > :last_update';
            $params_update = [
                'uid' => $this->uid,
                'last_update' => $this->last_update
            ];
            $this->getOrders($condition_update, $params_update, API_ORDER_UPDATE_FLAG);
            $this->last_update = $api_last_update;
        }
        
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        $this->result['last_order_sid'] = $this->sid;
        $this->result['last_update'] = $this->last_update;
        $this->result['order_list'] = $this->orders;
    }

    public function actionDetail($id)
    {
        $model = Orders::model()->with('driver')->findByPk($id);
        if ($model) {
            $result['error_code'] = SUCCESS_DEFAULT;
            $result['error_msg'] = '';
            $result['travel_duration'] = $model->travel_duration ? $model->travel_duration : 0;
            $result['travel_distance'] = $model->travel_distance;
            $result['driver_name'] = $model->driver ? $model->driver->name : '';
            $result['all_cost'] = $model->order_income;
            $result['order_status'] = $model->status;
            $this->result = $result;
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
        $criteria->select = 'id,order_no,pickup_place,estimated_cost,estimated_duration,estimated_distance,vehicle_type,drop_place,order_income,type,status,created,last_update';
        $criteria->condition = $condition;
        $criteria->order = 't.id asc';
        $criteria->params = $params;
        
        $orders = Orders::model()->with('driver')->with('driver.vehicle')->findAll($criteria);
        if ($orders) {
            foreach ($orders as $order) {
                $vehicle = $driver_name = '';
                if ($order->driver) {
                    $vehicle = $order->driver->vehicle;
                    $driver_name = $order->driver->name;
                }

                $this->orders[] = [
                    'order_sid' => $order->id,
                    'order_no' => $order->order_no,
                    'order_type' => $order->type,
                    'order_status' => $order->status,
                    'order_cost' => $order->order_income,
                    'pickup_place' => $order->pickup_place,
                    'drop_place' => $order->drop_place,
                    'driver_name' => $driver_name ? $driver_name : '',
                    'car_number' => $vehicle ? $vehicle[0]->license_no : '',
                    'order_date' => ($flag == API_ORDER_NEW_FLAG) ? $order->created : date('Y-m-d H:i:s', $order->last_update),
                    'estimated_cost' => $order->estimated_cost,
                    'estimated_duration' => $order->estimated_duration,
                    'estimated_distance' => $order->estimated_distance,
                    'car_type' => $order->vehicle_type,
                    'order_flag' => $flag
                ];
                if ($flag == API_ORDER_NEW_FLAG)
                    $this->sid = $order->id;
            }
        }
    }
    
    public function actionComment($id) {
        $model = Orders::model()->findByPk($id);
        $model->star = $this->getParam('comment');
        $model->last_update = time();
        if ($model->save()) {
            $this->setApiLastUpdate();
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        }
    }
}