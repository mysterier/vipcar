<?php

/**
 * This is the model class for table "tbl_client_items".
 *
 * The followings are the available columns in table 'tbl_client_items':
 * @property string $id
 * @property string $client_id
 * @property string $originator
 * @property string $company_name
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property string $created
 */
class ClientItems extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_client_items';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'company_name, originator, address',
                'required',
                'message' => '{attribute}不能为空',
                'on' => 'webreg'
            ],
            [
                'area, tel',
                'safe',
                'on' => 'webreg'
            ],
            [
                'id, client_id, originator, company_name, area, address, tel, created',
                'safe',
                'on' => 'search'
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
            'client_id' => '客户id',
            'originator' => '创建人',
            'company_name' => '企业名称',
            'area' => 'Area',
            'address' => '公司地址',
            'tel' => '固定电话',
            'created' => 'Created'
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
        
        $criteria->compare('id', $this->id, true);
        $criteria->compare('client_id', $this->client_id, true);
        $criteria->compare('originator', $this->originator, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('area', $this->area, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('tel', $this->tel, true);
        $criteria->compare('created', $this->created, true);
        
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
     * @return ClientItems the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
