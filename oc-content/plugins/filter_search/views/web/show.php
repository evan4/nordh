<?php
$filter_search = [];

$item = Params::getParamsAsArray();

$filter_search['address'] = htmlspecialchars($item['address']);


$filter_search['category'] = intval($item['sCategory']);

$filter_search['city'] = intval($item['sCity']);

$filter_search['sPriceMin'] = intval($item['sPriceMin']);

$filter_search['sPriceMax'] = intval($item['sPriceMax']);

$filter_search['areaMin'] = intval($item['areaMin']);
$filter_search['areaMax'] = intval($item['areaMax']);

$filter_search['floorsMin'] = intval($item['floorsMin']);
$filter_search['floorsMax'] = intval($item['floorsMax']);

$filter_search['floorMin'] = intval($item['floorMin']);
$filter_search['floorMax'] = intval($item['floorMax']);

$filter_search['rooms-0'] = intval($item['rooms-0']);
$filter_search['rooms-1'] = intval($item['rooms-1']);
$filter_search['rooms-2'] = intval($item['rooms-2']);
$filter_search['rooms-3'] = intval($item['rooms-3']);
$filter_search['rooms-4'] = intval($item['rooms-4']);
$filter_search['rooms-5'] = intval($item['rooms-5']);
$filter_search['rooms-6'] = intval($item['rooms-6']);
$filter_search['rooms-7'] = intval($item['rooms-7']);
$filter_search['rooms-8'] = intval($item['rooms-8']);
$filter_search['rooms-9'] = intval($item['rooms-9']);

$text = '';

$text .= $filter_search['rooms-0']==121 ? 'Студии, ' : '';
$text .= $filter_search['rooms-1']==1 ? '1, ' : '';
$text .= $filter_search['rooms-2']==2 ? '2, ' : '';
$text .= $filter_search['rooms-3']==3 ? '3, ' : '';
$text .= $filter_search['rooms-4']==4 ? '4, ' : '';
$text .= $filter_search['rooms-5']==5 ? '5, ' : '';
$text .= $filter_search['rooms-6']==6 ? '6, ' : '';
$text .= $filter_search['rooms-7']==7 ? '7, ' : '';
$text .= $filter_search['rooms-8']==8 ? '8, ' : '';
$text .= $filter_search['rooms-8']==9 ? '9, ' : '';

switch ($item['sCategory']) {
    case '121':
        $filter_name = 'квартир-студий';
        $filter_total = CategoryStats::newInstance()->countItemsFromCategory('121');
        break;
    case '101':
        $filter_name = 'квартир';
        $filter_total = CategoryStats::newInstance()->countItemsFromCategory('101');
        break;
    default:
        $filter_name = 'квартир';
        $filter_total = CategoryStats::newInstance()->countItemsFromCategory('101');
}
//var_dump($filter_search);

?>
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/css/libs/tooltipster.bundle.css"
      type="text/css">
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/css/libs/tooltipster-sideTip-light.min.css"
      type="text/css">
<link rel="stylesheet" href="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/css/libs/slider.css"
      type="text/css">
<link rel="stylesheet" href="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/css/filter_search.css"
      type="text/css">
<script type="text/javascript">

    var filter_get = [];
    <?php if(!osc_is_home_page()){ ?>
    filter_get['category'] = '<?= $filter_search['category']; ?>';
    filter_get['city'] = '<?= $filter_search['city']; ?>';

    <?php } ?>

</script>

<section class="filter">
    <div class="wrap">
        <!--        <p class="caption caption_small">фильтр поиска</p>-->
        <form action="/search/" method="get" class="filter-form">
            <ul class="filter-form__list filter-form__list_top clearfix">
                <li class="filter-form__item">
                    <select class="filter-form__select" name="city" id="city-select"
                            data-placeholder="Город"
                            data-live-search="true">
                        <option value=""></option>
                        <option value="409054">Сургут</option>
                        <?php
                        /*                        foreach (getAllCities() as $city) { */ ?><!--
                            <option value="<? /*= $city['pk_i_id'] */ ?>"><? /*= $city['s_name'] */ ?></option>
                        --><?php /*} */ ?>
                    </select>
                </li>
                <li class="filter-form__item filter-form__item_addr">
                    <input class="filter-form__input filter-form__input_full filter-form__input_address clearfix"
                           type="text"
                           name="address"
                           placeholder="Поиск по адресу"
                           value="<?= $filter_search['address']; ?>">
                </li>
            </ul>

            <ul class="filter-form__list">
                <!--<li class="filter-form__item filter-form__item_wide">
                    <select class="filter-form__select" name="category" id="category"
                            data-placeholder="Вид объекта"
                            data-live-search="true">
                        <?php /*foreach (osc_get_categories() as $cat) { */ ?>
                            <?php /*if ($cat['pk_i_id'] == '96') { */ ?>
                                <option class="filter-form__parent"
                                        value="<? /*= $cat['pk_i_id']; */ ?>" selected><? /*= $cat['s_name']; */ ?></option>
                            <?php /*} else { */ ?>
                                <option class="filter-form__parent"
                                        value="<? /*= $cat['pk_i_id']; */ ?>"><? /*= $cat['s_name']; */ ?></option>
                            <?php /*} */ ?>
                            <?php /*if (count($cat['categories']) > 0) { */ ?>
                                <?php /*foreach ($cat['categories'] as $sub) { */ ?>
                                    <option class="filter-form__child"
                                            value="<? /*= $sub['pk_i_id']; */ ?>"><? /*= $sub['s_name']; */ ?></option>
                                <?php /*} */ ?>
                            <?php /*} */ ?>
                        <?php /*} */ ?>
                    </select>
                </li>-->

                <li class="filter-form__item">
                    <div class="filter-form__input filter-form__input_full
                    filter-form__input filter-form__input_div tooltip
                    " data-tooltip-content="#tooltip_area">
                        <span class="filter-form__arealabel"
                              data-text="Общая площадь,">Общая площадь,</span> м<sup>2</sup>
                    </div>
                    <input class="filter-form__area"
                           type="number" name="areaMin"
                           value="<?= $filter_search['areaMin'] > 0 ? $filter_search['areaMin'] : ''; ?>"
                           id="areaMin" placeholder="Площадь от" hidden>
                    <input class="filter-form__area"
                           type="number" name="areaMax"
                           value="<?= $filter_search['areaMax'] > 0 ? $filter_search['areaMax'] : ''; ?>"
                           id="areaMax" placeholder="до, кв. м." hidden>
                </li>

                <li class="filter-form__item">
                    <input class="filter-form__input " type="number" name="sPriceMin"
                           id="sPriceMin"
                           value="<?= $filter_search['sPriceMin'] > 0 ? $filter_search['sPriceMin'] : ''; ?>"
                           min="5000" placeholder="Цена от">
                    <input class="filter-form__input" type="number" name="sPriceMax"
                           id="sPriceMax"
                           value="<?= $filter_search['sPriceMax'] > 0 ? $filter_search['sPriceMax'] : ''; ?>"
                           min="5000" placeholder="до, руб.">
                </li>
                <!--<li class="filter-form__item">
                    <select class="filter-form__select" name="project" id="project"
                            data-placeholder="Проект"
                            data-live-search="true">
                    </select>
                </li>-->

                <!--<li class="filter-form__item">
                    <select class="filter-form__select" name="residential" id="residential"
                            data-placeholder="Жилой комплекс"
                            data-live-search="true">
                    </select>
                </li>
                <li class="filter-form__item">
                    <select class="filter-form__select" name="districts" id="districts"
                            data-placeholder="Район"
                            data-live-search="true">
                    </select>
                </li>-->
                <li class="filter-form__item">
                    <div class="filter-form__input filter-form__input_full
                    filter-form__input filter-form__input_div tooltip
                    " data-tooltip-content="#tooltip_floors">
                        <span class="filter-form__floorslabel"
                              data-text="Этажей в доме">Этажей в доме</span>
                    </div>
                    <input class="filter-form__floors"
                           type="number" name="floorsMin"
                           value="<?= $filter_search['floorsMin'] > 0 ? $filter_search['floorsMin'] : ''; ?>"
                           id="floorsMin" hidden>
                    <input class="filter-form__floors"
                           type="number" name="floorsMax"
                           value="<?= $filter_search['floorsMax'] > 0 ? $filter_search['floorsMax'] : ''; ?>"
                           id="floorsMax" hidden>
                </li>
                <li class="filter-form__item">
                    <div class="filter-form__input filter-form__input_full
                    filter-form__input filter-form__input_div tooltip
                    " data-tooltip-content="#tooltip_floor">
                    <span class="filter-form__floorlabel"
                          data-text="Этаж">Этаж</span>
                    </div>
                    <input class="filter-form__floor"
                           type="number" name="floorMin"
                           value="<?= $filter_search['floorMin'] > 0 ? $filter_search['floorMin'] : ''; ?>"
                           id="floorMin" hidden>
                    <input class="filter-form__floor"
                           type="number" name="floorMax"
                           value="<?= $filter_search['floorMax'] > 0 ? $filter_search['floorMax'] : ''; ?>"
                           id="floorMax" hidden>
                </li>
                <li class="filter-form__item">
                    <div class="filter-form__input filter-form__input_full
                    filter-form__input filter-form__input_div tooltip
                    " data-tooltip-content="#tooltip_rooms">
                    <span class="filter-form__roomslabel"
                          data-text="Количество комнат">
                        <?php if($text == '') {
                            echo 'Количество комнат';
                        } else{
                            echo $text;
                        } ?></span>
                    </div>
                    <div class="filter-form__romms" hidden>

                        <input type="checkbox" name="rooms-0" value="121" id="rooms-0"
                            <?php echo ($filter_search['rooms-0']===121 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-1" value="1" id="rooms-1"
                            <?php echo ($filter_search['rooms-1']===1 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-2" value="2" id="rooms-2"
                            <?php echo ($filter_search['rooms-2']===2 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-3" value="3" id="rooms-3"
                            <?php echo ($filter_search['rooms-3'] === 3 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-4" value="4" id="rooms-4"
                            <?php echo ($filter_search['rooms-4']===4 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-5" value="5" id="rooms-5"
                            <?php echo ($filter_search['rooms-5']===5 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-6" value="6" id="rooms-6"
                            <?php echo ($filter_search['rooms-6']===6 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-7" value="7" id="rooms-7"
                            <?php echo ($filter_search['rooms-7']===7 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-8" value="8" id="rooms-8"
                            <?php echo ($filter_search['rooms-8']===8 ? 'checked' : ''); ?>>

                        <input type="checkbox" name="rooms-9" value="9" id="rooms-9"
                            <?php echo ($filter_search['rooms-9']===9 ? 'checked' : ''); ?>>
                    </div>
                </li>
                <li class="filter-form__item">

                </li>
            </ul>
            <div class="filter-form__bottom clearfix">
                <p class="filter__total">Всего <span class="filter__name"><?= $filter_name; ?></span>
                    в продаже <a href="/gorodskaya-nedvizhimost/kvartiry" class="filter__num"><?= $filter_total; ?></a>
                </p>
                <div class="filter-form__block">
                    <input class="button button_green button_border" type="submit" value="Применить фильтр">
                    <input class="button button_white filter-form__reset" type="reset" value="Очистить фильтр">
                </div>
            </div>

        </form>
    </div>
</section>
<div class="tooltip_templates">
    <span id="tooltip_area">
        <input id="area-slider" type="text" value=""
               data-slider-min="10" data-slider-max="200"
               data-slider-step="5" data-slider-value="[20,100]">
    </span>
</div>
<div class="tooltip_templates">
    <span id="tooltip_floors">
        <input id="floors-slider" type="text" value=""
               data-slider-min="1" data-slider-max="31"
               data-slider-step="1" data-slider-value="[5,9]">
    </span>
</div>
<div class="tooltip_templates">
    <span id="tooltip_floor">
        <input id="floor-slider" type="text" value=""
               data-slider-min="1" data-slider-max="31"
               data-slider-step="1" data-slider-value="[1,9]">
    </span>
</div>
<div class="tooltip_templates">
    <span id="tooltip_rooms">
        <ul class="multi-select-multi-select-list-27ff9 multi-select-list_colon-3-2wEtD">
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-0']===121 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-0" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">Студия</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-1']===1 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-1" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">1 комната</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-2']===2 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-2" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">2 комнаты</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-2']===3 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-3" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">3 комнаты</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-4']===4 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-4" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">4 комнаты</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-5']===5 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-5" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">5 комнат</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-6']===6 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-6" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">6 комнат</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-7']===7 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-7" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">7 комнат</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-8']===8 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-8" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">8 комнат</span>
                </label>
            </li>
            <li>
                <label class="checkbox-checkbox-7igZ6 checkbox-root-2fc3G
                    <?php echo ($filter_search['rooms-9']===9 ? ' checkbox-root_set-kXGxt' : ''); ?>">
                    <input type="checkbox" value="rooms-9" class="checkbox-input-3KD6i">
                    <span class="checkbox-label-3AzRS">9 комнат</span>
                </label>
            </li>
        </ul>
    </span>
</div>
<script>
    //here we hold some usefull info for easy access
    var mySiteAdmin = window.mySiteAdmin || {};
    mySiteAdmin.ajax_residential_url = '<?php echo osc_ajax_plugin_url('filter_search/helpers/residential/menu_ajax_get.php'); ?>';
    mySiteAdmin.ajax_districts_url = '<?php echo osc_ajax_plugin_url('filter_search/helpers/districts/menu_ajax_get.php'); ?>';
    mySiteAdmin.ajax_cat_url = '<?php echo osc_ajax_plugin_url('filter_search/helpers/public.php'); ?>';

    mySiteAdmin.csrf_token = '<?php echo osc_csrf_token_url(); ?>';
</script>
<script src="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/js/libs/tooltipster.bundle.min.js"></script>
<script src="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/js/libs/bootstrap-slider.js"></script>
<script src="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/js/filter_search.js"></script>