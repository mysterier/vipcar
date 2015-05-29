<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Address-' . $module;
$this->breadcrumbs = array(
    'Address-' . $module
);
?>

<h1>Address-<?php echo $module; ?></h1>


<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => $action,
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
<?php if($module=='list'):?>
    <div class="row">
		<label>Last Address Sid</label>
	    <input type="text" name="last_address_sid" />
	</div>
<?php endif;?>
<?php if($module=='add' || $module=='modify'):?>
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
	<div class="row">
		<label>is_common_use</label>
	    <input type="text" name="is_common_use" />
	</div>
<?php endif;?>
	<div class="row buttons">
		<?php echo CHtml::submitButton('address'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
