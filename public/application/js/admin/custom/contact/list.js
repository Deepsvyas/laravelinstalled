var contact_dtable = '';
var contact_list_url = ADMIN_HTTP_PATH + 'contact/contactlist';
$().ready(function () {
     contact_dtable = $(".contact_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: contact_list_url,
        delete_confirm: app_js_message.confirm_delete,
        container: "#contact_list_cont",
        delete_btn: "#contact_delete_rows",
        checkallitem: "#contact_checkallitem",
        actionsid: "input.contact_actionsid",
        ajaxSuccess: function (data) {
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        },
        deleteSuccess: function (data) {
            contact_dtable.refresh();
        }
    });

});