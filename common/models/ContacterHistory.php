<?php

/**
 * This is the model class for table "tbl_contacter_history".
 *
 * The followings are the available columns in table 'tbl_contacter_history':
 * @property integer $id
 * @property string $client_id
 * @property string $name
 * @property string $created
 * @property integer $weight
 */
class ContacterHistory extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_contacter_history';
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
            'client' => [
                self::BELONGS_TO,
                'Clients',
                'client_id'
            ],
            'tel' => [
                self::HAS_MANY,
                'ContacterTel',
                'contacter_id'
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
            'client_id' => '客户id',
            'name' => '联系人',
            'created' => '创建时间',
            'weight' => '权重'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return ContacterHistory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
