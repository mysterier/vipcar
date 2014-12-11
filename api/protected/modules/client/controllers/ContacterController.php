<?php

class ContacterController extends Controller
{

    public function actionIndex()
    {
        $model = ContacterHistory::model()->with('tel')->findAll('t.client_id =' . $this->uid);
        if ($model) {
            $contacters = $tel = [];
            foreach ($model as $contacter) {
                if ($contacter->tel) {
                    foreach ($contacter->tel as $objtel) {
                       $tel[$contacter->name][] = $objtel->tel;
                    }
                }
                $contacters[] = $tel;
            }
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
            $this->result['contacters'] = $contacters;
        } else {
            $this->result['error_code'] = NO_RECORD;
            $this->result['error_msg'] = NO_RECORD_MSG;
        }
    }
}