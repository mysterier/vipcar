<?php

/**
 * This is the model class for table "tbl_invoice_record".
 *
 * The followings are the available columns in table 'tbl_invoice_record':
 * @property string $id
 * @property string $uid
 * @property string $invoice_title
 * @property string $invoice_amount
 * @property string $contacter_name
 * @property string $contacter_mobile
 * @property string $address_info
 * @property string $created
 */
class InvoiceRecord extends CActiveRecord
{
    public $have_invoiced_amount;

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_invoice_record';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'uid, invoice_title, invoice_amount, contacter_name, contacter_mobile, address_info',
                'required',
                'message' => '{attribute}不能为空！'
            ],
            [
                'invoice_amount',
                'invoice_amount',
                'on' => 'webcreate'
            ]
        ];
    }

    public function invoice_amount($attribute, $params) {
        if ($_POST['InvoiceRecord']['invoice_amount'] <= 0)
            $this->addError('invoice_amount', '请注意发票金额！');
        if ($_POST['InvoiceRecord']['invoice_amount'] > $_POST['available_invoice_amount'])
            $this->addError('invoice_amount', '发票金额超出可开票金额！');
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
            'invoice_title' => '发票抬头',
            'invoice_amount' => '开票金额',
            'contacter_name' => '联系人',
            'contacter_mobile' => '联系电话',
            'address_info' => '地址详情',
            'created' => '创建时间'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * 
     * @param string $className
     *            active record class name.
     * @return InvoiceRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
