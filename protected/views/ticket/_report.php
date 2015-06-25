<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" id="searchfrm">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="start_date">Start Date :</label> 
                        <div class="col-sm-9">
                            <input type="text" name="start_date" placeholder="Start Date" class="form-control" readonly="readonly" maxlength="55" size="55" id="start_date"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="end_date">End Date :</label> 
                        <div class="col-sm-9">
                            <input type="text" name="end_date" placeholder="End Date" class="form-control" readonly="readonly" maxlength="55" size="55" id="end_date"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="ticket_status">Status :</label> 
                        <div class="col-sm-9">
                            <?php 
                             $status = array(
                                "Cancelled" => "Cancelled",
                                "Completed" => "Completed",
                               
                                    )
                            ?>
                            <?php echo CHtml::dropDownList("order_status", 'ticket_status', $status, array('style' => '', 'class' => 'form-control', 'empty' => 'Please Select Order Status')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="category">Category :</label> 
                        <div class="col-sm-9">
                            <?php
                            $category = array(
                                "PSD to HTML" => "PSD to HTML",
                                "PSD to Email" => "PSD to Email",
                                "PSD to Wordpress" => "PSD to Wordpress",
                                "PSD to Joomla" => "PSD to Joomla",
                                "PSD to Drupal" => "PSD to Drupal",
                                "PSD to Magento" => "PSD to Magento",
                                    )
                            ?>
                            <?php echo CHtml::dropDownList("category", 'category', $category, array('style' => '', 'class' => 'form-control', 'empty' => 'Please Select Category')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="Client">Client :</label> 
                        <div class="col-sm-9">
<?php echo CHtml::dropDownList("Client", 'user_id', Users::model()->getClienList(), array('style' => '', 'class' => 'form-control', 'empty' => 'Please Select Client')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
<?php echo CHtml::Button('Generate Report', array('class' => 'btn btn-primary', 'id' => 'btnSearch')); ?>
                        </div>
                    </div>
                </form>
            </div>            
        </div>
    </div>

    <div  class="col-md-12" id="results" style="display:none">
        <hr style="margin: 5px 0px;">

        <div style=" overflow: auto; border: 1px solid rgb(187, 187, 187); text-center">
            <table class="table table-bordered table-striped " style="text-align:left" >
                <tr>
                    <th style="width: 45px;">#S.N</th><th>Order No.</th><th>Client</th><th>Amount</th> <th>Category</th><th>Payment Status</th><th>Date</th><th style="width: 45px;text-align: center;">View</th>
                </tr>   
                <tbody class="ts"></tbody>
            </table>          


        </div>

    </div>

</div>
<div class="row">
    <div id="nomsg" class="text-danger "></div>
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
    var checkin = $('#start_date').datepicker({
        format: 'yyyy-mm-dd'
    }).on('changeDate', function (ev) {
        $('#start_date').blur();
        $(this).datepicker('hide');
        newDate = new Date(ev.date);
        newDate.setDate(newDate.getDate());
        checkout.setValue(newDate);
        checkout.hide();
        $('#end_date')[0].focus();
    }
    ).data('datepicker');
    var checkout = $('#end_date').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function (date) {
            return date.valueOf() < newDate.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        $('#end_date').blur();
        $(this).datepicker('hide');
        checkout.hide();
    }
    ).data('datepicker');

    $('#start_date,#end_date').keypress(function (e) {
        var code = e.keyCode || e.which;
        if (code === 9) {
            $(this).datepicker('hide');
        }
    });
    /*
     * 
     */

    $(document).ready(function () {
        $('#Coupons_coupon_type').change(function () {
            $('#coupons-form #Coupons_discount').val('');
            var type = parseInt($(this).val());
            if (type == 1) {
                $('#coupons-form #Coupons_discount').attr('step', '0.01');
                $('#coupons-form #Coupons_discount').attr('size', '5');
            } else {
                $('#coupons-form #Coupons_discount').removeAttr('step');
                $('#coupons-form #Coupons_discount').removeAttr('size');
                F
            }
        });
        $("#btnSearch").click(function () {
            $("#info_modal").show();
            data = $("#searchfrm").serialize() + '&page=1';
            getSearch(data);

        });


    });

    function getSearch(data) {
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/ticket/getOrderlList",
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
                    data = $("#searchfrm").serialize() + '&page=' + page;
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
                data += "<td>" + value.order_id + "</td>";
                data += "<td>" + value.client + "</td>";
                data += "<td>" + value.amount + "</td>";
                data += "<td>" + value.category + "</td>";
                data += "<td>" + value.status + "</td>";
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
    .selected a{
        background-color: #eee !important;
        border-color: #ddd!important;
        color: #2a6496!important;
    }
    .day:hover {
        cursor: pointer;
    }
</style>

