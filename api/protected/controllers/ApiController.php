<?php
class ApiController extends Controller
{

    public function actionIndex()
    {
        $this->render('index');
    }

    protected function afterAction($action)
    {}

    public function actionLogin()
    {
        $model = new ApiLoginForm();
        
        $this->render('login', array(
            'model' => $model
        ));
    }

    public function actionStatus()
    {
        $this->render('status');
    }

    public function actionOrderlist()
    {
        $this->render('order_list');
    }

    public function actionOrderdetail()
    {
        $this->render('order_detail');
    }

    public function actionOrderstatus()
    {
        $this->render('order_status');
    }

    public function actionOrdermodify()
    {
        $this->render('order_modify');
    }

    public function actionDriverinfor()
    {
        $this->render('driverinfor');
    }

    public function actionMessagelist()
    {
        $this->render('message_list');
    }

    public function actionIncomestat()
    {
        $this->render('incomestat');
    }
    
    public function actionChgiostoken()
    {
        $this->render('Chgiostoken',['module' => 'driver']);
    }
    
    public function actionBindchannel()
    {
        $this->render('bindchannel',['module' => 'driver']);
    }
    
    public function actionResetpass()
    {
        $this->render('resetpass',['module' => 'driver/driverinfor']);
    }
    
    public function actionSendcodeforget()
    {
        $this->render('sendcode_forget',['module' => 'driver/sendcode']);
    }
    
    public function actionForgetpass()
    {
        $this->render('forgetpass',['module' => 'driver/driverinfor']);
    }
    // =====================客户端=============
    public function actionCRegister()
    {
        $this->render('cregister');
    }

    public function actionCRegvalidate()
    {
        $this->render('cregvalidate');
    }

    public function actionCLogin()
    {
        $model = new ApiLoginForm();
        
        $this->render('clogin', array(
            'model' => $model
        ));
    }

    public function actionAirportpickup()
    {
        $this->render('airportpickup');
    }

    public function actionAirportsend()
    {
        $this->render('airportsend');
    }

    public function actionClientinfor()
    {
        $this->render('clientinfor');
    }

    public function actionCOrderlist()
    {
        $this->render('corder_list');
    }

    public function actionCOrderdetail()
    {
        $this->render('corder_detail');
    }

    public function actionCMessagelist()
    {
        $this->render('cmessage_list');
    }

    public function actionPageinfor()
    {
        $this->render('pageinfor');
    }

    public function actionContacter()
    {
        $this->render('contacter');
    }

    public function actionCchgiostoken()
    {
        $this->render('Chgiostoken',['module' => 'client']);
    }
    
    public function actionGetticket()
    {
        $this->render('get_ticket');
    }
    
    public function actionCouponlist()
    {
        $this->render('coupon_list');
    }
    
    public function actionCouponhistory()
    {
        $this->render('coupon_history');
    }
    
    public function actionSendcode()
    {
        $this->render('send_code');
    }
    
    public function actionCbindchannel()
    {
        $this->render('bindchannel',['module' => 'client']);
    }
    
    public function actionAvatar()
    {
        $this->render('avatar');
    }
    
    public function actionModifyinfor()
    {
        $this->render('modify_infor');
    }
    
    public function actionOrdercomment()
    {
        $this->render('order_comment');
    }
    
    public function actionRecharge() {
        $this->render('recharge');
    }
    
    public function actionRechargelist() {
        $this->render('recharge_list');
    }
    
    public function actionCouponpresent()
    {
        $this->render('coupon_present');
    }
    
    public function actionCresetpass()
    {
        $this->render('resetpass',['module' => 'client/clientinfor']);
    }
    
    public function actionCsendcodeforget()
    {
        $this->render('sendcode_forget',['module' => 'client/sendcode']);
    }
    
    public function actionCforgetpass()
    {
        $this->render('forgetpass',['module' => 'client/clientinfor']);
    }
}