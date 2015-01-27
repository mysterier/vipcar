<?php 
$this->widget(
    'booster.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label' => '未分配',
        'context' => 'Primary',
        'url' =>  Yii::app()->createUrl('order/process?status=' . ORDER_STATUS_NOT_DISTRIBUTE)
    ]
);

$this->widget(
    'booster.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label' => '已分配',
        'context' => 'Warning',
        'url' =>  Yii::app()->createUrl('order/process?status=' . ORDER_STATUS_DISTRIBUTE)
    ]
);

$this->widget(
    'booster.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label' => '进行中',
        'context' => 'danger',
        'url' =>  Yii::app()->createUrl('order/process?status=' . ORDER_STATUS_RUN)
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

$this->widget('booster.widgets.TbPager', [
    'displayFirstAndLast' => true,
    'pages' => $gridDataProvider->pagination,
    'maxButtonCount' => 5
]);
?>