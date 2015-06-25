<div class="portlet portlet-default">
    <div class="portlet-heading login-heading">
        <div class="portlet-title">
            <h4><strong>Recover Password</strong>
            </h4>
        </div>
        <div class="clearfix"></div>
    </div>


    <div class="portlet-body">
        <div class="recovery_block">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'recover_password',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <fieldset>

                <?php echo $message; ?>

                <?php if (Yii::app()->user->hasFlash('message')): ?>
                    <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?> alert-dismissable" id="successmsg">
                        <?php echo Yii::app()->user->getFlash('message'); ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <?php echo $form->textField($model, 'username', array('withoutspace'=>'yes','placeholder' => $model->getAttributeLabel('username'), 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'username', array('class' => 'text-red')); ?>
                </div>
                <br>
                <input type="submit" class="btn btn-lg btn-default btn-block" value="Submit"/>
            </fieldset>

            <?php $this->endWidget(); ?>
        </div>
        <br>
        <p class="small">
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/auth/login"><span class="fa fa-angle-double-left" > Back to Sign In</span></a>
        </p>
    </div>

</div>