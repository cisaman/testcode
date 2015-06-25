<?php
/* @var $this DepartmentController */
/* @var $data Department */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->department_id), array('view', 'id'=>$data->department_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_name')); ?>:</b>
	<?php echo CHtml::encode($data->department_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_desc')); ?>:</b>
	<?php echo CHtml::encode($data->department_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_created_by')); ?>:</b>
	<?php echo CHtml::encode($data->department_created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->department_updated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_head_id')); ?>:</b>
	<?php echo CHtml::encode($data->department_head_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_status')); ?>:</b>
	<?php echo CHtml::encode($data->department_status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	*/ ?>

</div>