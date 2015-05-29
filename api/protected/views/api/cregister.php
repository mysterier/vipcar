<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Register';
$this->breadcrumbs = array(
    'Register'
);
?>

<h1>Register</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/register',
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
	   <label>client_email</label>
	   <input type="text" name="client_email" />
	</div>

	<div class="row">
		<label>client_pass</label>
	    <input type="text" name="client_pass" />
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Register'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
