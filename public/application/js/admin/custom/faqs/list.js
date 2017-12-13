var comments_dtable = '';
var selected_tags_arr = [];
var edit_selected_tags_arr = [];
var edit_delete_selected_tags_arr = [];
$().ready(function () {
    CKEDITOR.config.removePlugins = 'Image';
    CKEDITOR.replace('faq_desc',
            {
            });
    var faq_key = "";
    var faq_edit_key = "";
    var comment_edit_key = "";
    var faqs_list_url = ADMIN_HTTP_PATH + 'faqs/faqlist'; 

    faq_dtable = $(".faqs_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: faqs_list_url,
        dataString: "",
        delete_confirm: app_js_message.confirm_delete,
        container: "#faqs_list_cont",
        delete_btn: "#faqs_delete_rows",
        checkallitem: "#faqs_checkallitem",
        actionsid: "input.faqs_actionsid",
        ajaxSuccess: function (data) {
            $('.faq_active').bootstrapToggle({});
            commonfn.enable_disable(".faqs_list_wrap .faq_active");
            $('.active_deactive').bootstrapToggle({});
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        },
        deleteSuccess: function (data) {
            faq_dtable.refresh();
        }
    });

    $("body").on("click", ".open_edit_faq", function (e) {
        e.preventDefault();
        var _this = this;
        clearForm();
        faq_edit_key = $(this).attr("data-key");
        getfillfaqform(_this);
        $("#page_heading").html(edit_faq);
        $("#add_new_faq_modal").modal("show");
    });

    if (new_faq == "new_faq") {
        $("#add_new_faq_modal").modal("show");
    }

    $("#openAddNewfaqFrm").on("click", function (e) {
        e.preventDefault();
        faq_edit_key = "";
        clearForm();
        $("#page_heading").html(add_new_faq);
        $("#add_new_faq_modal").modal("show");
    });

    function clearForm() {
        $("#ajax_tag_list").hide();
        $("label span.error").remove();
        $("#selected_tag_list").html("");
        CKEDITOR.instances.faq_desc.setData("", function () {
        });
        $("label span.error").remove();
        // $("#faq_key").val("");
        // $("#faq_author").val("");
        $("#faq_image").val('');
        // $("#faq_youtube_video_url").val('');
        $("#faq_image_view").attr('src', '');
        $("#faq_desc_h").val("");
        $("#faq_title").val("");
        $("#faq_publish").attr('checked', false);
    }

    $("#addNewfaqFrm").submit(function (e) {
        e.preventDefault();
        var faq_desc = encodeURIComponent(CKEDITOR.instances['faq_desc'].getData());
        $("#faq_desc_h").val(faq_desc);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'faqs/addnewfaqajax',
            dataString: new FormData(this),
            file: true,
            elem: "#submitfaqFrm",
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
                        $("#add_new_faq_modal").modal("hide");
                        faq_dtable.refresh();
                    });

                }
            }
        });
    });

    function getfillfaqform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'faqs/get_faq_data',
            dataString: "faq_id=" + faq_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else
                {
                    $("#ckeditor_faqdesc").show();
                    CKEDITOR.instances.faq_desc.setData(data.faq_desc, function () {
                    });
                    $("#faq_title").val(data.faq_title);
                    $("#faq_id").val(data.faq_id); 
                    if (data.faq_publish) {
                        $("#faq_publish").prop('checked', 'checked');
                    } else {
                        $("#faq_publish").prop('checked', false);
                    }
                }
            }
        });
    }
    //**** - ! faq Ends ! - ****//

    
});
