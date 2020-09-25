jQuery(document).ready(function ($) {
    $('.splc-wrapper').each(function (index) {
        var carousel_id = $(this).attr('id');
        if (carousel_id != '') {
            jQuery('#' + carousel_id).slick({
                prevArrow: "<div class=\'slick-prev\'><i class=\'fa fa-angle-left\'></i></div>",
                nextArrow: "<div class=\'slick-next\'><i class=\'fa fa-angle-right\'></i></div>",
            });
        }
    });
});
