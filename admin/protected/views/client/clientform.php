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
	<div class="field-left">
<?php

echo $form->textFieldGroup($model, 'real_name', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'mobile', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'maxlength' => 11
]);

echo $form->passwordFieldGroup($model, 'password', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'email', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->dropDownListGroup($model, 'client_title', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'widgetOptions' => [
        'data' => [
            '-请选择-',
            CLIENT_TITLE_MALE,
            CLIENT_TITLE_FEMALE
        ],
        'htmlOptions' => []
    ]
]);

echo $form->textAreaGroup($model, 'credit_record', [
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
	<div class="field-right">
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