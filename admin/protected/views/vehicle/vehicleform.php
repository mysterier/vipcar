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

echo $form->dropDownListGroup($model, 'vehicle_model_id', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'widgetOptions' => [
        'data' => $type,
        'htmlOptions' => []
    ]
]);

echo $form->textFieldGroup($model, 'frame_no', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'insurance', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->fileFieldGroup($model, 'vehicle_license_path', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

?>
</div>
	<div class="field-right">

<?php

echo $form->textFieldGroup($model, 'license_no', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'engine_no', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->datePickerGroup($model, 'inspection', [
    'widgetOptions' => [
        'options' => [
            'format' => 'yyyy-mm-dd',
            'language' => 'zh-CN',
            'autoclose' => true
        ]
    ],
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
]);

echo $form->fileFieldGroup($model, 'policy_path', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);
?>
</div>
	<div class="field-left">
		<div class="form-group">
			<label class="col-sm-3 control-label">汽车归属</label>
			<div class="col-sm-5 col-sm-9">
<?php
$this->widget('booster.widgets.TbSwitch', [
    'name' => 'Vehicle[switch]',
    'options' => [
        'onColor' => 'warning',
        'offColor' => 'info',
        'onText' => '公司',
        'offText' => '个人'
    ],
    'events' => [
        'switchChange' => 'js:function(event, state) {
            			if(state)
                            $(".company").show();
                        else
                            $(".company").hide();
            		}'
    ]
]);
?>
</div>
		</div>
<div class="company">
<?php
echo $form->textFieldGroup($model, 'ltd_name', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'ltd_legal_person', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'ltd_contacter', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'ltd_contacter_tel', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'ltd_reg_address', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'ltd_office_address', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);
?>
</div>
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