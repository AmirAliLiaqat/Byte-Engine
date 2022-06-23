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
        $link = get_option( 'bb_chat_link' );
        $number = get_option( 'bb_chat_label' );
        $bb_live_chat_div = '<div class="bb_live_chat_div">';
        $bb_live_chat_link = '<a href="'.$link.$number.'" class="chat_wrap"></a>';
        $bb_live_chat_div_end = '</div>';

        $content .= $bb_live_chat_div;
        $content .= $bb_live_chat_link;
        $content .= $bb_live_chat_div_end;
        
        if( is_main_query() AND is_single() AND 
        (
            get_option('wc_wordcount', '1') OR 
            get_option('wc_charactercount', '1') OR 
            get_option('wc_readtime', '1')
        ) ) {
            return $this->create_html($content);
        }

        return $content;
    }

    /******************************* Creating new function for Statistics html ************************************/
    function create_html($content) {
        $html = '
            <div style="background:#ccc; margin:10px; padding:20px; font-style:italic;">
                <h3 style="border-bottom:1px solid #000; padding-bottom:10px;">' .get_option('wc_headline', 'Post Statistics'). '</h3>
                    <p>';

                    // get word count once because both wordcount and read time will need it.
                    if(get_option('wc_wordcount', '1') OR get_option('wc_readtime', '1')) {
                        $wordcount = str_word_count(strip_tags($content));
                    }

                    if(get_option('wc_wordcount', '1')) {
                        $html .= 'This post has ' . $wordcount . ' words.</br>';
                    }

                    if(get_option('wc_charactercount', '1')) {
                        $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.</br>';
                    }

                    if(get_option('wc_readtime', '1')) {
                        $html .= 'This post will take about ' . round($wordcount/255) . ' minute(s) to read.</br>';
                    }

        $html .= '</p></div>';

        if(get_option('wc_location', '0') == '0') {
            return $html . $content;
        }
        return $content . $html;
    }

    /****************************** Callback function for Word Count option page *********************************/
    function cpt_html() {
        require_once 'template/custom-pots-type.php';
    }

    /****************************** settings, sections and fields for all pages *********************************/
    function settings() {

        /****************************** settings, sections and fields for live chat page *********************************/
        add_settings_section( 'bb_live_setting_section', null, null,'bb_live_setting' );

        register_setting( 'bb_live_setting', 'bb_chat_link' );
        add_settings_field( 'chat_link', 'Chat Link', array($this, 'chat_link_cb'), 'bb_live_setting', 'bb_live_setting_section' );

        register_setting( 'bb_live_setting', 'bb_chat_label' );
        add_settings_field( 'phone_number', 'Phone Number', array($this, 'phone_number_cb'), 'bb_live_setting', 'bb_live_setting_section' );

        /****************************** settings, sections and fields for word count page *********************************/
        add_settings_section( 'wc_first_section', null, null, 'word_count_settings' );

        add_settings_field( 'wc_location', 'Display Location', array($this, 'location_html'), 'word_count_settings', 'wc_first_section' );
        register_setting( 'wordCount', 'wc_location', array('sanitize_callback' => array($this, 'sanitize_location'), 'default' => '0') );

        add_settings_field( 'wc_headline', 'Headline Text', array($this, 'headline_html'), 'word_count_settings', 'wc_first_section' );
        register_setting( 'wordCount', 'wc_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics') );

        add_settings_field( 'wc_wordcount', 'Word count', array($this, 'wordcount_html'), 'word_count_settings', 'wc_first_section' );
        register_setting( 'wordCount', 'wc_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );

        add_settings_field( 'wc_charactercount', 'Character count', array($this, 'charactercount_html'), 'word_count_settings', 'wc_first_section' );
        register_setting( 'wordCount', 'wc_charactercount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );

        add_settings_field( 'wc_readtime', 'Read time', array($this, 'readtime_html'), 'word_count_settings', 'wc_first_section' );
        register_setting( 'wordCount', 'wc_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );

    }

    /****************************** Callback functios for live chat page *********************************/
    /****************************** Callback function for chat_link *********************************/
    function chat_link_cb() {
        $link = get_option('bb_chat_link');
        echo '<input type="text" name="bb_chat_link" value="'.$link.'">';
    }

    /****************************** Callback function for phone_number *********************************/
    function phone_number_cb() {
        $number = get_option('bb_chat_label');
        echo '<input type="text" name="bb_chat_label" value="'.$number.'">';
    }

    /******************************* Callback functions for word count page ************************************/
    /******************************* Callback function for wc_location field ************************************/
    function location_html() { ?>
        <select name="wc_location">
            <option value="0" <?php selected( get_option('wc_location'), '0' ) ?>>Beginning of post</option>
            <option value="1" <?php selected( get_option('wc_location'), '1' ) ?>>End of post</option>
        </select>
    <?php }

    /******************************* Callback function for wc_location sanitize_callback ************************************/
    function sanitize_location($input) {
        if($input != '0' AND $input != '1') {
            add_settings_error( 'wc_location', 'wc_location_error', 'Display location must be either beginning or end...' );
            return get_option('wc_location');
        }
        return $input;
    }

    /******************************* Callback function for wc_headline field ************************************/
    function headline_html() { ?>
        <input type="text" name="wc_headline" value="<?php echo esc_attr(get_option('wc_headline')); ?>">
    <?php }

    /******************************* Callback function for wc_wordcount field ************************************/
    function wordcount_html() { ?>
        <input type="checkbox" name="wc_wordcount" value="1" <?php checked(get_option('wc_wordcount'), '1'); ?>>
    <?php }

    /******************************* Callback function for wc_charactercount field ************************************/
    function charactercount_html() { ?>
        <input type="checkbox" name="wc_charactercount" value="1" <?php checked(get_option('wc_charactercount'), '1'); ?>>
    <?php }

    /******************************* Callback function for wc_readtime field ************************************/
    function readtime_html() { ?>
        <input type="checkbox" name="wc_readtime" value="1" <?php checked(get_option('wc_readtime'), '1'); ?>>
    <?php }

}
$bbPlugin = new BBPlugin();
?>