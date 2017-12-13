$().ready(function() {
    $('.role_per_isset').change(function() {
        if ($(this).prop('checked')) {
            var role_id = $(this).attr("data-role");
            var permission_id = $(this).attr("data-permission");
            var isset = 1;
        }
        else {
            var role_id = $(this).attr("data-role");
            var permission_id = $(this).attr("data-permission");
            var isset = 0;
        }
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'role/update_is_set',
            dataString: "&role_id="+role_id+"&permission_id="+permission_id+"&isset="+isset,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    });
});