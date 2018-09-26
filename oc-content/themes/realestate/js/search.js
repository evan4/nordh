$(document).ready(function () {

    "use strict";

    var dt_desc = $('#dt_pub_date-desc');

    var $select_sort = $('.page__sort').selectize({
        create: true,
        dropdownParent: 'body',
        onChange: selectChange
    });

    function selectChange(val) {
        console.log(val);
        var link = $("#" + val);
        link[0].click();
    }
});