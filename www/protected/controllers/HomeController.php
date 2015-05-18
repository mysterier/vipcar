<?php

class HomeController extends Controller
{

    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
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
        $this->render('service');
    }
    
    public function actionEvent() {
        $this->render('event');
    }
    
    public function actionDownload() {
        $this->render('download');
    }
    
    public function actionMagazine() {
        $attributes = [
            'status' => 1
        ];
        $model = Magazine::model()->findAllByAttributes($attributes);
        $hash['model'] = $model;
        $this->render('magazine', $hash);
    }
    
    public function actionAbout() {
        $this->layout = '//layouts/about';
        $this->render('static/about');
    }
    
    public function actionCulture() {
        $this->layout = '//layouts/about';
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