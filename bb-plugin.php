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

        if(get_option('bb_wordcount') == '1') {
            add_options_page( 'Word Count Settings', 'Word Count', 'manage_options', 'word_count_settings', array($this, 'menu_page_html') );
        }

        add_menu_page( 'BB Plugin', 'BB Plugin', 'manage_options', 'bb_plugin', array($this, 'main_page_html'), PLUGIN_URL . 'assets/img/icon.png', 110 );
        add_submenu_page( 'bb_plugin', 'Dashboard', 'Dashboard', 'manage_options', 'bb_plugin', null);

        if(get_option('bb_chat') == '1') {
            add_submenu_page( 'bb_plugin', 'BB Live Chat', 'Live Chat', 'manage_options', 'live_chat', array($this, 'live_chat_html') );
        }

        if(get_option('bb_cpt') == '1') {
            add_submenu_page( 'bb_plugin', 'BB CPT', 'CPT Manager', 'manage_options', 'cpt_manager', array($this, 'cpt_html') );
        }
        
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

        /****************************** settings, sections and fields for main page *********************************/
        add_settings_section( 'bb_main_setting_section', null, null,'bb_main_setting' );

        add_settings_field( 'bb_live_chat', 'Live Chat', array($this, 'bb_live_chat_html'), 'bb_main_setting', 'bb_main_setting_section' );
        register_setting( 'bb_main_setting', 'bb_chat' );

        add_settings_field( 'bb_cpt', 'CPT Manager', array($this, 'bb_cpt_html'), 'bb_main_setting', 'bb_main_setting_section' );
        register_setting( 'bb_main_setting', 'bb_cpt' );

        add_settings_field( 'bb_wordcount', 'Word Count', array($this, 'bb_wordcount_html'), 'bb_main_setting', 'bb_main_setting_section' );
        register_setting( 'bb_main_setting', 'bb_wordcount' );

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

        /****************************** settings, sections and fields for custom post type page *********************************/
        add_settings_section( 'bb_cpt_setting_section', null, null,'bb_cpt_setting' );

        $caption = "
            <p>Add supports for various available post editor features on the right. A checked value means the post type feature is supported.</p>
            <p> Use the 'None' option to expilicitly set 'supports' to false.</p>
        ";

        register_setting( 'bb_cpt_setting', 'labels' );
        add_settings_field( 'label', 'Label', array($this, 'label_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'description' );
        add_settings_field( 'description', 'Description', array($this, 'description_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'hierarchical' );
        add_settings_field( 'hierarchical', 'Hierarchical', array($this, 'hierarchical_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'public' );
        add_settings_field( 'public', 'Public', array($this, 'public_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'publicly_queryable' );
        add_settings_field( 'publicly_queryable', 'Publicly Queryable', array($this, 'publicly_queryable_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'show_ui' );
        add_settings_field( 'show_ui', 'Show UI', array($this, 'show_ui_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'show_in_menu' );
        add_settings_field( 'show_in_menu', 'Show in menu', array($this, 'show_in_menu_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'show_in_nav_menus' );
        add_settings_field( 'show_in_nav_menus', 'Show in nav menu', array($this, 'show_in_nav_menus_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'menu_position' );
        add_settings_field( 'menu_position', 'Menu Position', array($this, 'menu_position_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'can_export' );
        add_settings_field( 'can_export', 'Can Export', array($this, 'can_export_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'has_archive' );
        add_settings_field( 'has_archive', 'Has Archive', array($this, 'has_archive_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'capability_type' );
        add_settings_field( 'capability_type', 'Capability Type', array($this, 'capability_type_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

        register_setting( 'bb_cpt_setting', 'supports' );
        add_settings_field( 'supports', 'Supports <br>'. $caption, array($this, 'supports_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

    }

    /****************************** Callback functios for main page *********************************/
    /****************************** Callback function for bb_live_chat *********************************/
    function bb_live_chat_html() { ?>
        <input type="checkbox" name="bb_chat" value="1" <?php checked(get_option('bb_chat'), '1'); ?>>
    <?php }

    /****************************** Callback function for bb_cpt *********************************/
    function bb_cpt_html() { ?>
        <input type="checkbox" name="bb_cpt" value="1" <?php checked(get_option('bb_cpt'), '1'); ?>>
    <?php }

    /****************************** Callback function for bb_wordcount *********************************/
    function bb_wordcount_html() { ?>
        <input type="checkbox" name="bb_wordcount" value="1" <?php checked(get_option('bb_wordcount'), '1'); ?>>
    <?php }

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

}
$bbPlugin = new BBPlugin();
?>