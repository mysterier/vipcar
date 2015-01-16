<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - forgetpass';
$this->breadcrumbs = array(
    'forgetpass'
);
?>

<h1>forgetpass</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/'.$module.'/forgetpass',
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
	   <label>client_mobile</label>
	   <input type="text" name="client_mobile" />
	</div>
	
	<div class="row">
	   <label>verify_code</label>
	   <input type="text" name="verify_code" />
	</div>
	
	<div class="row">
	   <label>new_password</label>
	   <input type="text" name="new_pass" />
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton('forgetpass'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
