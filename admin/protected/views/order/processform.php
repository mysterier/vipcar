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

echo $form->textFieldGroup($model, 'contacter_name', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'contacter_phone', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textAreaGroup($model, 'summary', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-9'
    ],
    'widgetOptions' => [
        'htmlOptions' => [
            'rows' => 5
        ]
    ]
]);

echo $form->dropDownListGroup($model, 'vehicle_type', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'widgetOptions' => [
        'data' => [
          '' => '-请选择-',
           2 => '舒适型',
           3 => '商务型',
           4 => '豪华型'
        ],
        'htmlOptions' => []
    ]
]);

echo $form->dropDownListGroup($model, 'driver_id', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'widgetOptions' => [
        'data' => $drivers,
        'htmlOptions' => []
    ]
]);
?>
</div>
	<div class="field-right"></div>
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