<?php

/** @var TbActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', [
    'id' => 'horizontalForm',
    'type' => 'horizontal',
    'action' => $this->createUrl($this->action->id, [
        'id' => Yii::app()->request->getParam('id')
    ]),
]);
?>
<fieldset>
	<div class="field-left">
<?php

echo $form->textFieldGroup($model, 'title', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textAreaGroup($model, 'content', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-9'
    ],
    'widgetOptions' => [
        'htmlOptions' => [
            'rows' => 5
        ]
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