$().ready(function () {
    var config_edit_key = "";
    var custom_config_list_url = ADMIN_HTTP_PATH + 'dbconfig/customconfiglist';
    getcustomconfiglist();

    $("#config_list_cont").on("click", ".pagination a", function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        custom_config_list_url = url.replace("/?", "?");
        getcustomconfiglist();
    });

    $("body").on("change", ".config_active", function (e) {
        var key = $(this).attr("data-val");
        if ($(this).prop('checked')) {
            var status = 1;
        }
        else {
            var status = 0;
        }
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'dbconfig/update_active',
            dataString: "&config_key=" + key + "&status=" + status,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    });

    $("body").on("click", ".open_edit_config", function (e) {
        e.preventDefault();
        var _this = this;
        config_edit_key = $(this).attr("data-key");
        getfillconfigform(_this);
        $("#add_new_config_modal").modal("show");
    });
    

    $("#openAddNewConfigFrm").on("click", function (e) {
        e.preventDefault();
        config_edit_key = "";
        $("#def_key").val("");
        $("#def_value").val("");
        $("#add_new_config_modal").modal("show");
    });

    $("#addNewConfigFrm").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'dbconfig/addnewconfigajax',
            dataString: $("#addNewConfigFrm").serialize() + "&config_edit_key=" + config_edit_key,
            elem: "#submitConfigFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    $("#add_new_config_modal").modal("hide");
                    getcustomconfiglist();
                }
            }
        });
    });



    function deleteAjaxSuccess()
    {
        getcustomconfiglist();
    }
    
    function getfillconfigform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'dbconfig/get_config_data',
            dataString: "config_key=" + config_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else
                {
                    $("#def_key").val(data.def_key);
                    $("#def_value").val(data.def_value);
                }
            }
        });
    }

    function getcustomconfiglist()
    {
        commonfn.doAjax({
            url: custom_config_list_url,
            dataString: "",
            container: "#config_list_cont",
            ajaxSuccess: function (data)
            {
                commonfn.check_all_handle("#config_checkallitem", "input.config_actionsid", "#config_delete_rows");
                commonfn.delete_rows("#config_checkallitem", "input.config_actionsid", "#config_delete_rows");
                commonfn.check_sel_opt("#config_checkallitem", "input.config_actionsid", "#config_delete_rows");
                $('.config_active').bootstrapToggle({});
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    }
});
