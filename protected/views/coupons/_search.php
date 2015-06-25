<?php
/* @var $this CouponsController */
/* @var $model Coupons */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_code'); ?>
		<?php echo $form->textField($model,'coupon_code',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'no_of_used'); ?>
		<?php echo $form->textField($model,'no_of_used'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'validate_to'); ?>
		<?php echo $form->textField($model,'validate_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'validate_from'); ?>
		<?php echo $form->textField($model,'validate_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'min_amt'); ?>
		<?php echo $form->textField($model,'min_amt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'desc'); ?>
		<?php echo $form->textField($model,'desc',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_type'); ?>
		<?php echo $form->textField($model,'coupon_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'valid_for'); ?>
		<?php echo $form->textArea($model,'valid_for',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apply_on'); ?>
		<?php echo $form->textField($model,'apply_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'count'); ?>
		<?php echo $form->textField($model,'count'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->