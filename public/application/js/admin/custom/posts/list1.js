var selected_tags_arr = [];

var post_key = "";
var post_edit_key = "";
var comment_edit_key = "";
var posts_list_url = ADMIN_HTTP_PATH + 'posts/postlist';
var comment_list_url = ADMIN_HTTP_PATH + 'posts/commentslist';
var comment_list_url_static = comment_list_url;
var edit_selected_tags_arr = [];
var edit_delete_selected_tags_arr = [];

$().ready(function () {
    CKEDITOR.config.removePlugins = 'Image';
    CKEDITOR.replace('post_desc',
            {
            });
    
    getpostlist();

    $("#posts_list_cont").on("click", ".pagination a", function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        posts_list_url = url.replace("/?", "?");
        getpostlist()
    });

    $("body").on("click", ".open_edit_post", function (e) {
        e.preventDefault();
        var _this = this;
        clearForm();
        post_edit_key = $(this).attr("data-key");
        getfillpostform(_this);
        $("#add_new_post_modal").modal("show");
    });

    $("#openAddNewPostFrm").on("click", function (e) {
        e.preventDefault();
        post_edit_key = "";
        clearForm();
        $("#add_new_post_modal").modal("show");
    });

    function clearForm() {
        $("#ajax_tag_list").hide();
        selected_tags_arr = [];
        edit_selected_tags_arr = [];
        edit_delete_selected_tags_arr = [];
        $("#selected_tag_list").html("");
        CKEDITOR.instances.post_desc.setData("", function () {
        });
        $("label span.error").remove();
        $("#post_key").val("");
        $("#post_author").val("");
        $("#post_image").val('');
        $("#post_image_view").attr('src', '');
        $("#post_desc_h").val("");
        $("#post_title").val("");
        $("#post_publish").attr('checked', false);
    }

    $("#addNewPostFrm").submit(function (e) {
        e.preventDefault();
        var post_desc = encodeURIComponent(CKEDITOR.instances['post_desc'].getData());
        $("#post_desc_h").val(post_desc);
        $("#post_selected_tags").val(selected_tags_arr);
        
        $("#edit_delete_selected_tags_arr").val(edit_delete_selected_tags_arr);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/addnewpostajax',
            //  dataString: dataS + "&post_edit_key=" + post_edit_key,
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
                    $("#add_new_post_modal").modal("hide");
                    getpostlist();
                }
            }
        });
    });

    $("body").on("change", ".post_active", function (e) {
        var post_key = $(this).attr("data-val");
        if ($(this).prop('checked')) {
            var status = 1;
        }
        else {
            var status = 0;
        }
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/update_active',
            dataString: "&post=" + post_key + "&status=" + status,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    });

    //**** - ! Post Ends ! - ****//


    //**** - ! Comment Starts here ! - ****//

    $("body").on("click", ".open_comment_list_modal", function (e) {
        e.preventDefault();
        post_key = $(this).attr('data-val');
        var _this = this;
        comment_list_url = comment_list_url_static;
        getcomments(_this, post_key);
    });

    //$("body").on("click", ".pagination a" ,"#comment_list_modal", function (e) {
    $("#comment_list_modal").on("click", ".pagination a", function (e) {
        e.preventDefault();
        comment_list_url_page = $(this).attr("href");
        comment_list_url = comment_list_url_page;
        getcomments(this, post_key);
    });


    
    $("body").on("click", ".open_edit_comment_frm", function (e) {
        e.preventDefault();
        var _this = this;
        comment_key = $(this).attr("data-val");
        comment_edit_key = comment_key;
        getfillcommentform(_this);
        $("#comment_list_modal").modal("hide");
        $("#comment_edit_modal").modal("show");
    });

    
    $("#editCommentFrm").submit(function (e) {
        e.preventDefault();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/editcommentajax',
            dataString: $("#editCommentFrm").serialize() + "&comment_edit_key=" + comment_edit_key,
            // elem: "#updateCommentFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    comment_edit_key = "";
                    getcomments('', post_key);
                    $("#comment_edit_modal").modal("hide");
                    $("#comment_list_modal").modal("show");

                }
            }
        });
    });


    $("body").on("change", ".comment_active", function (e) {
        var comment_key = $(this).attr("data-val");
        if ($(this).prop('checked')) {
            var status = 1;
        }
        else {
            var status = 0;
        }
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/comment/update_active',
            dataString: "&comment_key=" + comment_key + "&status=" + status,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    });
    //**** - ! Comment Ends here ! - ****//


    //**** - Tag Start here ! - ****//
    // Add New tag
    $("body").on("click", "#add_new_tag", function (e) {
        e.preventDefault();
        var tag = $("#new_tag").val();
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/addnewtagajax',
            dataString: "&tag=" + tag,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    error_display(data.error_mess);
                    //bootbox.alert(data.error_mess);
                } else if (data.success == 1) {
                    $("#new_tag").val("");
                    setSelectedTag(data.tag_id, data.tag_text);
                }
            }
        });
    });

    $("body").on("click", "#getAllUsed_tags", function (e) {
        e.preventDefault();
        gettags();
    });

    $("body").on("click", ".select_this_tag", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        setSelectedTag(id, $(this).html());

    });

    $("body").on("click", ".remove_selected_tag", function (e) {
        e.preventDefault();
        var id = $(this).parent().attr("data-id");
        id = parseInt(id);

        var index = selected_tags_arr.indexOf(id);
        // var index_edit = edit_selected_tags_arr.indexOf(parseInt(id));
        if (commonfn.inArray(id, edit_selected_tags_arr)) {
            if (!commonfn.inArray(id, edit_delete_selected_tags_arr)) {
                edit_delete_selected_tags_arr.push(id);
            }
        }
        //edit_delete_selected_tags_arr
        if (index > -1) {
            selected_tags_arr.splice(index, 1);
        }
        $(this).parent().remove();
    });

    //**** - ! Tag Ends here ! - ****//
});

function deleteAjaxSuccess()
{
    getpostlist();
}

function getpostlist()
    {
        commonfn.doAjax({
            url: posts_list_url,
            dataString: "",
            container: "#posts_list_cont",
            ajaxSuccess: function (data)
            {
                commonfn.check_all_handle("#posts_checkallitem", "input.posts_actionsid", "#posts_delete_rows");
                commonfn.delete_rows("#posts_checkallitem", "input.posts_actionsid", "#posts_delete_rows");
                commonfn.check_sel_opt("#posts_checkallitem", "input.posts_actionsid", "#posts_delete_rows");
                $('.post_active').bootstrapToggle({});
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    }
    
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
    
    function getfillpostform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/get_post_data',
            dataString: "post_key=" + post_edit_key,
            elem: _this,
          //  container: "#selected_tag_list",
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
                  //  $("#selected_tag_list").show();
                    $("#post_image_view").attr('src', data.post_image);
                    if (data.post_publish) {
                        $("#post_publish").attr('checked', 'checked');
                    } else {
                        $("#post_publish").attr('checked', false);
                    }
                    edit_selected_tags_arr = (data.post_tags).split(",");
                    
                    for (var i = 0; i < edit_selected_tags_arr.length; i++)
                        edit_selected_tags_arr[i] = parseInt(edit_selected_tags_arr[i]);
                    $("#selected_tag_list").append(data.html);
                    
                    selected_tags_arr = edit_selected_tags_arr.slice();
                }
            }
        });
    }


    
    function getcomments(_this, post_key)
    {
        commonfn.doAjax({
            url: comment_list_url,
            dataString: "post_key=" + post_key,
            elem: _this,
            container: "#comment_list_modal .modal-body",
            ajaxSuccess: function (data)
            {
                if (data.error) {
                    bootbox.alert(data.error_mess);
                }
                else {
                    $("#comment_list_modal").modal("show");
                    commonfn.check_all_handle("#comment_checkallitem", "input.comment_actionsid", "#comment_delete_rows");
                    commonfn.delete_rows("#comment_checkallitem", "input.comment_actionsid", "#comment_delete_rows");
                    commonfn.check_sel_opt("#comment_checkallitem", "input.comment_actionsid", "#comment_delete_rows");
                    $('.comment_active').bootstrapToggle({});
                }
            }
        });
    }
    
    function setSelectedTag(tag_id,tag_text)
    {
        tag_id = parseInt(tag_id);
        if(!commonfn.inArray(tag_id,selected_tags_arr))
        {
            var html = '<a class="selected-tag-c" data-id="'+tag_id+'"><i class="remove_selected_tag cancel-selected-tag fa fa-times"></i> '+ tag_text +'</a>';
            selected_tags_arr.push(tag_id);
            $("#selected_tag_list").append(html);
        }
    }
    
    function gettags()
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'posts/taglist',
            // elem: _this,
            container: "#ajax_tag_list",
            ajaxSuccess: function (data)
            {
                if (data.error) {
                    bootbox.alert(data.error_mess);
                }
                $("#ajax_tag_list").show();
            }
        });
    }
