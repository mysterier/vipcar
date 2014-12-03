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
}