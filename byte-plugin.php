<?php
/**
 * Plugin Name: Byte Engine
 * Plugin URI: https://byte.likesyou.org/plugins
 * Author: Byte Ki Duniya
 * Author URI: https://byte.likesyou.org
 * Description: That plugin which is used for multi purposes like(Custom Forms, Custom Post Types, Live Chat, Word and Character Count etc).
 * Version: 1.0.0
 * License: GPL v2 or Later
 * Text Domain: byte_engine
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
class ByteEngine {
    /****************************** Function for adding all actions and filters *********************************/
    function __construct() {
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue') );

        add_action( 'admin_menu', array($this, 'main_dashboard') );

        add_action( 'admin_init', array( $this, 'all_pages_settings' ) );

        add_action( 'init', array( $this, 'create_custom_post_types' ) );

        add_filter( 'the_content', array( $this, 'live_chat_frontend' ) );
    }

    /****************************** Enqueue all styles and scripts *********************************/
    function enqueue() {
        wp_enqueue_style( 'byte-engine-style', PLUGIN_URL . 'assets/css/style.css' );
        wp_enqueue_style( 'byte-engine-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );

        wp_enqueue_script( 'byte-engine-script', PLUGIN_URL . 'assets/js/script.js', 'jquery' );
        wp_enqueue_script( 'byte-engine-popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js' );
        wp_enqueue_script( 'byte-engine-bootstrap-min', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js' );
        wp_enqueue_script( 'byte-engine-bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' );
    }

    /****************************** Adding new pages *********************************/
    function main_dashboard() {
        add_menu_page( 'Byte Engine', 'Byte Engine', 'manage_options', 'byte_engine', array($this, 'main_dashboard_html'), PLUGIN_URL . 'assets/img/icon.png', 110 );
        add_submenu_page( 'byte_engine', 'Dashboard', 'Dashboard', 'manage_options', 'byte_engine', null);

        if(get_option('byte_chat') == '1') {
            add_submenu_page( 'byte_engine', 'Byte Live Chat', 'Live Chat', 'manage_options', 'live_chat', array($this, 'live_chat_html') );
        }

        if(get_option('byte_cpt') == '1') {
            add_submenu_page( 'byte_engine', 'Byte CPT', 'CPT Manager', 'manage_options', 'cpt_manager', array($this, 'cpt_html') );
        }

        if(get_option('byte_wordcount') == '1') {
            add_options_page( 'byte_engine', 'Byte Word Count', 'Word Count', 'manage_options', 'word_count', array($this, 'word_count_html') );
        }
    }

    /****************************** Callback function for Byte Engine *********************************/
    function main_dashboard_html() {
        require_once PLUGIN_PATH . 'template/dashboard.php';
    }

    /****************************** Callback function for live chat *********************************/
    function live_chat_html() {
        require_once PLUGIN_PATH . 'template/live-chat.php';
    }

    /****************************** Callback function for custom post type *********************************/
    function cpt_html() {
        require_once PLUGIN_PATH . 'template/custom-pots-type.php';
    }

    /******************************* Callback function for word count ************************************/
    function word_count_html() {
        require_once PLUGIN_PATH . 'template/word-count.php';
    }

    /****************************** settings, sections and fields for all pages *********************************/
    function all_pages_settings() {
        /****************************** settings, sections and fields for main page *********************************/
        require_once PLUGIN_PATH . 'inc/dasboard-settings.php';

        /****************************** settings, sections and fields for live chat page *********************************/
        require_once PLUGIN_PATH . 'inc/live-chat-page-settings.php';

        /****************************** settings, sections and fields for word count page *********************************/
        require_once PLUGIN_PATH . 'inc/word-count-page-settings.php';
        
        /****************************** settings, sections and fields for custom post type page *********************************/
        require_once PLUGIN_PATH . 'inc/cpt-page-settings.php';
    }

    /****************************** Function for adding custom post types *********************************/
    function create_custom_post_types() {
        require_once PLUGIN_PATH . 'inc/creating-cpts.php';
    }

    /****************************** Function for live chat page html *********************************/
    function live_chat_frontend( $content ) {
        $link = get_option( 'byte_chat_link' );
        $number = get_option( 'byte_chat_number' );
        $byte_live_chat_div = '<div class="byte_live_chat_div">';
        $byte_live_chat_link = '<a href="'.$link.$number.'" class="chat_wrap"></a>';
        $byte_live_chat_div_end = '</div>';

        $content .= $byte_live_chat_div;
        $content .= $byte_live_chat_link;
        $content .= $byte_live_chat_div_end;
        
        if( is_main_query() && is_single() && ( get_option('byte_wordcount', '1') || get_option('byte_charactercount', '1') || get_option('byte_readtime', '1') ) ) {
            return $this->word_count_frontend($content);
        }

        return $content;
    }

    /******************************* Creating new function for Statistics html ************************************/
    function word_count_frontend($content) {
        $html = '
            <div style="background: #F0F0F0; color: #000; margin: 10px 0; padding:20px; border-radius: 5px;">
                <h3 style="border-bottom:1px solid #000; padding-bottom:10px;">' .get_option('byte_headline', 'Post Statistics'). '</h3>
                    <p>';
                        // get word count once because both wordcount and read time will need it.
                        if(get_option('byte_post_wc', '1') OR get_option('byte_readtime', '1')) {
                            $wordcount = str_word_count(strip_tags($content));
                        }

                        if(get_option('byte_post_wc', '1')) {
                            $html .= 'This post has ' . $wordcount . ' words.</br>';
                        }

                        if(get_option('byte_charactercount', '1')) {
                            $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.</br>';
                        }

                        if(get_option('byte_readtime', '1')) {
                            $html .= 'This post will take about ' . round($wordcount/255) . ' minute(s) to read.</br>';
                        }
        $html .= '</p></div>';

        if(get_option('byte_location', '0') == '0') {
            return $html . $content;
        }
        return $content . $html;
    }
}
$byteEngine = new ByteEngine();