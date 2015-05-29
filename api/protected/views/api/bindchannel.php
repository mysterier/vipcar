<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - bindchannel';
$this->breadcrumbs = array(
    'bindchannel'
);
?>

<h1>bindchannel</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/'.$module.'/bindchannel',
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
	   <label>channel_id</label>
	   <input type="text" name="channel_id" />
	</div>
	
	<div class="row">
	   <label>user_id</label>
	   <input type="text" name="user_id" />
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton('bindchannel'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
