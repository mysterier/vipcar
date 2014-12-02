<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    public $layout = '//layouts/column1';

    public $menu = array();

    public $breadcrumbs = array();

    public $result = [
        'code' => - 1,
        'error_msg' => 'params error'
    ];

    protected function beforeAction($action)
    {
        if ($this->module && $this->id != 'login') {
            if (! count($_POST)) {
                $this->result['error_msg'] = 'Please POST first!';
                $result = json_encode($this->result);
                echo $result;
                return false;
            }
            
            if (! $this->check_token())
                return false;
        }
        return true;
    }

    protected function afterAction($action)
    {
        $result = json_encode($this->result);
        echo $result;
    }

    public function check_token()
    {
        $obj_token = new Token('check');
        $obj_token->attributes = $_POST;var_dump($obj_token->attributes);exit();
        if (! $obj_token->validate()) {
            $this->result['error_msg'] = '账号在其他地方登陆';
            $result = json_encode($this->result);
            echo $result;
            return false;
        }
        return true;
    }

    /**
     * 增加错误信息
     *
     * @param obj $model            
     * @author lqf
     */
    public function add_errors($model)
    {
        $error_str = '';
        if ($model->hasErrors()) {
            $errors = $model->getErrors();
            foreach ($errors as $error) {
                $error_str .= implode(' ', $error) . ' ';
            }
        }
        $this->result['error_msg'] = $error_str;
    }

    /**
     * 获取post参数
     *
     * @param string $param            
     * @author lqf
     */
    public function get_param($param)
    {
        return (isset($_POST[$param]) && (strval($_POST[$param]) != '')) ? trim(strval($_POST[$param])) : '';
    }
}