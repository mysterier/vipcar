<?php

class DriverinforController extends Controller
{

    public function actionIndex()
    {
        $model = Drivers::model()->with('vehicle')
            ->with('vehicle.model')
            ->with('vehicle.model.type')
            ->findByPk($this->uid);
        
        if ($model && $model->last_update > $this->getParam('last_update')) {
            $car_name = $car_level = $car_number = '';
            if ($model->vehicle) {
                foreach ($model->vehicle as $vehicle) {
                    $car_name = $vehicle->model->make . $vehicle->model->model;
                    $car_number = $vehicle->license_no;
                    $car_level = $vehicle->model->type->vehicle_type;
                }
            }
            
            $result['error_code'] = API_UPDATE_USER_INFO;
            $result['error_msg'] = '';
            $result['driver_photo'] = $model->avatar;
            $result['driver_name'] = $model->name;
            $result['driver_level'] = $model->driver_level;
            $result['driver_mobile'] = $model->mobile;
            $result['car_name'] = $car_name;
            $result['car_level'] = $car_level;
            $result['car_number'] = $car_number;
            $result['last_update'] = $model->last_update;
            $this->result = $result;
        } else {
            $this->result['error_code'] = API_MAINTAIN_USER_INFO;
            $this->result['error_msg'] = '';
        }
    }
    
    public function actionResetpass()
    {
        $old_pass = $this->getParam('old_password');
        $new_pass = $this->getParam('new_password');
        $model = Drivers::model()->findByPk($this->uid);
        $model->setScenario('resetpass');
        if ($model && ($model->password == $old_pass)) {
            $model->password = $new_pass;
            if ($model->save()) {
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
            }
        } else {
            $this->result['error_code'] = ERROR_DEFAULT;
            $this->result['error_msg'] = '原始密码错误';
        }
    }
    
    public function actionForgetpass() {
        $mobile = $this->getParam('driver_mobile');
        $captcha = $this->sRedisGet($mobile);
        $code = $this->getParam('verify_code');
        $password = $this->getParam('new_pass');
        if ($code == $captcha) {
            $model = Drivers::model()->findByAttributes(['mobile' => $mobile]);
            if ($model) {
                $model->setScenario('resetpass');
                $model->password = $password;
                if ($model->save()) {
                    $this->result['error_code'] = SUCCESS_DEFAULT;
                    $this->result['error_msg'] = '';
                }
            }
        } else
            $this->result['error_msg'] = '验证码不正确';
    }
}