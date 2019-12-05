jQuery(document).ready(function () {
    var offset = $(window).outerHeight(true);
    var footer = $('.site-footer').offset().top;

    $(window).resize(function () {
        offset = $(window).outerHeight(true);
        footer = $('.site-footer').offset().top;
    });
    
    $(window).scroll(function () {
        if (window.scrollY + offset <= footer) {
            $('.submit').addClass("sticky");
        } else {
            $('.submit').removeClass("sticky");
        }
    });
});