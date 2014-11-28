<?php

class DriverModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            
            // 'client.models.*',
            'driver.components.*'
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }
}
