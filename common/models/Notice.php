<?php

/**
 * This is the model class for table "tbl_notice".
 *
 * The followings are the available columns in table 'tbl_notice':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $created
 */
class Notice extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_notice';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array(
                'title, content',
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
            'title' => '标题',
            'content' => '内容',
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
