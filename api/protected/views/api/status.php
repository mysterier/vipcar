<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Status';
$this->breadcrumbs = array(
    'Status'
);
?>

<h1>Status</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/driver/status',
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
		<label>Driver Status</label>
	    <input type="text" name="driver_status" />
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Status'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
