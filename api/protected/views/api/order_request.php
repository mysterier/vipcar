<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Order Request';
$this->breadcrumbs = array(
    'Order Request'
);
?>

<h1>Order Request</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/driver/order/request',
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
		<label>longitude</label>
	    <input type="text" name="longitude" />
	</div>
	
	<div class="row">
		<label>latitude</label>
	    <input type="text" name="latitude" />
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Order_Request'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
