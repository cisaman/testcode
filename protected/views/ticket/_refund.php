<div class="row">
    <div class="col-md-12">
        <div  id="refundChangeMsg"></div>
    </div>
     <?php if($model->ticket_status !=6){ ?>
    <div id="remove_refund" class="col-md-4" style="border-right: 1px solid rgb(67, 129, 185);">
        <div class="row">
           
            <div class="col-md-12" >
             
                <hr style="margin: 5px 0px;">
                    <div class="form-group">                    
                    <label class="required" style="margin: 8px 0px;">Refund Reason<span class="required">*</span></label>
                    <?php echo CHtml::textArea('refund_message', '', array('class' => 'form-control', 'placeholder' => 'Refund Reason', 'style' => 'resize:none;', 'rows' => 5)); ?>
                    <div id="remark_error" class="text-red" style="display: none">Remark cannot be blank.</div> 
                </div>                
                <div class="form-group">
                    <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-green btn-square', 'id' => 'refund_set')); ?>                        
                </div>
            </div>
           
        </div>
    </div> 
    <div class="col-md-8" >
     <?php }else{ ?>
         <div class="col-md-12" >
              <div class="row">                    
                    <label class="col-md-12 alert alert-warning"  style="margin: 8px 0px;">Refund request has been sent. Now ticket is on hold.</label>
                </div> 
     <?php } ?>
    
    
        <div class="row">
            <div class="col-md-12">
                
                <h4 class="text-blue">Ticket Status Summary</h4>
                <hr style="margin: 5px 0px;">
                <input type="hidden" id="last_ticket_status" name="last_ticket_status" value="0" /> 
                <div id="remarkList" style="height: 300px; overflow: auto; border: 1px solid rgb(187, 187, 187);">
                    <div id="set1" class="row">
                        <div class="col-sm-3">Status</div>
                        <div class="col-sm-3">User</div>
                        <div class="col-sm-3">Remark</div>
                        <div class="col-sm-3">Date/Time</div>
                    </div>
                    <table id="set2" class="table table-bordered ts"></table>
                    <div id="nomsg" class="text-danger text-center"></div>
                </div>                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    markcount = 1;
    $(document).ready(function () {        
        $("#remarkList").slimScroll({height: "300px", allowPageScroll: true, wheelStep: 1});
        //get_remarklist(0, 0);
        // $("#remarkList").slimScroll({height: "300px", scrollTo: '2000px', allowPageScroll: true, wheelStep: 1});
        $("#remark_message").keydown(function () {
            $("#remark_error").hide();
        })
        $("#refund_set").click(function () {           
            
            if ($.trim($("#refund_message").val()) == "") {
                $("#remark_error").show();
                return false;
            }

            $("#status_error").hide();
            $("#remark_error").hide();
            $("#refund_set").attr('disabled', 'disabled');         
            ticket_id = "<?php echo $ticket_id; ?>";
            remark = $("#refund_message").val();
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl ?>/ticket/changeStatus",
                data: ({ticket_id: ticket_id, status_id: 6, remark: remark}),
                type: "POST",
                dataType: 'JSON',
                success: function (response) {
                    $("#refund_message").val('');                  
                    if (response.length != 0) {
                        $('#refundChangeMsg').fadeIn();
                        //makehtmlremark(response, 1);
                        $('#refundChangeMsg').removeClass('alert alert-danger');
                        $('#refundChangeMsg').addClass('alert alert-success');
                        $('#refundChangeMsg').html('Refund request has been sent successfully.');
                        $("#remove_refund").remove();
                        socket.emit('server_receive', {msg: ""});
                    } else {
                        $('#refundChangeMsg').removeClass('alert alert-success');
                        $('#refundChangeMsg').addClass('alert alert-danger');
                        $('#refundChangeMsg').html('Ticket status change FAIL!');
                    }
                    setTimeout(function () {
                        $('#refundChangeMsg').fadeOut();
                        $("#refund_set").removeAttr('disabled');
                    }, 3000);
                }
            });
        });
       


    });
    function get_remarklist(id, flag) {
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl ?>/ticket/getRemarlList/<?php echo $ticket_id; ?>/" + id,
            type: "get",
            dataType: 'JSON',
            success: function (response) {
                makehtmlremark(response, flag);
            }
        });
    }

    function makehtmlremark(response, flag) {
        if (flag == 0) {
            var data = '';
            if (response.length != 0) {
                $.each(response, function (key, value) {
                    if (data == "") {
                        $("#last_ticket_status").val(value.id);
                    }
                    data += "<tr class='row'>";
                    data += "<td class='col-sm-3'>" + value.status_name + "</td>";
                    data += "<td class='col-sm-3'>" + value.user_name + "</td>";
                    data += "<td class='col-sm-3'>" + value.remark + "</td>";
                    data += "<td class='col-sm-3'>" + value.created_date + "</td>";
                    data += "</tr>";
                    markcount++;
                });
                $('#nomsg').hide();
                $(".ts").append(data);
            } else {
                $('#nomsg').html('No Record Found!');
            }

        } else {
            var single_data = '';
            $.each(response, function (key, value) {
                if (single_data == "") {
                    $("#last_ticket_status").val(value.id);
                }
                single_data += "<tr class='row'>";
                single_data += "<td class='col-sm-3'>" + value.status_name + "</td>";
                single_data += "<td class='col-sm-3'>" + value.user_name + "</td>";
                single_data += "<td class='col-sm-3'>" + value.remark + "</td>";
                single_data += "<td class='col-sm-3'>" + value.created_date + "</td>";
                single_data += "</tr>";
                markcount++;
            });
            $('#nomsg').hide();
            $('.ts').prepend(single_data);
        }
        // $("#remarkList").slimScroll({height: "300px", scrollTo: '2000px', allowPageScroll: true, wheelStep: 1});
    }


    $('#remarkList').scroll(function () {
        var scrollTop = $(this).scrollTop();
        var hh = $('#set1').height();
        $('#set1').css('position', 'relative').css('top', scrollTop);
    });

</script>
<style type="text/css">
    #set1, #set2 {
        margin: 0px ! important;padding: 0px ! important;
    }

    #set1 > div{
        border: 1px solid #ccc;        
        padding: 3px 0;
        text-align: center;
    }
    #set2 .row {        
        padding: 3px 0;
        margin: 0;
        text-align: center;
    }    
    #set2 .row div {
        padding: 0;
        margin: 0;
    }
    #set1 > div {
        font-weight: bold;
    }
    #set1 {
        background: #16a085;
        z-index: 9999;
        color: #fff;
    }

    #set2 .row { background: #ECF0F1 !important; }
    #set2 .row:nth-child(odd) { background: #fcfcfc !important; }
</style>
