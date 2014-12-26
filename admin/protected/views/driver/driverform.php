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

echo $form->textFieldGroup($model, 'name', [
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

if ($this->action->id == 'modify') {
    echo $form->passwordFieldGroup($model, 'password', [
        'wrapperHtmlOptions' => [
            'class' => 'col-sm-5'
        ]
    ]);
}

echo $form->dropDownListGroup($model, 'sex', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'widgetOptions' => [
        'data' => [
            '-请选择-',
            '男',
            '女'
        ],
        'htmlOptions' => []
    ]
]);

echo $form->textFieldGroup($model, 'address');

echo $form->textFieldGroup($model, 'contacter', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'level', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textFieldGroup($model, 'health', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->fileFieldGroup($model, 'avatar', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->fileFieldGroup($model, 'id_card_path', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->fileFieldGroup($model, 'license_path', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

?>
</div>
	<div class="field-right">

<?php

echo $form->textFieldGroup($model, 'age', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'maxlength' => 2
]);

echo $form->textFieldGroup($model, 'id_card', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->datePickerGroup($model, 'valid_from', [
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

echo $form->datePickerGroup($model, 'valid_for', [
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

echo $form->textFieldGroup($model, 'contacter_tel', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

echo $form->textAreaGroup($model, 'police_check', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-9'
    ],
    'widgetOptions' => [
        'htmlOptions' => [
            'rows' => 5
        ]
    ]
]);

echo $form->dropDownListGroup($model, 'status', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ],
    'widgetOptions' => [
        'data' => [
            DRIVER_TYPE_ON => DRIVER_MSG_ON,
            DRIVER_TYPE_OFF => DRIVER_MSG_OFF
        ],
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