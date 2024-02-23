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

        add_filter( "plugin_action_links_" . PLUGIN, array( $this, 'settings_links' ) );

        add_action( 'admin_menu', array($this, 'main_page') );

        add_filter( "the_content", array( $this, 'chat_html' ) );

        add_action( "admin_init", array( $this, 'settings' ) );

        add_action( "init", array( $this, 'cpt' ) );
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

    /****************************** Callback function for adding settings links *********************************/
    function settings_links($links) {
        $settings =  '<a href="admin.php?page=byte_engine">Settings</a>';
        array_push( $links, $settings );
        return $links;
    }

    /****************************** Adding new pages *********************************/
    function main_page() {

        if(get_option('byte_wordcount') == '1') {
            add_options_page( 'Word Count Settings', 'Word Count', 'manage_options', 'word_count_settings', array($this, 'menu_page_html') );
        }

        add_menu_page( 'Byte Engine', 'Byte Engine', 'manage_options', 'byte_engine', array($this, 'main_page_html'), PLUGIN_URL . 'assets/img/icon.png', 110 );
        add_submenu_page( 'byte_engine', 'Dashboard', 'Dashboard', 'manage_options', 'byte_engine', null);

        if(get_option('byte_chat') == '1') {
            add_submenu_page( 'byte_engine', 'Byte Live Chat', 'Live Chat', 'manage_options', 'live_chat', array($this, 'live_chat_html') );
        }

        if(get_option('byte_cpt') == '1') {
            add_submenu_page( 'byte_engine', 'Byte CPT', 'CPT Manager', 'manage_options', 'cpt_manager', array($this, 'cpt_html') );
        }
        
    }

    /******************************* Callback function for menu page ************************************/
    function menu_page_html() {
        require_once 'template/word-count.php';
    }

    /****************************** Callback function for Byte Engine *********************************/
    function main_page_html() {
        require_once PLUGIN_PATH . 'template/admin.php';
    }

    /****************************** Callback function for live chat *********************************/
    function live_chat_html() {
        require_once 'template/live-chat.php';
    }

    /****************************** Function for live chat page html *********************************/
    function chat_html( $content ) {
        $link = get_option( 'byte_chat_link' );
        $number = get_option( 'byte_chat_label' );
        $byte_live_chat_div = '<div class="byte_live_chat_div">';
        $byte_live_chat_link = '<a href="'.$link.$number.'" class="chat_wrap"></a>';
        $byte_live_chat_div_end = '</div>';

        $content .= $byte_live_chat_div;
        $content .= $byte_live_chat_link;
        $content .= $byte_live_chat_div_end;
        
        if( is_main_query() && is_single() && 
        (
            get_option('byte_wordcount', '1') || 
            get_option('byte_charactercount', '1') || 
            get_option('byte_readtime', '1')
        ) ) {
            return $this->create_html($content);
        }

        return $content;
    }

    /******************************* Creating new function for Statistics html ************************************/
    function create_html($content) {
        $html = '
            <div style="background:#ccc; margin:10px; padding:20px; font-style:italic;">
                <h3 style="border-bottom:1px solid #000; padding-bottom:10px;">' .get_option('byte_headline', 'Post Statistics'). '</h3>
                    <p>';

                    // get word count once because both wordcount and read time will need it.
                    if(get_option('byte_wordcount', '1') OR get_option('byte_readtime', '1')) {
                        $wordcount = str_word_count(strip_tags($content));
                    }

                    if(get_option('byte_wordcount', '1')) {
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

    /****************************** Callback function for Word Count option page *********************************/
    function cpt_html() {
        require_once 'template/custom-pots-type.php';
    }

    /****************************** settings, sections and fields for all pages *********************************/
    function settings() {

        /****************************** settings, sections and fields for main page *********************************/
        require_once 'inc/main-page-settings.php';

        /****************************** settings, sections and fields for live chat page *********************************/
        require_once 'inc/live-chat-page-settings.php';

        /****************************** settings, sections and fields for word count page *********************************/
        require_once 'inc/word-count-page-settings.php';
        
        /****************************** settings, sections and fields for custom post type page *********************************/
        require_once 'inc/cpt-page-settings.php';

    }

    /****************************** Callback functios for main page *********************************/
    /****************************** Callback function for byte_live_chat *********************************/
    function byte_live_chat_html() { ?>
        <input type="checkbox" name="byte_chat" value="1" <?php checked(get_option('byte_chat'), '1'); ?>>
    <?php }

    /****************************** Callback function for byte_cpt *********************************/
    function byte_cpt_html() { ?>
        <input type="checkbox" name="byte_cpt" value="1" <?php checked(get_option('byte_cpt'), '1'); ?>>
    <?php }

    /****************************** Callback function for byte_wordcount *********************************/
    function byte_wordcount_html() { ?>
        <input type="checkbox" name="byte_wordcount" value="1" <?php checked(get_option('byte_wordcount'), '1'); ?>>
    <?php }

    /****************************** Callback functios for live chat page *********************************/
    /****************************** Callback function for chat_link *********************************/
    function chat_link_cb() {
        $link = get_option('byte_chat_link');
        echo '<input type="text" name="byte_chat_link" value="'.$link.'">';
    }

    /****************************** Callback function for phone_number *********************************/
    function phone_number_cb() {
        $number = get_option('byte_chat_label');
        echo '<input type="text" name="byte_chat_label" value="'.$number.'">';
    }

    /******************************* Callback functions for word count page ************************************/
    /******************************* Callback function for byte_location field ************************************/
    function location_html() { ?>
        <select name="byte_location">
            <option value="0" <?php selected( get_option('byte_location'), '0' ) ?>>Beginning of post</option>
            <option value="1" <?php selected( get_option('byte_location'), '1' ) ?>>End of post</option>
        </select>
    <?php }

    /******************************* Callback function for byte_location sanitize_callback ************************************/
    function sanitize_location($input) {
        if($input != '0' && $input != '1') {
            add_settings_error( 'byte_location', 'byte_location_error', 'Display location must be either beginning or end...' );
            return get_option('byte_location');
        }
        return $input;
    }

    /******************************* Callback function for byte_headline field ************************************/
    function headline_html() { ?>
        <input type="text" name="byte_headline" value="<?php echo esc_attr(get_option('byte_headline')); ?>">
    <?php }

    /******************************* Callback function for byte_wordcount field ************************************/
    function wordcount_html() { ?>
        <input type="checkbox" name="byte_wordcount" value="1" <?php checked(get_option('byte_wordcount'), '1'); ?>>
    <?php }

    /******************************* Callback function for byte_charactercount field ************************************/
    function charactercount_html() { ?>
        <input type="checkbox" name="byte_charactercount" value="1" <?php checked(get_option('byte_charactercount'), '1'); ?>>
    <?php }

    /******************************* Callback function for byte_readtime field ************************************/
    function readtime_html() { ?>
        <input type="checkbox" name="byte_readtime" value="1" <?php checked(get_option('byte_readtime'), '1'); ?>>
    <?php }

    /****************************** Callback functions for custom post type page *********************************/
    /****************************** Callback function for label *********************************/
    function label_html() {
        $labels = get_option('labels'); 
    ?>
        <input type="text" name="labels" value="<?php echo $labels; ?>"></br>
        <p>Type the label of your post type...</p>
    <?php }

    /****************************** Callback function for description *********************************/
    function description_html() {
        $description = get_option('description'); 
    ?>
        <input type="text" name="description" value="<?php echo $description; ?>"></br>
        <p>Type the description of your post type...</p>
    <?php }

    /****************************** Callback function for menu_icon *********************************/
    function menu_icon_html() {
        $menu_icon = get_option('menu_icon'); 
    ?>
        <input type="text" name="menu_icon" value="<?php echo $menu_icon; ?>"></br>
        <p>Type the text of your post type menu icon...</p>
    <?php }

    /****************************** Callback function for hierarchical *********************************/
    function hierarchical_html() {
        $hierarchical = get_option('hierarchical'); 
    ?>
        <select name="hierarchical">
            <option value="0" <?php selected( get_option('hierarchical'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('hierarchical'), '1' ) ?>>False</option>
        </select>
        <p>(default: false) Not query can be performed on the front end as part of parse_request()</p>
    <?php }

    /****************************** Callback function for public *********************************/
    function public_html() {
        $public = get_option('public');
    ?>
        <select name="public">
            <option value="0" <?php selected( get_option('public'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('public'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not posts of this type should be shown in the admin UI and is publicly queryable.</p>
    <?php }

    /****************************** Callback function for publicly_queryable *********************************/
    function publicly_queryable_html() {
        $publicly_queryable = get_option('publicly_queryable');
    ?>
        <select name="publicly_queryable">
            <option value="0" <?php selected( get_option('publicly_queryable'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('publicly_queryable'), '1' ) ?>>False</option>
        </select>
        <p>(default: true) Not query can be performed on the front end as part of parse_request()</p>
    <?php }

    /****************************** Callback function for show_ui *********************************/
    function show_ui_html() {
        $show_ui = get_option('show_ui');
    ?>
        <select name="show_ui">
            <option value="0" <?php selected( get_option('show_ui'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('show_ui'), '1' ) ?>>False</option>
        </select>
        <p>(default: true) Whether or not to generate a default UI for managing this post type.</p>
    <?php }

    /****************************** Callback function for show_in_menu *********************************/
    function show_in_menu_html() {
        $show_in_menu = get_option('show_in_menu');
    ?>
        <select name="show_in_menu">
            <option value="0" <?php selected( get_option('show_in_menu'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('show_in_menu'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not this post type is available for selection in menus.</p>
    <?php }

    /****************************** Callback function for show_in_nav_menus *********************************/
    function show_in_nav_menus_html() {
        $show_in_nav_menus = get_option('show_in_nav_menus');
    ?>
        <select name="show_in_nav_menus">
            <option value="0" <?php selected( get_option('show_in_nav_menus'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('show_in_nav_menus'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not this post type is available for selection in navigation menus.</p>
    <?php }

    /****************************** Callback function for menu_position *********************************/
    function menu_position_html() {
        $menu_position = get_option('menu_position');
    ?>
        <input type="number" name="menu_position" value="<?php echo $menu_position; ?>"></br>
        <p>Type the number where you want to show your post type.</p>
    <?php }
    
    /****************************** Callback function for can_export *********************************/
    function can_export_html() {
        $can_export = get_option('can_export');
    ?>
        <select name="can_export">
            <option value="0" <?php selected( get_option('can_export'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('can_export'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not this post type you want to export or not.</p>
    <?php }
    
    /****************************** Callback function for has_archive *********************************/
    function has_archive_html() {
        $has_archive = get_option('has_archive');
    ?>
        <select name="has_archive">
            <option value="0" <?php selected( get_option('has_archive'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('has_archive'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not this post type has archives or not.</p>
    <?php }
    
    /****************************** Callback function for capability_type *********************************/
    function capability_type_html() {
        $capability_type = get_option('capability_type');
    ?>
        <select name="capability_type">
            <option value="0" <?php selected( get_option('capability_type'), '0' ) ?>>Post</option>
            <option value="1" <?php selected( get_option('capability_type'), '1' ) ?>>Page</option>
        </select>
        <p>(Custom Post Type UI default: post) Whether which post type you want to create.</p>
    <?php }
    
    /****************************** Callback function for supports *********************************/
    function supports_html() {
        $supports = get_option('supports');
    ?>
    <?php }

    /****************************** Function for adding custom post type *********************************/
    function cpt() {
        require_once 'inc/add-cpt.php';
    }

}
$byteEngine = new ByteEngine();
?>