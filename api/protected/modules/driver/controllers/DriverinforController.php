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
}