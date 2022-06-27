<?php

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

register_setting( 'bb_cpt_setting', 'menu_icon' );
add_settings_field( 'menu_icon', 'Menu Icon', array($this, 'menu_icon_html'), 'bb_cpt_setting', 'bb_cpt_setting_section' );

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

?>