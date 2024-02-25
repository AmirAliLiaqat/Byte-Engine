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
    public function __construct() {
        // Actions hooks
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_styles_scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_styles_scripts') );
        add_action( 'admin_menu', array($this, 'main_dashboard') );
        add_action( 'admin_init', array( $this, 'all_pages_settings' ) );
        add_action( 'init', array( $this, 'create_custom_post_types' ) );
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_custom_widget' ) );
        
        // Filters hooks
        add_filter( 'the_content', array( $this, 'live_chat_frontend' ) );

        // Activation hook
        register_activation_hook(__FILE__, array($this, 'create_custom_pages'));

        // Deactivation hook
        register_deactivation_hook(__FILE__, array($this, 'remove_custom_pages'));

        // Shortcode hooks
        add_shortcode('register_form', 'byte_engine_register_form');
        add_shortcode('login_form', 'byte_engine_login_form');
        add_shortcode('profile_page', 'byte_engine_profile_form');
    }

    /****************************** Register new widgets for elementor *********************************/
    public function register_custom_widget( $widgets_manager ) {
        require_once( __DIR__ . '/widgets/hello-world-widget.php' );
    
        $widgets_manager->register_widget_type( new Elementor_Hello_World_Widget() );
    }

    /****************************** Add custom page on plugin activation *********************************/
    public function create_custom_pages() {
        $pages = array(
            'login' => array(
                'title' => 'Login',
                'shortcode' => '[login_form]',
            ),
            'register' => array(
                'title' => 'Register',
                'shortcode' => '[register_form]',
            ),
            'profile' => array(
                'title' => 'Profile',
                'shortcode' => '[profile_page]',
            ),
        );
    
        foreach ($pages as $slug => $page) {
            $page_check = get_page_by_path($slug);
            if (!$page_check) {
                // Insert a shortcode block with the provided shortcode
                $content = '<!-- wp:shortcode -->';
                $content .= $page['shortcode'];
                $content .= '<!-- /wp:shortcode -->';
    
                $page_id = wp_insert_post(array(
                    'post_title' => $page['title'],
                    'post_content' => $content,
                    'post_status' => 'publish',
                    'post_type' => 'page',
                    'post_name' => $slug,
                ));
            }
        }
    }    

    /****************************** Remove custom page on plugin deactivation *********************************/
    public function remove_custom_pages() {
        $pages = array('login', 'register', 'profile');

        foreach ($pages as $slug) {
            $page = get_page_by_path($slug);
            if ($page) {
                wp_delete_post($page->ID, true);
            }
        }
    }

    /****************************** Callback function for register form shortcode *********************************/
    public function byte_engine_register_form() {
        // ob_start();
        require_once PLUGIN_PATH . 'forms/register.php';
        // return ob_get_clean();
    }

    /****************************** Callback function for login form shortcode *********************************/
    public function byte_engine_login_form() {
        // ob_start();
        require_once PLUGIN_PATH . 'forms/login.php';
        // return ob_get_clean();
    }

    /****************************** Callback function for profile page shortcode *********************************/
    public function byte_engine_profile_form() {
        // ob_start();
        require_once PLUGIN_PATH . 'forms/profile.php';
        // return ob_get_clean();
    }

    /****************************** Enqueue all styles and scripts *********************************/
    function enqueue_styles_scripts() {
        wp_enqueue_style('byte-engine-style', PLUGIN_URL . 'assets/css/style.css');
        wp_enqueue_style('byte-engine-bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    
        wp_enqueue_script('byte-engine-script', PLUGIN_URL . 'assets/js/script.js', array('jquery'), null, true);
        wp_enqueue_script('byte-engine-bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true);
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
            add_submenu_page( 'byte_engine', 'Byte Word Count', 'Word Count', 'manage_options', 'word_count', array($this, 'word_count_html') );
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
        require_once PLUGIN_PATH . 'template/custom-post-type.php';
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
            <div style="background: #F0F0F0; color: #000; margin: 10px 0; padding: 10px 20px; border-radius: 5px;">
                <h3 style="border-bottom: 1px solid #000; padding-bottom: 10px;">' .get_option('byte_headline', 'Post Statistics'). '</h3>
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