<?php
/*
Plugin Name: Ремонт помещений
Plugin URI: http://storenet.altervista.org/
Plugin update URI: http://storenet.altervista.org/
Description: repair
Version: 1.0.0
Author: Ivan Orlov - evan4mc@gmail.com
Author URI: http://storenet.altervista.org/
Short Name: repair
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
function repair_install() {
    filter_import_sql(__DIR__ . "/assets/model/install.sql");
}
osc_register_plugin(osc_plugin_path(__FILE__), 'repair_install');

/**
 * (hook: uninstall) Make un-installation operations
 * It destroys the database schema and unsets some preferences.
 * @returns void.
 */
function repair_uninstall() {
    filter_import_sql(__DIR__ . "/assets/model/uninstall.sql");
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'repair_uninstall');

function repair() {
    require 'views/web/show.php';
}
function repair_admin_menu() {
    osc_add_admin_submenu_page('plugins', __('Ремонт помещений', 'repair'), osc_admin_render_plugin_url("repair/views/admin/admin.php"), 'repair', 'administrator');
}

osc_add_hook('admin_menu_init', 'repair_admin_menu');