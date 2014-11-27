<?php

class ClientModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            
            // 'client.models.*',
            'client.components.*'
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
