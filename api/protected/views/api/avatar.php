<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Modify Avatar';
$this->breadcrumbs = array(
    'Modify Avatar'
);
?>

<h1>Modify Avatar</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/avatar',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
    'htmlOptions' => [
        'enctype' => 'multipart/form-data'
    ]
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
		<label>Avatar</label>
	    <input type="file" name="avatar">
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Modify Avatar'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
