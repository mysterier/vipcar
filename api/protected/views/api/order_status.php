<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Order-Status';
$this->breadcrumbs = array(
    'Order-Status'
);
?>

<h1>Order-Status</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/driver/order/status/3',
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
	   <label>Order Status</label>
	   <input type="text" name="order_status" />
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Order-Status'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
