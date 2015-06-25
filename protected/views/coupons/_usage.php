
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-md-12">
                <?php
                $form = $this->beginWidget('CActiveForm', array('id' => "searchfrm", 'htmlOptions' => array(
                        'class' => 'form-horizontal',
                        'role' => 'form'
                    ),));
                ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="coupon_code"><span class="text-red">*</span>Coupon :</label> 
                    <div class="col-sm-9">
                        <?php echo $form->textField($model, 'coupon_code', array('id' => "coupon_code", 'size' => 30, 'maxlength' => 30, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('coupon_code'))); ?>
                        <div class="text-red" style="display:none" id="err_coupon_code"> Coupon code is required.</div>
                    </div>
                </div>
                <!--                <div class="form-group">
                <?php $typelist = array("1" => "Percentage", "2" => "Amount"); ?>
                                    <label class="col-sm-3 control-label" for="start_date">Coupon Type :</label>                   
                                    <div class="col-sm-9">
                <?php echo $form->dropDownlist($model, 'coupon_type', $typelist, array('class' => 'form-control', 'empty' => 'Please Select ' . $model->getAttributeLabel('coupon_type'))); ?>                   
                <?php echo $form->error($model, 'coupon_type', array('class' => 'text-red')); ?>
                                    </div>
                                </div>-->
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="start_date">Start Date :</label> 
                    <div class="col-sm-9">
                        <?php echo $form->textField($model, 'validate_from', array('id' => "Coupons_validate_from1", 'size' => 55, 'maxlength' => 55, 'readonly' => "readonly", 'class' => 'form-control', 'placeholder' => "Start Date")); ?>
                        <?php echo $form->error($model, 'validate_from', array('class' => 'text-red')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="start_date">End Date :</label> 
                    <div class="col-sm-9">
                        <?php echo $form->textField($model, 'validate_to', array('id' => "Coupons_validate_to1", 'size' => 55, 'maxlength' => 55, 'readonly' => "readonly", 'class' => 'form-control', 'placeholder' => "End Date")); ?>
                        <?php echo $form->error($model, 'validate_to', array('class' => 'text-red')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <?php echo CHtml::Button('Search', array('class' => 'btn btn-green btn-square', 'id' => 'btnSearch')); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>            
        </div>

    </div>
    <div  class="col-md-12" id="results" style="display:none">
        <h4 class="text-blue">Report For Coupon "<span class="coupon_title"></span>"</h4>
        <hr style="margin: 5px 0px;">

        <div style="overflow: auto; border: 1px solid rgb(187, 187, 187);">
            <table class="table table-bordered table-striped " style="text-align:left" >
                <tr align="center">
                    <th style="width: 45px;">#</th><th>Client</th><th>Order Amount</th> <th>Product Name</th><th>Date</th><th style="width: 45px;text-align: center;">View</th>
                </tr>   
                <tbody class="ts"></tbody>
            </table>          


        </div>

    </div>

</div>
<div class="row">
    <div id="nomsg" class="text-danger"></div>
    <div id="pagination"> </div>     
</div>


<div id="info_modal" class="modal fade in" style="" aria-hidden="false">
    <div style="background: none repeat scroll 0% 0% white; height: 100%; left: 0px; position: fixed; top: 0px; width: 100%; z-index: 99999; opacity: 0.8;" id="fwd-loader1" class="list-inline">  

        <ul class="list-inline" id="fwd-loader" >
            <li>
                <h2><i class="fa fa-spinner fa-spin"></i> </h2>
            </li>
        </ul>
    </div>


</div>
<script type="text/javascript">
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var newDate = new Date();
    var checkin = $('#Coupons_validate_from1').datepicker({
        format: 'yyyy-mm-dd'
    }).on('changeDate', function (ev) {
        $('#Coupons_validate_from1').blur();
        $(this).datepicker('hide');
        newDate = new Date(ev.date);
        newDate.setDate(newDate.getDate());
        checkout.setValue(newDate);
        checkout.hide();
        $('#Coupons_validate_to1')[0].focus();
    }
    ).data('datepicker');
    var checkout = $('#Coupons_validate_to1').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function (date) {
            return date.valueOf() < newDate.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        $('#Coupons_validate_to1').blur();
        $(this).datepicker('hide');
        checkout.hide();
    }
    ).data('datepicker');
    
    $('#Coupons_validate_to1,#Coupons_validate_from1').keypress(function(e){
        var code = e.keyCode || e.which;
        if (code === 9) {  
            $(this).datepicker('hide');
        }        
    });
    /*
     * 
     */
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

        $("#btnSearch").click(function () {
            var title = $("#coupon_code").val();
            if (title != "") {
                $("#info_modal").show();
                data = $("#searchfrm").serialize() + '&Coupons[page]=1';
                $(".coupon_title").text(title);
                getSearch(data);
            } else {
                $("#err_coupon_code").show();
            }

        });

        $("#coupon_code").keydown(function () {
            $("#err_coupon_code").hide();
        })
    });

    function getSearch(data) {
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/coupons/getOrderlList",
            type: "POST",
            data: data,
            dataType: 'JSON',
            success: function (response) {
                $("#info_modal").hide();
                makehtmlremark(response);
                $("#pagination").html(response.pagination);
                $("#pagination a").click(function (e) {
                    e.preventDefault();
                    url = $(this).attr('href');
                    page = url.split("=").pop();
                    data = $("#searchfrm").serialize() + '&Coupons[page]=' + page;
                    getSearch(data);

                })
            }
        });
    }
    function makehtmlremark(response) {

        var markcount = 1;
        var data = '';

        if (response.length != 0) {
            $(".ts").html(data);
            $("#results").show();
            $.each(response.records, function (key, value) {
                data += "<tr>";
                data += "<td>" + markcount + "</td>";
                data += "<td>" + value.client + "</td>";
                data += "<td>" + value.amount + "</td>";
                data += "<td>" + value.product_name + "</td>";
                data += "<td>" + value.date + "</td>";
                data += "<td align='center'> <a target='_blank' href='" + value.url + "' title='View Order'  ><i class='fa fa-search'></i></a></td>";
                data += '</tr>';
                markcount++;
            });
            $('#nomsg').hide();
            $(".ts").append(data);

        } else {
            $(".ts").html(data);
            $("#pagination").html("");
            $("#results").hide();
            $('#nomsg').html('No Record Found!');
            $('#nomsg').show();
        }


    }


</script>
<style type="text/css">
    .disabled{
        opacity: .2;
        color: #cccccc;
    }
    #pagination{
        margin: 10px;
        float: right;
    }
    #fwd-loader{
        left: 50%;
        top: 50%;       
        position: fixed;


    }
</style>

