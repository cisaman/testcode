<?php
/* @var $this SystemModulesController */
/* @var $model SystemModules */

$this->breadcrumbs=array(
	'System Modules'=>array('index'),
	$model->module_id,
);

$this->menu=array(
	array('label'=>'List SystemModules', 'url'=>array('index')),
	array('label'=>'Create SystemModules', 'url'=>array('create')),
	array('label'=>'Update SystemModules', 'url'=>array('update', 'id'=>$model->module_id)),
	array('label'=>'Delete SystemModules', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->module_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SystemModules', 'url'=>array('admin')),
);
?>

<h1>View SystemModules #<?php echo $model->module_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'module_id',
		'module_name',
		'module_key',
		'created_date',
		'updated_date',
	),
)); ?>
