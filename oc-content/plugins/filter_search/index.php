<?php
/*
Plugin Name: Фильтр поиска
Plugin URI: http://storenet.altervista.org/
Plugin update URI: storenet.altervista.org/
Description: filter search
Version: 1.0.0
Author: Ivan Orlov - evan4mc@gmail.com
Author URI: http://storenet.altervista.org/
Short Name: filter_search
*/

/*
 * ==========================================================================
 *  LOADING
 * ==========================================================================
 */

require_once __DIR__ . "/oc-load.php";
/*
 * ==========================================================================
 * INSTALL / UNINSTALL
 * ==========================================================================
 */

/**
 * (hook: install) Make installation operations
 * It creates the database schema and sets some preferences.
 * @returns void.
 */
function filter_search_install() {

    filter_import_sql(__DIR__ . "/assets/model/install.sql");
}
osc_register_plugin(osc_plugin_path(__FILE__), 'filter_search_install');

/**
 * (hook: uninstall) Make un-installation operations
 * It destroys the database schema and unsets some preferences.
 * @returns void.
 */
function filter_search_uninstall() {
    filter_import_sql(__DIR__ . "/assets/model/unnstall.sql");
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'filter_search_uninstall');

function filter_search() {
    require 'views/web/show.php';
}
function filter_admin_menu() {

    osc_add_admin_submenu_divider('plugins', __('Фильтр поиска', 'filter_search'), 'filter_search', 'administrator');
    osc_add_admin_submenu_page('plugins', __('Жилой комплекс', 'filter_search'), osc_admin_render_plugin_url("filter_search/views/admin/residential_complex.php"), 'filter_residential_complex', 'administrator');
    osc_add_admin_submenu_page('plugins', __('Районы', 'filter_search'), osc_admin_render_plugin_url("filter_search/views/admin/districts.php"), 'filter_districts', 'administrator');
}

osc_add_hook('admin_menu_init', 'filter_admin_menu');