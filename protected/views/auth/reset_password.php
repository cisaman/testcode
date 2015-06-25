<div class="portlet portlet-default">
    <div class="portlet-heading login-heading">
        <div class="portlet-title">
            <h4><strong>Reset your Password</strong>
            </h4>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="portlet-body">
        <div class="portlet-body">
            <?php if (isset($error['success'])) { ?>		
                <div class="alert alert-success" >
                    <?php
                    echo $error["success"];
                    ?>
                </div>

            <?php }if (isset($error["error"])) { ?>	

                <div class="alert alert-danger">
                    <?php
                    echo $error["error"];
                    ?>
                </div>

                <?php
            }

            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'reset_password',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>

            <fieldset>
                <div class="form-group">
                    <?php echo $form->passwordField($model, 'password', array('placeholder' => 'Password', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'password', array('class' => 'alert-danger')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->passwordField($model, 're_password', array('placeholder' => 'Retype Password', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 're_password', array('class' => 'alert-danger')); ?>
                </div>                             
                <input type="submit" class="btn btn-lg btn-default btn-block" value="Submit" /><br/>
                <p class="text-center"><a href="<?php echo Yii::app()->createAbsoluteUrl('auth/index') ?>" title="Back to Home">Back to Home</a></p>
            </fieldset>            
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>