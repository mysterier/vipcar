<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - resetpass';
$this->breadcrumbs = array(
    'resetpass'
);
?>

<h1>resetpass</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/'.$module.'/resetpass',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    )
));
?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<div class="row">
	   <label>Token</label>
	   <input type="text" name="token" />
	</div>
	
	<div class="row">
	   <label>old_password</label>
	   <input type="text" name="old_password" />
	</div>
	
	<div class="row">
	   <label>new_password</label>
	   <input type="text" name="new_password" />
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton('resetpass'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
