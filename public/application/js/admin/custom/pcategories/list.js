var comments_dtable = '';
var selected_tags_arr = [];
var edit_selected_tags_arr = [];
var edit_delete_selected_tags_arr = [];
$().ready(function () {
    CKEDITOR.config.removePlugins = 'Image';
    CKEDITOR.replace('category_desc',
            {
            });
    var category_key = "";
    var category_edit_key = "";
    var comment_edit_key = "";
    var product_categories_list_url = ADMIN_HTTP_PATH + 'product-category/categorylist'; 

    category_dtable = $(".product-categories_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: product_categories_list_url,
        dataString: "",
        delete_confirm: app_js_message.confirm_delete,
        container: "#product-categories_list_cont",
        delete_btn: "#product-categories_delete_rows",
        checkallitem: "#product-categories_checkallitem",
        actionsid: "input.product-categories_actionsid",
        ajaxSuccess: function (data) {
            $('.category_active').bootstrapToggle({});
            commonfn.enable_disable(".product-categories_list_wrap .category_active");
            $('.active_deactive').bootstrapToggle({});
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        },
        deleteSuccess: function (data) {
            category_dtable.refresh();
        }
    });

    $("body").on("click", ".open_edit_category", function (e) {
        e.preventDefault();
        var _this = this;
        clearForm();
        category_edit_key = $(this).attr("data-key");
        getfillcategoryform(_this);
        $("#page_heading").html(edit_category);
        $("#add_new_category_modal").modal("show");
    });

    if (new_category == "new_category") {
        $("#add_new_category_modal").modal("show");
    }

    $("#openAddNewcategoryFrm").on("click", function (e) {
        e.preventDefault();
        category_edit_key = "";
        clearForm();
        $("#page_heading").html(add_new_category);
        $("#add_new_category_modal").modal("show");
    });

    function clearForm() {
        $("#ajax_tag_list").hide();
        $("label span.error").remove();
        $("#selected_tag_list").html("");
        CKEDITOR.instances.category_desc.setData("", function () {
        });
        $("label span.error").remove();
        // $("#category_key").val("");
        // $("#category_author").val("");
        $("#category_image").val('');
        // $("#category_youtube_video_url").val('');
        $("#category_image_view").attr('src', '');
        $("#category_desc_h").val("");
        $("#category_title").val("");
        $("#category_publish").attr('checked', false);
    }

    $("#addNewcategoryFrm").submit(function (e) {
        e.preventDefault();
        var category_desc = encodeURIComponent(CKEDITOR.instances['category_desc'].getData());
        $("#category_desc_h").val(category_desc);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'product-category/addnewcategoryajax',
            dataString: new FormData(this),
            file: true,
            elem: "#submitcategoryFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    bootbox.alert(data.success_mess, function () {
                        $("#add_new_category_modal").modal("hide");
                        category_dtable.refresh();
                    });

                }
            }
        });
    });

    function getfillcategoryform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'product-category/get_category_data',
            dataString: "category_id=" + category_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else
                {
                    $("#ckeditor_categorydesc").show();
                    CKEDITOR.instances.category_desc.setData(data.category_desc, function () {
                    });
                    $("#category_title").val(data.category_title);
                    $("#category_id").val(data.category_id); 
                    $("#category_image").val('');
                    $("#category_image_view").attr('src', data.category_image);
                    if (data.category_publish) {
                        $("#category_publish").prop('checked', 'checked');
                    } else {
                        $("#category_publish").prop('checked', false);
                    }
                }
            }
        });
    }
    //**** - ! category Ends ! - ****//

    
});
