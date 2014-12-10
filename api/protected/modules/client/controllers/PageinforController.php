<?php

class PageinforController extends Controller
{

    public function actionIndex()
    {
        $type = $this->getParam('info_type');
        //to do
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        $this->result['info_url'] = '未完成的url';
    }
}