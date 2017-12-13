var to_user_id = "";
$().ready(function () {

    var casting_url = HTTP_PATH + 'home/casting_ajax_data';
    var casting_url_static = casting_url;

    run_call();

    $('#casting_list_data').on('click', '.pagination li a', function (e) {
        e.preventDefault();
        casting_url = $(this).attr("href");
        run_call();
    });

    var count_days = "";
    var key = "";
    $('body').on('click', '.model_booking_now', function (e) {
        e.preventDefault();
        count_days = $(this).attr('data-days');
        formReset();
        key = $(this).attr('data-key');
        $('#model_booking_model').modal('show');
    });


    $('body').on('change', '#per_day_amount', function (e) {
        e.preventDefault();
        var _this = this;
        calc_amount(_this, count_days)
    });

    $('body').on('submit', '#booking_frm', function (e) {
        e.preventDefault();
        var dataS = $(this).serialize();
        commonfn.doAjax({
            url: HTTP_PATH+"casting-model-book",
            dataString: dataS+"&key="+key,
            elem:'#booking_submit_btn',
            ajaxSuccess: function (data)
            {
                if (data.error == 1){
                    error_display(data.error_mess);
                }
                if (data.error == 2){
                    $('#model_booking_model').modal('hide');
                    flash_msg(data.error_mess, "danger");
                }
                else if (data.success) {
                    $('#model_booking_model').modal('hide');
                    flash_msg(data.success_mess, "success");
                    window.location.href = HTTP_PATH+"payment_process/"+data.booking_key;
                }
            }
        });
    });

    function run_call() {

        commonfn.doAjax({
            url: casting_url,
            dataString: "",
            container: "#casting_list_data",
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    flash_msg(data.error_mess, "error");
                }
                else if (data.success) {

                    $("#captureImage").prop('checked', false);
                }
            }
        });
    }
});


function calc_amount(_this, count_days) {
    var amount = $('#per_day_amount').val();
    var persentage = $('#for_agency_amount').attr('data-value');
    if(count_days < 0){
        count_days = 1;
    }
    var total_amount = amount * count_days;
    var agency_amount = Math.round(total_amount * persentage / 100);
    $('#total_amount').val(total_amount);
    $('#for_agency_amount').val(agency_amount);
}