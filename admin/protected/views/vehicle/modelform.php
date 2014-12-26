<?php

/** @var TbActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', [
    'id' => 'horizontalForm',
    'type' => 'horizontal',
    'action' => $this->createUrl($this->action->id, [
        'id' => Yii::app()->request->getParam('id')
    ]),
    'htmlOptions' => [
        'enctype' => 'multipart/form-data'
    ]
]);
?>
<fieldset>
	<div class="field-middle">
<?php

echo $form->textFieldGroup($model, 'make', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'model', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'maxlength' => 11
]);

echo $form->dropDownListGroup($model, 'vehicle_type', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'widgetOptions' => [
        'data' => $type,
        'htmlOptions' => []
    ]
]);
?>
</div>

</fieldset>
<div class="form-actions">
<?php

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
</div>
<?php
$this->endWidget();