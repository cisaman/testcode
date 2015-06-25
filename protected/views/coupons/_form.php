<?php
$create_url = Yii::app()->createAbsoluteUrl('/coupons/create');
$update_url = Yii::app()->createAbsoluteUrl('/coupons/update/' . $model->id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'coupons-form',
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
                    <?php echo $form->labelEx($model, 'coupon_code'); ?>
                    <?php echo $form->textField($model, 'coupon_code', array("withoutspace" => "yes", 'size' => 30, 'maxlength' => 30, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('coupon_code'))); ?>
                    <?php echo $form->error($model, 'coupon_code', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php $typelist = array("1" => "Percentage", "2" => "Amount"); ?>
                    <?php echo $form->labelEx($model, 'coupon_type'); ?>                    
                    <?php echo $form->dropDownlist($model, 'coupon_type', $typelist, array('class' => 'form-control', 'empty' => 'Please Select ' . $model->getAttributeLabel('coupon_type'))); ?>                   
                    <?php echo $form->error($model, 'coupon_type', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'discount'); ?>
                    <?php echo $form->textField($model, 'discount', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('discount'))); ?>
                    <?php echo $form->error($model, 'discount', array('class' => 'text-red')); ?>

                    <div style="margin:10px 0 0 0;"class="alert alert-info"><b>Note</b>: If coupon type is amount then above field consider as Amount otherwise it will be Discount & Last 2 digits would be automatically considered as decimal values.</div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'min_amt'); ?>
                    <?php echo $form->textField($model, 'min_amt', array('size' => 55, 'maxlength' => 55, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('min_amt'))); ?>
                    <?php echo $form->error($model, 'min_amt', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'validate_from'); ?>
                    <?php echo $form->textField($model, 'validate_from', array('size' => 55, 'maxlength' => 55, 'readonly' => "readonly", 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('validate_from'))); ?>
                    <?php echo $form->error($model, 'validate_from', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'validate_to'); ?>
                    <?php echo $form->textField($model, 'validate_to', array('size' => 55, 'maxlength' => 55, 'readonly' => "readonly", 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('validate_to'))); ?>
                    <?php echo $form->error($model, 'validate_to', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'no_of_used'); ?>
                    <?php echo $form->textField($model, 'no_of_used', array('size' => 60, 'maxlength' => 23, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('no_of_used'))); ?>
                    <?php echo $form->error($model, 'no_of_used', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'desc'); ?>
                    <?php echo $form->textArea($model, 'desc', array('size' => 60, 'maxlength' => 256, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('desc'))); ?>
                    <?php echo $form->error($model, 'desc', array('class' => 'text-red')); ?>
                </div>



            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add Coupon', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update Coupon', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    var nowTemp1 = new Date();
    var now1 = new Date(nowTemp1.getFullYear(), nowTemp1.getMonth(), nowTemp1.getDate(), 0, 0, 0, 0);
    var newDate1 = new Date();
    var checkin1 = $('#Coupons_validate_from').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function (date) {
            return date.valueOf() < now1.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        $('#Coupons_validate_from').blur();
        $(this).datepicker('hide');
        newDate1 = new Date(ev.date);
        newDate1.setDate(newDate1.getDate());
        checkout1.setValue(newDate1);
        checkout1.hide();
        $('#Coupons_validate_to')[0].focus();
    }
    ).data('datepicker');
    var checkout1 = $('#Coupons_validate_to').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function (date) {
            return date.valueOf() < newDate1.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        $('#Coupons_validate_to').blur();
        $(this).datepicker('hide');
        checkout1.hide();
    }
    ).data('datepicker');
    $('#Coupons_validate_to,#Coupons_validate_from').keypress(function(e){
        var code = e.keyCode || e.which;
        if (code === 9) {  
            $(this).datepicker('hide');
        }        
    });
    function randString(n) {
        if (!n) {
            n = 11;
        }
        var text = '';
        var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789';
        for (var i = 0; i < n; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        document.getElementById('coupon_code').value = text;
        document.getElementById("coupon_code").focus();
    }
    $(document).ready(function () {
        $('#coupons-form #Coupons_coupon_type').change(function () {
            $('#coupons-form #Coupons_discount').val('');
            var type = parseInt($(this).val());
            if (type == 1) {
                $('#coupons-form #Coupons_discount').attr('placeholder', "Discount(%)");
                $('#coupons-form #Coupons_discount').attr('maxlength', '4');
            } else {
                $('#coupons-form #Coupons_discount').attr('maxlength', '8');
                $('#coupons-form #Coupons_discount').attr('placeholder', "Amount");
            }
        });
        $("#coupons-form #Coupons_discount").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $("#Coupons_discount_em_").html("Digits Only .").show().fadeOut("slow");
                return false;
            }

        });
        $("#coupons-form #Coupons_discount").blur(function (e) {
            var type = parseInt($("#coupons-form #Coupons_coupon_type").val());
            if (type == 1) {
                var discount = $("#coupons-form #Coupons_discount").val();
                if (discount.length > 2) {
                    $("#coupons-form #Coupons_discount").val(discount / 100);
                }

            }
        });
        $("#coupons-form #Coupons_discount").focus(function (e) {
            var type = parseInt($("#coupons-form #Coupons_coupon_type").val());
            if (type == 1) {
                var discount = $("#coupons-form #Coupons_discount").val();
                $("#coupons-form #Coupons_discount").val(parseInt(parseFloat(discount * 100).toFixed(2)));

            }
        });
        $("#coupons-form #Coupons_min_amt").keypress(function (e) {

            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
                $("#Coupons_min_amt_em_").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });
         $("#coupons-form #Coupons_no_of_used").keypress(function (e) {

            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
                $("#Coupons_no_of_used_em_").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });
    });

</script>
<style type="text/css">
    .disabled{
        opacity: .2;
        color: #cccccc;
    }
    .day:hover{
        cursor: pointer;
    }
    .disabled:hover{
        cursor: default!important;
    }
</style>