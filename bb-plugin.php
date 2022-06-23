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

        add_filter( "plugin_action_links_" . PLUGIN, array( $this, 'settings_links' ) );

        add_action( 'admin_menu', array($this, 'main_page') );

        add_filter( "the_content", array( $this, 'chat_html' ) );

        add_action( "admin_init", array( $this, 'settings' ) );
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

    /****************************** Callback function for adding settings links *********************************/
    function settings_links($links) {
        $settings =  '<a href="admin.php?page=bb_plugin">Settings</a>';
        array_push( $links, $settings );
        return $links;
    }

    /****************************** Adding new pages *********************************/
    function main_page() {
        add_options_page( 'Word Count Settings', 'Word Count', 'manage_options', 'word_count_settings', array($this, 'menu_page_html') );
        add_menu_page( 'BB Plugin', 'BB Plugin', 'manage_options', 'bb_plugin', array($this, 'main_page_html'), PLUGIN_URL . 'assets/img/icon.png', 110 );
        add_submenu_page( 'bb_plugin', 'Dashboard', 'Dashboard', 'manage_options', 'bb_plugin', null);
        add_submenu_page( 'bb_plugin', 'BB Live Chat', 'Live Chat', 'manage_options', 'live_chat', array($this, 'live_chat_html') );
        add_submenu_page( 'bb_plugin', 'BB CPT', 'CPT Manager', 'manage_options', 'cpt_manager', array($this, 'cpt_html') );
    }

    /******************************* Callback function for menu page ************************************/
    function menu_page_html() {
        require_once 'template/word-count.php';
    }

    /****************************** Callback function for BB Plugin *********************************/
    function main_page_html() {
        require_once PLUGIN_PATH . 'template/admin.php';
    }

    /****************************** Callback function for live chat *********************************/
    function live_chat_html() {
        require_once 'template/live-chat.php';
    }

    /****************************** Function for live chat page html *********************************/
    function chat_html( $content ) {
        $number = get_option( 'bb_chat_label' );
        $bb_live_chat_div = '<div class="bb_live_chat_div">';
        $bb_live_chat_link = '<a href="https://web.whatsapp.com/send?phone='.$number.'" class="chat_wrap"></a>';
        $bb_live_chat_div_end = '</div>';

        $content .= $bb_live_chat_div;
        $content .= $bb_live_chat_link;
        $content .= $bb_live_chat_div_end;

        return $content;
    }

    /****************************** Callback function for Word Count option page *********************************/
    function cpt_html() {
        require_once 'template/custom-pots-type.php';
    }

    /****************************** settings, sections and fields for all pages *********************************/
    function settings() {

        /****************************** settings, sections and fields for live chat page *********************************/
        register_setting( 'bb_live_setting', 'bb_chat_label' );
        add_settings_section( 'bb_live_setting_section', null, null,'bb_live_setting' );
        add_settings_field( 'phone_number', 'Phone Number', array($this, 'phone_number_cb'), 'bb_live_setting', 'bb_live_setting_section' );

    }

    /****************************** Callback functios for live chat page *********************************/
    /****************************** Callback function for phone_number *********************************/
    function phone_number_cb() {
        $number = get_option('bb_chat_label');
        echo '<input type="text" name="bb_chat_label" value="'.$number.'">';
    }

}
$bbPlugin = new BBPlugin();
?>