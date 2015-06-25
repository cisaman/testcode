<div class="portlet portlet-default">
    <div class="portlet-heading login-heading">
        <div class="portlet-title">
            <h4>Sign In to <?php echo $this->site_name; ?>!
            </h4>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="portlet-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => TRUE,
            'clientOptions' => array(
                'validateOnSubmit' => TRUE,
                'validateOnChange' => TRUE
            ),
            'htmlOptions' => array(
                'autocomplete' => 'off',
                'role' => 'form'
            ),
            'focus' => array($model, 'username'),
        ));
        ?>
        <fieldset>            
            <div class="form-group">
                <?php echo $form->textField($model, 'username', array('withoutspace' => 'yes', 'placeholder' => $model->getAttributeLabel('username'), 'class' => 'form-control')); ?>           
                <?php echo $form->error($model, 'username', array('class' => 'error_box')); ?> 
            </div>
            <div class="form-group">
                <?php echo $form->passwordField($model, 'password', array('placeholder' => $model->getAttributeLabel('password'), 'class' => 'form-control')); ?>           
                <?php echo $form->error($model, 'password', array('class' => 'error_box')); ?> 
            </div>
            <!--            <div class="checkbox">
                            <label>
            <?php echo $form->checkBox($model, 'rememberMe'); ?>
            <?php echo $form->label($model, 'rememberMe'); ?>
            <?php echo $form->error($model, 'rememberMe', array('class' => 'error_box')); ?>
                            </label>
                        </div>-->
            <br>
            <input type="submit" class="btn btn-lg btn-primary submit_btn btn-block" value="Sign In" />
        </fieldset>
        <br>
        <p class="small">
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/auth/recover_password">Forgot Password?</a>
        </p>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    if ($('#LoginForm_password_em_').html().indexOf('3 incorrect') >= 0) {
        $('#LoginForm_password_em_').hide();
        alert($('#LoginForm_password_em_').html());
    }
</script>