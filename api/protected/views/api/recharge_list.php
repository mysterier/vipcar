<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Recharge List';
$this->breadcrumbs = array(
    'Recharge List'
);
?>

<h1>Recharge List</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/recharge/list',
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
		<label>last_recharge_sid</label>
	    <input type="text" name="last_recharge_sid" />
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Recharge List'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
