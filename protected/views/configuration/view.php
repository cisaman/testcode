<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-cog"></i> System Settings </h1></li>
            </ol>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-body">  

                <?php if (Yii::app()->user->hasFlash('message')): ?>
                    <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?> alert-dismissable" id="successmsg">
                        <?php echo Yii::app()->user->getFlash('message'); ?>
                    </div>
                <?php endif; ?>
                <div id="bookingTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="coupon-view">                            
                        <div class="row">
                            <!-- Form Controls -->
                            <div class="col-lg-12">
                                <div class="portlet portlet-green">
                                    <div class="portlet-heading">
                                        <div class="portlet-title">
                                            <h4>System Settings</h4>
                                        </div>
                                        <div class="portlet-widgets">
                                            <a href="#formControls" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-collapse collapse in" id="formControls">
                                        <div class="portlet-body">
                                            <form class="form-horizontal" method="post"  enctype="multipart/form-data" onsubmit="return beforsubmit()">

                                                <?php foreach ($model as $m) { ?>

                                                    <?php
                                                    $label = Utils::createLabel($m->label);
                                                    switch (strtolower($m->format)) {
                                                        case 'text':
                                                            $control = Utils::createInputBox($m->_id, $m->name, $m->value, $m->label);
                                                            break;
                                                        case 'textarea':
                                                            $control = Utils::createTextArea($m->_id, $m->name, $m->value, $m->label);
                                                            break;
                                                        case 'select':
                                                            break;
                                                        case 'img':
                                                            $control = Utils::createImage($m->_id, $m->name, $m->value, $m->label);
                                                            break;
                                                        case 'radio':
                                                            break;
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <?php echo $label; ?>
                                                        <div class="col-sm-6">
                                                            <?php echo $control; ?>
                                                            <div class="required" id="<?php echo $m->_id ?>_error"><?php echo $m->label ?> is required.</div>
                                                        </div>
                                                    </div>                                                    
                                                <?php }
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label col-sm-offset-1" >&nbsp;</label>
                                                    <div class="col-sm-6">
                                                        <?php
                                                        echo CHtml::submitButton('Save Configuration', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                                                        ?>
                                                    </div>
                                                </div>   

                                            </form>
                                        </div>
                                    </div>
                                </div>                                
                            </div>       
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>    
</div>

<style type="text/css">
    .required{
        display: none;
        color: red;
    }
</style>

<script type="text/javascript">
    function beforsubmit() {
        var flag = 1;
        var fields = document.getElementsByTagName('INPUT');
        for (var i = 0; i < fields.length; i++) {
            //fields[i];
            if (fields[i].value == '' && fields[i].type != "file") {
                flag = 0;
                //console.log(fields[i]);
                $('#' + fields[i].id + '_error').show();
            } else {
                $('#' + fields[i].id + '_error').hide();
            }
        }

        if (flag == "1") {
            return true;
        } else {
            return false;
        }

    }
    $("#upload_file").change(function () {
        var file_name = $(this).val();
        var files = !!this.files ? this.files : [];
        if (file_name != '') {

            var valid_extensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;
            if (!valid_extensions.test(file_name)) {
                alert('Invalid file type. Only jpg, jpeg, png & gif image type allowed.');
                $(this).val("");
                return false;

            }
            if (this.files[0].size > 2097152) {
                alert('Only Image size upto 2MB is allowed.');
                $(this).val("");
                return false;

            }
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onloadend = function (event) {
                $("#imagPrev").attr("src", event.target.result).show();
                $(".image_pic").hide();
                $(".innerdiv").show();
            }
        }
        $("#close").click(function () {
            $("#upload_file").val('');
            $("#imagPrev").attr("src", "").show();
            $(".image_pic").show();
            $(".innerdiv").hide();
        })
    })


</script>

<style>
    #close{

        cursor: pointer;
        color: #fff;
        margin-top: 5px;
    }
    .innerdiv{
        position: relative;
        max-width: 200px;
        max-height: 200px;  

    }
</style>