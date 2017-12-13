$().ready(function () {
    $("#editRoleFrm").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'role/editajax',
            dataString: $("#editRoleFrm").serialize() + "&role_id=" + role_id,
            elem: "#submitFrm",
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else
                {
                    msg_alert(data.success_mess,ADMIN_HTTP_PATH+"role");
                }
                
            }
        });
    });

});
