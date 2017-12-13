$().ready(function () {

    var booking_url = HTTP_PATH + 'home/booking_ajax_data';
    var booking_url_static = booking_url;

    run_call();

    $('#booking_list_data').on('click', '.pagination li a', function (e) {
        e.preventDefault();
        booking_url = $(this).attr("href");
        run_call();
    });
    function run_call() {
        var payment_status = $('#payment_status').val();
        var job_status = $('#job_status').val();
        var booking_status = $('#booking_status').val();
        if (typeof payment_status == "undefined") {
            payment_status = "";
        }
        if (typeof job_status == "undefined") {
            job_status = "";
        }
        if (typeof booking_status == "undefined") {
            booking_status = "";
        }
        commonfn.doAjax({
            url: booking_url,
            dataString: "payment_status=" + payment_status + "&booking_status=" + booking_status + "&job_status=" + job_status,
            elem: "#submitPortfolioFrm",
            container: "#booking_list_data",
            ajaxSuccess: function (data)
            {
                if (data.error)
                {
                    flash_msg(data.error_mess, "error");
                }
                else if (data.success) {
                }
            }
        });
    }

    $('body').on('change', function () {
        run_call();

    });

});