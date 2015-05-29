<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Pushmsg';
$this->breadcrumbs = array(
    'Pushmsg'
);
?>

<h1>Pushmsg</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/driver/default/pushmsg',
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
		<label>msg</label>
	    <input type="text" name="msg" />
	</div>
	
	<div class="row">
		<label>Is Driver</label>
	    <input type="text" name="is_driver" />
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Pushmsg'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
