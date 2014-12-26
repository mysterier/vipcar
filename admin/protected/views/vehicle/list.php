<?php 
include  '_' . $this->action->id . '.php';
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