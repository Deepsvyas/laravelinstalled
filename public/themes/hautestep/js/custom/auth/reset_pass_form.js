$().ready(function () {
    $("#resetpassform").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: HTTP_PATH + 'resetpasswordajax',
            dataString: $("#resetpassform").serialize() + "&token="+ token,
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error == 1)
                {
                    error_display(data.error_mess);
                }else
                if(data.success){
                    $("#new_password").val("");
                    $("#confirm_password").val("");
                    bootbox.alert('Your password has been updated successfully and you may login here',function(){
                        window.location = HTTP_PATH + 'login';
                    });
                }
            }
        });
    });

});