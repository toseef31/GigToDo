(function ($) {
    "use strict";


    //===== Prealoder
    $(window).on('load', function (event) {
        $('.proloader').delay(500).fadeOut(500);
    });


    /*=========================
      ofcavas-menu START
    ===========================*/






    /*=========================
      Home-slider START
    ===========================*/

    $(".home-slide-active").owlCarousel({
        items: 1,
        dot: true,
        autoplayTimeout: 2000,
        loop: true,
        margin: 0,
        autoplay: true,
        smartSpeed: 450
    });

    // Nice-select
    $('select').niceSelect();




    $(".message-inner .message-inner-toggle").on("click", function () {
        $(".message-box, .overlay-bg").addClass("active");
        $('.overlay-bg').addClass('bg-transparent');
    });

    $(".overlay-bg").on("click", function () {
        $(".message-box, .overlay-bg").removeClass("active");
        $('.overlay-bg').removeClass('bg-transparent');
    });

    
    

    $(".menubar").on("click", function () {
        $(".all-content, .home-content, .header-top.sticky").addClass("active");
    });

    $(".close-icon, .overlay-bg").on("click", function () {
        $(".all-content, .home-content").removeClass("active");
    });




    $(".menubar").on("click", function () {
        $(".ofcanvas-menu, .overlay-bg").addClass("active");
    });

    $(".close-icon, .overlay-bg").on("click", function () {
        $(".ofcanvas-menu, .overlay-bg").removeClass("active");
    });


    // sticky
    var wind = $(window);
    var sticky = $('.header-top, .home-header, .dashboard-page');
    var headerHeight = sticky.outerHeight();
    wind.on('scroll', function () {
        var scroll = wind.scrollTop();
        if (scroll < headerHeight) {
            sticky.removeClass('sticky');
        } else {
            sticky.addClass('sticky');
        }
    });
})(jQuery);
