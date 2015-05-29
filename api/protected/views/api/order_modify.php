<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Order-Modify';
$this->breadcrumbs = array(
    'Order-Modify'
);
?>

<h1>Order-Modify</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/driver/order/modify/3',
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
	   <label>Travel Duration</label>
	   <input type="text" name="travel_duration" />
	</div>
	
	<div class="row">
	   <label>Travel Distance</label>
	   <input type="text" name="travel_distance" />
	</div>

	<div class="row">
	   <label>Packing Fee</label>
	   <input type="text" name="packing_fee" />
	</div>
	
	<div class="row">
	   <label>Highway Fee</label>
	   <input type="text" name="highway_fee" />
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Order-Modify'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
