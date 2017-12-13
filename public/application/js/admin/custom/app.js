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
        }
        else
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
            custombox.removedefalert();
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
            }
            else
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
        }
        else
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
        }
        else
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
        }
        else
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
                                if (typeof deleteAjaxSuccess != 'undefined')
                                    deleteAjaxSuccess.call(this, data);
                                else
                                    window.location.reload();
                            }
                            else
                            {
                                msg_alert(data.error_mess);
                                return false;
                            }
                        }});

                }
            });

        });
    }

    exports.enable_disable = function (eventor, callback)
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
                    if (typeof callback != "undefined")
                    {
                        callback.call();
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

function Custombox(){
    var _this = this;
    var varTime;
    this.init = function ()
    {
        this.info_icon = '<i class="icon-info-sign"></i>';
        this.remove_icon = '<i class="icon-remove-sign"></i>';
    }
    this.alert = function (mess, error_success, time)
    {
        this.init();
        $("#cust_alert").removeClass("cust_alert_success").removeClass("cust_alert_error").html('').hide();
        if (typeof error_success === "undefined" || error_success == null)
        {
            error_success = 1;
        }
        if (typeof time === "undefined")
        {
            time = 0;
        }

        var class_set = 'cust_alert_success';
        if (error_success == 0)
        {
            class_set = 'cust_alert_error';
        }

        $("#cust_alert").addClass(class_set).html(this.info_icon + mess + this.remove_icon).slideDown(500);
        clearTimeout(varTime);
        if (time != 0)
        {
            varTime = setTimeout(function () {
                _this.removealert();
            }, time)
        }
        $("#cust_alert .icon-remove-sign").bind("click", function () {
            $("#cust_alert").slideUp(500);
        });

    }
    this.defalert = function (mess)
    {
        $("#cust_loader_def").html(mess).slideDown(500);
    }

    this.removedefalert = function ()
    {
        setTimeout(function () {
            $("#cust_loader_def").slideUp(1000);
        }, 1000);
    }
    this.removealert = function ()
    {
        $("#cust_alert").removeClass("cust_alert_success").removeClass("cust_alert_success").html('').slideUp(500);
    }
}

$(document).ready(function () {
    $('body').on('click', '.go_back_history', function () {
        window.history.back();
    });
    $(".lv-tooltip").tooltip();
});
function setPanelHeight() {
    var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    $(".right-col-sec-me .mess-sec-list .chatboxcontent-wrap").height(height - ($(".right-col-sec-me .chat-frame-head").outerHeight() + $(".right-col-sec-me .chat-frame-lower ").outerHeight() + 60));

    $(".right-col-sec-me").height(height - 50);
}

var custombox = new Custombox();

function msg_alert(str, redirect)
{
    if (typeof redirect == "undefined")
        bootbox.alert(str);
    else
        bootbox.alert(str, function () {
            window.location = redirect;
        });
}

function error_display_ci(errorArr)
{
    clear_error_label_ci();
    $.each(errorArr, function (key, val) {
        show_label_error_ci(key, val);
        $("#" + key).focus();
        return;
    });
}

function clear_error_label_ci()
{
    $("div.ci_error_label").remove();
}

function show_label_error_ci(key, val)
{
    if ($("#" + key + "_error").length == 0)
    {
        var parent = $("#" + key).parent();
        $('<div class="callout error callout-danger ci_error_label" id="' + key + '_error" style="">' + val + '</div>').insertAfter(parent);
    }
    else
    {
        $("#" + key + "_error").html(val).show();
    }
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
    }
    else
    {
        $("#" + key + "-error").html(' (' + val + ')').show();
    }
}

function formReset(form)
{
    $("input[type='text'],input[type='password'], input[type='email'],input[type='hidden'],input[type='file'], textarea", form).val('');
}


function loadState(countryId, elem, returnCall)
{
    commonfn.doAjax({
        url: HTTP_PATH + 'fn/getstatesbycountryid',
        dataString: "countryId=" + countryId,
        elem: elem,
        ajaxSuccess: function (data)
        {
            if (data.success)
            {
                if ($.isFunction(returnCall))
                    returnCall.call(this, data);
            }
            else
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        }
    });
}

function loadCity(countryId, elem, returnCall)
{
    commonfn.doAjax({
        url: HTTP_PATH + 'fn/getcitiesbycountryid',
        dataString: "countryId=" + countryId,
        elem: elem,
        ajaxSuccess: function (data)
        {
            if (data.success)
            {
                if ($.isFunction(returnCall))
                    returnCall.call(this, data);
            }
            else
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        }
    });
}

function loadCityByState(state, elem, returnCall)
{
    commonfn.doAjax({
        url: HTTP_PATH + 'fn/getcitiesbystateid',
        dataString: "state=" + state,
        elem: elem,
        ajaxSuccess: function (data)
        {
            if (data.success)
            {
                if ($.isFunction(returnCall))
                    returnCall.call(this, data);
            }
            else
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        }
    });
}

