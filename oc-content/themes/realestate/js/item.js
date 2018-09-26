$(document).ready(function () {

    "use strict";
    $('.ticket__carousel').slick({
        mobileFirst: true,
        adaptiveHeight: true,
        dots: false,
        infinite: true,
        lazyLoad: 'progressive',
        //slidesToShow: 1,
        nextArrow: '<div class="fa fa-angle-right slick-right"></div>',
        prevArrow: '<div class="fa fa-angle-left slick-left"></div>',
        responsive: [{
            breakpoint: 760,
            settings: {
                arrows: true
            }

        }, {
            breakpoint: 300,
            settings: {
                arrows: false
            }
        }],
        asNavFor: '.ticket__vertical'
    });

    if(img_total > 5){
        img_total = 5;
    }
    if(img_total > 0 && img_total <= 5 ){
        img_total = img_total -1;
    }

    $('.ticket__vertical').slick({
        infinite: true,
        slidesToShow: img_total,
        slidesToScroll: 1,
        dots: false,
        vertical: true,
        verticalSwiping: true,
        nextArrow: '<div class="fa fa-angle-down slick-right slick-right_v"></div>',
        prevArrow: '<div class="fa fa-angle-up slick-left slick-left_v"></div>',
        responsive: [
            {
                breakpoint: 770,
                settings: {
                    arrows: true,
                    vertical: true,
                    verticalSwiping: true,
                    adaptiveHeight: true,
                    slidesToShow: img_total,
                    nextArrow: '<div class="fa fa-angle-right slick-right"></div>',
                    prevArrow: '<div class="fa fa-angle-left slick-left"></div>',
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: true,
                    vertical: false,
                    verticalSwiping: false,
                    slidesToShow: 2,
                    nextArrow: '<div class="fa fa-angle-right slick-right"></div>',
                    prevArrow: '<div class="fa fa-angle-left slick-left"></div>',
                }

            },
            {
                breakpoint: 600,
                settings: {
                    arrows: true,
                    vertical: false,
                    verticalSwiping: false,
                    slidesToShow: 1,
                    nextArrow: '<div class="fa fa-angle-right slick-right"></div>',
                    prevArrow: '<div class="fa fa-angle-left slick-left"></div>',
                }

            },
            {
                breakpoint: 400,
                settings: {
                    arrows: false,
                    vertical: false,
                    verticalSwiping: false,
                    slidesToShow: 1,
                    nextArrow: '<div class="fa fa-angle-right slick-right"></div>',
                    prevArrow: '<div class="fa fa-angle-left slick-left"></div>',
                }
            }],
        asNavFor: '.ticket__carousel'
    });

});