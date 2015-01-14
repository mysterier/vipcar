<?php

/**
 * This is the model class for table "tbl_token".
 *
 * The followings are the available columns in table 'tbl_token':
 * @property string $id
 * @property string $client_id
 * @property string $type
 * @property string $token
 * @property string $created
 */
class Token extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_token';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            [
                'token',
                'exist',
                'className' => 'Token',
                'attributeName' => 'token',
                'allowEmpty' => false,
                'on' => 'check'
            ],
            
            [
                'client_id,type,token,ios_token',
                'safe'
            ]
        );
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
            'type' => '用户类型1客户2司机',
            'token' => 'token',
            'created' => '创建时间'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return Token the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
