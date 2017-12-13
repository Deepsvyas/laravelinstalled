$().ready(function () {
    var static_config_list_url = ADMIN_HTTP_PATH + 'dbconfig/staticconfiglist';
    
    
    $("body").on("change", ".update_config_status", function (e) {
        e.preventDefault();
        var key = $(this).attr("data-key");
        if ($(this).prop('checked')) {
            var status = 1;
        }
        else {
            var status = 0;
        }
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'dbconfig/update_static_config',
            dataString: "&def_key=" + key + "&def_value=" + status,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    });

    $("body").on("click", ".edit_config", function (e) {
        e.preventDefault();
        var def_key = $(this).attr("data-key");
        var def_value = $("#" + def_key).val();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'dbconfig/update_static_config',
            dataString: "&def_key=" + def_key + "&def_value=" + def_value,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                } else if (data.success) {
                    bootbox.alert(data.success_mess);
                    //window.location.reload();
                }
            }
        });
    });


    $("body").on("change", "#website_logo", function (e) {
        e.preventDefault();
        $("#websiteLogoFrm").submit();
    });

    $("body").on("submit", "#websiteLogoFrm", function (e) {
        e.preventDefault();
        var website_logo = $("#website_logo").val();
        if($.trim(website_logo).length == 0)
            return false;
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'dbconfig/addwebsitelogo',
            dataString: new FormData(this),
            file: true,
            elem: "#website_logo",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                $("#website_logo").val("");
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    $("#website_logo_view").attr("src",data.image_logo);
                    $("#logo_upload_success").html("Logo Uploaded successfully.").show();
                    setTimeout(function(){
                        $("#logo_upload_success").fadeOut(1000);
                    },5000);
                }
            }
        });

    });

});