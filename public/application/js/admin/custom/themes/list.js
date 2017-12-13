$().ready(function() {
    
    $(".theme_container").on("click",".activate",function(e){
        e.preventDefault();
        var theme_key = $(this).attr("data-key");
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'themes/activatetheme',
            dataString: "theme_key="+theme_key,
            elem: "#submitMenuFrm",
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    msg_alert(data.error_mess);
                }
                else if(data.success)
                {
                    msg_alert(data.success_mess,location.href);
                }
            }
        });
    });
    
    $(".theme_delete").click(function (e){
        e.preventDefault();
        var _this = this;
        bootbox.confirm("Are you sure to remove this theme?",function(result){
            if(result)
            {
                var theme_key_array = [];
                var theme_key = $(_this).attr("data-key");
                theme_key_array.push(theme_key);
                commonfn.doAjax({
                    url: ADMIN_HTTP_PATH + 'themes/deletetheme',
                    dataString: "checkval=" + theme_key_array,
                   // elem: ".theme_delete",
                    ajaxSuccess: function (data)
                    {
                        if (data.error)
                        {
                            bootbox.alert(data.error_mess);
                        }
                        if (data.success)
                        {
                            bootbox.alert(data.success_mess);
                        }
                    }
                });
            }
        });
    });
    
    
    $("#upload_new_theme").click(function(e){
        e.preventDefault();
        $("#add_new_theme_modal").modal("show");
    });
    
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