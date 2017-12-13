$(document).ready(function () {
    $('#forgot_password').click(function () {
        $("#login_div_frm").slideUp();
        ;
        $("#forgotpassword_frm").slideDown();

    });
    $('#backToLogin').click(function () {
        $("#forgotpassword_frm").slideUp();
        $("#login_div_frm").slideDown();
        ;
    });

    $("#forgotPasswordFrm").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'forgotpassword',
            dataString: $("#forgotPasswordFrm").serialize(),
            elem: "#submitForgotPasswordFrm",
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    error_display_ci(data.error_mess);
                }
                else if (data.success)
                {
                    msg_alert(data.success_mess, ADMIN_HTTP_PATH + "themes");
                }
            }
        });
    });

});