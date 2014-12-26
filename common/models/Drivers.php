<?php

/**
 * This is the model class for table "tbl_drivers".
 *
 * The followings are the available columns in table 'tbl_drivers':
 * @property string $id
 * @property string $name
 * @property string $password
 * @property integer $age
 * @property string $sex
 * @property string $avatar
 * @property string $id_card
 * @property string $level
 * @property string $driver_level
 * @property string $valid_from
 * @property string $valid_for
 * @property string $address
 * @property string $mobile
 * @property string $contacter
 * @property string $contacter_tel
 * @property string $police_check
 * @property string $id_card_path
 * @property string $license_path
 * @property string $health
 * @property string $status
 * @property string $created
 * @property integer $last_update
 */
class Drivers extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_drivers';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'name, id_card, level, valid_from, valid_for, address, mobile, contacter, contacter_tel, police_check, id_card_path, license_path, health',
                'required'
            ],
            [
                'age',
                'numerical'
            ],
            [
                'age',
                'length',
                'min' => 1,
                'max' => 2
            ],
            [
                'mobile',
                'match',
                'pattern' => '/^(?:(?:1(?:3[4-9]|5[012789]|8[78])\d{8}|1(?:3[0-2]|5[56]|8[56])\d{8}|18[0-9]\d{8}|1[35]3\d{8})|14[57]\d{8}|170[059]\d{7}|17[67]\d{8})$/',
                'allowEmpty' => false,
                'message' => ERROR_MSG_MOBILE
            ],
            [
                'mobile',
                'unique',
                'className' => 'Drivers',
                'attributeName' => 'mobile',
                'allowEmpty' => false,
                'message' => CLIENT_EORROR_MSG_REGISTERED
            ],
            [
                'id_card',
                'unique',
                'className' => 'Drivers',
                'attributeName' => 'id_card',
                'allowEmpty' => false,
                'message' => ID_CARD_EXISTED
            ],
            [
                'avatar',
                'file',
                'types' => 'jpg,png,gif',
                'maxSize' => 1024 * 1024 * 10,
                'tooLarge' => FILE_TOOLARGE,
                'allowEmpty' => true,
            ],
            [
                'id_card_path',
                'file',
                'types' => 'jpg,png,gif',
                'maxSize' => 1024 * 1024 * 10,
                'tooLarge' => FILE_TOOLARGE
            ],
            [
                'license_path',
                'file',
                'types' => 'jpg,png,gif',
                'maxSize' => 1024 * 1024 * 10,
                'tooLarge' => FILE_TOOLARGE
            ],
            [
                'name, id_card',
                'safe',
                'on' => 'search'
            ],
            [
                'sex, status',
                'safe'
            ]
        ];
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'vehicle' => [
                self::MANY_MANY,
                'Vehicle',
                'tbl_driver_vehicle(driver_id, vehicle_id)'
            ],
            'orders' => [
                self::HAS_MANY,
                'Orders',
                'driver_id'
            ],
            'driver_msg' => [
                self::HAS_MANY,
                'DriverMessage',
                'driver_id'
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
            'name' => '姓名',
            'age' => '年龄',
            'sex' => '性别',
            'avatar' => '头像',
            'id_card' => '身份证号码',
            'password' => '密码',
            'level' => '准驾等级',
            'valid_from' => '初次领证时间',
            'valid_for' => '年审换证时间',
            'address' => '家庭地址',
            'mobile' => '手机',
            'contacter' => '紧急联系人',
            'contacter_tel' => '紧急联系人电话',
            'police_check' => '无犯罪记录证明',
            'id_card_path' => '身份证',
            'license_path' => '驾驶证',
            'health' => '体检状态',
            'status' => '状态'
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
        
        $criteria->compare('name', $this->name, true);
        $criteria->compare('id_card', $this->id_card, true);
        
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
     * @return Drivers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
