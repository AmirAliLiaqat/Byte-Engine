<?php
/**
 * Plugin Name: BB Plugin
 * Plugin URI: https://amir.bytebunch.com/plugins
 * Author: Byte Ki Duniya
 * Author URI: https://amir.bytebunch.com
 * Description: That plugin which is used for multi purposes like(Custom Forms, Custom Post Types, Live Chat, Word and Character Count etc).
 * Version: 1.0.0
 * License: GPL v2 or Later
 * Text Domain: bb_plugin
 */

/****************************** Create constant to avoid to direct access *********************************/
if(!defined('ABSPATH')) {
    die();
}

/****************************** Create constant for plugin directory path *********************************/
if(!defined('PLUGIN_PATH')) {
    define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));
}

/****************************** Create constant for plugin directory url *********************************/
if(!defined('PLUGIN_URL')) {
    define('PLUGIN_URL', plugin_dir_url( __FILE__ ));
}

/****************************** Create constant for plugin directory basename *********************************/
if(!defined('PLUGIN')) {
    define('PLUGIN', plugin_basename( __FILE__ ));
}