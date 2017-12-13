$().ready(function () {
    $("#editProfileFrm").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: HTTP_PATH + 'editprofileajax',
            dataString: $("#editProfileFrm").serialize()+ "&user_key=" + user_key,
            elem: "#submitFrm",
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    flash_msg(data.error_mess, "danger");   
                }
                else
                {
                   flash_msg(data.success_mess, "success");   
                }
                
            }
        });
    });

});

