<?php

/**
 * This is the model class for table "tbl_vehicle_type".
 *
 * The followings are the available columns in table 'tbl_vehicle_type':
 * @property string $id
 * @property string $vehicle_type
 */
class VehicleType extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_vehicle_type';
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'model' => [
                self::HAS_MANY,
                'VehicleModel',
                'vehicle_type'
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
            'vehicle_type' => '汽车分类'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return VehicleType the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
