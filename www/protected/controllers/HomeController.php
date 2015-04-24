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
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
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
        $hash['model'] = $model;
        $hash['item'] = $item;
        $this->render('register', $hash);
    }
    
    public function actionRegperson() {
        $model = new Clients();
        $model->setScenario('webreg');
        $model->attributes = $_POST['Clients'];
        if ($model->validate()) {
            $model->password = $this->encryptPasswd($model->password);
            if ($model->save(false))
                $this->redirect('/login');
        }
        
        $hash['model'] = $model;
        $this->render('register', $hash);
    }
    
    public function actionRegenter() {
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
            if ($model->save(false)) {
                $item->client_id = $model->id;
                $item->area = implode('-', $item->area);
                $item->area = $item->area == '省份-地级市-区县' ? '' : $item->area;
                if ($item->save(false))
                    $this->redirect('/login?type=1');
            }
        }
        
        $hash['model'] = $model;
        $hash['item'] = $item;
        $hash['show_enter'] = true;
        $this->render('register', $hash);
    }

    public function filters()
    {
        return [
            'accessControl'
        ];
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