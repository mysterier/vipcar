<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login'
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/login',
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
		<label>client_pass</label>
	    <input type="password" name="client_pass" />
		<p class="hint">
			Hint: You may login with
			<kbd>demo</kbd>
			/
			<kbd>demo</kbd>
			or
			<kbd>admin</kbd>
			/
			<kbd>admin</kbd>
			.
		</p>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
