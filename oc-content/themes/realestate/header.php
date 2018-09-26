<?php
/*
 *      Osclass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2013 Osclass
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <?php
    if (osc_is_search_page()) {
        if (osc_count_items() == 0) {
            osc_add_filter('meta_robots', 'meta_robots_custom');
            function meta_robots_custom()
            {
                return 'noindex, nofollow';
            }
        }
    }; ?>
    <meta name="robots" content="<?php echo osc_apply_filter('meta_robots', 'index, follow'); ?>"/>
    <meta name="googlebot" content="<?php echo osc_apply_filter('meta_robots', 'index, follow'); ?>"/>
	<meta name="mailru-domain" content="dpzxBW0rYGI2FnyG" />
</head>
<body>

<?php if (osc_get_preference('header-728x90', 'realestate') != '') { ?>
    <!-- header ad 728x60-->
    <div style="width: 728px; height: 120px; margin-left: auto;margin-right: auto;">
        <?php echo osc_get_preference('header-728x90', 'realestate'); ?>
    </div>
    <!-- /header ad 728x60-->
<?php } ?>
<?php osc_show_flash_message(); ?>
<!-- header -->
<div class="city-detect clearfix">
    <div class="wrap">
        <div class="city-detect__text">
            <span>Ваш город</span>
            <span class="city-detect__city"></span>
        </div>
        <div class="city-detect__block">
            <select class="city-detect__select"
                    name="city"
                    data-live-search="true">
                <option value="">сменить город</option>
                <option value="409054">Сургут</option>
                <?php
/*                foreach (getAllCities() as $city) {  */?><!--
                    <option value="<?/*= $city['pk_i_id'] */?>"><?/*= $city['s_name']*/?></option>
                --><?php /*} */?>
            </select>
        </div>

    </div>
</div>

<header class="header clearfix">
    <div class="wrap">
        <div class="header-logo">
            <?php echo logo_header(); ?>
            <p class="header__motto">Измени жизнь к лучшему!</p>
        </div>
        <div class="header__right">
            <div class="header__top clearfix">
                <div class="header__info">
                    <a class="header__tel" href="tel:+73462771077">+7 (3462) 77-10-77</a>
                    <a class="header__order callback" href="#callback">Заказать звонок</a>
                </div>
                <div class="header__information">
                    <span class="header__addr">г. Сургут, пр. Ленина, д.21, 4 эт., каб.425 </span>
                    <a class="header__email" href="mailto:77-10-77@mail.ru">77-10-77@mail.ru</a>
                </div>

            </div>
            <div class="header__application">
                <a href="#order" id="form_publish"
                   class="button button_green button_border callback">Подать заявку</a>
            </div>
        </div>
    </div>
</header>
<!-- /header -->

<?php if (function_exists(main_menu)) {
    echo main_menu();
} ?>

<!-- container -->
<?php if (osc_is_home_page()) { ?>
<div class="main main_home">
    <?php }else{ ?>
    <div class="main">
        <?php } ?>
        <?php
        if (osc_is_search_page() || osc_is_home_page() || Params::getParam('slug') == 'catalog') {
            if (function_exists(filter_search)) {
                echo filter_search();
            }
        } ?>
        <div class="wrap">
            <div class="breadcrumb">
                <?php breadcrumbs(''); ?>
            </div>

