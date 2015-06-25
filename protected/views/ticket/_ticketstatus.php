<div class="row">
    <div class="col-md-12">
        <div  id="statusChangeMsg"></div>
    </div>
    <div class="col-md-4" style="border-right: 1px solid rgb(67, 129, 185);">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-blue">Change Ticket Status</h4>
                <hr style="margin: 5px 0px;">
                <div class="form-group">                    
                    <label class="required" style="margin: 8px 0px;">Ticket Status</label>
                    <?php echo CHtml::dropDownlist('status_id', "", CHtml::listData(TicketStatus::model()->getStatusbyfilter(), 'status_id', 'status_name'), array('class' => 'form-control', 'empty' => 'Please Select Status')); ?>
                    <div id="status_error" class="text-red" style="display: none">Please select ticket status.</div> 
                </div>
                <div class="form-group">                    
                    <label class="required" style="margin: 8px 0px;">Remark <span class="required">*</span></label>
                    <?php echo CHtml::textArea('remark_message', '', array('class' => 'form-control', 'placeholder' => 'Remark (if any)', 'style' => 'resize:none;', 'rows' => 5)); ?>
                    <div id="remark_error" class="text-red" style="display: none">Remark cannot be blank.</div> 
                </div>                
                <div class="form-group">
                    <?php echo CHtml::submitButton('Save Status', array('class' => 'btn btn-green btn-square', 'id' => 'changebtn')); ?>                        
                </div>
            </div>
        </div>
    </div>   
    <div class="col-md-8" >
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
        get_remarklist(0, 0);
        // $("#remarkList").slimScroll({height: "300px", scrollTo: '2000px', allowPageScroll: true, wheelStep: 1});
        $("#remark_message").keydown(function () {
            $("#remark_error").hide();
        })
        $("#changebtn").click(function () {
            if ($.trim($("#status_id").val()) == "") {
                $("#status_error").show();
                return false;
            }
            $("#status_error").hide();
            if ($.trim($("#remark_message").val()) == "") {
                $("#remark_error").show();
                return false;
            }

            $("#status_error").hide();
            $("#remark_error").hide();
            $("#changebtn").attr('disabled', 'disabled');
            status_id = $("#status_id").val();
            ticket_id = "<?php echo $ticket_id; ?>";
            remark = $("#remark_message").val();
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl ?>/ticket/changeStatus",
                data: ({ticket_id: ticket_id, status_id: status_id, remark: remark}),
                type: "POST",
                dataType: 'JSON',
                success: function (response) {
                    $("#remark_message").val('');
                    $("#status_id").val("");
                    if (response.length != 0) {
                        $('#statusChangeMsg').fadeIn();
                        //makehtmlremark(response, 1);
                        $('#statusChangeMsg').removeClass('alert alert-danger');
                        $('#statusChangeMsg').addClass('alert alert-success');
                        $('#statusChangeMsg').html('Ticket status has been changed successfully.');
                        socket.emit('server_receive', {msg: ""});
                    } else {
                        $('#statusChangeMsg').removeClass('alert alert-success');
                        $('#statusChangeMsg').addClass('alert alert-danger');
                        $('#statusChangeMsg').html('Ticket status change FAIL!');
                    }
                    setTimeout(function () {
                        $('#statusChangeMsg').fadeOut();
                        $("#changebtn").removeAttr('disabled');
                    }, 3000);
                }
            });
        });
        $("#changeTicketStatus").click(function () {
            // $("#remarkList").slimScroll({height: "300px", scrollTo: '2000px', allowPageScroll: true, wheelStep: 1});
        })


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
