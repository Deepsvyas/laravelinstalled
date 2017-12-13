(function ($) {
    $.fn.data_table = function (options) {
        var s = {
                    
                };
        s = $.extend({}, {
                sort: "created_at",
                order: "DESC",
                url: "",
                dataString: "",
                container: "",
                elem: "",
                onload_data: true,
                delete_btn: ".delete_rows",
                delete_confirm: "Are you sure to delete the selected records?",
                checkallitem: ".checkallitem",
                actionsid: ".actionsid",
                enable_disable: [],
                sortable: [],
                loader:true,
                refresh:".refresh_list",
                ajaxSuccess: function () {
                },
                deleteSuccess: function () {
                }
        }, options);
        var _this = this;
        var type_aheads = {};
        var search_data = {};
        var search_data_text = {};
        s.def_url;
        s.page_num;
        s.trigger = function ()
        {
            s.loader_f();
            var dataString;
            if(s.dataString == "")
                dataString = "sort="+s.sort+"&order="+s.order;
            else
                dataString = s.dataString+"&sort="+s.sort+"&order="+s.order;
            if(Object.keys(search_data).length > 0)
            {
                var ss = "";
                ss = JSON.stringify(search_data);
                dataString = dataString+ "&search_data="+ss;
            }
            if(Object.keys(type_aheads).length > 0)
            {
                var ss = "";
                ss = JSON.stringify(type_aheads);
                dataString = dataString+ "&type_aheads="+ss;
            }
            commonfn.doAjax({
                url: s.url,
                dataString: dataString,
                container: s.container,
                elem: s.elem,
                ajaxSuccess: function (data)
                {
                    $("table",_this).addClass("fixed-table-container");
                    s.feat();
                    s.remove_loader();
                    if ($.isFunction(s.ajaxSuccess))
                        s.ajaxSuccess.call(this, data);
                }
            });
        };
        
        s.loader_f = function(){
            if(!s.loader)
                return false;
            var html = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
            $(".box-body",_this).after(html);
        };
        
        s.remove_loader = function()
        {
            $(".overlay", _this).remove();
        };
        
        s.refresh = function()
        {
            s.trigger();
        };
        
        s.feat = function(){
            s.set_sorting();
            s.check_sel_opt();
            s.check_all_handle();
            s.delete_rows();
            s.setup_search();
        };
        
        s.init = function ()
        {
            $.ajaxSetup({
                complete: function() {
                    s.remove_loader();
                }
            });
            s.def_url = s.url;
            $(_this).off("click", ".pagination a");
            
            $(_this).on("click", ".pagination a", function (e) {
                e.preventDefault();
                var url = $(this).attr("href");
                s.url = url.replace("/?", "?");
                s.trigger();
            });
            
            $(_this).off("click", ".refresh_list");
            $(_this).on("click", ".refresh_list", function (e) {
                e.preventDefault();
                s.refresh();
            });
            
            //s.feat();
            if(s.onload_data){
                s.trigger();
            }
        };
        
        s.set_sorting = function()
        {
            $("thead tr:first th", _this).each(function(){
                var sort = $(this).attr("data-field");
                var is_sortable = $(this).attr("data-sort");
                if((typeof sort != "undefined" && sort.length > 0) && (typeof is_sortable == "undefined" || is_sortable == true))
                {
                    $(this).wrapInner( "<div class='sortable both'></div>");
                    if(s.sort == sort)
                    {
                        var order_c = (s.order).toLowerCase();
                        $(".sortable",this).addClass(order_c)
                    }
                }
            });
            
            $(".sortable",_this).unbind().click(function () {});
            
            $(".sortable",_this).bind("click",function () {
                var sort_c = $(this).parent().attr("data-field");
                if(typeof sort_c == "undefined")
                    return;
                var sel = $(this);
                s.sort = sort_c;
                if(sel.hasClass("asc"))
                {
                    s.order = "DESC";
                }
                else
                {
                    s.order = "ASC";
                }
                s.refresh();
            });
        };

        s.check_sel_opt = function ()
        {
            if ($(s.actionsid + ":checked", _this).length == 0)
            {
                $(s.delete_btn,_this).attr("disabled", 'disabled');
            }
            else
            {
                $(s.delete_btn,_this).removeAttr("disabled");
            }
        };
        
        s.check_all_handle = function ()
        {
            if (!$.isFunction($.fn.iCheck))
                return;
            $(s.checkallitem + ", " + s.actionsid, _this).iCheck({
                checkboxClass: 'icheckbox_square-blue'
            }).attr("autocomplete", 'off');

            $(s.checkallitem, _this).on('ifChecked', function (e) {
                $(s.actionsid, _this).each(function () {
                    $(this).iCheck('check');
                });
                s.check_sel_opt();
            });
            $(s.checkallitem, _this).on('ifUnchecked', function (e) {
                $(s.actionsid, _this).each(function () {
                    $(this).iCheck('uncheck');
                });
                s.check_sel_opt();
            });

            $(s.actionsid, _this).on('ifChecked', function (e) {
                s.check_sel_opt();
            });
            $(s.actionsid, _this).on('ifUnchecked', function (e) {
                $(s.actionsid, _this).each(function () {
                    if (!(this.checked))
                    {
                        $(s.checkallitem, _this).removeAttr("checked");
                    }
                });
                s.check_sel_opt();
            });
        };

        s.delete_rows = function ()
        {
            $(s.delete_btn, _this).unbind().click(function () {

            });
            $(s.delete_btn, _this).bind("click", function (e) {
                e.preventDefault();

                var checkval = [];
                
                $(s.actionsid + ':checkbox:checked', _this).each(function (i) {
                    checkval[i] = $(this).val();
                });
                if (checkval.length == 0)
                {
                    return false;
                }
                var s_this = this;
                bootbox.confirm(s.delete_confirm, function (result) {
                    if (result == true)
                    {
                        var url = $(s_this).attr('href');
                        var dataString = "checkval=" + checkval;
                        commonfn.doAjax({'url': url, 'dataString': dataString, 'elem': $(s.delete_btn,_this),
                            ajaxSuccess: function (data) {
                                if (data.success)
                                {
                                    $(s.actionsid + ':checkbox:checked',_this).each(function (i) {
                                        $(this).closest('tr').remove();
                                    });
                                    $(s.checkallitem, _this).iCheck('uncheck');
                                    if ($.isFunction(s.deleteSuccess))
                                        s.deleteSuccess.call(this, data);
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
        };
        
        s.setup_search = function()
        {
            var i = 0;
            var has_search = false;
            $("thead tr:first th", _this).each(function(){
                var search = $(this).attr("data-search");
                if(typeof search != "undefined")
                {
                    if(i == 0){
                        var row = "<tr></tr>";
                        $("thead", _this).append(row);
                        has_search = true;
                    }
                    i++;
                }
            });
            if(has_search){
                var i = 0;
                $("thead tr:first th", _this).each(function(){
                    var search = $(this).attr("data-search");
                    var search_name = $(this).attr("data-field");
                    var search_url = $(this).attr("data-url");
                    var search_inp = $("<th/>");
                    var search_s ;
                    var search_s_hdn ;
                    if(typeof search != "undefined")
                    {
                        var last_v = "";
                        var last_v_id = "";
                        if(typeof search_data[search_name] != "undefined" && (search_data[search_name]).length > 0){
                            last_v = decodeURIComponent(search_data[search_name]);
                        }
                        
                        search_s = $("<input />").addClass("form-control").attr("name","search_"+search_name).attr("id","search_"+search_name).val(last_v);
                        
                        if(search == "true"){
                            
                        }
                        
                        if(search == "typeahead"){
                            if(typeof search_data[search_name+"_id"] != "undefined" && (search_data[search_name+"_id"]).length > 0){
                                last_v_id = decodeURIComponent(search_data[search_name+"_id"]);
                            }
                            if(typeof search_data_text[search_name] != "undefined" && (search_data_text[search_name]).length > 0){
                                last_v = decodeURIComponent(search_data_text[search_name]);
                            }
                            search_s.val(last_v);
                            search_s_hdn = $("<input type='hidden' />").attr("name","search_"+search_name+"_id").attr("id","search_"+search_name+"_id").val(last_v_id);
                            search_inp.append(search_s_hdn);
                            search_s.addClass("typeahead_inp");
                        }
                        search_inp.append(search_s);
                        i++;
                    }
                    $("thead tr:eq( 1 )", _this).append(search_inp);
                    if(typeof search != "undefined" && search == "typeahead"){
                        s.set_typeahead("search_"+search_name, search_url);
                    }

                });
                
                $("thead tr:eq( 1 ) input", _this).unbind("keyup",function () {});
                $("thead tr:eq( 1 ) input", _this).bind("keyup", function (e) {
                    e.preventDefault();
                    var code = (typeof e.which === "number") ? e.which : e.keyCode;
                    if(code == 13) e.preventDefault();
                    if(code == 13){
                        search_data = {};
                        search_data_text = {};
                        type_aheads = {};
                        $("thead tr:eq( 1 ) input", _this).each(function(i){
                            var value = $(this).val();
                            var name = $(this).attr("name");
                            name = name.replace("search_", "");
                            if(!$(this).hasClass("typeahead_inp")){
                                search_data[name] = encodeURIComponent($.trim(value));
                            }
                            else{
                                search_data_text[name] = encodeURIComponent($.trim(value));
                                if(($.trim(value)).length > 0){
                                    type_aheads[name+"_id"] = 1;
                                }
                            }
                        });
                        s.url = s.def_url;
                        s.trigger();
                    } 
                });
                
            }
        }
        
        s.set_typeahead = function(selector, url){
            $("#"+selector).typeahead({
                ajax: {
                    url: url,
                    method: 'post',
                    triggerLength: 1,
                    preDispatch: function (query) {
                        return {
                            search: query,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }
                    }
                },
                displayField: 'name',
                valueField: 'id',
                onSelect: function (data, value,text) {
                    $("#"+selector+"_id").val(data.value);
                }
            });
        }
        
        s.init();
        return s;
    };
}(jQuery));