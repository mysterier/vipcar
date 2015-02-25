<?php

/**
 * This is the model class for table "tbl_wx_coupon".
 *
 * The followings are the available columns in table 'tbl_wx_coupon':
 * @property string $id
 * @property string $open_id
 * @property string $value
 * @property string $scope
 * @property string $status
 * @property string $created
 * @property string $last_update
 */
class WxCoupon extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_wx_coupon';
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
			'open_id' => '微信openid',
			'value' => '优惠券价值',
			'scope' => '适用范围：1接机2送机',
			'status' => '状态：1可用 2已使用',
			'created' => '创建时间',
			'last_update' => '最后更新时间',
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WxCoupon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
