 $(document).ready(function (){
    
    
 $(document).keyup(function(event) { 
       
            if (event.keyCode == 27) {
                $(".modal").modal('hide');              

            } 
        });
      
       });

function isNumberKey(evt)
{

    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
    if (!emailReg.test(email)) {
        return false;
    } else {
        return true;
    }
}

function phonenumber(inputtxt)
{
    var phoneno = /^\d{10}$/;
    if (phoneno.test(inputtxt))
    {
        return true;
    }
    else {
        return false;
    }
}


function isValidURL(url) {
    //var RegExp1 = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    var RegExp = /((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i;
    if (RegExp.test(url)) {
        return true;
    } else {
        return false;
    }
}



function set_usersstatus(id, operation_on) {

    if ($("#status_" + id).hasClass("btn btn-xs btn-red")) {
        $("#status_" + id).removeClass("btn btn-xs btn-red");
        $("#status_" + id).addClass("btn btn-xs btn-green");
        $("#status_" + id + " i").removeClass("fa fa-minus-square").addClass("fa fa-check-square");

        var status = 1;

    } else if ($("#status_" + id).hasClass("btn btn-xs btn-green")) {
        $("#status_" + id).removeClass("btn btn-xs btn-green");
        $("#status_" + id).addClass("btn btn-xs btn-red");
        $("#status_" + id + " i").removeClass("fa fa-check-square").addClass("fa fa-minus-square");

        var status = 0;
    }

    $.ajax({
        type: 'post',
        dataType: 'text',
        acync: false,
        url: site_path + '/ajax/setstatus',
        data: {
            'id': id,
            'status': status,
            'operation_on': operation_on
        },
        success: function(data) {

        }

    });
}

function validateInputs(form_id)
{
    var ack = 1;
    $("#main_error").hide();
    $("form#" + form_id + " .required").each(function() {

        if ($(this).val() == "")
        {
            ack = 0;
            $(this).addClass("alert-danger");

        }
        else {

            $(this).removeClass("alert-danger");
            if ($(this).hasClass('email')) {

                if (!validateEmail($(this).val()))
                {
                    ack = 0;
                    $(this).addClass("alert-danger");
                }
            }
            if ($(this).hasClass('number')) {

                if (!phonenumber($(this).val()))
                {
                    ack = 0;
                    $(this).addClass("alert-danger");
                }
            }
        }
    });

    if (ack == 0)
    {
        $("#main_error").show();
        return false;

    } else {
        return true;
    }

}


function deleteData(id, operation_on)
{ 
    if (id != "" && operation_on != "")
    {
        $(".delete_box_open").click();
        $("#delete_button").click(function() {
            if (id != "" && operation_on != "") {
                if (operation_on == 'department') {
                    $.ajax({
                        type: 'POST',
                        url: site_path + '/ajax/check_user_department',
                        data: {'id': id, 'operation_on': operation_on},
                        success: function(data) {

                            if (data == 1) {
                                $.ajax({
                                    type: 'POST',
                                    url: site_path + '/ajax/delete',
                                    data: {'id': id, 'operation_on': operation_on},
                                    success: function(data) {

                                        if (data == 1) {
                                            $("#row_" + id).hide();
                                            $("#delete_box_close").click();
                                            window.location.reload();
                                        } else {
                                            alert("Error in delete data");
                                        }
                                    }
                                });
                            } else {
                               // alert("You can not delete this department, User/ticket are assign to this department ");
                                 $("#delete_box_close").click();
                               bootbox.alert("You can not delete this department, User/ticket are assign to this department", function() {
                               });
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: site_path + '/ajax/delete',
                        data: {'id': id, 'operation_on': operation_on},
                        success: function(data) {

                            if (data == 1) {
                                $("#row_" + id).hide();
                                $("#delete_box_close").click();
                                window.location.reload();
                            } else {
                                alert("Error in delete data");
                            }
                        }
                    });
                }

            }
        });

    } else {
        alert("Invalid Details");
    }

}