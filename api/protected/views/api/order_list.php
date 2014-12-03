<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Order-List';
$this->breadcrumbs = array(
    'Order-List'
);
?>

<h1>Order-List</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/driver/order/list',
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
		<label>Status</label>
	    <input type="text" name="status" />
	</div>

    <div class="row">
		<label>Last Order Sid</label>
	    <input type="text" name="last_order_sid" />
	</div>
	
	<div class="row">
		<label>Last Update</label>
	    <input type="text" name="last_update" />
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Order-List'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
