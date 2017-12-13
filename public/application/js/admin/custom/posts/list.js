var comments_dtable = '';
var selected_tags_arr = [];
var edit_selected_tags_arr = [];
var edit_delete_selected_tags_arr = [];
$().ready(function () {
    CKEDITOR.config.removePlugins = 'Image';
    CKEDITOR.replace('post_desc',
            {
            });
    var post_key = "";
    var post_edit_key = "";
    var comment_edit_key = "";
    var posts_list_url = ADMIN_HTTP_PATH + 'posts/postlist';
    var comment_list_url = ADMIN_HTTP_PATH + 'posts/commentslist';
    var comment_list_url_static = comment_list_url;

    post_dtable = $(".posts_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: posts_list_url,
        dataString: "",
        delete_confirm: app_js_message.confirm_delete,
        container: "#posts_list_cont",
        delete_btn: "#posts_delete_rows",
        checkallitem: "#posts_checkallitem",
        actionsid: "input.posts_actionsid",
        ajaxSuccess: function (data) {
            $('.post_active').bootstrapToggle({});
            commonfn.enable_disable(".posts_list_wrap .post_active");
            $('.active_deactive').bootstrapToggle({});
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        },
        deleteSuccess: function (data) {
            post_dtable.refresh();
        }
    });

    $("body").on("click", ".open_edit_post", function (e) {
        e.preventDefault();
        var _this = this;
        clearForm();
        post_edit_key = $(this).attr("data-key");
        getfillpostform(_this);
        $("#page_heading").html(edit_post);
        $("#add_new_post_modal").modal("show");
    });

    if (new_post == "new_post") {
        $("#add_new_post_modal").modal("show");
    }

    $("#openAddNewPostFrm").on("click", function (e) {
        e.preventDefault();
        post_edit_key = "";
        clearForm();
        $("#page_heading").html(add_new_post);
        $("#add_new_post_modal").modal("show");
    });

    function clearForm() {
        $("#ajax_tag_list").hide();
        $("label span.error").remove();
        $("#selected_tag_list").html("");
        CKEDITOR.instances.post_desc.setData("", function () {
        });
        $("label span.error").remove();
        $("#post_key").val("");
        $("#post_author").val("");
        $("#post_image").val('');
        $("#post_youtube_video_url").val('');
        $("#post_image_view").attr('src', '');
        $("#post_desc_h").val("");
        $("#post_title").val("");
        $("#post_publish").attr('checked', false);
    }

    $("#addNewPostFrm").submit(function (e) {
        e.preventDefault();
        var post_desc = encodeURIComponent(CKEDITOR.instances['post_desc'].getData());
        $("#post_desc_h").val(post_desc);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/addnewpostajax',
            dataString: new FormData(this),
            file: true,
            elem: "#submitPostFrm",
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
                        $("#add_new_post_modal").modal("hide");
                        post_dtable.refresh();
                    });

                }
            }
        });
    });

    function getfillpostform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/get_post_data',
            dataString: "post_key=" + post_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else
                {
                    $("#ckeditor_postdesc").show();
                    CKEDITOR.instances.post_desc.setData(data.post_desc, function () {
                    });
                    $("#post_author").val(data.post_author);
                    $("#post_title").val(data.post_title);
                    $("#post_key").val(data.post_key);
                    $("#post_youtube_video_url").val(data.post_youtube_video_url);
                    $("#post_image").val('');
                    $("#post_image_view").attr('src', data.post_image);
                    if (data.post_publish) {
                        $("#post_publish").prop('checked', 'checked');
                    } else {
                        $("#post_publish").prop('checked', false);
                    }
                }
            }
        });
    }
    //**** - ! Post Ends ! - ****//

    //**** - ! Comment Starts here ! - ****//

    $("body").on("click", ".open_comment_list_modal", function (e) {
        e.preventDefault();
        post_key = $(this).attr('data-val');
        var _this = this;
        comment_list_url = comment_list_url_static;
        comments_dtable.url = comment_list_url;
        comments_dtable.dataString = "post_key=" + post_key;
        comments_dtable.elem = _this;
        comments_dtable.refresh();
    });


    comments_dtable = $(".comments_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: comment_list_url,
        onload_data: false,
        dataString: "post_key=" + post_key,
        delete_confirm: app_js_message.confirm_delete,
        container: "#comment_list_modal .modal-body",
        delete_btn: "#comment_delete_rows",
        checkallitem: "#comment_checkallitem",
        actionsid: "input.comment_actionsid",
        ajaxSuccess: function (data) {
            commonfn.enable_disable(".comments_list_wrap .active_deactive");
            $('.active_deactive').bootstrapToggle({});
            if (data.error) {
                bootbox.alert(data.error_mess);
            }
            else if (data.success) {
                $("#comment_list_modal").modal("show");
            }
        },
        deleteSuccess: function (data) {
            comments_dtable.refresh();
        }
    });

    $("body").on("click", ".open_edit_comment_frm", function (e) {
        e.preventDefault();
        var _this = this;
        $("label span.error").remove();
        comment_key = $(this).attr("data-val");
        comment_edit_key = comment_key;
        getfillcommentform(_this);
        $("#comment_list_modal").modal("hide");
        $("#comment_edit_modal").modal("show");
    });

    function getfillcommentform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/get_comment_data',
            dataString: "comment_key=" + comment_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else if (data.success)
                {
                    $("#comment_message").val(data.comment_message);
                }
            }
        });
    }

    $("#editCommentFrm").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/editcommentajax',
            dataString: $("#editCommentFrm").serialize() + "&comment_edit_key=" + comment_edit_key,
            elem: "#updateCommentFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success){
                    comment_edit_key = "";
                    $("#comment_edit_modal").modal("hide");
                    comments_dtable.refresh();
                }
            }
        });
    });
});
