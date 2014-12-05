<?php

/**
 * This is the model class for table "tbl_vehicle".
 *
 * The followings are the available columns in table 'tbl_vehicle':
 * @property string $id
 * @property string $license_no
 * @property string $vehicle_model_id
 * @property string $engine_no
 * @property string $frame_no
 * @property string $insurance
 * @property string $inspection
 * @property string $vehicle_license_path
 * @property string $policy_path
 * @property string $status
 * @property string $ltd_name
 * @property string $ltd_legal_person
 * @property string $ltd_contacter
 * @property string $ltd_contacter_tel
 * @property string $ltd_reg_address
 * @property string $ltd_office_address
 * @property string $created
 */
class Vehicle extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_vehicle';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array(
                'license_no, vehicle_model_id, engine_no, frame_no, insurance, inspection, vehicle_license_path, policy_path',
                'required'
            ),
            array(
                'license_no, engine_no',
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
            'drivers'   => [
                self::MANY_MANY,
                'Drivers',
                'tbl_driver_vehihcle(vehicle_id, driver_id)'
            ],
            'model'     => [
                self::BELONGS_TO,
                'VehicleModel',
                'vehicle_model_id'
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
            'license_no' => '车牌号',
            'vehicle_model' => '车型',
            'vehicle_type' => '汽车分类',
            'engine_no' => '车架号',
            'frame_no' => '车架号',
            'insurance' => '保险额度',
            'inspection' => '年检时间',
            'vehicle_license_path' => '行驶证',
            'policy_path' => '保单复印件',
            'status' => '状态 ',
            'ltd_name' => '公司名称',
            'ltd_legal_person' => '法人',
            'ltd_contacter' => '联系人',
            'ltd_contacter_tel' => '联系电话',
            'ltd_reg_address' => '注册地址',
            'ltd_office_address' => '办公地址',
            'created' => '创建时间'
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
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria();
        
        $criteria->compare('license_no', $this->license_no, true);
        $criteria->compare('engine_no', $this->engine_no, true);
        
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
     * @return Vehicle the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
