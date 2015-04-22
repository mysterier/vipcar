<?php

/**
 * This is the model class for table "tbl_magazine".
 *
 * The followings are the available columns in table 'tbl_magazine':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $created
 */
class Magazine extends CActiveRecord
{

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_magazine';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array(
                'title, cover, out_link, content',
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
            'cover' => '封面',
            'out_link' => '链接',
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
