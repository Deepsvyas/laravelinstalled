$(document).ready(function () {

    $("#addNewThemeFrm").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'themes/addnewajax',
            dataString: new FormData(this),
            file: true,
            elem: "#submitFrm",
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else
                {
                    msg_alert(data.success_mess, ADMIN_HTTP_PATH + "themes");
                }
            }
        });
    });

    

});