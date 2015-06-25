<?php
$create_url = Yii::app()->createAbsoluteUrl('/users/create');
$update_url = Yii::app()->createAbsoluteUrl('/users/update/' . base64_encode($model->user_id));

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'users-form',
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
    'focus' => array($model, 'user_name'),
        ));

if ($model->isNewRecord) {
    $model->user_password = Utils::getRandomPassword();
}
$list = Department::getDepartmentList();
$typelist = UserRoles::getUserType();
?>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="form-horizontal">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'user_name', array('class' => 'col-sm-3 control-label')); ?>
                        <div class="col-sm-9">
                            <?php echo $form->textField($model, 'user_name', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('user_name'))); ?>
                            <?php echo $form->error($model, 'user_name', array('class' => 'text-red')); ?>
                        </div>
                    </div>  
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'user_email', array('class' => 'col-sm-3 control-label')); ?>
                        <div class="col-sm-9">
                            <?php echo $form->textField($model, 'user_email', array('withoutspace' => "yes", 'size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('user_email'))); ?>
                            <?php echo $form->error($model, 'user_email', array('class' => 'text-red')); ?>
                        </div>
                    </div>  
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-3 control-label')); ?>
                        <div class="col-sm-9">
                            <?php echo $form->textField($model, 'phone', array('withoutspace' => "yes", 'size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                            <?php echo $form->error($model, 'phone', array('class' => 'text-red')); ?>
                        </div>
                    </div>  
                       <div class="form-group">
                        <?php echo $form->labelEx($model, 'skype', array('class' => 'col-sm-3 control-label')); ?>
                        <div class="col-sm-9">
                            <?php echo $form->textField($model, 'skype', array('withoutspace' => "yes", 'size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('skype'))); ?>
                            <?php echo $form->error($model, 'skype', array('class' => 'text-red')); ?>
                        </div>
                    </div>  

                    <?php if ($model->isNewRecord) { ?>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_password', array('class' => 'col-sm-3 control-label')); ?>
                            <div class="col-sm-9">
                                <?php echo $form->textField($model, 'user_password', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'readonly' => TRUE, 'placeholder' => $model->getAttributeLabel('user_password'))); ?>
                                <?php echo $form->error($model, 'user_password', array('class' => 'text-red')); ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (Yii::app()->session['user_data']['user_role_type'] != 3) { ?>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_role_type', array('class' => 'col-sm-3 control-label')); ?>
                            <div class="col-sm-9">
                                <?php echo $form->dropDownlist($model, 'user_role_type', $typelist, array('class' => 'form-control', 'empty' => 'Please Select ' . $model->getAttributeLabel('user_role_name'))); ?>
                                <?php echo $form->error($model, 'user_role_type', array('class' => 'text-red')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_department_id', array('class' => 'col-sm-3 control-label')); ?>
                            <div class="col-sm-9">
                                <?php echo $form->dropDownlist($model, 'user_department_id', $list, array('class' => 'form-control', 'empty' => 'Please Select ' . $model->getAttributeLabel('department_name'))); ?>
                                <?php echo $form->error($model, 'user_department_id', array('class' => 'text-red')); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!$model->isNewRecord) { ?>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_status', array('class' => 'col-sm-3 control-label')); ?>
                            <div class="col-sm-9">
                                <?php echo $form->checkBox($model, 'user_status', array('class' => 'checkbox-inline')); ?>
                                <?php echo $form->error($model, 'user_status', array('class' => 'text-red')); ?>
                            </div>
                        </div>                    
                    <?php } ?>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-sm-offset-3 col-sm-9">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add User', array('class' => 'btn btn-primary btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update User', array('class' => 'btn btn-primary btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>
