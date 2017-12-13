$().ready(function () {
    var menu_edit_key = "";
    var menus_list_url = ADMIN_HTTP_PATH + 'menus/menulist';
    getmenuslist();

    $("#menus_list_cont").on("click", ".pagination a", function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        menus_list_url = url.replace("/?", "?");
        getmenuslist()
    });


    $("#openAddNewMenuFrm").on("click", function (e) {
        e.preventDefault();
        commonfn.doAjax({
           url: ADMIN_HTTP_PATH + 'menus/menutree',
            dataString: "menu_id=0",
            ajaxSuccess: function (data)
            {
                $("#page_heading").html("Add New Menu");    
                $("#parent_menu_tree").html(data.listing);
            }
        });
        getpagesdropdown(this, function () {
            menu_edit_key = "";
            $("#menu_text").val("");
            $("#menu_slug").val("");
            $("#menu_title").val("");
            $("#menu_icon").val("");
            $("#menu_url").val("");
            $("#page_key").val("");
            //$("#parent_menu").hide();
            //$("#parent_menu_tree").show();
            $("#add_new_menu_modal").modal("show");
        });

    });

    $("body").on("click", ".open_edit_menu", function (e) {
        e.preventDefault();
        var _this = this;
        menu_edit_key = $(this).attr("data-key");
        $("#page_heading").html("Edit Menu");    
        getpagesdropdown(_this, function () {
            getfillmenuform(_this);
        });
        $("#add_new_menu_modal").modal("show");
    });


    $("#addNewMenuFrm").submit(function (e) {
        e.preventDefault();
        var parent_menu = $(".menu_tree li.active a").attr("data-child");
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'menus/addnewmenuajax',
            dataString: $("#addNewMenuFrm").serialize() + "&parent_menu=" + parent_menu + "&menu_edit_key=" + menu_edit_key,
            elem: "#submitMenuFrm",
            ajaxSuccess: function (data)
            {
                $("label span.error").remove();
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if (data.success)
                {
                    open_menu_tree($(".menu_tree li.active a"), data.listing, 0);
                    $("#add_new_menu_modal").modal("hide");
                    getmenuslist();
                }
            }
        });
    });

    $("body").on("change", ".menu_active", function (e) {
        var menu_key = $(this).attr("data-val");
        if ($(this).prop('checked')) {
            var status = 1;
        }
        else {
            var status = 0;
        }
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'menus/update_active',
            dataString: "&menu_key=" + menu_key + "&status=" + status,
            ajaxSuccess: function (data)
            {
                if(data.success){
                    getmenuslist();
                }
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    });

    function open_menu_tree(_this, listing, append)
    {
        if ($(_this).length > 0)
        {
            $(_this).removeClass("menu_tree_close");
            if (append)
                $(_this).parent().after(listing);
            else
            {
                var selector = $(_this).parent().next("ul");
                $(selector).remove();
                $(_this).parent().after(listing);
            }
            $("i", _this).removeClass("fa-plus-square").addClass("fa-minus-square");
        }
        else
        {
            $("#parent_menu_tree").html(listing);
        }
    }
    
    $("#parent_menu_tree").on("click",".menu_tree li",function(e){
        var _this = this;
        var menu_id = $("a",this).attr("data-child");
        $(".menu_tree li").removeClass("active");
        $(this).addClass("active");
    });
    
    $("#menu_text").keyup(function(e){
            var text = $.trim($(this).val());
            text = text.replace(/\s{1,}/g, '-');
            text = text.replace(/ /gi, '');
            $("#menu_slug").val(text);
    });
    
    $("#parent_menu_tree").on("click",".menu_tree .menu_tree_close",function(e){
        var _this = this;
        var menu_id = $(this).attr("data-child");
        commonfn.doAjax({
            url:ADMIN_HTTP_PATH+'menus/menutree',
            dataString:"menu_id="+menu_id,
            ajaxSuccess:function(data)
            {
                if(data.success)
                {
                    open_menu_tree(_this,data.listing,1);
                }
            }
        });
    });
    
    

    function getfillmenuform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'menus/get_menu_data',
            dataString: "menu_key=" + menu_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else
                {
                    $("#menu_text").val(data.menu_text);
                    $("#menu_slug").val(data.menu_slug);
                    //$("#parent_menu").show();
                    //$("#parent_menu").val(data.parent_menu);
                    $("#parent_menu_tree").hide();
                    $("#menu_title").val(data.menu_title);
                    $("#menu_icon").val(data.menu_icon);
                    $("#menu_url").val(data.menu_url);
                    $("#page_key").val(data.page_key);
                }
            }
        });
    }


    function getParentMenuTree()
    {
        commonfn.doAjax({
            url: menus_list_url,
            dataString: "",
            container: "#menus_list_cont",
            ajaxSuccess: function (data)
            {
                commonfn.check_all_handle();
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    }
    
    function deleteAjaxSuccess(){
        getmenuslist();
    }
    
    function getmenuslist()
    {
        commonfn.doAjax({
            url: menus_list_url,
            dataString: "",
            container: "#menus_list_cont",
            ajaxSuccess: function (data)
            {
                commonfn.check_all_handle();
                $('.menu_active').bootstrapToggle({});
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
            }
        });
    }

    function getpagesdropdown(_this, callback)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'menus/get_pages_dropdown',
            dataString: "",
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else
                {
                    $("#page_key").replaceWith(data.pages);
                }
                if (typeof callback !== "undefined")
                    callback.call();
            }
        });
    }


});
