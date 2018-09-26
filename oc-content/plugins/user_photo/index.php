<?php
/*
Plugin Name: User Photo
Plugin URI: http://storenet.altervista.org/
Description: Allows users to upload a profile picture
Version: 1.0.0
Author: Ivan Orlov - evan4mc@gmail.com
Author URI: http://storenet.altervista.org/
Short Name: user_photo
*/

function user_photo_install() {
    $conn = getConnection();
    $conn->autocommit(false);
    try {
        $path = osc_plugin_resource('user_photo/struct.sql');
        $sql = file_get_contents($path);
        $conn->osc_dbImportSQL($sql);
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
}
osc_register_plugin(osc_plugin_path(__FILE__), 'user_photo_install');

function user_photo_uninstall() {
    $conn = getConnection();
    $conn->autocommit(false);
    try {
	$conn->osc_dbExec('DROP TABLE %st_user_photo', DB_TABLE_PREFIX);
	$conn->commit();
	} catch (Exception $e) {
	    $conn->rollback();
	    echo $e->getMessage();
	}
    $conn->autocommit(true);
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'user_photo_uninstall');
