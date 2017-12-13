var user_list_url = ADMIN_HTTP_PATH + 'users/userlist';
var user_dtable = '';
var portfolio_edit_key = '';
var edit_portfolio = '';
$().ready(function () {

    var user_id = 0;
    user_dtable = $(".user_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: user_list_url,
        dataString: "",
        delete_confirm: app_js_message.confirm_delete,
        container: "#user_list_cont",
        delete_btn: "#user_delete_rows",
        checkallitem: "#user_checkallitem",
        actionsid: "input.user_actionsid",
        ajaxSuccess: function (data) {
            $('.user_active').bootstrapToggle({});
            $('.user_feature_cls').bootstrapToggle({});
            if (data.error){
                bootbox.alert(data.error_mess);
            }
        },
        deleteSuccess: function (data) {
            user_dtable.refresh();
        }
    });

    $('body').on('change', '.user_active', function () {
        if ($(this).prop('checked')) {
            var user_key = $(this).attr("data-val");
            var blocked = 0;
        }
        else {
            var user_key = $(this).attr("data-val");
            var blocked = 2;
        }
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'users/update_active',
            dataString: "&user=" + user_key + "&blocked=" + blocked,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                if (data.success) {
                   // user_dtable.refresh();
                }
            }
        });
    });
    
    $('body').on('change', '.user_feature_cls', function () {
        if ($(this).prop('checked')) {
            var user_key = $(this).attr("data-val");
            var featured = 1;
        }
        else {
            var user_key = $(this).attr("data-val");
            var featured = 0;
        }
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'users/update_feature',
            dataString: "&user=" + user_key + "&featured=" + featured,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                if (data.success) {
                   // user_dtable.refresh();
                }
            }
        });
    });

    /* -- portfolio started --  */
    $('body').on('click', '.open_portfolio', function (e) {
        e.preventDefault();
        user_id = $(this).attr('data-value');
        portfolio_dtable.dataString = "user_id=" + user_id;
        portfolio_dtable.refresh();
    });



    portfolio_dtable = $(".portfolio_list_wrap").data_table({
        sort: "created_at",
        order: "DESC",
        url: ADMIN_HTTP_PATH + 'users/portfoliodetailslist',
        dataString: "",
        onload_data: false,
        delete_confirm: app_js_message.confirm_delete,
        container: "#portfolio_list_cont",
        delete_btn: "#portfolio_delete_rows",
        checkallitem: "#portfolio_checkallitem",
        actionsid: "input.portfolio_actionsid",
        ajaxSuccess: function (data) {
            $(".portfolio_model").modal("show");
            if (data.error)
            {
                bootbox.alert(data.error_mess);
            }
        },
        deleteSuccess: function (data) {
            portfolio_dtable.refresh();
        }
    });




    $('body').on('click', '.add_portfolio_details', function (e) {
        e.preventDefault();
        clearForm();
        $(".add_portfolio_details_model").modal("show");
        $(".portfolio_model").modal("hide");
    });

    $('body').on('click','editPortfolioDetails',function (e){
        e.preventDefault();
        clearForm();
        var portfolio_id = $(this).attr('data-value');
         $(".add_portfolio_details_model").modal("show");
    });


    $("#portfolioAddDetailsFrm").submit(function (e) {
        e.preventDefault();
        var dataS = new FormData(this);
        dataS.append("user_id", user_id);
        dataS.append("portfolio_edit_key", portfolio_edit_key);
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'users/addnewportfolioajax',
            dataString: dataS,
            elem: "#submitPortfolioFrm",
            file:true,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    error_display(data.error_mess);
                }
                else if(data.success) 
                {
                    bootbox.alert(data.success_mess, function () {
                        $(".add_portfolio_details_model").modal("hide");
                        portfolio_dtable.refresh();
                    });
                }

            }
        });
    });
    
    
    $('body').on('click','.editPortfolioDetails',function (e){
        e.preventDefault(); 
        var _this = this;
        clearForm();
         portfolio_edit_key = $(this).attr("data-key");
         getfillportfolioform(_this);
        $("#page_heading").html(edit_portfolio);
         $(".add_portfolio_details_model").modal("show");
    });
    
    function getfillportfolioform(_this)
    {
        commonfn.doAjax({
            url: ADMIN_HTTP_PATH + 'users/get_portfolio_data',
            dataString: "portfolio_key=" + portfolio_edit_key,
            elem: _this,
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    bootbox.alert(data.error_mess);
                }
                else
                {
                    $("#view_portfolio_image").attr("src", data.portfolio_image).show();
                    $("#portfolio_title").val(data.title);
                    $("#portfolio_desc").val(data.description);
                    
                }
            }
        });
    }
    

    function clearForm() {
        $("label span.error").remove();
        portfolio_edit_key = "";
        formReset('#portfolioAddDetailsFrm');
        $("#title").val("");
        $("#view_portfolio_image").hide();
        $("#description").val("");
    }
    
    
    /* -- portfolio End --  */
    
    
    /* -- Affiliate Started-  */
    
   
    /* -- Affiliate End --  */

});