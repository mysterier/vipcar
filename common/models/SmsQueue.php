<?php

/**
 * This is the model class for table "tbl_sms_queue".
 *
 * The followings are the available columns in table 'tbl_sms_queue':
 * @property string $id
 * @property string $tpl
 * @property string $mobile
 * @property string $content
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class SmsQueue extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_sms_queue';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'tpl, mobile, content',
                'required'
            ],
            [
                'mobile',
                'match',
                'pattern' => '/^(?:(?:1(?:3[4-9]|5[012789]|8[78])\d{8}|1(?:3[0-2]|5[56]|8[56])\d{8}|18[0-9]\d{8}|1[35]3\d{8})|14[57]\d{8}|170[059]\d{7}|17[67]\d{8})$/',
                'allowEmpty' => false,
                'message' => ERROR_MSG_MOBILE,
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
            'tpl' => '短信模板',
            'mobile' => '手机号',
            'content' => '短信内容',
            'status' => '状态0未发送1发送',
            'created' => '创建时间',
            'updated' => '更新时间'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * 
     * @param string $className
     *            active record class name.
     * @return SmsQueue the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
