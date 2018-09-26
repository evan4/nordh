$(document).ready(function () {

    "use strict";
    var city,
        select = $('.filter-form__select'),
        sPriceMin = $('#sPriceMin'),
        sPriceMax = $('#sPriceMax'),
        filter_form = $('.filter-form'),
        rooms = $('#rooms'),
        total_name = $('.filter__name'),
        total_num = $('.filter__num'),
        label_div = $('.filter-form__input_div');

    $('.tooltip').tooltipster({
        animation: 'fade',
        delay: 20,
        theme: 'tooltipster-light',
        trigger: 'click',
        side: 'bottom',
        interactive: true,
        multiple: true,
        selfDestruction: false
    });

    //Общая площадь
    var  area_label = $('.filter-form__arealabel'),
        input_area = $('.filter-form__area');

    var area_slider = $('#area-slider').slider({
        range: true,
        orientation: 'horizontal',
        handle: 'square',
        tooltip: 'hide'
    }).on('slide', function (ev) {
        var area = area_slider.val(),
            arr = area.split(',');

        container.eq(0).text(arr[0]);
        container.eq(1).text(arr[1]);

        input_area.eq(0).attr('value',arr[0]);
        input_area.eq(1).attr('value',arr[1]);

        area_label.text(arr[0]+' - '+arr[1])
            .parent().css('color', '#303030');
    });

    var container = $('#tooltip_area').find('.slider-handle'),
        arr_slider = area_slider.data('slider-value');

    if(input_area.eq(0).val() !== ''){
        arr_slider[0] = input_area.eq(0).val();
        if(input_area.eq(1).val() !== ''){
            arr_slider[1] = input_area.eq(1).val();
        }
        area_label.text(arr_slider[0]+' - '+arr_slider[1])
            .parent().css('color', '#303030');

    }else if(input_area.eq(1).val() !== ''){
        arr_slider[1] = input_area.eq(1).val();
        area_label.text(arr_slider[0]+' - '+arr_slider[1])
            .parent().css('color', '#303030');
    }

    container.eq(0).text(arr_slider[0]);
    container.eq(1).text(arr_slider[1]);


    //Этажей в доме
    var  floors_label = $('.filter-form__floorslabel'),
        input_floors = $('.filter-form__floors');

    var floors_slider = $('#floors-slider').slider({
        range: true,
        orientation: 'horizontal',
        handle: 'square',
        tooltip: 'hide'
    }).on('slide', function (ev) {
        var area = floors_slider.val(),
            arr = area.split(',');

        container_floors.eq(0).text(arr[0]);
        container_floors.eq(1).text(arr[1]);

        input_floors.eq(0).attr('value',arr[0]);
        input_floors.eq(1).attr('value',arr[1]);

        floors_label.text(arr[0]+' - '+arr[1] + ' эт.')
            .parent().css('color', '#303030');
    });

    var container_floors = $('#tooltip_floors').find('.slider-handle'),
        arr_slider_floors = floors_slider.data('slider-value');

    if(input_floors.eq(0).val() !== ''){
        arr_slider_floors[0] = input_floors.eq(0).val();
        if(input_floors.eq(1).val() !== ''){
            arr_slider_floors[1] = input_floors.eq(1).val();
        }
        floors_label.text(arr_slider_floors[0]+' - '+arr_slider_floors[1])
            .parent().css('color', '#303030');

    }else if(input_floors.eq(1).val() !== ''){
        arr_slider_floors[1] = input_floors.eq(1).val();
        floors_label.text(arr_slider_floors[0]+' - '+arr_slider_floors[1])
            .parent().css('color', '#303030');

    }

    container_floors.eq(0).text(arr_slider_floors[0]);
    container_floors.eq(1).text(arr_slider_floors[1]);


    //Этаж
    var  floor_label = $('.filter-form__floorlabel'),
        input_floor = $('.filter-form__floor');

    var floor_slider = $('#floor-slider').slider({
        range: true,
        orientation: 'horizontal',
        handle: 'square',
        tooltip: 'hide'
    }).on('slide', function (ev) {
        var area = floor_slider.val(),
            arr = area.split(',');

        container_floor.eq(0).text(arr[0]);
        container_floor.eq(1).text(arr[1]);

        input_floor.eq(0).attr('value',arr[0]);
        input_floor.eq(1).attr('value',arr[1]);

        floor_label.text(arr[0]+' - '+arr[1] + ' эт.')
            .parent().css('color', '#303030');
    });

    var container_floor = $('#tooltip_floor').find('.slider-handle'),
        arr_slider_floor = floor_slider.data('slider-value');

    if(input_floor.eq(0).val() !== ''){
        arr_slider_floor[0] = input_floor.eq(0).val();
        if(input_floor.eq(1).val() !== ''){
            arr_slider_floor[1] = input_floor.eq(1).val();
        }
        floor_label.text(arr_slider_floor[0]+' - '+arr_slider_floor[1])
            .parent().css('color', '#303030');

    }else if(input_floor.eq(1).val() !== ''){
        arr_slider_floor[1] = input_floor.eq(1).val();
        floor_label.text(arr_slider_floor[0]+' - '+arr_slider_floor[1])
            .parent().css('color', '#303030');

    }

    container_floor.eq(0).text(arr_slider_floor[0]);
    container_floor.eq(1).text(arr_slider_floor[1]);

    $('.checkbox-checkbox-7igZ6').on('click', function (e) {

       $(this).toggleClass('checkbox-root_set-kXGxt');

       var id = $(this).find('input').attr('value');

       $('#'+id+'').prop('checked', function(_, checked) {
           return !checked;
       });
       var rooms = '';

        $('.filter-form__romms').find('input:checked').each(function () {
            var v = $(this).attr('value');
            if( v == 121){
                rooms += 'Студии, ';
            }else{
                rooms += $(this).attr('value')+', ';
            }
        });
        if(rooms.slice(-1) == ' '){
            rooms =rooms.slice(0,-1);
            if(rooms.slice(-1) == ','){
                rooms =rooms.slice(0,-1);
            }
        }
       $('.filter-form__roomslabel').text(rooms).css('color', '#303030');

       e.preventDefault();
    });


    $('#project').selectize({
        create: true,
        dropdownParent: 'body',
        allowEmptyOption: true,
        onChange: function (val) {

        }
    });

    var $city = $('#city-select').selectize({
        create: true,
        dropdownParent: 'body',
        allowEmptyOption: true,
        onChange: function (val) {

            if (val) {
                console.log(val);
                /*
                 var selectize1 = $residential[0].selectize;
                 selectize1.clearOptions();

                 $.ajax({
                 url: mySiteAdmin.ajax_residential_url,
                 data: {'parent': new_value}
                 }).done(function (data) {
                 if (data) {
                 var dist = data.res;
                 if (dist) {
                 dist.forEach(function (p1, p2, p3) {
                 selectize1.addOption({
                 text: String(p1.s_name),
                 value: Number(p1.pk_i_id)
                 });
                 });
                 }
                 }
                 });

                 var selectize2 = $districts[0].selectize;
                 selectize2.clearOptions();

                 $.ajax({
                 url: mySiteAdmin.ajax_districts_url,
                 data: {'parent': new_value}
                 }).done(function (data) {
                 if (data) {
                 var dist = data.res;
                 if (dist) {
                 dist.forEach(function (p1, p2, p3) {
                 selectize2.addOption({
                 text: String(p1.s_name),
                 value: Number(p1.pk_i_id)
                 });
                 });
                 }
                 }
                 });*/
            }
        }
    });

    if (!$.isEmptyObject(filter_get)) {

        if (filter_get['category'] > 0) {
            var selectizeControl = $('#category')[0].selectize;
            selectizeControl.setValue(filter_get['category']);
        }
        if (filter_get['city'] > 0) {
            var selectizeControl1 = $city[0].selectize;
            selectizeControl1.setValue(filter_get['city']);
        }
    }

    //console.log(select.length);

    filter_form.on('reset', function () {

        var selectize = $(this).find('.selectize-input'),
            len = selectize.length;

        for (var i = 0; i < len; i++) {
            var selectize1 = select[i].selectize;

            selectize1.clear();
        }

        filter_form.find("input[type=text], input[type=number]").attr('value', "");

        var arr_slider = area_slider.data('slider-value');
        area_slider.slider('setValue', arr_slider);

        area_slider.prev().prev().find('.slider-handle').eq(0).text(arr_slider[0])
            .end().eq(1).text(arr_slider[1]);

        var arr_slider_floors = floors_slider.data('slider-value');
        floors_slider.slider('setValue', arr_slider_floors);
        floors_slider.prev().prev()
            .find('.slider-handle').eq(0).text(arr_slider_floors[0])
            .end().eq(1).text(arr_slider_floors[1]);

        var arr_slider_floor = floor_slider.data('slider-value');
        floor_slider.slider('setValue', arr_slider_floor);
        floor_slider.prev().prev()
            .find('.slider-handle').eq(0).text(arr_slider_floor[0])
            .end().eq(1).text(arr_slider_floor[1]);

        label_div.css('color', '#999');

        label_div.each(function(){
            var that =  $(this);

            that.find('span').text(that.find('span').data('text'))
        });

        $('.multi-select-multi-select-list-27ff9').find('label').removeClass('checkbox-root_set-kXGxt');

    });

    // residential and districs

    /*  var $residential = $('#residential').selectize({
     create: true,
     dropdownParent: 'body',
     allowEmptyOption: true
     });

     var $districts = $('#districts').selectize({
     create: true,
     dropdownParent: 'body',
     allowEmptyOption: true
     });*/

    /* $('#category').selectize({
     create: true,
     dropdownParent: 'body',
     allowEmptyOption: true,
     onChange: function (val) {
     switch (val) {
     case '121':
     rooms.next().hide();
     total_name.text('квартир-студий');
     break;
     case '101':
     rooms.next().show();
     total_name.text('квартир');
     break;
     default:
     rooms.next().show();
     total_name.text('квартир');
     }
     total_num = total_item_by_cat(val);
     }
     });

    function total_item_by_cat(id) {

        $.ajax({
            url: mySiteAdmin.ajax_cat_url,
            data: {'id': id}
        }).done(function (data) {
            if (data) {
                return data;
            } else {
                return null;
            }
        }).error(function () {
            return null;
        });
    }
     */
});