<?php

/**
 * This is the model class for table "tbl_vehicle_model".
 *
 * The followings are the available columns in table 'tbl_vehicle_model':
 * @property string $id
 * @property string $make
 * @property string $model
 * @property string $vehicle_type
 */
class VehicleModel extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_vehicle_model';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array();
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'vehicle' => [
                self::HAS_MANY,
                'Vehicle',
                'vehicle_model_id'
            ],
            'type' => [
                self::BELONGS_TO,
                'VehicleType',
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
            'make' => '品牌名称',
            'model' => '型号',
            'vehicle_type' => '汽车分类id'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * 
     * @param string $className
     *            active record class name.
     * @return VehicleModel the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
