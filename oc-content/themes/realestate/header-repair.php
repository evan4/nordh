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
    <?php osc_current_web_theme_path('head-repair.php'); ?>
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

<header class="header clearfix">
    <div class="wrap">
        <a href="/" class="header-logo header-logo_repair">
            <p class="header-logo__name">NordHouse</p>
            <p class="header-logo__sub">строительная компания</p>
        </a>
        <div class="header__right header__right_repair">
            <ul class="header__top header__top_repair clearfix">
                <li>
                    <a class="" href="mailto:77-10-77@mail.ru">Email: 77-10-77@mail.ru</a>
                </li>
                <li>
                    <a class="" href="tel:+73462771077">+7 (3462) 77-10-77</a>
                </li>
                <li>
                    <a class="header__order header__order_repair  callback" href="#callback">Заказать звонок</a>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- /header -->

<?php if (function_exists(main_menu_repair)) { ?>
<nav class="menu menu_repair clearfix">
    <div class="wrap">
        <a class="mobile" href="#"><span class="fa fa-bars"></span></a>
        <ul class="menu__list menu__list_repair">
    <?php echo main_menu_repair(); ?>
        </ul>
    </div>
</nav>

<?php } ?>

<!-- container -->

    <div class="main">

