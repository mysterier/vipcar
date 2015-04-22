<?php
$this->widget('booster.widgets.TbButton', [
    'buttonType' => 'link',
    'label' => '新建',
    'context' => 'Primary',
    'url' => Yii::app()->createUrl('magazine/create')
]);
?>

<?php
$this->widget('booster.widgets.TbGridView', [
    'type' => 'striped',
    'dataProvider' => $gridDataProvider,
    'emptyText' => '没有找到数据.',
    'template' => "{items}",
    'columns' => $gridColumns
]);

$this->widget('booster.widgets.TbPager', [   
    'displayFirstAndLast' => true,
    'pages' => $gridDataProvider->pagination,
    'maxButtonCount' => 5
]);
?>