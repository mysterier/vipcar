<?php
/**
 * 订单相关脚本
 * 
 * @author lqf
 *
 */
class OrderCommand extends CConsoleCommand
{
    /**
     * 分发订单
     * 命令：cli.php order distribute
     * 
     * @author lqf
     */
    public function actionDistribute() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'status = :status';
        $criteria->order = 'pickup_time ASC';
        $criteria->params = [
            'status' => (string)ORDER_STATUS_NOT_DISTRIBUTE
        ];
        $orders = Orders::model()->findAll($criteria);
        if ($orders) {
            foreach ($orders as $order) {
                $drivers = Orders::model()->getDriversByVehcileType($order->vehicle_type);
                if ($drivers) {
                    $driver = array_shift($drivers);
                    $attributes = [
                        'driver_id' => $driver->id,
                        'license_no' => $driver->vehicle[0]->license_no,
                        'status' => (string)ORDER_STATUS_DISTRIBUTE,
                        'last_update' => time()
                    ];
                    Orders::model()->updateByPk($order->id, $attributes);
                    
                    $this->setApiLastUpdate($order->client_id, 'client');
                    $this->setApiLastUpdate($driver->id, 'driver');
                    //更改司机flag
                    $order->driver_id = $driver->id;
                    Drivers::model()->modifyFlag(DRIVER_FLAG_DISTRIBUTED, $order);
                    //给司机发送通知
                    Yii::import('common.pushmsg.*');
                    $attributes = [
                        'client_id' => $driver->id,
                        'type' => USER_TYPE_DRIVER
                    ];
                    $tpl = 'driver_new_order';
                    
                    PushMsg::action(1)->pushMsg($attributes, $tpl);
                }
            }
        }
    }
    
    /**
     * 设置api最后更新时间
     * 主要针对orderlist接口
     *
     *
     * @return string
     * @author lqf
     */
    public function setApiLastUpdate($uid, $utype)
    {
        $api = $utype . '_order_list';
        $url = '/' . $utype . '/order/list';
        $utype = ($utype == 'driver') ? USER_TYPE_DRIVER : USER_TYPE_CLIENT;
    
        $c = new CDbCriteria();
        $c->condition = 'uid =:uid and utype=:utype and url=:url';
        $c->params = [
            'uid' => $uid,
            'utype' => $utype,
            'url' => $url
        ];
        $model = ApiLastupdate::model()->find($c);
        if (! $model)
            $model = new ApiLastupdate();
    
        $model->attributes = [
            'last_update' => time(),
            'uid' => $uid,
            'utype' => $utype,
            'api' => $api,
            'url' => $url
        ];
        return $model->save();
    }
}