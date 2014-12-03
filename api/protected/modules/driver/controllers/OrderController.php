<?php

class OrderController extends Controller
{
    
    private $orders = [];
    
    private $sid;
    
    private $last_update;

    public function init() {
        $this->sid = $this->get_param('last_order_sid');
        $this->last_update = $this->get_param('last_update');
    }
    
    public function actionIndex()
    {
        echo 'hello world';
    }

    public function actionList()
    {
        $status = $this->get_param('status');
        
        switch ($status) {
            //请求未完成订单列表
            case '1':
                $this->get_new_orders();
                break;
            //请求已完成订单列表
            case '0':
                $this->get_update_orders();
                break;
            default:
                $this->get_new_orders();
                $this->get_update_orders();
        }
        $this->result['error_code'] = 1;
        $this->result['error_msg'] = '';
        $this->result['last_order_sid'] = $this->sid;
        $this->result['last_update'] = $this->last_update;
        $this->result['order_list'] = $this->orders;
    }

    /**
     * 获取最新增加的订单
     * 
     * @return int $sid 最新的订单id
     * @author lqf
     */
    private function get_new_orders()
    {
        $condition = 'driver_id=:uid and id > :id and (status="1" or status="2")';
        $params = [
            'uid' => $this->uid,
            'id' => $this->sid
        ];
        
        $this->get_orders($condition, $params, 2);
        
        //获取未完成但已经修改过的订单
        $this->get_update_orders('driver_id=:uid and (status="1" or status="2") and last_update > :last_update');
    }

    /**
     * 获取最新修改的订单
     * 
     * @author lqf
     */
    private function get_update_orders($condition = '')
    {
        $last_update = $this->last_update;
        $api_last_update = $this->get_api_lastupdate();
        
        if ($api_last_update > $last_update) {
            $condition = $condition ? $condition : 'driver_id=:uid and status="0" and last_update > :last_update';
            $params = [
                'uid' => $this->uid,
                'last_update' => $last_update
            ];
            $this->get_orders($condition, $params, 1);
            $this->last_update = $api_last_update;
        }
    }
    
    /**
     * 根据条件查询订单
     * @param string $condition
     * @param array $params
     * @param int $flag
     * @author lqf
     */
    private function get_orders($condition, $params, $flag) {        
        $criteria = new CDbCriteria();
        $criteria->select = 'id,order_no,pickup_place,drop_place,created,last_update';
        $criteria->condition = $condition;
        $criteria->order = 'id asc';
        $criteria->params = $params;
        
        $orders = Orders::model()->findAll($criteria);
        if ($orders) {
            foreach ($orders as $order) {
                $this->orders[] = [
                    'order_no' => $order->order_no,
                    'pickup_place' => $order->pickup_place,
                    'drop_place' => $order->drop_place,
                    'order_date' => ($flag==2) ? $order->created : date('Y-m-d H:i:s', $order->last_update),
                    'order_flag' => $flag// 1:修改 2:添加
                ];
                if ($flag == 2)
                    $this->sid = $order->id;
            }
        }
    }
}