<?php
/*
Plugin Name: Наши преимущества
Plugin URI: http://storenet.altervista.org/
Plugin update URI: http://storenet.altervista.org/
Description: advantages
Version: 1.0.0
Author: Ivan Orlov - evan4mc@gmail.com
Author URI: http://storenet.altervista.org/
Short Name: advantages
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
function advantages_install() {
    filter_import_sql(__DIR__ . "/assets/model/install.sql");
}
osc_register_plugin(osc_plugin_path(__FILE__), 'advantages_install');

/**
 * (hook: uninstall) Make un-installation operations
 * It destroys the database schema and unsets some preferences.
 * @returns void.
 */
function advantages_uninstall() {
    filter_import_sql(__DIR__ . "/assets/model/uninstall.sql");
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'advantages_uninstall');

function advantages() {
    require 'views/web/show.php';
}
function advantages_admin_menu() {
    osc_add_admin_submenu_page('plugins', __('Наши преимущества', 'advantages'), osc_admin_render_plugin_url("advantages/views/admin/admin.php"), 'advantages', 'administrator');
}

osc_add_hook('admin_menu_init', 'advantages_admin_menu');