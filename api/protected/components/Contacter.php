<?php

class Contacter
{

    public function setContacter()
    {
        $uid = Yii::app()->controller->uid;
        $name = Yii::app()->controller->getParam('contacter_name');
        $tel = Yii::app()->controller->getParam('contacter_mobile');
        
        include COMMON . '/models/ContacterHistory.php';
        include COMMON . '/models/ContacterTel.php';
        
        $model = ContacterHistory::model()->findByAttributes([
            'client_id' => $uid,
            'name' => $name
        ]);
        if ($model) {
            $obj_tel = ContacterTel::model()->findByAttributes([
                'contacter_id' => $model->id,
                'tel' => $tel
            ]);
            if (!$obj_tel) {
                $obj_tel = new ContacterTel();
                $obj_tel->contacter_id = $model->id;
                $obj_tel->tel = $tel;
                $obj_tel->save();
            }

        } else {
            $model = new ContacterHistory();
            $model->client_id = $uid;
            $model->name = $name;
            if ($model->save()) {
                $obj_tel = new ContacterTel();
                $obj_tel->contacter_id = $model->id;
                $obj_tel->tel = $tel;
                $obj_tel->save();
            }
        }
    }
}