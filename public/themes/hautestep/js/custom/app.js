window.commonfn = window.commonfn || (function init($, undefined) {
    "use strict";
    var exports = {loaded: []};
    exports.callAjax = function (url, dataString)
    {
        return $.ajax({
            type: "POST",
            url: url,
            cache: false,
            data: dataString,
            dataType: "json"
        });
    }

    exports.doAjax = function (options)
    {
        var s = {message: "wait..", load: false};
        s = $.extend({}, {
            ajaxSuccess: function () {
            }
        }, options);
        if (typeof s.elem != "undefined")
            exports.disableButton(s.elem, s.message);
        if (s.load)
        {
            exports.block_body();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (typeof s.file != "undefined" && s.file == true)
        {
            var ajax = $.ajax({
                type: "POST",
                url: s.url,
                data: s.dataString,
                contentType: false,
                cache: false,
                processData: false
            });
        } else
        {
            var ajax = $.ajax({
                type: "POST",
                url: s.url,
                cache: false,
                data: s.dataString,
                dataType: "json"
            });
        }

        ajax.complete(function () {
            if (s.load)
                exports.unblock_body();
            if (typeof s.elem != "undefined")
                exports.enableButton(s.elem);
        });
        ajax.success(function (data) {
            if (typeof s.file != "undefined" && s.file == true)
            {
                data = $.parseJSON(data);
            }
            if (data.error == 'logged_out')
            {
                exports.openloginalert();
            } else
            if (data.success == 1)
            {
                if (typeof s.container != 'undefined' && s.container != false)
                {
                    $(s.container).html(data.html);
                }
            }
            if ($.isFunction(s.ajaxSuccess))
                s.ajaxSuccess.call(this, data);
        });
    }

    exports.openloginalert = function (msg, path)
    {
        if (typeof path == "undefined")
            path = HTTP_PATH;
        bootbox.alert("Your are logged out", function () {
            window.location = path;
            return false;
        });
    }

    exports.timeConverter = function (UNIX_timestamp, h_i_s) {
        if (h_i_s == undefined)
            h_i_s = false;
        var a = new Date(UNIX_timestamp * 1000);
        var months = ['January', 'Feburary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();

        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = month + ' ' + date + ', ' + year;
        if (h_i_s)
        {
            time += ' ' + hour + ':' + min + ':' + sec;
        }
        return time;
    }


    exports.disableButton = function (elem, message)
    {
        if (typeof message == "undefined")
            message = "Please wait...";
        var id = $(elem).attr("id");
        var class_es = $(elem).attr("class");
        var thistag = $(elem).clone();
        $(elem).addClass("displaynonehard");
        if ($(elem).is("input"))
        {
            var button = $("<button></button>");
            $(button).attr("class", class_es).attr("disabled", "disabled").attr("id", id + "_dummybtn").html('<i class="fa fa-spinner fa-spin"></i> ' + message);

            $(elem).after(button);
        } else
        {
            $(thistag).removeAttr("id").attr("disabled", "disabled").attr("id", id + "_dummybtn").html('<i class="fa fa-spinner fa-spin"></i> ' + message);
            $(elem).after(thistag);
        }
        var date = new Date();
        exports.elem = date.getTime();

    }

    exports.enableButton = function (elem)
    {
        var date = new Date();
        var elem_now = date.getTime();
        var timeDiff = elem_now - exports.elem;
        if (timeDiff < 100)
        {
            timeDiff = 1000;
        } else
            timeDiff = 0;

        var id = $(elem).attr("id");
        $(elem).fadeIn("slow", function () {
            $(this).removeAttr("disabled").removeClass("displaynonehard").css("display", "inline-block");
            $("#" + id + "_dummybtn").remove();
        });




    }
    exports.block_body = function ()
    {
        var h = $(window).height();
        $("body").addClass("body_relative").css("height", h);

        $(".body_loader").fadeIn().css("height", h);
    }
    exports.unblock_body = function ()
    {
        $("body").removeClass("body_relative").css("height", "auto");
        $(".body_loader").fadeOut();
    }

    exports.check_sel_opt = function (parent, childs, delete_event)
    {
        if (typeof parent == "undefined")
            parent = "#checkallitem";
        if (typeof childs == "undefined")
            childs = "input.actionsid";
        if (typeof delete_event == "undefined")
            delete_event = "#delete_rows";
        if ($(childs + ":checked").length == 0)
        {
            $(delete_event).attr("disabled", 'disabled');
        } else
        {
            $(delete_event).removeAttr("disabled");
        }
    }
    exports.check_all_handle = function (parent, childs, delete_event)
    {
        if (typeof parent == "undefined")
            parent = "#checkallitem";
        if (typeof childs == "undefined")
            childs = "input.actionsid";
        if (typeof delete_event == "undefined")
            delete_event = "#delete_rows";
        if (!$.isFunction($.fn.iCheck))
            return;
        $(parent + ", " + childs).iCheck({
            checkboxClass: 'icheckbox_square-blue'
        }).attr("autocomplete", 'off');

        $(parent).on('ifChecked', function (e) {
            $(childs).each(function () {
                $(this).iCheck('check');
            });
            exports.check_sel_opt(parent, childs, delete_event);
        });
        $(parent).on('ifUnchecked', function (e) {
            $(childs).each(function () {
                $(this).iCheck('uncheck');
            });
            exports.check_sel_opt(parent, childs, delete_event);
        });

        $(childs).on('ifChecked', function (e) {
            exports.check_sel_opt(parent, childs, delete_event);
        });
        $(childs).on('ifUnchecked', function (e) {
            $(childs).each(function () {
                if (!(this.checked))
                {
                    $(parent).removeAttr("checked");
                }
            });
            exports.check_sel_opt(parent, childs, delete_event);
        });
    }

    exports.delete_rows = function (parent, childs, delete_event)
    {
        if (typeof parent == "undefined")
            parent = "#checkallitem";
        if (typeof childs == "undefined")
            childs = "input.actionsid";
        if (typeof delete_event == "undefined")
            delete_event = "#delete_rows";
        $(delete_event).unbind().click(function () {

        });
        $(delete_event).bind("click", function (e) {
            e.preventDefault();

            var checkval = [];
            $(childs + ':checkbox:checked').each(function (i) {
                checkval[i] = $(this).val();
            });
            if (checkval.length == 0)
            {
                return false;
            }
            var _this = this;
            bootbox.confirm("Are you sure to delete the selected data?", function (result) {
                if (result == true)
                {
                    var tab_d = $(_this).attr('href');

                    var url = tab_d;
                    var dataString = "checkval=" + checkval;
                    exports.doAjax({'url': url, 'dataString': dataString, 'elem': delete_event,
                        ajaxSuccess: function (data) {
                            if (data.success)
                            {
                                $(childs + ':checkbox:checked').each(function (i) {
                                    $(this).closest('tr').remove();
                                });
                                $(parent).iCheck('uncheck');
                                if (deleteAjaxSuccess)
                                    deleteAjaxSuccess.call(this, data);
                                else
                                    window.location.reload();
                            } else
                            {
                                msg_alert(data.error_mess);
                                return false;
                            }
                        }});

                }
            });

        });
    }

    exports.enable_disable = function (eventor)
    {
        if (typeof eventor == "undefined")
            eventor = ".active_deactive";

        if (!$.isFunction($.fn.bootstrapToggle))
            return;
        $(eventor).bootstrapToggle();
        $(eventor).unbind().click(function () {

        });
        $(eventor).bind("change", function () {
            var id = $(this).attr("data-val");
            var status = 0;
            if ($(this).prop('checked')) {
                status = 1;
            }

            commonfn.doAjax({
                url: $(this).attr("data-url"),
                dataString: "id=" + id + "&status=" + status,
                ajaxSuccess: function (data)
                {
                    if (data.error)
                    {
                        bootbox.alert(data.error_mess);
                    }
                }
            });
        });
    }

    exports.inArray = function (e, t)
    {
        var n = t.length;
        for (var c = 0; c < n; c++)
        {
            if (e == t[c])
            {
                return 1
            }
        }
        return 0;
    }
    exports.init = function (_$) {
        window.commonfn = init(_$ || $);
    };
    exports.check_all_handle();
    exports.delete_rows();
    exports.check_sel_opt();
    exports.enable_disable();
    return exports;

}(window.jQuery));

function msg_alert(str, redirect)
{
    if (typeof redirect == "undefined")
        bootbox.alert(str);
    else
        bootbox.alert(str, function () {
            window.location = redirect;
        });
}

function set_tooltip() {
    $('[data-toggle="tooltip"]').tooltip();
}

function error_display(errorArr)
{
    $.each(errorArr, function (key, val) {
        show_label_error(key, val);
        $("#" + key).focus();
        return;
    });
}

function show_label_error(key, val)
{
    if ($("label[for='" + key + "'] #" + key + "-error").length == 0)
    {
        $("label[for='" + key + "']").append('<span id="' + key + '-error" class="error"> (' + val + ')</span>');
    } else
    {
        $("#" + key + "-error").html(' (' + val + ')').show();
    }
}

function formReset(form)
{
    $("input[type='text'],input[type='password'], input[type='email'], textarea, select", form).val('');
}

$(document).ready(function () {
    $("#signin_form").submit(function (e) {
        e.preventDefault();
        var _this = this;
        commonfn.doAjax({
            url: HTTP_PATH + 'signin',
            dataString: $("#signin_form").serialize(),
            elem: "#submitSignInFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    $("#signin_success").show();
                    window.location = HTTP_PATH + data.redirect;
                }
            }
        });
    });


    $('body').on('click', '.vdeo-ply-btn', function (e) {
        e.preventDefault();
        $('.video-frm').attr('src', '');
        var detailsrc = $(this).data('src');
        var videosrc = $(this).find('img.vdo-mt').data('value');
        var videotitle = $(this).attr('title');
        if (typeof videotitle != "undefined") {
            $('.topic-title').html('<a href="' + detailsrc + '" style="color:white">' + videotitle + '</a>');
        }
        $('.video-frm').attr('src', videosrc+"?autoplay=1");
        $('#videoModal').modal('show');
    });

    $('body').on('click', '.closevideomdl', function (e) {
        e.preventDefault();
        $('.video-frm').attr('src', '');
        $('.topic-title').html('');
        $('.video-frm').attr('src', '');
        $('#videoModal').modal('hide');
    });


    $('body').on('click', '.go_back_history', function () {
        window.history.back();
    });
});


function randomBetween(min, max) {
    if (min < 0) {
        return min + Math.random() * (Math.abs(min) + max);
    } else {
        return min + Math.random() * max;
    }
}

if (typeof trendingtags != "undefined") {
    var word_list = [];
    var listtag = {};
    for (var i in trendingtags) {
        if ((i % 2) == 0) {
            var tagname = trendingtags[i].tag;
            word_list.push({text: "<a href='" + tagurl + trendingtags[i].tag + "'>#" + trendingtags[i].tag + "</a>", weight: randomBetween(2, 15)});
        } else {
            word_list.push({text: "<a href='" + tagurl + trendingtags[i].tag + "'>#" + trendingtags[i].tag + "</a>", weight: randomBetween(2, 15), html: {"class": "vertical"}});
        }
    }
    $(function () {
        $("#my_favorite_latin_words").jQCloud(word_list);
    });

}


