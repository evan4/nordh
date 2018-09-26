(function () {
    // Как только будет загружен API и готов DOM, выполняем инициализацию
    ymaps.ready(init);

    function init() {
        // Создание экземпляра карты и его привязка к контейнеру с
        // заданным id ("map")
        var myMap = new ymaps.Map('map', {
            // При инициализации карты, обязательно нужно указать
            // ее центр и коэффициент масштабирования
            center: [61.251945, 73.400174],
            zoom: 16,
            controls: []
        });

        var myPlacemark = new ymaps.Placemark(
            // Координаты метки
            [61.251945, 73.400174], {}, {
                // Опции
                // Иконка метки будет растягиваться под ее контент
                preset: 'islands#redCircleIcon',
                balloonOptions: {
                    maxWidth: 70,
                    hasCloseButton: true,
                    mapAutoPan: 0
                }
            });

            myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
                hintContent: 'ООО НОРД ХАУС КОМПАНИ',
                balloonContent: 'Это красивая метка'
            }, {
            }),

            myMap.geoObjects
                .add(myPlacemark)


        // Добавление метки на карту
        myMap.geoObjects.add(myPlacemark);

        myMap.behaviors.disable('scrollZoom');

        myMap.container.fitToViewport();
    }

})();