$(document).ready(function () {

    "use strict";

    $('.slick-repair').slick({
        mobileFirst: true,
        dots: true,
        infinite: true,
        slidesToShow: 1,
        appendArrows: $('.slick-repair__arrows'),
        nextArrow: '<div class="slick-right">Дальше<i class="fa fa-long-arrow-right"></i></div>',
        prevArrow: '<div class="slick-left"><i class="fa fa-long-arrow-left"></i>назад</div>',

    });

});