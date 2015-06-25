<?php
/* @var $this UsersettingController */
/* @var $model SuUser */
/* @var $form CActiveForm */
$user_fname = $model->user_fname;
$user_lname = $model->user_lname;
$user_email = $model->user_email;
$user_title = $model->user_title;
$user_phoneNumber = $model->user_phoneNumber;
$user_departmentID = $model->user_departmentID;
$user_accountTypeID = $model->user_accountTypeID;
$notification_option = $model->user_notification;

if ($user_edit_data != "") {
    $user_fname = $user_edit_data['user_fname'];
    $user_lname = $user_edit_data['user_lname'];
    $user_email = $user_edit_data['user_email'];
    $user_title = $user_edit_data['user_title'];
    $user_phoneNumber = $user_edit_data['user_phoneNumber'];
    $user_departmentID = $user_edit_data['user_departmentID'];
    $user_accountTypeID = $user_edit_data['user_accountTypeID'];
    $notification_option = $user_edit_data['user_notification'];
}
?>
<style>
    .form-group{min-height:80px;}

</style>
<div class="page-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Add User</h1>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                    </li>
                    <li class="active">New user</li>
                </ol>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="portlet portlet-default" style="float:left; width:100%">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4>User Setting </h4>
                    </div>
                    <div class="portlet-widgets">
                        <a data-toggle="collapse" data-parent="#accordion" href="#basicFormExample"><i class="fa fa-chevron-down"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="basicFormExample" class="panel-collapse collapse in">
                    <div class="portlet-body" style="float:left; width:100%">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="<?php echo ($profile) ? 'active' : '' ?>"><a href="#profile" data-toggle="tab">Profile</a></li>
                            <li class="<?php echo ($reset_password) ? 'active' : '' ?>"><a href="#reset_password" data-toggle="tab">Reset Password</a> </li>
                        </ul>

                        <div id="myTabContent" class="tab-content">

                            <div class="tab-pane fade <?php echo ($profile) ? 'in active' : '' ?>" id="profile">

                                <?php if (isset($message['success'])) { ?> <div class="alert alert-success" > <?php echo $message["success"]; ?></div><?php
                                }
                                if (isset($message["error"])) {
                                    ?>	
                                    <div class="alert alert-danger"> <?php echo $message["error"]; ?> </div> <?php } ?>		

                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'su-user-user_form-form',
                                    'enableClientValidation' => true,
                                    'enableAjaxValidation' => false,
                                ));
                                ?>

                                <div class="alert alert-info">
                                    Fields with <strong>*</strong> are required.
                                </div>

                                <?php //echo $form->errorSummary($model);  ?>

                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_fname'); ?>
                                    <?php echo $form->textField($model, 'user_fname', array('class' => 'form-control', 'value' => $user_fname)); ?>
                                    <?php echo $form->error($model, 'user_fname', array('class' => 'alert-danger')); ?>
                                </div>

                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_lname'); ?>
                                    <?php echo $form->textField($model, 'user_lname', array('class' => 'form-control', 'value' => $user_lname)); ?>
                                    <?php echo $form->error($model, 'user_lname', array('class' => 'alert-danger')); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_phoneNumber'); ?>
                                    <?php echo $form->textField($model, 'user_phoneNumber', array('class' => 'form-control', 'value' => $user_phoneNumber)); ?>
                                    <?php echo $form->error($model, 'user_phoneNumber', array('class' => 'alert-danger')); ?>
                                </div>

                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_title'); ?>
                                    <?php echo $form->textField($model, 'user_title', array('class' => 'form-control', 'value' => $user_title)); ?>
                                    <?php echo $form->error($model, 'user_title', array('class' => 'alert-danger')); ?>
                                </div>

                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_email'); ?>
                                    <?php echo $form->textField($model, 'user_email', array('class' => 'form-control', 'value' => $user_email, 'readonly' => 'readonly')); ?>
                                    <?php echo $form->error($model, 'user_email', array('class' => 'alert-danger')); ?>
                                </div>
                               

                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_departmentID'); ?>
                                    <?php
                                    $depart_options = array("" => "Select Department");
                                    foreach ($dept_list as $department) {
                                        $depart_options[$department["department_id"]] = $department["department_name"];
                                    }
                                    ?>
                                    <?php echo $form->dropDownList($model, 'user_departmentID', $depart_options, array('disabled' => true, 'class' => 'form-control', 'options' => array($user_departmentID => array('selected' => true)))); ?>
                                    <?php echo $form->error($model, 'user_departmentID', array('class' => 'alert-danger')); ?>
                                </div>

                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_accountTypeID'); ?>
                                    <?php
                                    $acc_options = array("" => "Select Account type");
                                    foreach ($acc_type as $account_type) {
                                        $acc_options[$account_type["accountType_id"]] = $account_type["accountType_name"];
                                    }
                                    ?>
                                    <?php echo $form->dropDownList($model, 'user_accountTypeID', $acc_options, array('disabled' => true, 'class' => 'form-control', 'options' => array($user_accountTypeID => array('selected' => true)))); ?>
                                    <?php echo $form->error($model, 'user_accountTypeID', array('class' => 'alert-danger')); ?>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Notification via</label>
                                    <div class="col-sm-10">
                                        <label class="checkbox-inline">
                                            <input type="radio" name="notification_option" id="notification_option_e" value="mail" <?php echo ($notification_option == 'mail') ? "checked" : ""; ?> >Email
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" name="notification_option" id="notification_option_s" value="sms" <?php echo ($notification_option == 'sms') ? "checked" : ""; ?>  >SMS
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" name="notification_option" id="notification_option_b" value="both" <?php echo ($notification_option == 'both') ? "checked" : ""; ?>  >Both
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="btn-group" id="btn_attachment">
                                        <?php if ($this->user_data["user_avatar"] == NULL || $this->user_data["user_avatar"] == "") { ?>
                                            <img class="img-circle" src="<?php echo Yii::app()->request->baseUrl; ?>/img/ADMIN.jpg" alt="">
                                        <?php } else { ?>
                                            <img style="width: 200px;"  src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/<?php echo YII::app()->session['user_data']["user_avatar"]; ?>" alt=""/><br/><br/>
                                        <?php } ?>
                                        <a class="btn btn-green" href="javascript:void(0);" data-toggle="modal" data-target="#add_attachement">
                                            <i class="fa fa-paperclip"></i> Change Avater
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <?php echo CHtml::submitButton('Update', array('class' => 'btn btn-default')); ?>
                                </div>

                                <?php $this->endWidget(); ?>
                            </div><!-- End profile tab -->

                            <div class="tab-pane fade <?php echo ($reset_password) ? 'in active' : '' ?>" id="reset_password" >

                                <?php if (isset($message['success'])) { ?><div class="alert alert-success" > <?php echo $message["success"]; ?> </div><?php
                                }
                                if (isset($message["error"])) {
                                    ?> <div class="alert alert-danger"> <?php echo $message["error"]; ?> </div>
                                <?php } ?>

                                <form id="reset_password-form" action="<?php echo Yii::app()->request->baseUrl; ?>/usersetting/update_password" method="post" >
                                    <div class="form-group col-sm-8">
                                        <label for="customer_name_option" class="required">Old Password <span>*</span></label>
                                        <input class="form-control" name="old_password" id="old_password" type="password">
                                        <?php if (isset($message['old_password'])) { ?>
                                            <span class="has-error">
                                                <span class="help-block"><?php echo $message['old_password']; ?></span>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <label for="customer_name_option" class="required">New Password <span>*</span></label>
                                        <input class="form-control" name="password" id="password" type="password">
                                        <?php if (isset($message['password'])) { ?>
                                            <span class="has-error">
                                                <span class="help-block"><?php echo $message['password']; ?></span>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <label for="customer_name_option" class="required">Retype New Password <span>*</span></label>
                                        <input class="form-control" name="re_password" id="re_password" type="password">
                                        <?php if (isset($message['re_password'])) { ?>
                                            <span class="has-error">
                                                <span class="help-block"><?php echo $message['re_password']; ?></span>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-12"></div>
                                    <div class="form-group col-sm-2">
                                        <input type="submit" id="reset_password_frm" class="btn btn-lg btn-green btn-block" value="Update" />
                                    </div>
                                </form>

                            </div><!-- reset password tab -->

                        </div>  <!-- end of myTabContent -->

                    </div>
                </div>
                <!-- /.portlet -->
            </div>
        </div>
    </div>

    <!-- Add avater model -->
    <div class="modal modal-flex fade" id="add_attachement" tabindex="-1" role="dialog" aria-labelledby="flexModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="attachementForm" action="<?php echo Yii::app()->request->baseUrl; ?>/ajax/Add_avatar" method="post" enctype="multipart/form-data" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="flexModalLabel">Add Avatar</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" id="attachement_error" style="display:none;">
                            <strong>Error:</strong> Please select a file to upload
                        </div>
                        <div class="alert alert-success" id="successM" style="display:none;">
                            Avatar has been uploaded !
                        </div>
                        <p>Avatar</p>
                        <p>
                            <input class="form-control" name="attachement" id="attachement" type="file">
                            <input type="hidden" value="upload" name="do" >
                        <div id="progress">
                            <div id="bar"></div>
                            <div id="percent">0%</div >
                        </div>
                        <div id="view"></div>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" id="add_attachement_btn" class="btn btn-green" value="Add">
                    </div>
            </div>
            <!-- /.modal-content -->

            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/flex.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/common.js"></script>

    <script type="text/javascript">
        $("document").ready(function () {

            $('#add_attachement').on('shown.bs.modal', function (e) {
                $('#successM').hide();
                $("#attachement_error").hide();
                $("#view").val(" ");
            })

            //open file upload modal box 
            $('#add_attachement_btn').on('click', function () {
                $("#attachement_error").hide();
                $("#bar").width('0%');
                $("#percent").html('0%');
                $("#view").val("");
                $('#successM').hide();

                if ($("#attachement").val() != "") {
                    $("#attachementForm").ajaxForm({
                        beforeSend: function () {
                            $("#progress").show();
                            $("#bar").width('0%');
                            $("#message").html("");
                            $("#percent").html("0%");
                        },
                        uploadProgress: function (event, position, total, percentComplete) {
                            $("#bar").width(percentComplete + '%');
                            $("#percent").html(percentComplete + '%');
                        },
                        success: function ()
                        {
                            $("#bar").width('100%');
                            $("#percent").html('100%');

                        },
                        complete: function (response) {
                            var str = response.responseText;
                            if (str.indexOf("Error") == 0) {
                                $("#view").html("<font color='red'>" + str + "</font>");
                                $("#bar").width('0%');
                                $("#percent").html('0%');
                            } else {
                                /*$("#attachement_name > span.tes").html(str);*/
                                $('#successM').show();
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function () {
                            $("#view").html("<font color='red'> ERROR: unable to upload files</font>");
                        },
                        resetForm: true
                    });

                } else {
                    $("#attachement_error").show();
                    $("#attachementForm").submit(function (e) {
                        e.preventDefault();
                    });
                }

            })
            //end file upload modal box 



            /*client side validation */
            var form = $('#reset_password-form');

            $.validator.addMethod(
                    "checkPassword",
                    function (value, element) {
                        $.ajax({
                            type: "POST",
                            url: site_path + "/usersetting/checkPassword",
                            data: "password=" + value,
                            dataType: "html",
                            success: function (msg)
                            {
                                //If username exists, set response to true
                                response = (msg == 1) ? true : false;
                            }
                        });
                        return response;
                    },
                    "Password is not correct"
                    );

            $(form).validate({
                rules: {
                    old_password: {
                        required: true,
                        minlength: 6
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    re_password: {
                        required: true,
                        minlength: 6,
                        equalTo: "#password"
                    }
                },
                messages: {
                    old_password: {required: "<i class='fa fa-warning'></i> This field is required.",
                        minlength: jQuery.format("<i class='fa fa-warning'></i>  Please, at least {0} characters are necessary")
                    },
                    password: {required: "<i class='fa fa-warning'></i> This field is required.",
                        minlength: jQuery.format("<i class='fa fa-warning'></i>  Please, at least {0} characters are necessary")
                    },
                    re_password: {required: "<i class='fa fa-warning'></i> This field is required.",
                        minlength: jQuery.format("<i class='fa fa-warning'></i>  Please, at least {0} characters are necessary"),
                        equalTo: "<i class='fa fa-warning'></i>  Password and Retype Password must be same"
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'help-block',
            });
        });
    </script>
