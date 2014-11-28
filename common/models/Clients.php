<?php

/**
 * This is the model class for table "tbl_clients".
 *
 * The followings are the available columns in table 'tbl_clients':
 * @property string $id
 * @property string $real_name
 * @property string $avatar
 * @property string $mobile
 * @property string $email
 * @property string $credit_record
 * @property string $city_id
 * @property string $created
 * @property string $last_update
 */
class Clients extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_clients';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array(
                'real_name, credit_record, mobile',
                'required'
            ),
            array(
                'email',
                'email'
            ),
            array(
                'mobile',
                'match',
                'pattern' => '/^(?:(?:1(?:3[4-9]|5[012789]|8[78])\d{8}|1(?:3[0-2]|5[56]|8[56])\d{8}|18[0-9]\d{8}|1[35]3\d{8})|14[57]\d{8}|170[059]\d{7}|17[67]\d{8})$/'
            ),
            
            // The following rule is used by search().
            array(
                'real_name, mobile, email',
                'safe',
                'on' => 'search'
            )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'city' => [
                self::BELONGS_TO,
                'City',
                'city_id'
            ],
            'orders' => [
                self::HAS_MANY,
                'Orders',
                'client_id'
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
            'real_name' => '姓名',
            'avatar' => '头像',
            'mobile' => '手机号',
            'email' => '邮箱',
            'credit_record' => '诚信记录',
            'city_id' => '城市',
            'created' => '创建时间',
            'last_update' => '最后更新时间'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     *         based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();
        
        $criteria->compare('real_name', $this->real_name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('email', $this->email, true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return Clients the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
