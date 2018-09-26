function set_session(city) {
    // name of our custom ajax hook
    var ajax_hook = 'session_set';

    // build axjxa url
    var url = mySite.base_url + '?page=ajax&action=runhook&hook=' + ajax_hook;


    $.post(url, {'city': city}, function (data) {
        city = data.city;
        cityId = data.cityId;
    });
}
$(document).ready(function () {

    "use strict";
    var city,
        cityId,
        nav = $('.menu__list'),
        citySelect = $('#city-select'),
        tel = $('#tel'),
        name = $('#name'),
        ftel = $('#ftel'),
        fname = $('#fname'),
        fmsg = $('.main-contact__textarea'),
        oname = $('#oname'),
        otel = $('#otel'),
        select = $('.popup__select'),
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

    // name of our custom ajax hook
    var ajax_hook = 'session_get';
    // build axjxa url
    var url = mySite.base_url + '?page=ajax&action=runhook&hook=' + ajax_hook;

    $.post(url, function (data) {
        city = data.city;
        cityId = data.cityId;


        if (!city) {
            $('.city-detect__city').text('Сургут');
            city = 'Сургут';
            cityId = 409054;
            ymaps.ready(init);
        } else {
            if ($('#city-select').lemght) {
                var selectize = $('#city-select')[0].selectize;
                $('.city-detect__city').text(city);
                if (cityId) {

                    if ($('#city-select').length) {
                        if (filter_get['city']) {
                            cityId = filter_get['city'];
                        }
                        selectize.setValue(cityId);
                    }
                } else {
                    selectize.setValue('409054');
                }
            }


        }
    });

    function init() {
        ymaps.geolocation.get({
            // Зададим способ определения геолокации
            // на основе ip пользователя.
            provider: 'yandex',
            // Включим автоматическое геокодирование результата.
            autoReverseGeocode: true
        }).then(function (result) {
            // Выведем результат геокодирования.
            var geo = result.geoObjects.get(0).properties.get('metaDataProperty'),
                cityget = geo.GeocoderMetaData.Address.formatted;

            if (geo) {
                if (!selectize.search(cityget).total) {
                    cityget = 'Сургут';
                }
                $('.city-detect__city').text(cityget);
                set_session(cityget);

            } else {
                cityget = 'Сургут';
                $('.city-detect__city').text(cityget);
                set_session(cityget);
            }
        });
    }

    var $select_init = $('.city-detect__select').selectize({
        create: true,
        onChange: selectChangeCity
    });

    function selectChangeCity(val) {
        var selectizeControl = $select_init[0].selectize;

        if (val) {
            if (citySelect) {
                var selectize = citySelect[0].selectize;
                selectize.setValue(val);
            }

            var something = selectizeControl.getItem(selectizeControl.getValue());

            $('.city-detect__city').text(something.text());
            set_session(something.text());
            selectizeControl.clear();
        }
        selectizeControl.blur();
    }

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

    function checkCost(o, tooltip) {
        if (!o.val() || o.val() === $(o).attr('placeholder') || o.val() < 100) {
            errorField(o, tooltip);
        } else {
            $(o).siblings("span").remove();
            return true;
        }
    }

    function checkSelect(o, tooltip) {
        if (!o.val() || o.val() === $(o).attr('placeholder')) {
            if ($('.selectize-dropdown').next(".popup__error").length === 0) {
                $("<span class='popup__error'>" + tooltip + "</span>").insertAfter($('.popup__order .selectize-dropdown'));
            }
            return false;
        } else {
            $('.selectize-dropdown').siblings("span").remove();
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
            }).error(function () {
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
            }).error(function () {
                output(false);
            });
        }

        e.preventDefault();
    });

    $('.popup__order').on('submit', function (e) {


        // name of our custom ajax hook
        var ajax_hook = 'submit_application';

        // build axjxa url
        var url = mySite.base_url + '?page=ajax&action=runhook&hook=' + ajax_hook + '&' + mySite.csrf_token;

        var fValid;
        fValid = true;
        fValid = fValid && checkReg(oname, nameReg, nameTooltip);
        fValid = fValid && checkReg(otel, phoneReg, phoneTooltip);
        fValid = fValid && checkSelect(select, emptyTooltip);
        fValid = fValid && checkEmpty(oaddress, emptyTooltip);
        fValid = fValid && checkCost(ocost, emptyTooltip);
        fValid = fValid && checkEmpty(odesc, emptyTooltip);
        fValid = fValid && checkEmpty(oadd, emptyTooltip);
        if (fValid) {
            var data = $(this).serializeArray();
            data.push({name: 'select', value: select.val()});
            $.ajax({
                dataType: "json",
                type: "POST",
                url: url,
                data: data
            }).done(function (data) {
                if (data.status) {
                    $.magnificPopup.open({
                        items: {
                            src: '#result-success',
                            type: 'inline'
                        },
                        removalDelay: 300
                    });
                    $('.popup__res').text('Заявка отправлена');
                } else {
                    $('.popup__res').text('Призошла ошибка. Попробуйте снова');
                }
                //$('.popup__order')[0].reset();
            }).error(function () {
                $('.popup__res').text('Призошла ошибка. Попробуйте снова');
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

    //console.log($('table tr').length);
    select.selectize({
        create: true
    });
});