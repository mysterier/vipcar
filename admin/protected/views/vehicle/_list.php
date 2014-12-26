<?php
$this->widget(
    'booster.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label' => '新建车辆',
        'context' => 'primary',
        'url' =>  Yii::app()->createUrl('vehicle/new')
    ]
);
?>

<?php 
$this->widget(
    'booster.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label' => '车型管理',
        'context' => 'warning',
        'url' =>  Yii::app()->createUrl('vehicle/modellist')
    ]
);
?>