<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Regvalidate';
$this->breadcrumbs = array(
    'Regvalidate'
);
?>

<h1>Regvalidate</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/regvalidate',
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
	   <label>token</label>
	   <input type="text" name="token" />
	</div>

	<div class="row">
	   <label>client_code</label>
	   <input type="text" name="client_code" />
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Regvalidate'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
