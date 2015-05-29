<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Get Ticket';
$this->breadcrumbs = array(
    'Get Ticket'
);
?>

<h1>Get Ticket</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/coupon/getticket',
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
		<label>coupon_code</label>
	    <input type="text" name="coupon_code" />
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('get_ticket'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
