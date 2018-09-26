<?php
/*
Plugin Name: Виды ремонта
Plugin URI: http://storenet.altervista.org/
Plugin update URI: storenet.altervista.org/
Description: repair_types
Version: 1.0.0
Author: Ivan Orlov - evan4mc@gmail.com
Author URI: http://storenet.altervista.org/
Short Name: repair_types
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
function repair_types_install() {
    filter_import_sql(__DIR__ . "/assets/model/install.sql");
}
osc_register_plugin(osc_plugin_path(__FILE__), 'repair_types_install');

/**
 * (hook: uninstall) Make un-installation operations
 * It destroys the database schema and unsets some preferences.
 * @returns void.
 */
function repair_types_uninstall() {
    filter_import_sql(__DIR__ . "/assets/model/uninstall.sql");
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'repair_types_uninstall');

function repair_types() {
    require 'views/web/show.php';
}
function menu_admin_repair_types() {
    osc_add_admin_submenu_page('plugins', __('Виды ремонта', 'repair_types'), osc_admin_render_plugin_url("repair_types/views/admin/admin.php"), 'repair_types', 'administrator');
}

osc_add_hook('admin_menu_init', 'menu_admin_repair_types');