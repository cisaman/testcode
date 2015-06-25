<div class="row">
    <div  id="statusAssignMsg"></div>
    <div class="col-md-12">
        <h4 style="margin: 5px 0px;" class="text-blue">Ticket Assignee - Search 
            <a data-toggle="collapse" data-parent="#accordion" href="#formControls" class="pull-right"><i class="fa fa-chevron-down"></i></a>
        </h4>
        <hr style="margin: 5px 0px;">
        <div class="row panel-collapse in" id="formControls">

            <?php if (Yii::app()->session['user_data']['user_role_type'] != 3) { ?>
                <div class="col-md-4">
                    <div class="form-group">                    
                        <label class="required" style="margin: 8px 0px;">Department</label>
                        <?php echo CHtml::dropDownlist('assignee_department', '', Department::getDepartmentFilter(), array('class' => 'form-control', 'empty' => 'All Department')); ?>
                        <div style="" id="department_em_" class="text-red"></div>
                    </div>
                </div>  
            <?php } else { ?>
                <input type="hidden" id="assignee_department" value="<?php echo Yii::app()->session['user_data']['user_department_id']; ?>"/>
            <?php } ?>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="required" style="margin: 8px 0px;">User Name</label>
                    <input type="text" id="assignee_name" name="assignee_name" placeholder="Enter the User Name" class="form-control" maxlength="100">
                    <div style="" id="assignee_name_em_" class="text-red"></div>
                </div>
            </div>  
            <div class="col-md-4">
                <div class="form-group">
                    <label class="required" style="margin: 8px 0px;">User Email ID</label>
                    <input type="text" id="email_id"  withoutspace="yes"  name="email_id" placeholder="Enter the User Email ID" class="form-control" maxlength="100">
                    <div style="" id="email_id_em_" class="text-red"></div>
                </div>
            </div>  
            <div class="col-md-12">
                <div class="my_userList">              
                    <label class="required" style="valign:top;padding-right: 8px;" > User List </label>
                    <hr style="margin: 5px 0px;">
                    <div class="row" id="assignee_list"></div>     

                    <div id="norecords"> 
                        <div class="norecord">
                            No users found.
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-md-12">
                <div class="my_userList">
                    <label  style="valign:top;padding-right: 8px;">Selected User List</label>
                    <hr style="margin: 5px 0px;">
                    <div class="row">                        
                        <div id="currentList"></div>                        
                        <div  class="showWhenSelected">
                            <div class="col-sm-12">
                                <div class="norecord col-sm-12">
                                    No users selected.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-12">
                            <div  class="hideWhenSelected pull-right" style="display:none">                                
                                <?php
                                echo CHtml::submitButton('Assign Ticket', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                                ?>
                            </div>               
                        </div>  
                    </div>
                </div>
            </div>            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">        
        <h4 style="margin: 5px 0px;" class="text-blue">Ticket Assigned</h4>        
        <hr style="margin: 5px 0px;">
        <ul class="nav nav-tabs" id="AssignedListing">
            <li class="active"><a data-toggle="tab" href="#clients_my"><i class="fa fa-user"></i> Clients</a></li>
            <li class=""><a data-toggle="tab" href="#users_my"><i class="fa fa-users"></i> Users</a></li>            
        </ul>
        <div class="tab-content" id="AssignedListing">
            <div id="clients_my" class="tab-pane fade active in">
                <div id='assignedClientlist'>
                    <?php echo Users::model()->getClientAssigneeList($ticket_id) ?>
                </div>
            </div>
            <div id="users_my" class="tab-pane fade">
                <div id='assignedlist'>
                    <?php echo Users::model()->getUserAssigneeList($ticket_id) ?>
                </div>
            </div>            
        </div>
    </div>   
</div>


<script type="text/javascript">
    ticket_id = "<?php echo $ticket_id; ?>";
    $(document).ready(function () {
        $('.removeBR').next('br').remove();
        $('#norecords').hide();
        var department = $("#assignee_department").val();
        getAjax("", department, "", "");
        getremovefun();
    });

    function setCurrentAssignee() {
        $('.selectAssignee').on('click', function () {

            var data = $(this).parents().html();
            $(this).parent().remove();

            if ($.trim($("#userlist").text()) == "") {
                $('#norecords').show();

            }
            data = '<div class="col-sm-6 removeBR">' + data + '</div>';
            $('.showWhenSelected').hide();
            $('.hideWhenSelected').show();
            $('#currentList').append(data);
            $('#currentList input').attr('checked', true);
            $('#currentList input').removeClass('selectAssignee');
            $('#currentList input').addClass('currentAssigneed');
            removeCurrentAssignee();

        });

    }

    function removeCurrentAssignee() {
        $('.currentAssigneed').on('click', function () {
            var data = $(this).parents().html();
            $(this).parent().remove();
            if ($.trim($("#currentList").html()) == "") {
                $('.showWhenSelected').show();
                $('.hideWhenSelected').hide();
            }
            $('#norecords').hide();
            var username = $("#assignee_name").val();
            var department = $("#assignee_department").val();

            var restrictedUsers = [];
            $('#currentList input').each(function () {
                restrictedUsers.push($(this).attr('value'));
            });

            getAjax(username, department, restrictedUsers);
        });
    }


    $("#assignee_name").keyup(function () {
        var username = $(this).val();
        var department = $("#assignee_department").val();
        var email_id = $("#email_id").val();
        var restrictedUsers = [];
        $('#currentList input').each(function () {
            restrictedUsers.push($(this).attr('value'));
        });
        getAjax(username, department, restrictedUsers, email_id);
    });

    $("#email_id").keyup(function (e) {
        if (e.keyCode == 0 || e.keyCode == 32) {
            return false;
        }
        var email_id = $(this).val();
        var department = $("#assignee_department").val();
        var username = $("#assignee_name").val();
        var restrictedUsers = [];
        $('#currentList input').each(function () {
            restrictedUsers.push($(this).attr('value'));
        });
        getAjax(username, department, restrictedUsers, email_id);
    });

    $("#assignee_department").change(function () {
        var department = $(this).val();
        var email_id = $("#email_id").val();
        var username = $("#assignee_name").val();
        var restrictedUsers = [];
        $('#currentList input').each(function () {
            restrictedUsers.push($(this).attr('value'));
        });
        getAjax(username, department, restrictedUsers, email_id);
    });

    function getAjax(username, department, restrictedUsers, email_id) {

        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl ?>/users/customSearch",
            data: ({ticket_id: "<?php echo $ticket_id; ?>", username: username, email_id: email_id, department: department, restrictedUsers: restrictedUsers}),
            type: "POST",
            success: function (response) {
                $("#assignee_list").html(response);
                $('#norecords').hide();
                setCurrentAssignee();
                $('.removeBR').next('br').remove();
            }
        });
    }

    $('#btnSave').click(function () {
        var assigneeusers = [];
        $('#currentList input').each(function () {
            assigneeusers.push($(this).attr('value'));
        });
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl ?>/ticket/assignUsers",
            data: {ticket_id: ticket_id, assigneeusers: assigneeusers},
            type: "POST",
            dataType: "JSON",
            success: function (response) {
                $("#assignedlist").html(response.userAssignee);
                $("#assignedClientlist").html(response.clientAssignee);
                getremovefun();
                $("#currentList").html('');
                $(".assinee_added").show();
                $('#statusAssignMsg').removeClass('alert alert-danger');
                $('#statusAssignMsg').addClass('alert alert-success');
                $('#statusAssignMsg').html('Ticket Assigned to the selected user(s) successfully.');
                 $('#statusAssignMsg').fadeIn();
                $(".hideWhenSelected").hide();
                setTimeout(function () {
                    $('#statusAssignMsg').fadeOut();
                    $("#changebtn").removeAttr('disabled');
                }, 3000);

            }
        });
    });
    function getremovefun() {
        $('.removeUser').on('click', function () {
            user_id = $(this).attr('data');
            $(this).parent().parent().remove();
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl ?>/ticket/removeUser",
                data: {ticket_id: ticket_id, user_id: user_id},
                type: "POST",
                dataType: "JSON",
                success: function (response) {
                    $("#assignedlist").html(response.userAssignee);
                    $("#assignedClientlist").html(response.clientAssignee);
                    getremovefun();
                    var username = $("#assignee_name").val();
                    var email_id = $("#assignee_name").val();
                    var department = $("#assignee_department").val();

                    var restrictedUsers = [];
                    $('#currentList input').each(function () {
                        restrictedUsers.push($(this).attr('value'));
                    });
                    getAjax(username, department, restrictedUsers, email_id);
                }
            });
        });
    }

</script>

<style type="text/css">
    .removeBR label{
       /* font-weight: normal !important; */
    }
    .norecord{
        text-align: center; 
        background-color: #f2dede;
        border-color: #ebccd1;
        color: #a94442;
        border: 1px solid transparent;
        border-radius: 4px;        
        padding: 10px;
    }
    .alert {
        margin: 0 !important;
    }
    .my_userList {
        border: 1px solid rgb(221, 221, 221); 
        border-radius: 4px; 
        padding: 5px; 
        margin: 10px 0px;
        background: none repeat scroll 0% 0% rgb(252, 252, 252);
    } 

    .selectAssignee ,.currentAssigneed {
        float: left;
        margin: 3px 4px 0 0 !important;

    }

</style>
