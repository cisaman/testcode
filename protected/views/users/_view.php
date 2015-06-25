<?php
/* @var $this UsersController */
/* @var $data Users */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_image')); ?>:</b>
	<?php echo CHtml::encode($data->user_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_email')); ?>:</b>
	<?php echo CHtml::encode($data->user_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_password')); ?>:</b>
	<?php echo CHtml::encode($data->user_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_status')); ?>:</b>
	<?php echo CHtml::encode($data->user_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_role_type')); ?>:</b>
	<?php echo CHtml::encode($data->user_role_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_department_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_department_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_created_by_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_created_by_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_last_login_time')); ?>:</b>
	<?php echo CHtml::encode($data->user_last_login_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_last_logout_time')); ?>:</b>
	<?php echo CHtml::encode($data->user_last_logout_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_ip_address')); ?>:</b>
	<?php echo CHtml::encode($data->user_ip_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	*/ ?>

</div>