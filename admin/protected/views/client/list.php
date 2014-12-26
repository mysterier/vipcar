<?php 
$this->widget(
    'booster.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label' => '新建',
        'context' => 'Primary',
        'url' =>  Yii::app()->createUrl('client/new')
    ]
);
?>

<?php
$this->widget(
    'booster.widgets.TbGridView',
    [
        'type' => 'striped',
        'dataProvider' => $gridDataProvider,
        'emptyText'=>'没有找到数据.',
        'template' => "{items}",
        'columns' => $gridColumns
    ]
);
?>