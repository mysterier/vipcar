<?php

/**
 * This is the model class for table "tbl_wx_expand".
 *
 * The followings are the available columns in table 'tbl_wx_expand':
 * @property string $id
 * @property string $open_id
 * @property string $ad_type
 * @property string $grant
 * @property string $created
 */
class WxExpand extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_wx_expand';
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
			'ad_type' => '推广广告',
			'grant' => '是否已经生成优惠券0否1是',
			'created' => 'Created',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WxExpand the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
