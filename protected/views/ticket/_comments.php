<div class="ibox float-e-margins">

    <div class="ibox-content no-padding" id="comment_group_container" style="overflow-y: scroll; max-height: 400px; border: 1px solid rgb(187, 187, 187); padding:0px;">
        <ul class="list-group"></ul>
        <li class="list-group-item" id="group_no_comment"><p class="text-center">No comments for you</p></li>
    </div>
</div>

<form method="post" id="commentfrm" multiple enctype="multipart/form-data" class="form-group" style="margin-top: 18px;"  >    
    <input type="hidden" id="group_essay_id" name="ticket_id" value="<?php echo $ticket_id ?>" /> 
    <input type="hidden" id="last_comment_id" name="last_comment_id" value="" /> 
<!--    <input type="hidden" name="max_group_comment_id" id="max_comment_id" value="<?php echo $max_comment_id; ?>"/>-->
    <textarea rows="4" id="comment" class="form-control" name="comment" style="width:100%;resize: none;"></textarea>   
    <div id="comment_error" class="text-red" style="display: none">Comment cannot be blank.</div> 
    <p class="help-block">(Allowed multiple Files:txt,doc,docs,docx,pdf,ppt,odt,rtf,png,gif,jpg,jpeg) Max limit(5)</p>

    <div class="form-group">
        <div id="file_name"></div>
        <button class="btn btn-primary" name="addFileGroupBtn" id="addFileGroupBtn" type="button">
            <i class="fa fa-plus"></i> Upload Files
        </button>
        <input type="button" class="btn btn-primary pull-right gsubmit" id="submit_comment" value="Add Comment"/>
        <div id="file_btn" style="display: none"></div>

    </div>       
</form>
<script src="<?php echo Utils::getBaseNew(); ?>:8001/socket.io/socket.io.js"></script>
<script type="text/javascript">
    var socket = io.connect('<?php echo Utils::getBaseNew(); ?>:8001');
    socket.on('client_receive', function (data) {
        $('#getComments').click();
        status_id = $("#last_ticket_status").val();
        get_remarklist(status_id, 1);

    });
    $(function () {
        Cnt = 1;
        $("#comment_group_container").slimScroll({height: "300px", scrollTo: '5000px', allowPageScroll: true, wheelStep: 1});
        $("#commentfrm").ajaxForm({
            url: "<?php echo Yii::app()->request->baseUrl ?>/ticket/addComments",
            type: "post",
            success: function (res) {
                $("#comment").val('');
                $("#file_name").html("");
                $("#file_btn").html("");
                $("#submit_comment").removeAttr('disabled');
                socket.emit('server_receive', {msg: ""});

            }
        });
        $("#submit_comment").click(function () {
            if ($.trim($("#comment").val()) != "") {
                $("#submit_comment").attr('disabled', 'disabled');
                $("#commentfrm").submit();
            } else {
                $("#comment_error").show();
            }
        });
        $("#comment").keydown(function () {
            $("#comment_error").hide();
        })

        $('#getComments').click(function () {
            last_comment_id = $("#last_comment_id").val();
            var divHeight = 1;
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl ?>/ticket/getComments",
                data: ({ticket_id: <?php echo $ticket_id ?>, last_comment_id: last_comment_id}),
                type: "POST",
                dataType: 'JSON',
                success: function (response) {
                    if (response.length != 0) {
                        $.each(response, function (key, value) {
                            var data = '';
                            data += '<li class="list-group-item">';
                            data += '<p><a href="javascript:void(0);" class="text-info">@' + value.username + ' </a>: ' + value.message + '</p>';
                            data += '<small class="block text-muted">';
                            data += '<i class="fa fa-clock-o"></i>' + value.datetime;
                            data += '<span class="pull-right">' + value.attachment_link + '</span>';
                            data += '</small>';
                            data += '</li>';
                            $("#last_comment_id").val(value.id);
                            $('.list-group').append(data);
                            divHeight++;
                        });
                        $("#group_no_comment").hide();
                        setTimeout(function () {
                             $("#comment_group_container").slimScroll({height: "300px", scrollTo: (divHeight * 100) + 'px', allowPageScroll: true, wheelStep: 1});
                        }, 300);
                       
                    } else {
                        //$("#group_no_comment").show();
                    }

                }
            });

        });
        $('#addFileGroupBtn').click(function () {
            if (Cnt != 6) {
                $('#file_btn').append('<input type="file" class="fileupload" name="cstfile[]" id="file_' + Cnt + '" />');
                $('#file_' + Cnt).click();
                $('#file_' + Cnt).change(function () {
                    var file_name = $(this).val();
                    if (file_name != '') {
                        var valid_extensions = /(\.jpg|\.jpeg|\.gif|\.png|\.doc|\.docx|\.odt|\.txt|\.pdf|\.ppt|\.rtf\.)$/i;
                        if (!valid_extensions.test(file_name)) {
                            alert('Invalid file. Allow file extension are jpg,png,gif,doc,docx,odt');
                            $(this).remove();
                        } else {
                            var closeImg = '<i class="fa fa-times"></i>';
                            $("#file_name").append('<div id="file_img_' + Cnt + '"><span><a href="javascript:void(0)" class="removeImg" onclick=removeImg("' + Cnt + '") >' + closeImg + '</a>' + file_name + '</span><br/></div>');
                            Cnt++;
                        }
                    }
                });
            }
        });


    });
    //unset selected file
    function removeImg(cnt) {
        $('#file_' + cnt).remove();
        $('#file_img_' + cnt).remove();
        Cnt--;
    }



</script>
<style>
    .fa-times{
        color: red;
        padding: 5px;

    }
    .list-group li { background: #ECF0F1; }
    .list-group li:nth-child(odd) { background: #fcfcfc; }

</style>