<?php
/* @var $this SiteController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs = array(
    'Admins'
);
?>

<h1>Admins</h1>
<?php
$this->widget('booster.widgets.TbButton', array(
    'label' => 'Top popover',
    'context' => 'primary',
    'htmlOptions' => array(
        'data-title' => 'A Title',
        'data-placement' => 'right',
        'data-content' => "And here's some amazing content. It's very engaging. right?",
        'data-toggle' => 'popover'
    )
));
?>

<?php 
// $gridColumns
$gridColumns = array(
    array('name'=>'id', 'header'=>'#', 'htmlOptions'=>array('style'=>'width: 60px')),
    array('name'=>'firstName', 'header'=>'First name'),
    array('name'=>'lastName', 'header'=>'Last name'),
    array('name'=>'language', 'header'=>'Language'),
    array('name'=>'hours', 'header'=>'Hours worked'),
    array(
        'htmlOptions' => array('nowrap'=>'nowrap'),
        'class'=>'booster.widgets.TbButtonColumn',
        'viewButtonUrl'=>null,
        'updateButtonUrl'=>null,
        'deleteButtonUrl'=>null,
    )
);

//     $this->widget(
//     'booster.widgets.TbGridView',
//     array(
//     'dataProvider' => new stdClass(),
//     'template' => "{items}",
//     'columns' => $gridColumns,
//     )
//     );
?>

<?php

// $this->widget('zii.widgets.CListView', array(
//     'dataProvider' => $dataProvider,
//     'itemView' => '_view'
// ));
?>
