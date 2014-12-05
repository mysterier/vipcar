<?php

/**
 * This is the model class for table "tbl_api_lastupdate".
 *
 * The followings are the available columns in table 'tbl_api_lastupdate':
 * @property string $id
 * @property string $token
 * @property string $api
 * @property string $url
 * @property string $last_update
 */
class ApiLastupdate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_api_lastupdate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
		    [
		        'last_update,token,api,url',
		         'safe'
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
			'token' => 'token',
			'api' => 'api名称',
			'url' => 'api对应的url',
			'last_update' => '最后更新时间',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ApiLastupdate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
