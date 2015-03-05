<?php

class CheckupdateController extends Controller
{

    public function actionIndex()
    {
        $this->result['error_code'] = NO_RECORD;
        $this->result['error_msg'] = '';
        $this->result['app_url'] = '';
    }
}