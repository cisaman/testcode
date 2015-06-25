<?php
/* @var $this ModulePermissionController */
/* @var $data ModulePermission */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('module_permission_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->module_permission_id), array('view', 'id'=>$data->module_permission_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('module_id')); ?>:</b>
	<?php echo CHtml::encode($data->module_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('module_permission_user_role_type')); ?>:</b>
	<?php echo CHtml::encode($data->module_permission_user_role_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by')); ?>:</b>
	<?php echo CHtml::encode($data->update_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_date')); ?>:</b>
	<?php echo CHtml::encode($data->update_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_by_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	*/ ?>

</div>