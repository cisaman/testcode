<?php
/* @var $this ModulePermissionController */
/* @var $model ModulePermission */

$this->breadcrumbs=array(
	'Module Permissions'=>array('index'),
	$model->module_permission_id,
);

$this->menu=array(
	array('label'=>'List ModulePermission', 'url'=>array('index')),
	array('label'=>'Create ModulePermission', 'url'=>array('create')),
	array('label'=>'Update ModulePermission', 'url'=>array('update', 'id'=>$model->module_permission_id)),
	array('label'=>'Delete ModulePermission', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->module_permission_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ModulePermission', 'url'=>array('admin')),
);
?>

<h1>View ModulePermission #<?php echo $model->module_permission_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'module_permission_id',
		'module_id',
		'module_permission_user_role_type',
		'update_by',
		'update_date',
		'update_by_user_id',
		'created_date',
		'updated_date',
	),
)); ?>
