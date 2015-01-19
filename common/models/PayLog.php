<?php

/**
 * This is the model class for table "tbl_pay_log".
 *
 * The followings are the available columns in table 'tbl_pay_log':
 * @property string $id
 * @property string $uid
 * @property string $amount
 * @property string $order_no
 * @property string $created
 */
class PayLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_pay_log';
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
		return [];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'uid' => '用户id',
			'amount' => '金额',
			'order_id' => '订单id',
			'created' => '创建时间',
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PayLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
