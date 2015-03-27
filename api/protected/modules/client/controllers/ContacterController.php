<?php

class ContacterController extends Controller
{

    public function actionIndex()
    {
        $model = ContacterHistory::model()->with('tel')->findAll('t.client_id =' . $this->uid);
        if ($model) {
            $contacters = $temp = [];
            foreach ($model as $contacter) {
                if ($contacter->tel) {
                    $tel = [];
                    foreach ($contacter->tel as $objtel) {
                       $tel[] = [                          
                           'weight' => $objtel->weight,
                           'tel' => $objtel->tel
                       ];
                    }
                }
                $temp['contacter'] = $contacter->name;
                $temp['weight'] = $contacter->weight;
                $temp['contacter_tel'] = $tel;
                $contacters[] = $temp;
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