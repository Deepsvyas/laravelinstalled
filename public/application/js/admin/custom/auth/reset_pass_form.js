$().ready(function () {
    $("#resetpassform").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'resetpasswordajax',
            dataString: $("#resetpassform").serialize() + "&token="+ token,
            elem:"#resetpassword",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error == 1)
                {
                    error_display(data.error_mess);
                }
                else
                if(data.success)
                {
                    bootbox.alert(data.success_mess, function () {
                        window.location = ADMIN_HTTP_PATH;
                    });
                    return true;
                }
                
            }
        });
    });

});