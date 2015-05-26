<h1 style="padding-left:300px;">登录</h1>
<div class="form">
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', [
    'id' => 'login-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => [
        'validateOnSubmit' => true
    ]
]);
?>

	<div class="row">
		<?php
echo $form->textFieldGroup($model, 'username', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-3'
    ]
]);
?>
	</div>

	<div class="row">
		<?php
echo $form->passwordFieldGroup($model, 'password', [
    'wrapperHtmlOptions' => [
        'class' => 'col-sm-3'
    ]
]);
?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkboxGroup($model, 'rememberMe'); ?>
	</div>
	<div class="row buttons" style="padding-left:288px;">
		<?php
$this->widget('booster.widgets.TbButton', [
    'buttonType' => 'submit',
    'context' => 'primary',
    'label' => '登录'
]);
?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
