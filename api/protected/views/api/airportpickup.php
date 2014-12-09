<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle = Yii::app()->name . ' - Airportpickup';
$this->breadcrumbs = array(
    'Airportpickup'
);
?>

<h1>Airportpickup</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'action' => '/client/airportpickup',
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
		<label>token</label>
	    <input type="text" name="token" />
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
		<label>flight_number</label>
	    <input type="text" name="flight_number" />
	</div>
	
	<div class="row">
		<label>pickup_place</label>
	    <input type="text" name="pickup_place" />
	</div>
	
	<div class="row">
		<label>drop_place</label>
	    <input type="text" name="drop_place" />
	</div>
	
	<div class="row">
		<label>car_type</label>
	    <input type="text" name="car_type" />
	</div>
	
	<div class="row">
		<label>order_summary</label>
	    <input type="text" name="order_summary" />
	</div>
	
	<div class="row">
		<label>estimated_cost</label>
	    <input type="text" name="estimated_cost" />
	</div>
	
	<div class="row">
		<label>order_type</label>
	    <input type="text" name="order_type" />
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Airportpickup'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
