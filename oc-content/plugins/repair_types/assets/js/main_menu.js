(function () {

    var
        title = $('#title'),
        title_edit = $('#title_edit'),
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


    // form new
    filter_form_add.on('submit', function (e) {
        var that = $(this),
            fValid = true;

        fValid = fValid && (title.length > 0 );
        var data = $(this).serializeArray(),
            id = (data_districts.find('tbody tr').length + 1) ? (data_districts.find('tbody tr').length + 1) : 1;
        data.push({name: 'orderliness', value: id});

        if (fValid) {

            $.ajax({
                url: mySiteAdmin.ajax_add_url,
                data: data,
                beforeSend: function () {
                    $('#filter-submit').prop("disabled", true);
                }
            }).done(function (data) {
                if (data.status === true) {
                    appendTable(data);
                    toastr.info('Данные добавлены');
                } else {
                    toastr.error('Произошла ошибка');
                }
            }).fail(function () {
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
            fValid = true;

        fValid = fValid && (title_edit.length > 0 );

        if (fValid) {

            $.ajax({
                url: mySiteAdmin.ajax_update_url,
                data: $(this).serializeArray(),
                beforeSend: function () {
                    $('#filter-submit').prop("disabled", true);
                }
            }).done(function (data) {
                if (data.status === true) {
                    var el =  $('#filter-form-' + data.id);
                    el.find('td:eq(0)').text(data.title);
                    el.find('td:eq(1)').text(data.description);
                    el.find('td:eq(2)').text(data.description_list);
                    el.find('td:eq(3)').text(data.orderliness);

                    toastr.info('Данные изменены');
                } else {
                    toastr.error('Произошла ошибка');
                }
            }).fail(function () {
                toastr.error('Произошла ошибка');
            });
            $('#filter-submit').prop("disabled", false);
            that.slideToggle();
            $(filter_form_add)[0].reset();
        }

        e.preventDefault();
    });

    function appendTable(data) {
        var len = data_districts.find('tbody tr').length + 1;

        data_districts.find('tbody').append('\
                        <tr id="filter-form-' + data.id + '">\
                        <td>' + data.title + '</td>\
                        <td>' + data.description + '</td>\
                        <td>' + data.description_list + '</td>\
                        <td>' + len + '</td>\
                        <td class="tiny"><span data-id="' + data.id + '" class="glyphicon glyphicon-edit text-info icon_edit" aria-hidden="true"></span></td>\
                        <td class="tiny"><span data-id="' + data.id + '" class="glyphicon glyphicon-remove text-danger icon_delete" aria-hidden="true"></span></td></tr>\
                        ');
    }

    // Edit icon
    $(document).delegate('.icon_edit', 'click', function () {

        var that = $(this),
            id = Number(that.data('id')),
            title = that.closest('tr').find('td:eq(0)').text(),
            description = that.closest('tr').find('td:eq(1)').text(),
            description_list = that.closest('tr').find('td:eq(2)').text(),
            orderliness = that.closest('tr').find('td:eq(3)').text();

        $('#title_edit').attr('value', title);
        $('#description_edit').attr('value', description);
        $('#description_edit_list').attr('value', description_list);
        $('#order_edit').attr('value', orderliness);
        $('#id').val(id);

        filter_form_edit.slideDown();
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
            }).fail(function () {
                toastr.error('Произошла ошибка');
            });
        }

    });
})();