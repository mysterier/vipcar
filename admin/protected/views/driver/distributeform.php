<?php 
$this->widget(
    'booster.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label' => '新建',
        'context' => 'Primary',
        'url' =>  Yii::app()->createUrl('driver/new')
    ]
);
?>

<?php

/** @var TbActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', [
    'id' => 'horizontalForm',
    'type' => 'horizontal',
    'action' => $this->createUrl('savevehicle', [
        'id' => Yii::app()->request->getParam('id')
    ])
]);
?>

<?php
$this->widget(
    'booster.widgets.TbGridView',
    [
        'type' => 'striped',
        //目前只给客户单选，可扩展为多选
        'selectableRows' => 1,
        'dataProvider' => $gridDataProvider,
        'emptyText'=>'没有找到数据.',
        'template' => "{items}",
        'columns' => $gridColumns
    ]
);

$this->widget('booster.widgets.TbPager', [
    'displayFirstAndLast' => true,
    'pages' => $gridDataProvider->pagination,
    'maxButtonCount' => 5
]);

$this->widget('booster.widgets.TbButton', [
    'buttonType' => 'submit',
    'context' => 'primary',
    'label' => '提交'
]);

$this->widget('booster.widgets.TbButton', [
    'buttonType' => 'reset',
    'label' => '重置'
]);
?>

<?php
$this->endWidget();