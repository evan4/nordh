<?php
/*
Plugin Name: Главное меню
Plugin URI: http://storenet.altervista.org/
Plugin update URI: storenet.altervista.org/
Description: main menu
Version: 1.0.0
Author: Ivan Orlov - evan4mc@gmail.com
Author URI: http://storenet.altervista.org/
Short Name: main_menu
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
function main_menu_install() {
    filter_import_sql(__DIR__ . "/assets/model/install.sql");
}
osc_register_plugin(osc_plugin_path(__FILE__), 'main_menu_install');

/**
 * (hook: uninstall) Make un-installation operations
 * It destroys the database schema and unsets some preferences.
 * @returns void.
 */
function main_menu_uninstall() {
    filter_import_sql(__DIR__ . "/assets/model/uninstall.sql");
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'main_menu_uninstall');

function main_menu() {
    require 'views/web/show.php';
}
function menu_admin_menu() {
    osc_add_admin_submenu_page('plugins', __('Главное меню', 'main_menu'), osc_admin_render_plugin_url("main_menu/views/admin/admin.php"), 'main_menu', 'administrator');
}

osc_add_hook('admin_menu_init', 'menu_admin_menu');