<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Coupon-history';
$this->breadcrumbs = array(
    'Coupon-history'
);
?>

<h1>Coupon-history</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/coupon/history',
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
	   <label>last_coupon_sid</label>
	   <input type="text" name="last_coupon_sid" />
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('coupon_history'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
