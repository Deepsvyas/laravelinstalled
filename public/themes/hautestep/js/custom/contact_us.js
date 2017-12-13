$().ready(function () {
    $("#contactFrm").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: HTTP_PATH + 'contact_us',
            dataString: $("#contactFrm").serialize(),
            elem: "#submitContactFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    flash_msg(data.success_mess, "success", -1);
                    $("#contact_name, #contact_email, #contact_number, #contact_message").val("");
                }
            }
        });
    });
});
