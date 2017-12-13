$().ready(function () {

    // photo carousel
    $(".photo_carousel").owlCarousel({
        items: 4,
        lazyLoad: true,
        navigation: false,
        slideSpeed: 300,
        pagination: true,
        paginationSpeed: 2000,
        singleItem: true,
        autoPlay: true,
        navigationText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
    });

    $(".photographer-thumb").mouseenter(function () {
        $(this).next().hide();
    });
    $(".photographer-thumb").mouseleave(function () {
        $(this).next().fadeIn();
    });

    $(".lnk_scrolldown").click(function(){
        $("html, body").animate({ scrollTop: $('.models-wrap').offset().top }, 1500);
    });
    

});
