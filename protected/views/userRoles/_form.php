<?php
$create_url = Yii::app()->createAbsoluteUrl('/userRoles/create');
$update_url = Yii::app()->createAbsoluteUrl('/userRoles/update/' . $model->user_role_type);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'users-form',
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
    'focus' => array($model, 'user_role_name'),
        ));
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'user_role_name'); ?>
                    <?php echo $form->textField($model, 'user_role_name', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('user_role_name'))); ?>
                    <?php echo $form->error($model, 'user_role_name', array('class' => 'text-red')); ?>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add User Role', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update User Role', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>