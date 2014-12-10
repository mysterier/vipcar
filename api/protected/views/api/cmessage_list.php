<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Message-List';
$this->breadcrumbs = array(
    'Message-List'
);
?>

<h1>Message-List</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/message/list',
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
	   <label>Last Message Sid</label>
	   <input type="text" name="last_message_sid" />
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Message-List'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
