<?php
    /****************************** settings, sections and fields for custom post type page *********************************/
    add_settings_section( 'byte_cpt_setting_section', null, null,'byte_cpt_setting' );

    $caption = "
        <p>Add supports for various available post editor features on the right. A checked value means the post type feature is supported.</p>
        <p> Use the 'None' option to expilicitly set 'supports' to false.</p>
    ";

    register_setting( 'byte_cpt_setting', 'labels' );
    add_settings_field( 'label', 'Label', 'label_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'description' );
    add_settings_field( 'description', 'Description', 'description_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'menu_icon' );
    add_settings_field( 'menu_icon', 'Menu Icon', 'menu_icon_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'hierarchical' );
    add_settings_field( 'hierarchical', 'Hierarchical', 'hierarchical_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'public' );
    add_settings_field( 'public', 'Public', 'public_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'publicly_queryable' );
    add_settings_field( 'publicly_queryable', 'Publicly Queryable', 'publicly_queryable_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'show_ui' );
    add_settings_field( 'show_ui', 'Show UI', 'show_ui_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'show_in_menu' );
    add_settings_field( 'show_in_menu', 'Show in menu', 'show_in_menu_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'show_in_nav_menus' );
    add_settings_field( 'show_in_nav_menus', 'Show in nav menu', 'show_in_nav_menus_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'menu_position' );
    add_settings_field( 'menu_position', 'Menu Position', 'menu_position_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'can_export' );
    add_settings_field( 'can_export', 'Can Export', 'can_export_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'has_archive' );
    add_settings_field( 'has_archive', 'Has Archive', 'has_archive_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'capability_type' );
    add_settings_field( 'capability_type', 'Capability Type', 'capability_type_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    register_setting( 'byte_cpt_setting', 'supports' );
    add_settings_field( 'supports', 'Supports', 'supports_html', 'byte_cpt_setting', 'byte_cpt_setting_section' );

    /****************************** Callback functions for custom post type page *********************************/
    function label_html() { ?>
        <input type="text" name="labels" value="<?php echo get_option('labels'); ?>" required></br>
        <p>Type the label of your post type...</p>
    <?php }

    function description_html() { ?>
        <input type="text" name="description" value="<?php echo get_option('description'); ?>" required></br>
        <p>Type the description of your post type...</p>
    <?php }

    function menu_icon_html() { ?>
        <input type="text" name="menu_icon" value="<?php echo get_option('menu_icon'); ?>"></br>
        <p>Type the text for your post type menu icon...</p>
    <?php }

    function hierarchical_html() { ?>
        <select name="hierarchical">
            <option value="0" <?php selected( get_option('hierarchical'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('hierarchical'), '1' ) ?>>False</option>
        </select>
        <p>(default: true) Not query can be performed on the front end as part of parse_request()</p>
    <?php }

    function public_html() { ?>
        <select name="public">
            <option value="0" <?php selected( get_option('public'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('public'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not posts of this type should be shown in the admin UI and is publicly queryable.</p>
    <?php }

    function publicly_queryable_html() { ?>
        <select name="publicly_queryable">
            <option value="0" <?php selected( get_option('publicly_queryable'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('publicly_queryable'), '1' ) ?>>False</option>
        </select>
        <p>(default: true) Not query can be performed on the front end as part of parse_request()</p>
    <?php }

    function show_ui_html() { ?>
        <select name="show_ui">
            <option value="0" <?php selected( get_option('show_ui'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('show_ui'), '1' ) ?>>False</option>
        </select>
        <p>(default: true) Whether or not to generate a default UI for managing this post type.</p>
    <?php }

    function show_in_menu_html() { ?>
        <select name="show_in_menu">
            <option value="0" <?php selected( get_option('show_in_menu'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('show_in_menu'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not this post type is available for selection in menus.</p>
    <?php }

    function show_in_nav_menus_html() { ?>
        <select name="show_in_nav_menus">
            <option value="0" <?php selected( get_option('show_in_nav_menus'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('show_in_nav_menus'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not this post type is available for selection in navigation menus.</p>
    <?php }

    function menu_position_html() { ?>
        <input type="number" name="menu_position" value="<?php echo get_option('menu_position'); ?>"></br>
        <p>Type the number where you want to show your post type.</p>
    <?php }
    
    function can_export_html() { ?>
        <select name="can_export">
            <option value="0" <?php selected( get_option('can_export'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('can_export'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not this post type you want to export or not.</p>
    <?php }
    
    function has_archive_html() { ?>
        <select name="has_archive">
            <option value="0" <?php selected( get_option('has_archive'), '0' ) ?>>True</option>
            <option value="1" <?php selected( get_option('has_archive'), '1' ) ?>>False</option>
        </select>
        <p>(Custom Post Type UI default: true) Whether or not this post type has archives or not.</p>
    <?php }
    
    function capability_type_html() { ?>
        <select name="capability_type">
            <option value="0" <?php selected( get_option('capability_type'), '0' ) ?>>Post</option>
            <option value="1" <?php selected( get_option('capability_type'), '1' ) ?>>Page</option>
        </select>
        <p>(Custom Post Type UI default: post) Whether which post type you want to create.</p>
    <?php }
    
    function supports_html() {
        $selected_supports = get_option('supports');
    
        $available_supports = ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'];
    
        foreach ($available_supports as $support) {
            echo '<input type="checkbox" name="supports[]"> ' . ucfirst($support) . '<br>';
        }
    }