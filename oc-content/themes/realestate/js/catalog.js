$(document).ready(function () {

    "use strict";

    var $select_sort = $('.page__sort').selectize({
        create: true,
        dropdownParent: 'body',
        onChange: selectChange
    });

    function selectChange(val) {
        var sort = val.split('-');

        console.log(sort);

        window.location ='/catalog-p30?orderby='+sort[0]+'&dir='+sort[1];
    }
});