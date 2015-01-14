<?php

/**
 * This is the model class for table "tbl_city".
 *
 * The followings are the available columns in table 'tbl_city':
 * @property string $id
 * @property string $name
 */
class City extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_city';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [];
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'clients' => [
                self::HAS_MANY,
                'Clients',
                'city_id'
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
            'name' => '城市'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return City the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
