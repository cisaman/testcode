<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_image'); ?>
		<?php echo $form->textField($model,'user_image',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email',array('size'=>55,'maxlength'=>55)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_status'); ?>
		<?php echo $form->textField($model,'user_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_role_type'); ?>
		<?php echo $form->textField($model,'user_role_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_department_id'); ?>
		<?php echo $form->textField($model,'user_department_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_created_by_id'); ?>
		<?php echo $form->textField($model,'user_created_by_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_last_login_time'); ?>
		<?php echo $form->textField($model,'user_last_login_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_last_logout_time'); ?>
		<?php echo $form->textField($model,'user_last_logout_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_ip_address'); ?>
		<?php echo $form->textField($model,'user_ip_address',array('size'=>60,'maxlength'=>100)); ?>
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