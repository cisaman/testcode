$(document).ready(function () {
    $("#successmsg").animate({opacity: 1.0}, 6000).fadeOut("slow");
   // $("#wrapper").slimScroll({height: window.innerHeight, allowPageScroll: true, wheelStep: 1});
    /* * **************************************************** */
    /* * Trim Multiple Whitespaces into Single Space for all input Elements Start Block */
    /* * **************************************************** */
    function trimspace(element) {
        var cat = $(element).val();
        cat = $.trim(cat.replace(/ +(?= )/g, ''));
        if (cat != "") {
            $(element).val(cat);
        } else {
            $(element).val($.trim(cat));
        }
    }
    $('input').bind('blur', function () {
        trimspace(this);
    });
    $('textarea').bind('blur', function () {
        trimspace(this);
    });
    /* * **************************************************** */
    /* * Trim Multiple Whitespaces into Single Space for all input Elements End Block */
    /* * **************************************************** */
    /* Code written on 26 Sep 2014 for Focusing and Validating Input and Textarea */
    /*
     * Block whitespaces
     */
    $("input[withoutspace='yes']").on("keydown", function (e) {
        return e.which !== 32;
    });
    $("input[type='password']").on("keydown", function (e) {
        return e.which !== 32;
    });

});