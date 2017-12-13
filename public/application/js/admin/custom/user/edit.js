$().ready(function () {
    $("#editUserFrm").submit(function (e) {
        e.preventDefault();
        var dataString = new FormData(this);
        dataString.append('user_key', user_key);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'users/editajax',
            dataString: dataString,   
            file: true,   
            elem: "#submitFrm",
            ajaxSuccess: function (data)
            {
                $("#editUserFrm span.error").remove();
                if (data.error){
                    error_display(data.error_mess);
                }
                else
                {
                    bootbox.alert(data.success_mess, function () {
                        window.location = ADMIN_HTTP_PATH + "users";
                    });
                }

            }
        });
    });


    
 });

