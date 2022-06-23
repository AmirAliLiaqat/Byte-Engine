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

/****************************** Creating main class for whole plugin *********************************/
class BBPlugin {

    /****************************** Function for adding all actions and filters *********************************/
    function __construct() {
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue') );
    }
    
    /****************************** Enqueue all styles and scripts *********************************/
    function enqueue() {
        wp_enqueue_style( 'bb-plugin-style', PLUGIN_URL . 'assets/css/style.css' );
        wp_enqueue_style( 'bb-plugin-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );

        wp_enqueue_script( 'bb-plugin-script', PLUGIN_URL . 'assets/js/script.js', 'jquery' );
        wp_enqueue_script( 'popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js' );
        wp_enqueue_script( 'bootstrap-min', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js' );
        wp_enqueue_script( 'bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' );
    }

}
$bbPlugin = new BBPlugin();
?>