<?php

/**
 * This is the model class for table "tbl_orders".
 *
 * The followings are the available columns in table 'tbl_orders':
 * @property string $id
 * @property string $order_no
 * @property string $client_id
 * @property string $contacter_name
 * @property string $contacter_phone
 * @property string $driver_id
 * @property string $vehicle_type
 * @property string $license_no
 * @property string $estimated_duration
 * @property double $estimated_distance
 * @property double $estimated_cost
 * @property double $order_income
 * @property string $travel_duration
 * @property double $travel_distance
 * @property double $packing_fee
 * @property double $highway_fee
 * @property string $pickup_place
 * @property string $drop_place
 * @property string $flight_number
 * @property string $summary
 * @property string $type
 * @property string $status
 * @property string $created
 * @property string $last_update
 */
class Orders extends CActiveRecord
{

    public $total_order;

    public $total_income;

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_orders';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'order_no, client_id, contacter_name, vehicle_type, contacter_phone, estimated_cost, pickup_place, drop_place, flight_number, pickup_time, coordinate, type',
                'required',
                'on' => 'insert'
            ],
            
            [
                'order_no, client_id, contacter_name, vehicle_type, contacter_phone, estimated_cost, pickup_place, drop_place, flight_number, pickup_time, coordinate, is_round_trip, type',
                'required',
                'on' => 'airportsend'
            ],
            
            [
                'order_income,travel_duration,packing_fee,highway_fee,status,last_update',
                'required',
                'on' => 'driver_modify'
            ],
            
            [
                'order_income,packing_fee,highway_fee',
                'numerical',
                'on' => 'driver_modify'
            ],
            
            [
                'order_no, license_no, pickup_place, drop_place',
                'safe',
                'on' => 'search'
            ],
            
            [
                'contacter_name, contacter_phone, vehicle_type, driver_id',
                'required',
                'on' => 'process_order'
            ],
            
            [
                'summary,estimated_duration,estimated_distance,license_no',
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
        return [
            'client' => [
                self::BELONGS_TO,
                'Clients',
                'client_id'
            ],
            'driver' => [
                self::BELONGS_TO,
                'Drivers',
                'driver_id'
            ],
            'ticket' => [
                self::HAS_ONE,
                'ClientTicket',
                'order_id'
            ]
        ];
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
            'client_id' => '用户id',
            'contacter_name' => '联系人',
            'contacter_phone' => '联系电话',
            'driver_id' => '司机',
            'vehicle_type' => '汽车类型',
            'license_no' => '车牌号',
            'estimated_cost' => '预计费用',
            'carusing_time' => '用车时长',
            'pickup_place' => '出发地',
            'drop_place' => '目的地',
            'flight_number' => '航班号',
            'summary' => '备注',
            'type' => '订单类型',
            'status' => '订单状态',
            'created' => '创建时间',
            'last_update' => '最后更新时间'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     *         based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria();
        
        $criteria->compare('order_no', $this->order_no, true);
        $criteria->compare('license_no', $this->license_no, true);
        $criteria->compare('pickup_place', $this->pickup_place, true);
        $criteria->compare('drop_place', $this->drop_place, true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return Orders the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function getDriversByVehcileType($type = '') {
        $criteria = new CDbCriteria();
        $criteria->condition = 'model.vehicle_type = :mtype and t.status = :status and vehicle.status = :vstatus';
        $criteria->params = [
            'mtype' => $type ? $type : (int)$this->vehicle_type,
            'status' => (string)DRIVER_TYPE_ON,
            'vstatus' => (string)VEHICLE_STATUS_ON
        ];
        $criteria->with = 'vehicle';
        $criteria->with = 'vehicle.model';
        $drivers = Drivers::model()->findAll($criteria);
        return $drivers;
    }
}
