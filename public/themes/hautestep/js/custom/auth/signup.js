$().ready(function () {

    $("#signup_form").submit(function (e) {
        e.preventDefault();
        var dataString = $(this).serialize();
        var _this = this;
        commonfn.doAjax({
            url: HTTP_PATH + 'signup',
            dataString: dataString,
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error) {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    window.location = HTTP_PATH;
                }
            }
        });
    });
});
