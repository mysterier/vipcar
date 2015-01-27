<?php

/**
 * This is the model class for table "tbl_driver_vehicle".
 *
 * The followings are the available columns in table 'tbl_driver_vehicle':
 * @property string $id
 * @property string $driver_id
 * @property string $vehicle_id
 * @property string $created
 */
class DriverVehicle extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_driver_vehicle';
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
			'driver_id' => '司机id',
			'vehicle_id' => '车辆id',
			'created' => '创建时间',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DriverVehicle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
