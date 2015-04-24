<?php

/**
 * This is the model class for table "tbl_messages".
 *
 * The followings are the available columns in table 'tbl_messages':
 * @property string $id
 * @property string $tpl_id
 * @property string $type
 * @property string $event
 * @property string $created
 */
class Messages extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_messages';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'tpl_id, type, event, created',
                'required'
            )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'tpl_id' => '消息模板id',
            'type' => '消息类型',
            'event' => '触发事件',
            'created' => '创建时间'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return Messages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
