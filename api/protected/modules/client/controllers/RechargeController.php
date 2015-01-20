<?php

class RechargeController extends Controller
{

    public function actionIndex()
    {
        $recharge_no = 'rcg' . time();
        $model = new RechargeLog();
        $model->uid = $this->uid;
        $model->recharge_no = $recharge_no;
        $model->amount = $this->getParam('recharge_amount');
        if ($model->save()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
            $this->result['recharge_no'] = $recharge_no;
        }
    }
    
    public function actionList() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid = :uid and id > :id';
        $criteria->order = 'id asc';
        $criteria->params = [
            'id' => $this->getParam('last_recharge_sid'),
            'uid' => $this->uid
        ];
        $model = RechargeLog::model()->findAll($criteria);
        if ($model) {
            foreach ($model as $recharge) {
                $last_recharge_sid = $recharge->id;
                $rechargelist[] = [
                    'recharge_sid' => $recharge->id,
                    'recharge_no' => $recharge->recharge_no,
                    'recharge_amount' => $recharge->amount,
                    'recharge_date' => $recharge->created,
                    'recharge_status' => $recharge->status
                ];
            }
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
            $this->result['last_recharge_sid'] = $last_recharge_sid;
            $this->result['rechargelist'] = $rechargelist;
        } else {
            $this->result['error_code'] = API_MAINTAIN_RECHARGE;
            $this->result['error_msg'] = '';
            $this->result['last_recharge_sid'] = '';
            $this->result['rechargelist'] = [];
        }
    }
    
    public function actionNotify() {
        require_once(COMMON . "/alipay/alipay.config.php");
        require_once(COMMON . "/alipay/lib/alipay_notify.class.php");
        $alipayNotify = new AlipayNotify($alipay_config);
        var_dump($alipayNotify);
    }
}