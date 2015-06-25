<?php
/* @var $this DepartmentController */
/* @var $model Department */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'department_id'); ?>
		<?php echo $form->textField($model,'department_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'department_name'); ?>
		<?php echo $form->textField($model,'department_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'department_desc'); ?>
		<?php echo $form->textField($model,'department_desc',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'department_created_by'); ?>
		<?php echo $form->textField($model,'department_created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'department_updated_by'); ?>
		<?php echo $form->textField($model,'department_updated_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'department_head_id'); ?>
		<?php echo $form->textField($model,'department_head_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'department_status'); ?>
		<?php echo $form->textField($model,'department_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->