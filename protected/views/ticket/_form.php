<?php
$update_url = Yii::app()->createAbsoluteUrl('/ticket/update/' . $model->ticket_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'ticket-form',
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
    'focus' => array($model, 'coupon_code'),
        ));
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-md-12">


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'candidate_key'); ?>
                    <?php echo $form->textField($model, 'candidate_key', array('size' => 60, 'maxlength' => 255,'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('candidate_key'))); ?>
                    <?php echo $form->error($model, 'candidate_key'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ticket_title'); ?>
                    <?php echo $form->textField($model, 'ticket_title', array('size' => 60, 'maxlength' => 255,'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('ticket_title'))); ?>
                    <?php echo $form->error($model, 'ticket_title'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'order_id'); ?>
                    <?php echo $form->textField($model, 'order_id', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('order_id'))); ?>
                    <?php echo $form->error($model, 'order_id'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'description'); ?>
                    <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50,'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('description'))); ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'department_id'); ?>
                    <?php echo $form->textField($model, 'department_id', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('department_id'))); ?>
                    <?php echo $form->error($model, 'department_id'); ?>
                </div>

<!--                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ticket_resolve_date'); ?>
                    <?php echo $form->textField($model, 'ticket_resolve_date', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('ticket_resolve_date'))); ?>
                    <?php echo $form->error($model, 'ticket_resolve_date'); ?>
                </div>-->

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ticket_status'); ?>
                    <?php echo $form->textField($model, 'ticket_status', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('ticket_status'))); ?>
                    <?php echo $form->error($model, 'ticket_status'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'closed_at'); ?>
                    <?php echo $form->textField($model, 'closed_at', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('closed_at'))); ?>
                    <?php echo $form->error($model, 'closed_at'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'closed_by'); ?>
                    <?php echo $form->textField($model, 'closed_by', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('closed_by'))); ?>
                    <?php echo $form->error($model, 'closed_by'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'close_reason'); ?>
                    <?php echo $form->textField($model, 'close_reason', array('size' => 60, 'maxlength' => 255 ,'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('close_reason'))); ?>
                    <?php echo $form->error($model, 'close_reason'); ?>
                </div>



            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                echo CHtml::submitButton('Update Ticket', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
