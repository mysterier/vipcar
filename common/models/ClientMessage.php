<?php

/**
 * This is the model class for table "tbl_personal_message".
 *
 * The followings are the available columns in table 'tbl_personal_message':
 * @property string $id
 * @property string $client_id
 * @property string $client_type
 * @property string $tpl_id
 * @property string $created
 * @property string $last_update
 */
class ClientMessage extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_client_message';
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
            
            'tpl' => [
                self::BELONGS_TO,
                'MessageTpl',
                'tpl_id'
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
            'client_id' => '用户id',
            'client_type' => '用户类型 ',
            'tpl_id' => '消息模板id',
            'created' => '创建时间',
            'last_update' => '最后更新时间'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * 
     * @param string $className
     *            active record class name.
     * @return PersonalMessage the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
