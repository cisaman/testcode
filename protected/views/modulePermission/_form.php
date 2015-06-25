<?php
$create_url = Yii::app()->createAbsoluteUrl('/modulePermission/create');
$update_url = Yii::app()->createAbsoluteUrl('/modulePermission/update/' . $_GET['id']);
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'module-permission-form',
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
    'focus' => array($model, 'module_id'),
        ));
$list = Department::getDepartmentList();
$typelist = UserRoles::getUserTypeList();
?>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
            	<div class="form-horizontal">
                <?php if ($model->isNewRecord) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'user_role_type', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->dropDownlist($model, 'user_role_type', $typelist, array('class' => 'form-control', 'empty' => 'Please Select ' . $model->getAttributeLabel('user_role_name'))); ?>
                        <?php echo $form->error($model, 'user_role_type', array('class' => 'text-red')); ?>
                    </div>
                    </div>
                <?php } else { ?>
                    <div class="form-group">
                        <label for="user_role_type col-sm-3 control-label">User Role Type</label>
                    <div class="col-sm-9">
                        <?php echo CHtml::textField('ModulePermission[user_role_type]', UserRoles::getRoleName($_GET['id']), array("readonly" => "readonly", 'class' => 'form-control')); ?>                        
                    </div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <?php ?>
                    <label class="required col-sm-3 control-label" for="classified_id" style="valign:top;padding-right: 8px;" > Module List <span class="required">*</span></label>
                    <div class="col-sm-9">
                    <div class="row">
                        <?php
                        $modulelist = CHtml::listData(SystemModules::model()->findAll(), 'module_id', 'module_name');

                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                            $id = $_GET['id'];
                            $data = ModulePermission::model()->findAllByAttributes(array('user_role_type' => $id));
                            $selected_keys = array_keys(CHtml::listData($data, 'module_id', 'module_permission_id'));
                            echo CHtml::checkBoxList('ModulePermission[module_id]', $selected_keys, $modulelist, array('template' => '<div class="col-sm-6 removeBR checkbox_list">{input} {label}</div>'));
                        } else {
                            echo CHtml::checkBoxList('ModulePermission[module_id]', '', $modulelist, array('template' => '<div class="col-sm-6 removeBR checkbox_list">{input} {label}</div>'));
                        }
                        ?>
                    </div>
                    <div style="" id="classified_error" class="text-red"></div>
                    </div>
                </div> 

			</div>
            </div>            
        </div>
        <div class="row">
            <div class="col-sm-offset-3 col-sm-9">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add Module Permission', array('class' => 'btn btn-primary btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update Module Permission', array('class' => 'btn btn-primary btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>
<script type="text/javascript">

    $(document).ready(function () {

        $('#module-permission-form').submit(function () {
            var flag = 0;
            $("input[id^='ModulePermission_module_id_']").each(function () {
                if ($(this).is(":checked")) {
                    flag++;
                }
            });

            if (flag == 0) {
                $('#classified_error').html('Please Select Module Name');
                return false;
            } else {
                $('#classified_error').html('');
            }
        });

        $('.removeBR').next('br').remove();

    });

</script>

<style type="text/css">
    .removeBR label{
        font-weight: normal !important;
    }
</style>