$(document).ready(function () {

    "use strict";
    var nav = $('.menu__list'),
        tel = $('#tel'),
        name = $('#name'),
        ftel = $('#ftel'),
        fname = $('#fname'),
        fmsg = $('.main-contact__textarea'),
        oname = $('#oname'),
        otel = $('#otel'),
        oaddress = $('#oaddress'),
        ocost = $('#ocost'),
        odesc = $('#odesc'),
        oadd = $('#oadd'),
        nameReg = /^[a-zа-я ]{2,}$/i,
        nameTooltip = "Имя должно начинаться с буквы.",
        phoneReg = /^[+#*\(\)\[\]]*([0-9][ ext+-pw#*\(\)\[\]]*){7,15}$/,
        phoneTooltip = "Номер должен быть более 6 цифр",
        emptyTooltip = "Заполните поле",
        res = $('.popup__res');

    function errorField(o, tooltip) {
        if ($(o).next(".popup__error").length === 0) {
            $("<span class='popup__error'>" + tooltip + "</span>").insertAfter(o);
        }
        return false;
    }

    function checkEmpty(o, tooltip) {
        if (!o.val() || o.val() === $(o).attr('placeholder')) {
            errorField(o, tooltip);
        } else {
            $(o).siblings("span").remove();
            return true;
        }
    }

    function checkReg(o, regexp, tooltip) {
        if (!(regexp.test(o.val())) || o.val() === $(o).attr('placeholder')) {
            errorField(o, tooltip);
        } else {
            $(o).siblings("span").remove();
            return true;
        }
    }

    //menu
    $('.mobile').click(function (e) {
        nav.slideToggle();
        e.preventDefault();
    });
    $(window).on("load resize", function () {
        if ($(document).width() > 768) {
            nav.show();
        } else {
            nav.hide();
        }
    });

    //заказать звонок
    $('.popup__callback').on('submit', function (e) {

        // name of our custom ajax hook
        var ajax_hook = 'order_call';

        // build axjxa url
        var url = mySite.base_url + '?page=ajax&action=runhook&hook=' + ajax_hook + '&' + mySite.csrf_token;

        var fValid;
        fValid = true;
        fValid = fValid && checkReg(name, nameReg, nameTooltip);
        fValid = fValid && checkReg(tel, phoneReg, phoneTooltip);

        if (fValid) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: url,
                data: $(this).serializeArray()
            }).done(function (data) {
                if (data.status) {
                    $.magnificPopup.open({
                        items: {
                            src: '#result-success',
                            type: 'inline'
                        },
                        removalDelay: 300
                    });
                } else {
                    output(false);
                }
                $('.popup__callback')[0].reset();
            }).fail(function () {
                output(false);
            });
        }
        e.preventDefault();
    });

    function output(data) {
        if (data) {
            res.find('i').removeClass('popup__errors').addClass('popup__success').end().find('span').text('Заявка отправлена');
        } else {
            res.find('i').removeClass('popup__success').addClass('popup__errors').end().find('span').text('Призошла ошибка. Попробуйте снова');
        }
    }
    function clearres() {
        res.find('i').removeClass('popup__errors popup__success').end().find('span').text('');

    }
    //Оставьте заявку
    $('.main-contact__form').on('submit', function (e) {

        // name of our custom ajax hook
        var ajax_hook = 'feedback';

        // build axjxa url
        var url = mySite.base_url + '?page=ajax&action=runhook&hook=' + ajax_hook + '&' + mySite.csrf_token;

        var fValid;
        fValid = true;
        console.log(ftel.val());
        fValid = fValid && checkReg(ftel, phoneReg, phoneTooltip);
        fValid = fValid && checkReg(fname, nameReg, nameTooltip);
        fValid = fValid && checkEmpty(fmsg, emptyTooltip);
        if (fValid) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: url,
                data: $(this).serializeArray()
            }).done(function (data) {
                if (data.status) {
                    $.magnificPopup.open({
                        items: {
                            src: '#result-success',
                            type: 'inline'
                        },
                        removalDelay: 300
                    });
                } else {
                    output(false);
                }
                $('.main-contact__form')[0].reset();
            }).fail(function () {
                output(false);
            });
        }

        e.preventDefault();
    });

    //modals

    $('.callback').magnificPopup({
        midClick: true, // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        callbacks: {
            close: function() {
                clearres();
            }
        }
    });

    var popup__caption_services = $('.popup__caption_services'),
        popup__text = $('.popup__text');

    $('.preimushchestva__item').find('a').on('click', function (e) {
        var title = $(this).text();

        $(this).next().show().find('.popup__caption_services').text(title);

        e.preventDefault();
    });
    $('.preimushchestva__close').on('click', function (e) {
        $(this).closest('.preimushchestva__content').hide();
        e.preventDefault();
    });
   /* magnificPopup({
        delegate: 'a',
        midClick: true, // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        callbacks: {
            open: function () {

                var caption = this.st.el.context.innerText,
                    text = $(this.st.el).next('.preimushchestva__content').html();
                popup__caption_services.html(caption);
                popup__text.html(text);
            }
        }
    });*/

    //scroll to
    $('.menu__item a').on('click',function(e) {
        var destination,
            root;
        destination = $(e.target).attr('href');
        root = destination.split("#");
        function action(des) {
            $('html, body').animate({
                scrollTop: $(des).offset().top
            }, 1500);
        }
        action(destination);

        e.preventDefault();
    });


    $('.remont__link').on('click', function (e) {
        var parent = $(this).parent();
        parent.hide();
        parent.next().show();

        e.preventDefault();
    });
    $('.remont__back').on('click', function (e) {
        var parent = $(this).closest('ul');
        parent.hide();
        parent.prev().show();
        e.preventDefault();
    });

    /*
     * category accordion
     * */
    var allPanels = $('.popular-question__item'),
        parentPanels = $('.popular-question__list .popular-question__parent');

    $(parentPanels).on('click', function(e) {
        if(!$(this).closest('li').hasClass('popular-question__parent_active')){
            allPanels.slideUp();
            parentPanels.removeClass('popular-question__parent_active');
            $(this).closest('li').next().slideDown();
        }
        $(this).closest('li').addClass('popular-question__parent_active');
        e.preventDefault();
    });
});