<?php
/*
Plugin Name: Вопрос-ответ
Plugin URI: http://storenet.altervista.org/
Plugin update URI: storenet.altervista.org/
Description: vopros
Version: 1.0.0
Author: Ivan Orlov - evan4mc@gmail.com
Author URI: http://storenet.altervista.org/
Short Name: vopros
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
function vopros_install() {
    filter_import_sql(__DIR__ . "/assets/model/install.sql");
}
osc_register_plugin(osc_plugin_path(__FILE__), 'vopros_install');

/**
 * (hook: uninstall) Make un-installation operations
 * It destroys the database schema and unsets some preferences.
 * @returns void.
 */
function vopros_uninstall() {
    filter_import_sql(__DIR__ . "/assets/model/uninstall.sql");
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'vopros_uninstall');

function vopros() {
    require 'views/web/show.php';
}
function menu_admin_vopros() {
    osc_add_admin_submenu_page('plugins', __('Вопрос-ответ', 'vopros'), osc_admin_render_plugin_url("vopros/views/admin/admin.php"), 'vopros', 'administrator');
}

osc_add_hook('admin_menu_init', 'menu_admin_vopros');