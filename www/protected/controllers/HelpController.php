<?php

class HelpController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = '//layouts/help';
    }
    
    public function actionLogin() {
        $this->render('login');
    }
    
    public function actionPassword() {
        $this->render('password');
    }

    public function actionWebpay() {
        $this->render('webpay');
    }
    
    public function actionApppay() {
        $this->render('apppay');
    }
    
    public function actionCar() {
        $this->render('car');
    }
    
    public function actionBilling() {
        $this->render('billing');
    }
    
    public function actionService() {
        $this->render('service');
    }
    
    public function actionOrder() {
        $this->render('order');
    }
    
    public function actionFaq() {
        $this->render('faq');
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