<?php

class StatusController extends Controller
{

    public function actionIndex()
    {
        $token = $this->get_param('token');
        $driver_status = $this->get_param('driver_status');
        switch ($driver_status) {
            case 'on':
                $attributes = [
                    'status' => 1
                ];
                break;
            case 'off':
                $attributes = [
                    'status' => 0
                ];
                break;
            default:
                $attributes = [
                    'status' => 1
                ];
        }
        
        $model = Drivers::model()->updateByPk($this->uid, $attributes);
        if ($model) {
            $this->result['error_code'] = 1;
            $this->result['error_msg'] = '';
            $this->result['driver_status'] = $driver_status;
        } else {
            $this->result['error_msg'] = '状态未更新！';
        }
    }
}