$().ready(function () {

    $('#btnforgotpaswd').on('click', function (e) {
        e.preventDefault();
        formReset("#resetFrm");
        $("#resetFrm").slideDown(1000);
        $("#signin_form").slideUp(1000);
    });

    $('#back_to_login').on('click', function (e) {
        e.preventDefault();
        formReset("#signin_form");
        $("#signin_form").slideDown(1000);
        $("#resetFrm").slideUp(1000);
    });

    /* Forgot password form */
    $("#resetFrm").submit(function (e) {
        e.preventDefault();
        var _this = this;
        commonfn.doAjax({
            url: HTTP_PATH + 'forgotpassword',
            dataString: $("#resetFrm").serialize(),
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success){
                    $("#reset_sent_email").html($("#forgotPasswordEmail").val());
                    $("#forgot_pass_info").hide();
                    $("#forgotPasswordEmail").val("");
                    bootbox.alert('Please check your mail for reset the password.');
                }
            }
        });
    });
    
    $("#social_form").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: HTTP_PATH + 'sociallogin',
            dataString: $(this).serialize(),
            ajaxSuccess: function (data){
                $("label span.error").remove();
                if (data.error){
                    error_display(data.error_mess);
                } else if (data.success){
                    window.location.href = HTTP_PATH;
                }
            }
        });
    });



});
