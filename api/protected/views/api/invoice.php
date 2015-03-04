<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Invoice-' . $module;
$this->breadcrumbs = array(
    'Invoice-' . $module
);
?>

<h1>Invoice-<?php echo $module; ?></h1>


<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/invoice/' . $module,
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
<?php if($module=='history'):?>
    <div class="row">
		<label>Last Invoice Sid</label>
	    <input type="text" name="last_invoice_sid" />
	</div>
<?php endif;?>
<?php if($module=='new'):?>
    <div class="row">
		<label>invoice_title</label>
	    <input type="text" name="invoice_title" />
	</div>
	<div class="row">
		<label>invoice_amount</label>
	    <input type="text" name="invoice_amount" />
	</div>
    <div class="row">
		<label>contacter_name</label>
	    <input type="text" name="contacter_name" />
	</div>
	<div class="row">
		<label>contacter_mobile</label>
	    <input type="text" name="contacter_mobile" />
	</div>
	<div class="row">
		<label>address_info</label>
	    <input type="text" name="address_info" />
	</div>
<?php endif;?>
	<div class="row buttons">
		<?php echo CHtml::submitButton('invoice'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
