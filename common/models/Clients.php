<?php

/**
 * This is the model class for table "tbl_clients".
 *
 * The followings are the available columns in table 'tbl_clients':
 * @property string $id
 * @property string $real_name
 * @property string $avatar
 * @property string $mobile
 * @property string $password
 * @property string $email
 * @property string $credit_record
 * @property string $city_id
 * @property string $created
 * @property string $last_update
 */
class Clients extends CActiveRecord
{

    public $msg_code;
    public $confirmpwd;
    public $agreeme;
    public $oldpwd;
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
        return [
            
            [
                'email',
                'email',
                'message' => '{attribute}格式不正确！',
            ],
            [
                'email,mobile',
                'required',
                'on' => [
                    'insert',
                    'update',
                    'reg'
                ]
            ],
            [
                'mobile',
                'match',
                'pattern' => '/^(?:(?:1(?:3[4-9]|5[012789]|8[78])\d{8}|1(?:3[0-2]|5[56]|8[56])\d{8}|18[0-9]\d{8}|1[35]3\d{8})|14[57]\d{8}|170[059]\d{7}|17[67]\d{8})$/',
                'allowEmpty' => false,
                'message' => ERROR_MSG_MOBILE,
                'on' => [
                    'insert',
                    'update',
                    'reg',
                    'loginv1',
                    'webreg',
                    'webedit',
                    'webgetpass',
                    'wechat'
                ]
            ],
            [
                'mobile',
                'unique',
                'className' => 'Clients',
                'attributeName' => 'mobile',
                'allowEmpty' => false,
                'message' => CLIENT_ERROR_MSG_REGISTERED,
                'on' => [
                    'insert',
                    'update',
                    'reg',
                    'loginv1',
                    'webreg',
                    'webedit'
                ]
            ],
            [
                'email',
                'unique',
                'className' => 'Clients',
                'attributeName' => 'email',
                'message' => EMAIL_EXISTED,
                'on' => [
                    'insert',
                    'update',
                    'reg',
                    'webreg',
                    'webedit',
                    'wxedit'
                ]
            ],
            [
                'password,last_update',
                'safe',
                'on' => 'reg'
            ],
            [
                'real_name, mobile, email',
                'safe',
                'on' => 'search'
            ],
            [
                'real_name, client_title,credit_record',
                'safe',
                'on' => [
                    'insert',
                    'update',
                    'webreg'
                ]
            ],
            [
                'msg_code',
                'msg_code',
                'on' => [                    
                    'webreg',
                    'webgetpass',
                    'wechat'
                ],
            ],
            [
                'password,oldpwd',
                'required',
                'message' => '{attribute}不能为空！',
                'on' => [
                    'webeditpwd'
                ]
            ],
            [
                'password',
                'required',
                'message' => '{attribute}不能为空！',
                'on' => [                    
                    'webreg',
                    'webgetpass',
                    'wechat'
                ]
            ],
            [
                'confirmpwd',
                'compare',
                'compareAttribute' => 'password',
                'message' => '两次密码输入不一致',
                'on' => [
                    'webreg',
                    'webeditpwd',
                    'webgetpass'
                ]
            ],
            [
                'agreeme',
                'agreeme',
                'on' => 'webreg'
            ],
            [
                'oldpwd',
                'oldpwd',
                'on' => 'webeditpwd'
            ],
            [
                'real_name, client_title,',
                'safe',
                'on' => [
                    'webedit',
                    'wxedit'
                ]
            ],
            [
                'open_id',
                'safe',
                'on' => 'wechat'
            ]
        ];
    }

    public function msg_code($attribute, $params) {
        $captcha = Yii::app()->redis->getClient()->get($this->mobile);
        if (!$this->msg_code || $captcha != $this->msg_code)
            $this->addError('msg_code', '验证码错误！');
    }
    
    public function agreeme($attribute, $params) {
        if (!$this->agreeme)
            $this->addError('agreeme', '未同意条款！');
    }
    
    public function oldpwd($attribute, $params) {
        $uid = Yii::app()->user->id;
        $model = self::model()->findByPk($uid);
        $pass = md5($this->oldpwd);
        $pass = 'suxian' . $pass;
        $pass = md5($pass);
        if ($model->password != $pass) 
            $this->addError('oldpwd', '原始密码不正确！');
    }
    
    /**
     * 注册得50元优惠券
     * 活动时间：2015年6月1日-2015年9月1日
     */
    public function getticket() {
        $start = strtotime('2015-06-01 00:00:01');
        $end = strtotime('2015-09-01 23:59:59');
        if (time() > $start && time() < $end) {
            $client_ticket = new ClientTicket();
            $client_ticket->client_id = $this->id;
            $client_ticket->ticket_id = 2;
            $client_ticket->coupon_type = COUPON_COMMON;
            $client_ticket->expire = strtotime('+30 days');
            $client_ticket->save();
        }
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
            ],
            'client_msg' => [
                self::HAS_MANY,
                'ClientMessage',
                'client_id'
            ],
            'contacter' => [
                self::HAS_MANY,
                'ContacterHistory',
                'client_id'
            ],
            'ticket' => [
                self::MANY_MANY,
                'Tickets',
                'tbl_client_ticket(client_id, ticket_id)'
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
            'email' => '电子邮箱',
            'password' => '密码',
            'client_title' => '称谓',
            'credit_record' => '诚信记录',
            'city_id' => '城市',
            'created' => '创建时间',
            'last_update' => '最后更新时间',
            'msg_code' => '短信验证码',
            'confirmpwd' => '确认密码',
            'oldpwd' => '原始密码'
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
