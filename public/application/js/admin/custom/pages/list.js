var page_dtable = '';
$().ready(function () {
    CKEDITOR.config.removePlugins = 'Image';
    CKEDITOR.replace('page_content',
            {
            });
    var page_edit_key = "";
    var pages_list_url = ADMIN_HTTP_PATH + 'pages/pagelist';
    
    page_dtable = $(".pages_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: pages_list_url,
        dataString: "",
        delete_confirm: app_js_message.confirm_delete,
        container: "#pages_list_cont",
        delete_btn: "#pages_delete_rows",
        checkallitem: "#pages_checkallitem",
        actionsid: "input.pages_actionsid",
        ajaxSuccess: function (data) {
            $('.page_active').bootstrapToggle({});
            commonfn.enable_disable(".page_active");
            
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        },
        deleteSuccess: function (data) {
            page_dtable.refresh();
        }
    });

    $("body").on("click", ".open_page_content", function (e) {
        e.preventDefault();
        var key = $(this).attr("data-key");
        var html = $("#page_content_" + key).html();
        $("#page_content_modal .modal-body").html(html);
        $("#page_content_modal").modal("show");
    });

    $("body").on("click", ".open_edit_page", function (e) {
        e.preventDefault();
        var _this = this;
        clearForm();
        page_edit_key = $(this).attr("data-key");
        $("#page_headline").html(edit_page);
        getfillpageform(_this);
        $("#add_new_page_modal").modal("show");
    });

    $("#openAddNewPageFrm").on("click", function (e) {
        e.preventDefault();
        page_edit_key = "";
        $("#page_headline").html(add_new_page);
        CKEDITOR.instances.page_content.setData("", function () {
        });
        clearForm();
        $("#page_content").val("");
        $("#page_slug").val("");
        $("#page_title").val("");
        $("#page_heading").val("");
        $("#page_meta_description").val("");
        $("#page_meta_keywords").val("");
        $("#add_new_page_modal").modal("show");
    });

    $("#addNewPageFrm").submit(function (e) {
        e.preventDefault();
        var page_content = CKEDITOR.instances['page_content'].getData();
        page_slug = $("#page_slug").val();
        page_title = $("#page_title").val();
        page_heading = $("#page_heading").val();
        page_meta_keywords = $("#page_meta_keywords").val();
        page_meta_description = $("#page_meta_description").val();
        var dataS = "page_slug=" + page_slug + "&page_content=" + encodeURIComponent(page_content) + "&page_title=" + encodeURIComponent(page_title) + "&page_heading=" + encodeURIComponent(page_heading) + "&page_meta_keywords=" + encodeURIComponent(page_meta_keywords) + "&page_meta_description=" + encodeURIComponent(page_meta_description);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'pages/addnewpageajax',
            dataString: dataS + "&page_edit_key=" + page_edit_key,
            elem: "#submitPageFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    bootbox.alert(data.success_mess, function(){
                        $("#add_new_page_modal").modal("hide");
                        page_dtable.refresh();
                    });
                }
            }
        });
    });

    
    function getfillpageform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'pages/get_page_data',
            dataString: "page_key=" + page_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error){
                    bootbox.alert(data.error_mess);
                }
                else{
                    $("#page_slug").val(data.page_slug);
                    $("#page_slug").removeAttr('readonly');
                    $("#ckeditor_pagecontent").show();
                    CKEDITOR.instances.page_content.setData(data.page_content, function () {
                    });

                    $("#page_title").val(data.page_title);
                    $("#page_heading").val(data.page_heading);
                    //$("#page_content").val(data.page_content);
                    $("#page_meta_keywords").val(data.page_meta_keywords);
                    $("#page_meta_description").val(data.page_meta_description);
                }
            }
        });
    }

});

function clearForm(){
    $("label span.error").remove();
    formReset('#addNewPageFrm');
}
