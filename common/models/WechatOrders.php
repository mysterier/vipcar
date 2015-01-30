<?php

/**
 * This is the model class for table "tbl_wechat_orders".
 *
 * The followings are the available columns in table 'tbl_wechat_orders':
 * @property string $id
 * @property string $order_no
 * @property string $contacter_name
 * @property string $contacter_phone
 * @property string $driver_id
 * @property string $vehicle_type
 * @property string $license_no
 * @property double $estimated_cost
 * @property double $order_income
 * @property string $pickup_place
 * @property string $drop_place
 * @property string $flight_number
 * @property string $summary
 * @property string $type
 * @property string $is_round_trip
 * @property string $pickup_time
 * @property string $status
 * @property string $created
 * @property string $last_update
 */
class WechatOrders extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_wechat_orders';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'contacter_name,contacter_phone,vehicle_type,estimated_cost,summary,pickup_place,drop_place,license_no,flight_number,is_round_trip,pickup_time',
                'safe'
            ]
        ];
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        return [];
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'order_no' => '订单号',
            'contacter_name' => '联系人',
            'contacter_phone' => '联系电话',
            'driver_id' => '司机id',
            'vehicle_type' => '汽车分类',
            'license_no' => '车牌号',
            'estimated_cost' => '预计费用',
            'order_income' => '订单收入',
            'pickup_place' => '出发地',
            'drop_place' => '目的地',
            'flight_number' => '航班号',
            'summary' => '备注',
            'type' => '订单类型：1接机单2送机单3预约接机4预约送机',
            'is_round_trip' => '是否往返',
            'pickup_time' => '上车时间',
            'status' => '订单状态:0未分配1已分配2进行中3需要人工派单4需要紧急干预5待付款6已完成',
            'created' => '创建时间',
            'last_update' => '最后更新时间'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * 
     * @param string $className
     *            active record class name.
     * @return WechatOrders the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
