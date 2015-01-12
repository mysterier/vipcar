<?php

class ClientinforController extends Controller
{

    public function actionIndex()
    {
        $model = Clients::model()->findByPk($this->uid);
        
        if ($model && $model->last_update > $this->getParam('last_update')) {
            $result['error_code'] = API_UPDATE_USER_INFO;
            $result['error_msg'] = '';
            $result['client_name'] = $model->real_name;
            $result['client_score'] = $model->score;
            $result['account_balance'] = $model->account_balance;
            $result['client_avatar'] = $model->avatar;
            $result['client_title'] = $model->client_title;
            $result['last_update'] = $model->last_update;
            $this->result = $result;
        } else {
            $this->result['error_code'] = API_MAINTAIN_DRIVER_INFO;
            $this->result['error_msg'] = '';
        }
    }

    public function actionModify($id)
    {
        $model = Clients::model()->findByPk($id);
        $model->setScenario('modify');
        if ($model && ($model->id == $this->uid)) {
            $model->real_name = $this->getParam('name');
            $model->client_title = $this->getParam('client_title');
            $model->last_update = time();
            if ($model->save()) {
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
            }
        }
    }
}