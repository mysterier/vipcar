<?php

/**
 * This is the model class for table "tbl_client_ticket".
 *
 * The followings are the available columns in table 'tbl_client_ticket':
 * @property string $id
 * @property string $client_id
 * @property string $ticket_id
 * @property string $parent_id
 * @property string $order_id
 * @property integer $status
 * @property string $expire
 * @property string $created
 * @property string $last_update
 */
class ClientTicket extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_client_ticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return [
		    'ticket' => [
		        self::BELONGS_TO,
		        'Tickets',
		        'ticket_id'
		    ],
		    'order' => [
		        self::BELONGS_TO,
		        'Orders',
		        'order_id'
		    ]
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_id' => '用户id',
			'ticket_id' => '优惠券id',
			'parent_id' => '上级用户优惠券关联表id',
			'order_id' => '订单id',
			'status' => '优惠券状态 0删除 1 可用 2 已使用 3 转赠',
			'expire' => '过期时间',
			'created' => '创建时间',
			'last_update' => '最后更新时间',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientTicket the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
