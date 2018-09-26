(function () {

    var
        name = $('#name'),
        name_edit = $('#name_edit'),
        data_districts = $('#data-districts'),
        filter_form_add = $('#filter-form-add'),
        filter_form_edit = $('#filter-form_edit');

    toastr.options.closeButton = true;

    // common

    $.ajaxSetup({
        dataType: "json",
        type: "POST"
    });

    $('#add-district').on('click', function () {
        filter_form_add.slideToggle();
    });

    $('.filter-form__select').selectize({
        create: true,
        dropdownParent: 'body',
        onChange: function (val) {
            var new_value = Number(val);

            if(new_value > 0){
                name.data('parent', new_value);
                data_districts.find('tbody').empty();

                $.ajax({
                    url: mySiteAdmin.ajax_get_url,
                    data: {'parent': new_value}
                }).done(function (data) {
                    if (data) {
                        var districts = data.res;
                        if (districts) {
                            districts.forEach(function (p1, p2, p3) {
                                appendTable1(p1)
                            });
                        }
                    }

                })
            }
        }
    });


    // form new
    filter_form_add.on('submit', function (e) {
        var that = $(this),
            fValid = true,
            nameval = name.val();

        fValid = fValid && (name.length > 0 );

        if (fValid) {

            var data = {
                'name': nameval,
                'parent': name.data('parent')
            };

            $.ajax({
                url: mySiteAdmin.ajax_add_url,
                data: data,
                beforeSend: function () {
                    $('#filter-submit').prop("disabled", true);
                }
            }).done(function (data) {
                if (data.status === true) {
                    appendTable(data);
                    scrollTo($('#filter-form-' + data.id));
                    toastr.info('Данные добавлены');
                } else {
                    toastr.error('Произошла ошибка');
                }
            }).error(function () {
                toastr.error('Произошла ошибка');
            });
            $('#filter-submit').prop("disabled", false);
            that.slideToggle();
            $(filter_form_add)[0].reset();
        }

        e.preventDefault();
    });

    filter_form_edit.on('submit', function (e) {
        var that = $(this),
            fValid = true,
            nameval = name_edit.val();

        fValid = fValid && (name_edit.length > 0 );

        if (fValid) {

            var data = {
                'name': nameval,
                'id': name_edit.data('id')
            };

            $.ajax({
                url: mySiteAdmin.ajax_update_url,
                data: data,
                beforeSend: function () {
                    $('#filter-submit').prop("disabled", true);
                }
            }).done(function (data) {
                if (data.status === true) {
                    var el =  $('#filter-form-' + data.id);
                    el.find('td:eq(0)').text(data.name);
                    scrollTo(el);
                    toastr.info('Данные изменены');
                } else {
                    toastr.error('Произошла ошибка');
                }
            }).error(function () {
                toastr.error('Произошла ошибка');
            });
            $('#filter-submit').prop("disabled", false);
            that.slideToggle();
            $(filter_form_add)[0].reset();
        }

        e.preventDefault();
    });

    function appendTable(data) {
        data_districts.find('tbody').append('\
                        <tr id="filter-form-' + data.id + '">\
                        <td>' + data.name + '</td>\
                        <td class="tiny"><span data-id="' + data.id + '" class="glyphicon glyphicon-edit text-info icon_edit" aria-hidden="true"></span></td>\
                        <td class="tiny"><span data-id="' + data.id + '" class="glyphicon glyphicon-remove text-danger icon_delete" aria-hidden="true"></span></td></tr>\
                        ');
    }
    function appendTable1(data) {
        data_districts.find('tbody').append('\
                        <tr id="filter-form-' + data.pk_i_id + '">\
                        <td>' + data.s_name + '</td>\
                        <td class="tiny"><span data-id="' + data.pk_i_id + '" class="glyphicon glyphicon-edit text-info icon_edit" aria-hidden="true"></span></td>\
                        <td class="tiny"><span data-id="' + data.pk_i_id + '" class="glyphicon glyphicon-remove text-danger icon_delete" aria-hidden="true"></span></td></tr>\
                        ');
    }

    // Edit icon
    $(document).delegate('.icon_edit', 'click', function () {

        var that = $(this),
            id = that.data('id'),
            name = that.closest('tr').find('td:eq(0)').text();

        $('#name_edit').attr('value', name)
            .data('id', id);

        filter_form_edit.slideDown();
        scrollTo(filter_form_edit);
    });

    // delete
    $(document).delegate('.icon_delete', 'click', function () {

        var that = $(this),
            fValid = true,
            id = Number(that.data('id'));

        fValid = fValid && (id >= 0 );

        if (fValid) {

            var data = {
                'id': id
            };

            $.ajax({
                data: data,
                url: mySiteAdmin.ajax_delete_url
            }).done(function (data) {
                if (data.status === true) {
                    $('#filter-form-' + id).remove();

                    toastr.info('Запись удалена');
                } else {
                    toastr.error('Произошла ошибка');
                }
            }).error(function () {
                toastr.error('Произошла ошибка');
            });
        }

    });

    function scrollTo(el) {
        $('html, body').animate({
            scrollTop: el.offset().top
        }, 500);
    }

})();