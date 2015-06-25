<?php
$create_url = Yii::app()->createAbsoluteUrl('/systemModules/create');
$update_url = Yii::app()->createAbsoluteUrl('/systemModules/update/' . $model->module_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'system-modules-form',
    'action' => ($model->isNewRecord) ? $create_url : $update_url,
    'enableAjaxValidation' => TRUE,
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'autocomplete' => 'off',
        'role' => 'form'
    ),
    'focus' => array($model, 'module_name'),
        ));

$list = Utils::getListOfControllers();
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'module_name'); ?>
                    <?php echo $form->textField($model, 'module_name', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('module_name'))); ?>
                    <?php echo $form->error($model, 'module_name', array('class' => 'text-red')); ?>
                </div>         
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'module_key'); ?>
                    <?php echo $form->dropDownlist($model, 'module_key', $list, array('class' => 'form-control', 'empty' => 'Please Select ' . $model->getAttributeLabel('module_key'))); ?>
                    <?php echo $form->error($model, 'module_key', array('class' => 'text-red')); ?>
                </div>                
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add Module', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update Module', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>