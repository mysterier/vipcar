<?php

class StatusController extends Controller
{

    public function actionIndex()
    {
        $token = $this->getParam('token');
        $driver_status = $this->getParam('driver_status');
        switch ($driver_status) {
            case 'on':
                $attributes = [
                    'status' => DRIVER_TYPE_ON
                ];
                break;
            case 'off':
                $attributes = [
                    'status' => DRIVER_TYPE_OFF
                ];
                break;
            default:
                $attributes = [
                    'status' => DRIVER_TYPE_ON
                ];
        }
        
        $model = Drivers::model()->updateByPk($this->uid, $attributes);
        if ($model) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        } else {
            $this->result['error_msg'] = '状态未更新！';
        }
    }
}