<?php

class AirportsendController extends Controller
{
    
    public function actionIndex()
    {
        $this->title = '送机';
        $this->render('index');
    }
}
