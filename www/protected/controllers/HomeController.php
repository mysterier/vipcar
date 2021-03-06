<?php

class HomeController extends Controller
{

    public function actionIndex()
    {
        $this->setPageTitle('专注接送机服务，让出行轻松一些_众择用车');
        $this->render('index');
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->setPageTitle('个人会员登录_众择用车');
        $model = new LoginForm();
        $hash['model'] = $model;
        
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $url = Yii::app()->user->returnUrl;
                $url = $url == '/' ? '/order/pickup' : $url;
                $this->redirect($url);
            }               
        }
        $this->render('login', $hash);
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/');
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
    public function actionRegister() {
        $this->setPageTitle('个人会员注册_众择用车');
        $model = new Clients();
        $item = new ClientItems();
        $model->client_title = '1';
        $hash['model'] = $model;
        $hash['item'] = $item;
        $this->render('register', $hash);
    }
    
    public function actionRegperson() {
        if (!$_POST)
            $this->redirect('/register');
        $model = new Clients();
        $model->setScenario('webreg');
        $model->attributes = $_POST['Clients'];
        if ($model->validate()) {
            $model->password = $this->encryptPasswd($model->password);
            $model->status = USER_CLIENT_ACTIVED;
            if ($model->save(false)) {
                //注册赠送优惠券活动
                $model->getticket();
                $login = new LoginForm();
                $login->username = $_POST['Clients']['mobile'];
                $login->password = $_POST['Clients']['password'];
                if ($login->validate() && $login->login())
                    $this->redirect('/order/pickup');
            }              
        }
        
        $item = new ClientItems();
        $hash['item'] = $item;
        $hash['model'] = $model;
        $this->render('register', $hash);
    }
    
    public function actionRegenter() {
        if (!$_POST)
            $this->redirect('/register');
        $model = new Clients();
        $model->setScenario('webreg');
        $model->attributes = $_POST['Clients'];
        
        $item = new ClientItems();
        $item->setScenario('webreg');
        $item->attributes = $_POST['ClientItems'];
        
        $model_validate = $model->validate();
        $item_validate = $item->validate();
        
        if ($model_validate && $item_validate) {
            $model->password = $this->encryptPasswd($model->password);
            $model->type = 1;
            $model->status = USER_CLIENT_ACTIVED;
            if ($model->save(false)) {
                //注册赠送优惠券活动
                $model->getticket();
                $item->client_id = $model->id;
                $item->area = implode('-', $item->area);
                $item->area = $item->area == '省份-地级市-区县' ? '' : $item->area;
                if ($item->save(false)) {
                    $_GET['type'] = 1;
                    $login = new LoginForm();
                    $login->username = $_POST['Clients']['mobile'];
                    $login->password = $_POST['Clients']['password'];
                    if ($login->validate() && $login->login())
                        $this->redirect('/order/pickup');
                }
            }
        }
        
        $hash['model'] = $model;
        $hash['item'] = $item;
        $hash['show_enter'] = true;
        $this->render('register', $hash);
    }

    public function actionService() {
        $this->setPageTitle('【图】上海机场高铁接送_众择用车');
        $this->render('service');
    }
    
    public function actionEvent() {
        $this->setPageTitle('最新活动_众择用车');
        $criteria = new CDbCriteria();
        $criteria->condition = 'status = :status';
        $criteria->order = 'id DESC';
        $criteria->params = [
            'status' => STATUS_LIVE
        ];
        $model = Event::model()->findAll($criteria);
        $hash['model'] = $model;
        $this->render('event', $hash);
    }
    
    public function actionEventdetail($id) {
        $model = Event::model()->findByPk($id);
        $hash['model'] = $model;
        $this->render('eventdetail', $hash);
    }
    
    public function actionDownload() {
        $this->render('download');
    }
    
    public function actionAppdown() {
        $this->render('appdown');
    }
    
    public function actionMagazine() {
        $this->setPageTitle('聚焦论谈_众择用车');
        $attributes = [
            'status' => 1
        ];
        $model = Magazine::model()->findAllByAttributes($attributes);
        $hash['model'] = $model;
        $this->render('magazine', $hash);
    }
    
    public function actionAbout() {
        $this->layout = '//layouts/about';
        $this->setPageTitle('帮助中心_关于众择_众择用车');
        $this->render('static/about');
    }
    
    public function actionCulture() {
        $this->layout = '//layouts/about';
        $this->setPageTitle('帮助中心_众择文化_众择用车');
        $this->render('static/culture');
    }
    
    public function actionServices() {
        $this->layout = '//layouts/about';
        $this->render('static/services');
    }
    
    public function actionSpecial() {
        $this->layout = '//layouts/about';
        $this->render('static/special');
    }
    
    public function actionJobs() {
        $this->layout = '//layouts/about';
        $this->render('static/jobs');
    }
    
    public function actionContact() {
        $this->layout = '//layouts/about';
        $this->render('static/contact');
    }
    
    public function actionAttention() {
        $this->render('static/attention');
    }
    
    public function actionProtocal() {
        $this->render('static/protocal');
    }
    
    public function actionEntprotocal() {
        $this->render('static/entprotocal');
    }
    
    public function actionGetpass() {
        $model = new Clients();
        if ($_POST) {
            $attributes = [
                'mobile' => $_POST['Clients']['mobile']
            ];
            $client = Clients::model()->findByAttributes($attributes);
            if ($client) {
                $client->setScenario('webgetpass');
                $client->attributes = $_POST['Clients'];//var_dump($client->attributes);exit();
                if ($client->validate()) {
                    $client->password = $this->encryptPasswd($client->password);
                    if($client->save(false))
                        $this->redirect('/login');
                } else {
                    $model = $client;
                }
            } else {
                $model->attributes = $_POST['Clients'];
                $model->addError('mobile', '该用户不存在！');
            }          
        }
        $hash['model'] = $model;
        $this->render('getpass', $hash);
    }
    
    public function actionNotice() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'status = 1';
        $criteria->order = 'id DESC';
        $model = Notice::model()->findAll($criteria);
        $hash['model'] = $model;
        $this->render('notice' ,$hash);
    }
    
    public function accessRules()
    {
        return [

            [
                'deny',
                'actions' => [
                    'login'
                ],
                'users' => [
                    '@'
                ],
                'deniedCallback' => function ($rule) {
                    header("location: /");
                }
            ]
        ];
    }
}