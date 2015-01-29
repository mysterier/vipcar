<?php

class AirportpickupController extends Controller
{

    public function actionIndex()
    {
        $this->title = '接机';
        $this->render('index');
    }
}