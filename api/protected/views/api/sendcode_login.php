<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Send Code';
$this->breadcrumbs = array(
    'Send Code'
);
?>

<h1>Send Code</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/sendcode/login',
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

	<div class="row buttons">
		<?php echo CHtml::submitButton('SendCode'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
