<?php

class RechargeController extends Controller
{

    public function actionIndex()
    {
        $recharge_no = 'rcg' . time();
        $model = new RechargeLog();
        $model->uid = $this->uid;
        $model->recharge_no = $recharge_no;
        if ($model->save()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
            $this->result['recharge_no'] = $recharge_no;
        }
    }
}