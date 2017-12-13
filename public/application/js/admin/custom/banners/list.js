var comments_dtable = '';
var selected_tags_arr = [];
var edit_selected_tags_arr = [];
var edit_delete_selected_tags_arr = [];
$().ready(function () {
    CKEDITOR.config.removePlugins = 'Image';
    CKEDITOR.replace('banner_desc',
            {
            });
    var banner_key = "";
    var banner_edit_key = "";
    var comment_edit_key = "";
    var banners_list_url = ADMIN_HTTP_PATH + 'banners/bannerlist'; 

    banner_dtable = $(".banners_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: banners_list_url,
        dataString: "",
        delete_confirm: app_js_message.confirm_delete,
        container: "#banners_list_cont",
        delete_btn: "#banners_delete_rows",
        checkallitem: "#banners_checkallitem",
        actionsid: "input.banners_actionsid",
        ajaxSuccess: function (data) {
            $('.banner_active').bootstrapToggle({});
            commonfn.enable_disable(".banners_list_wrap .banner_active");
            $('.active_deactive').bootstrapToggle({});
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        },
        deleteSuccess: function (data) {
            banner_dtable.refresh();
        }
    });

    $("body").on("click", ".open_edit_banner", function (e) {
        e.preventDefault();
        var _this = this;
        clearForm();
        banner_edit_key = $(this).attr("data-key");
        getfillbannerform(_this);
        $("#page_heading").html(edit_banner);
        $("#add_new_banner_modal").modal("show");
    });

    if (new_banner == "new_banner") {
        $("#add_new_banner_modal").modal("show");
    }

    $("#openAddNewbannerFrm").on("click", function (e) {
        e.preventDefault();
        banner_edit_key = "";
        clearForm();
        $("#page_heading").html(add_new_banner);
        $("#add_new_banner_modal").modal("show");
    });

    function clearForm() {
        $("#ajax_tag_list").hide();
        $("label span.error").remove();
        $("#selected_tag_list").html("");
        CKEDITOR.instances.banner_desc.setData("", function () {
        });
        $("label span.error").remove();
        // $("#banner_key").val("");
        // $("#banner_author").val("");
        $("#banner_image").val('');
        // $("#banner_youtube_video_url").val('');
        $("#banner_image_view").attr('src', '');
        $("#banner_desc_h").val("");
        $("#banner_title").val("");
        $("#banner_publish").attr('checked', false);
    }

    $("#addNewbannerFrm").submit(function (e) {
        e.preventDefault();
        var banner_desc = encodeURIComponent(CKEDITOR.instances['banner_desc'].getData());
        $("#banner_desc_h").val(banner_desc);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'banners/addnewbannerajax',
            dataString: new FormData(this),
            file: true,
            elem: "#submitbannerFrm",
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
                        $("#add_new_banner_modal").modal("hide");
                        banner_dtable.refresh();
                    });

                }
            }
        });
    });

    function getfillbannerform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'banners/get_banner_data',
            dataString: "banner_id=" + banner_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else
                {
                    $("#ckeditor_bannerdesc").show();
                    CKEDITOR.instances.banner_desc.setData(data.banner_desc, function () {
                    });
                    $("#banner_title").val(data.banner_title);
                    $("#banner_id").val(data.banner_id); 
                    $("#banner_image").val('');
                    $("#banner_image_view").attr('src', data.banner_image);
                    if (data.banner_publish) {
                        $("#banner_publish").prop('checked', 'checked');
                    } else {
                        $("#banner_publish").prop('checked', false);
                    }
                }
            }
        });
    }
    //**** - ! Banner Ends ! - ****//

    
});
