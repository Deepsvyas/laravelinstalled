$().ready(function () {
    $("#editProfileFrm").submit(function (e) {
        e.preventDefault();
        var datas =  new FormData(this);
        datas.append('user_key',user_key);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'editprofileajax',
            //dataString: $("#editProfileFrm").serialize()+ "&user_key=" + user_key,
            dataString: datas,
            file: true,
            elem: "#submitFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if(data.success)
                {
                    $('.pic_preview #profile-pic').attr('src',data.user_image_view);
                    bootbox.alert(data.success_mess);
                }
                
            }
        });
    });

    $(".cancel").click(function () {
        //validator.resetForm();
        $('#editProfileFrm')[0].reset();
    });

});

