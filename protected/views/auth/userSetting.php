<?php $create_url = Yii::app()->createAbsoluteUrl('/dashboard'); ?>
<div class="page-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>User Settings</h1>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i>  <a href="<?php echo $create_url; ?>">Dashboard</a>
                    </li>
                    <li class="active">User Settings</li>
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
                        <h4>User Settings </h4>
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

                                <?php if (isset($message['success']) && $profile) { ?> <div id="successmsg" class="alert alert-success" > <?php
                                    echo $message["success"];
                                    unset($message['success']);
                                    ?></div><?php
                                }
                                if (isset($message["error"])) {
                                    ?>	
                                    <div class="alert alert-danger"> <?php echo $message["error"]; ?> </div> <?php } ?>		

                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'user-user_form-form',
                                    'enableClientValidation' => true,
                                    'enableAjaxValidation' => false,
                                ));
                                ?>


<?php //echo $form->errorSummary($model);     ?>

                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_name'); ?>
                                    <?php echo $form->textField($model, 'user_name', array('class' => 'form-control', 'value' => $user_name)); ?>
<?php echo $form->error($model, 'user_name', array('class' => 'alert-danger')); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'user_email'); ?>
                                    <?php echo $form->textField($model, 'user_email', array('class' => 'form-control', 'value' => $user_email, 'readonly' => 'readonly')); ?>
<?php echo $form->error($model, 'user_email', array('class' => 'alert-danger')); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'phone'); ?>
                                    <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'value' => $user_email, 'readonly' => 'readonly')); ?>
<?php echo $form->error($model, 'phone', array('class' => 'alert-danger')); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php echo $form->labelEx($model, 'skype'); ?>
                                    <?php echo $form->textField($model, 'skype', array('class' => 'form-control', 'value' => $user_email, 'readonly' => 'readonly')); ?>
<?php echo $form->error($model, 'skype', array('class' => 'alert-danger')); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php $model->user_role_type = UserRoles::getRoleName($model->user_role_type); ?>
                                    <?php echo $form->labelEx($model, 'user_role_type'); ?>
                                    <?php echo $form->textField($model, 'user_role_type', array('class' => 'form-control', 'readonly' => 'readonly')); ?>
<?php echo $form->error($model, 'user_email', array('class' => 'alert-danger')); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php $model->user_department_id = Department::getDepartmentName($model->user_department_id); ?>
                                    <?php echo $form->labelEx($model, 'user_department_id'); ?>
                                    <?php echo $form->textField($model, 'user_department_id', array('class' => 'form-control', 'readonly' => 'readonly')); ?>
<?php echo $form->error($model, 'user_email', array('class' => 'alert-danger')); ?>
                                </div>

                                <div class="form-group col-sm-12">
<?php echo CHtml::submitButton('Update', array('class' => 'btn btn-default')); ?>
                                </div>

<?php $this->endWidget(); ?>
                            </div><!-- End profile tab -->

                            <div class="tab-pane fade <?php echo ($reset_password) ? 'in active' : '' ?>" id="reset_password" >

                                <?php if (isset($message['success'])) { ?><div id="successmsg" class="alert alert-success" > <?php
                                        echo $message["success"];
                                        unset($message['success']);
                                        ?> </div><?php
                                    }
                                    if (isset($message["error"])) {
                                        ?> <div class="alert alert-danger"> <?php echo $message["error"]; ?> </div>
<?php } ?>

                                <form id="reset_password-form" action="<?php echo Yii::app()->request->baseUrl; ?>/usersetting/update_password" method="post" >
                                    <div class="form-group col-sm-8">
                                        <label for="customer_name_option" class="required">Old Password <span class="text-red">*</span></label>
                                        <input class="form-control" name="old_password" id="old_password" type="password">
<?php if (isset($message['old_password'])) { ?>
                                            <span class="has-error">
                                                <span class="help-block"><?php echo $message['old_password']; ?></span>
                                            </span>
<?php } ?>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <label for="customer_name_option" class="required">New Password <span class="text-red">*</span></label>
                                        <input class="form-control" name="password" id="password" type="password">
<?php if (isset($message['password'])) { ?>
                                            <span class="has-error">
                                                <span class="help-block"><?php echo $message['password']; ?></span>
                                            </span>
<?php } ?>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <label for="customer_name_option" class="required">Reconfirm New Password <span class="text-red">*</span></label>
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
                        minlength: jQuery.format("<i class='fa fa-warning'></i>  Please enter atleast {0} characters.")
                    },
                    password: {required: "<i class='fa fa-warning'></i> This field is required.",
                        minlength: jQuery.format("<i class='fa fa-warning'></i>  Please enter atleast {0} characters.")
                    },
                    re_password: {required: "<i class='fa fa-warning'></i> This field is required.",
                        minlength: jQuery.format("<i class='fa fa-warning'></i>  Please enter atleast {0} characters."),
                        equalTo: "<i class='fa fa-warning'></i>  New Password and Reconfirm New Password must be same."
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