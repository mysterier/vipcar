<?php

/** @var TbActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', [
    'id' => 'horizontalForm',
    'type' => 'horizontal',
    'action' => $this->createUrl($this->action->id, [
        'id' => Yii::app()->request->getParam('id')
    ])
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

echo $form->passwordFieldGroup($model, 'passwd', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-5'
    ]
]);

if ($this->action->id == 'new') {
    echo $form->passwordFieldGroup($model, 'confirmpwd', [
        'wrapperHtmlOptions' => [
            'class' => 'col-sm-5'
        ]
    ]);
}

?>
</div>
<div class="field-right">
    <div class="form-group">
        <label>角色名称:</label>
        <select id="role" name="role">
            <option value="">--请选择--</option>
        <?php foreach($roles as $role_name):?>
            <option value="<?php echo $role_name;?>" <?php if($selected == $role_name) echo 'selected';?>><?php echo $role_name;?></option>
        <?php endforeach;?>
        </select>
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