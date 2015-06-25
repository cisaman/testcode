<?php
$create_url = Yii::app()->createAbsoluteUrl('/department/create');
$update_url = Yii::app()->createAbsoluteUrl('/department/update/' . $model->department_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'deparment-form',
    'action' => ($model->isNewRecord) ? $create_url : $update_url,
    //'enableAjaxValidation' => TRUE,
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'autocomplete' => 'off',
        'role' => 'form'
    ),
    'focus' => array($model, 'department_name'),
        ));


?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'department_name'); ?>
                    <?php echo $form->textField($model, 'department_name', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('department_name'))); ?>
                    <?php echo $form->error($model, 'department_name', array('class' => 'text-red')); ?>
                </div>  
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'department_desc'); ?>
                    <?php echo $form->textField($model, 'department_desc', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('department_desc'))); ?>
                    <?php echo $form->error($model, 'department_desc', array('class' => 'text-red')); ?>
                </div>  

            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add Department', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update Department', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>