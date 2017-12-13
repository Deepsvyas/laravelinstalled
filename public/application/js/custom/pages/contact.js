$(document).ready(function (e) {
    $("#contact_form").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: HTTP_PATH + 'submitcontact',
            dataString: $("#addNewMenuFrm").serialize() + "&website_key=" + website_key + "&menu_edit_key=" + menu_edit_key,
            elem: "#submitMenuFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    $("#add_new_menu_modal").modal("hide");
                    getmenuslist();
                }
            }
        });
    });
});