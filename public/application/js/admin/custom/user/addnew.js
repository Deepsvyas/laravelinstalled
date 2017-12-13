$(document).ready(function () {
    $("#addNewFrm").submit(function (e) {
        e.preventDefault();
        var dataString = new FormData(this);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'users/addnewajax',
            dataString: dataString,
            file: true,
            elem: "#submitFrm",
            ajaxSuccess: function (data)
            {
                $("#addNewFrm span.error").remove();
                if (data.error)
                {
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