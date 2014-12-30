<?php

/**
 * This is the model class for table "tbl_tickets".
 *
 * The followings are the available columns in table 'tbl_tickets':
 * @property string $id
 * @property string $name
 * @property string $status
 */
class Tickets extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_tickets';
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
            'code' => [
                self::HAS_MANY,
                'Coupon',
                'ticket_id'
            ],
            'client' => [
                self::MANY_MANY,
                'Clients',
                'tbl_client_ticket(ticket_id, client_id)'
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
            'name' => '优惠券',
            'status' => '状态'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * 
     * @param string $className
     *            active record class name.
     * @return Tickets the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
