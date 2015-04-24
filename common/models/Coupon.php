<?php

/**
 * This is the model class for table "tbl_coupon".
 *
 * The followings are the available columns in table 'tbl_coupon':
 * @property string $id
 * @property string $client_id
 * @property string $coupon
 * @property string $status
 * @property string $created
 */
class Coupon extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_coupon';
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
			'coupon' => '优惠码',
			'status' => '优惠码状态0未使用1已经使用',
			'created' => '创建时间',
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Coupon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
