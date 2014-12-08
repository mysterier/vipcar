<?php

class ApiController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	protected function afterAction($action) {}
	
	public function actionLogin() {
	    $model=new ApiLoginForm;

		$this->render('login',array('model'=>$model));
	}

    public function actionStatus() {
        $this->render('status');
    }

    public function actionOrderlist() {
        $this->render('order_list');
    }
    
    public function actionOrderdetail() {
        $this->render('order_detail');
    }
   
    public function actionOrderstatus() {
        $this->render('order_status');
    }
    
    public function actionOrdermodify() {
        $this->render('order_modify');
    }
    
    public function actionDriverinfor() {
        $this->render('driverinfor');
    }
    
    public function actionMessagelist() {
        $this->render('message_list');
    }
    
    
    //=====================客户端=============
    
    public function actionCRegister() {
        $this->render('cregister');
    }
    
    public function actionCRegvalidate() {
        $this->render('cregvalidate');
    }
    
    public function actionCLogin() {
        $model=new ApiLoginForm;
    
        $this->render('clogin',array('model'=>$model));
    }
}