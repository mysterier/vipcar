<?php
$this->widget(
    'booster.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label' => '新建车型',
        'context' => 'primary',
        'url' =>  Yii::app()->createUrl('vehicle/newmodel')
    ]
);
?>
