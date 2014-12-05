<?php

/**
 * This is the model class for table "tbl_message_tpl".
 *
 * The followings are the available columns in table 'tbl_message_tpl':
 * @property integer $id
 * @property string $tag
 * @property string $content
 */
class MessageTpl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_message_tpl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return [
		    'personal_msg' => [
		         self::HAS_MANY,
		         'PersonalMessage',
		         'tpl_id'
		    ]
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tag' => '消息头',
			'content' => '信息模板',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MessageTpl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
