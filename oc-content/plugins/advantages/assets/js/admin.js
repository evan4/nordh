(function () {
    "use strict";
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

        var id = (data_districts.find('tbody tr').length + 1) ? (data_districts.find('tbody tr').length + 1) : 1;

        if (fValid) {
            var formData = new FormData();

            formData.append('title', title.val());
            formData.append('description', $('#description').val());
            formData.append('orderliness', id);

            $.each(that.find("input[type=file]"), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    formData.append('photo[]', file);
                })
            });
            $.ajax({
                url: mySiteAdmin.ajax_add_url,
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#filter-submit').prop("disabled", true);
                }
            })
                .done(function (data) {
                    if (data.status === true) {
                        appendTable(data);

                        toastr.info('Данные добавлены');
                    } else {
                        toastr.error('Произошла ошибка');
                    }
                    $('#filter-submit').prop("disabled", false);
                    that.slideToggle();
                    $(filter_form_add)[0].reset();

                })
                .fail(function () {
                    toastr.error('Произошла ошибка');
                    $('#filter-submit').prop("disabled", false);
                    that.slideToggle();
                    $(filter_form_add)[0].reset();
                });

            $('#filter-submit').prop("disabled", false);
        }

        e.preventDefault();
    });

    filter_form_edit.on('submit', function (e) {

        var that = $(this),
            fValid = true;
        var id = title_edit.val();

        fValid = fValid && (title_edit.length > 0 );

        if (fValid) {
            var formData = new FormData();

            formData.append('id', $('#id').val());
            formData.append('title', title_edit.val());
            formData.append('description', $('#description_edit').val());
            formData.append('orderliness', $('#order_edit').val());

            $.each(that.find("input[type=file]"), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    formData.append('photo[]', file);
                })
            });
            $.ajax({
                url: mySiteAdmin.ajax_update_url,
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#filter-submit').prop("disabled", true);
                }
            }).done(function (data) {
                if (data.status === true) {
                    var el = $('#filter-form-' + data.id);
                    if(data.image){

                            var src = el.data('src'),
                            image = data.image,
                            arr = '';

                        if (src.slice(-1) === ',') {
                            src = src.slice(0, -1);
                        }
                        image.forEach(function (p1) {
                            if (p1 !== '') {
                                arr = arr + ',' + p1;
                            }
                        });
                        var newsrc = src + arr;

                        el.data('src', newsrc);
                    }

                    el.find('td:eq(0)').text(data.title);
                    el.find('td:eq(1)').text(data.description);
                    el.find('td:eq(2)').text(data.orderliness);
                    toastr.info('Данные изменены');
                } else {
                    toastr.error('Произошла ошибка');
                }

            }).fail(function () {
                toastr.error('Произошла ошибка');
            });
            $('#filter-submit').prop("disabled", false);

            $(filter_form_add)[0].reset();
        }

        e.preventDefault();
    });

    function appendTable(data) {
        var len = data_districts.find('tbody tr').length + 1;

        data_districts.find('tbody').append('\
                        <tr id="filter-form-' + data.id + '" ' +
            'data-src="' + data.avatar + '">\
                        <td>' + data.title + '</td>\
                        <td>' + data.description + '</td>\
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
            orderliness = that.closest('tr').find('td:eq(2)').text(),
            images = (that.closest('tr').data('src')).split(',');

        $('#title_edit').attr('value', title);
        $('#description_edit').val(description);
        $('#order_edit').attr('value', orderliness);
        $('#id').val(id);
        $('#images').empty();
        images.forEach(function (p1, p2, p3) {
            if (p1 !== '') {
                $('#images').append('<li><img src="/oc-content/uploads/advantages/' + p1 + '" class="img-responsive"><i data-name="' + p1 + '" class="glyphicon glyphicon-remove text-danger image-name"></i></li>');
            }
        });

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
                    filter_form_edit.slideUp();
                    toastr.info('Запись удалена');
                } else {
                    toastr.error('Произошла ошибка');
                }
            }).fail(function () {
                toastr.error('Произошла ошибка');
            });
        }

    });

    //dekete image
    $(document).delegate('.image-name', 'click', function () {
        var that = $(this),
            name = that.data('name');

        if (name !== '') {

            var data = {
                'name': name
            };

            $.ajax({
                data: data,
                context: that,
                url: mySiteAdmin.ajax_delete_img
            }).done(function (data) {
                if (data.status === true) {
                    that.parent('li').remove();

                    var tr = $('#filter-form-' + $('#id').val());
                    tr.data('src', '');

                    toastr.info('Фото удалено');
                } else {
                    toastr.error('Произошла ошибка');
                }
            }).fail(function () {
                toastr.error('Произошла ошибка');
            });

        }
    });

})();