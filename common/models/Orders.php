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

    public $agreeme;

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
                'contacter_name, contacter_phone, pickup_place, drop_place, pickup_time, vehicle_type, driver_id',
                'required',
                'on' => 'process_order'
            ],
            
            [
                'order_no, open_id, contacter_name, vehicle_type, contacter_phone, estimated_cost, pickup_place, drop_place, flight_number, pickup_time, type',
                'required',
                'on' => 'wechat_pickup'
            ],
            
            [
                'order_no, open_id, contacter_name, vehicle_type, contacter_phone, estimated_cost, pickup_place, drop_place, pickup_time, is_round_trip, type',
                'required',
                'on' => 'wechat_send'
            ],
            
            [
                'summary,estimated_duration,estimated_distance,license_no,driver_id,status,last_update',
                'safe'
            ],
            
            [
                'star',
                'required',
                'on' => 'webcomment'
            ],
            [
                'order_no, contacter_name, vehicle_type, contacter_phone, estimated_cost, pickup_place, drop_place, flight_number, pickup_time, type',
                'required',
                'message' => '{attribute}不能为空！',
                'on' => 'weborder_pickup'
            ],
            [
                'order_no, contacter_name, vehicle_type, contacter_phone, estimated_cost, pickup_place, drop_place, pickup_time, is_round_trip, type',
                'required',
                'message' => '{attribute}不能为空！',
                'on' => 'weborder_send'
            ],
            [
                'agreeme',
                'agreeme',
                'on' => [
                    'weborder_pickup',
                    'weborder_send'
                ]
            ]
        ];
    }

    public function agreeme($attribute, $params)
    {
        if (! $_POST['Orders']['agreeme'])
            $this->addError('agreeme', '未同意条款！');
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
            'pickup_time' => '上车时间',
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

    public function getDriversByVehcileType($type = '')
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'model.vehicle_type = :mtype and t.flag = :flag and t.status = :status and vehicle.status = :vstatus';
        $criteria->params = [
            'mtype' => $type ? $type : (int) $this->vehicle_type,
            'status' => (string) DRIVER_TYPE_ON,
            'vstatus' => (string) VEHICLE_STATUS_ON,
            'flag' => DRIVER_FLAG_FREE
        ];
        $criteria->with = 'vehicle';
        $criteria->with = 'vehicle.model';
        $drivers = Drivers::model()->findAll($criteria);
        return $drivers;
    }
    
    /**
     * 取消待分配订单
     * 
     * @return 1:成功，2：需扣费等待用户再次确认，3：取消失败
     */
    public function cancelzero($id) {
        $model = $this->findByPk($id);
        $model->status = (string) ORDER_STATUS_CANCEL;
        $model->last_update = time();
        if ($model->save(false)) {
            //司机变更为空闲 加百度推送
            Drivers::model()->modifyFlag(DRIVER_FLAG_FREE, $model);
            if ($model->driver_id) {
                // 给司机发送通知
                Yii::import('common.pushmsg.*');
                $attributes = [
                    'client_id' => $model->driver_id,
                    'type' => USER_TYPE_DRIVER
                ];
                $tpl = 'driver_cancel_order';
                $option = [
                    'description' => '订单' . $model->order_no . '，用户已取消，请耐心等待下一单吧。'
                ];
                PushMsg::action()->pushMsg($attributes, $tpl, $option);
            }            
            return 1;
        }            
         return 3;
    }
    
    /**
     * 取消已分配订单
     * $confirm ? 用户未确认 ：用户已经确认
     * 
     * @return 1:成功，2：需扣费等待用户再次确认，3：取消失败
     */
    public function cancelone($id, $confirm, $uid) {
        $model = $this->findByPk($id);
         
        $pickup_time = strtotime($model->pickup_time);
        $len = $pickup_time - time();
        if ($len < 7200) {
            if ($confirm) {
                return 2;
            }
            // 开启事务处理
            $transaction = Yii::app()->db->beginTransaction();
            //扣除20%费用
            // 修改账户余额
            $client_obj = Clients::model()->findByPk($uid);
            $payment = ($model->estimated_cost)*0.2;
            $client_obj->account_balance = $client_obj->account_balance - $payment;
            $client_obj->last_update = time();
            $client_obj->setScenario('modify_balance');
            if ($client_obj->save()) {
                // 支付记录
                $palylog = new PayLog();
                $palylog->uid = $uid;
                $palylog->amount = $payment;
                $palylog->order_id = $id;
                if (!$palylog->save())
                    $transaction->rollback();
            } else
                $transaction->rollback();
        }
    
        $model->status = (string) ORDER_STATUS_CANCEL;
        $model->last_update = time();
        if ($model->save(false)) {
            //司机变更为空闲 加百度推送
            Drivers::model()->modifyFlag(DRIVER_FLAG_FREE, $model);
            // 给司机发送通知
            Yii::import('common.pushmsg.*');
            $attributes = [
                'client_id' => $model->driver_id,
                'type' => USER_TYPE_DRIVER
            ];
            $tpl = 'driver_cancel_order';
            $option = [
                'description' => '订单' . $model->order_no . '，用户已取消，请耐心等待下一单吧。'
            ];
            PushMsg::action()->pushMsg($attributes, $tpl, $option);
            $transaction->commit();
            return 1;
        } else {
            $transaction->rollback();
            return 3;
        }
    }
}
