<?php

/**
 * This is the model class for table "tbl_admin".
 *
 * The followings are the available columns in table 'tbl_admin':
 * @property string $id
 * @property string $name
 * @property string $passwd
 * @property string $created
 */
class Admin extends CActiveRecord
{

    public $confirmpwd;

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_admin';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'name',
                'required'
            ],
            [
                'name',
                'unique',
                'className' => 'Admin',
                'attributeName' => 'name',
                'allowEmpty' => false,
                'message' => '用户名不能重复',
            ],
            [
                'passwd',
                'required'
            ],
            [
                'confirmpwd',
                'compare',
                'compareAttribute' => 'passwd',
                'message' => '两次密码输入不一致',
                'on' => 'insert'
            ],
            [
                'id, name, passwd, created',
                'safe',
                'on' => 'search'
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
            'name' => '用户名',
            'passwd' => '密码',
            'confirmpwd' => '确认密码',
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
        
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('passwd', $this->passwd, true);
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
     * @return Admin the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
