<?php

/**
 * This is the model class for table "tbl_invoice_address".
 *
 * The followings are the available columns in table 'tbl_invoice_address':
 * @property string $id
 * @property string $uid
 * @property string $contacter_name
 * @property string $contacter_mobile
 * @property string $address_info
 * @property integer $is_common_use
 * @property integer $status
 * @property string $created
 */
class InvoiceAddress extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_invoice_address';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'uid, contacter_name, contacter_mobile, address_info, is_common_use',
                'required'
            ]
        ];
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        return [];
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'uid' => '用户id',
            'contacter_name' => '联系人',
            'contacter_mobile' => '联系电话',
            'address_info' => '地址详情',
            'is_common_use' => '默认地址0否1是',
            'status' => '状态0删除1可用',
            'created' => '创建时间'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * 
     * @param string $className
     *            active record class name.
     * @return InvoiceAddress the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
