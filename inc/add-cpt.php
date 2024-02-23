<?php

    $domain = 'byte_engine';
    $labels = get_option('labels');
    $description = get_option('description');
    $menu_icon = get_option('menu_icon');
    $hierarchical = get_option('hierarchical');	
    $public = get_option('public');
    $publicly_queryable = get_option('publicly_queryable');
    $show_ui = get_option('show_ui');
    $show_in_menu = get_option('show_in_menu');
    $show_in_nav_menus = get_option('show_in_nav_menus');
    $menu_position = get_option('menu_position');
    $can_export = get_option('can_export');
    $has_archive = get_option('has_archive');
    $capability_type = get_option('capability_type');
    $supports = get_option('supports');

    if($hierarchical == '0') {
        $hierarchical = true;
    } else {
        $hierarchical = false;
    }

    if($public == '0') {
        $public = true;
    } else {
        $public = false;
    }

    if($publicly_queryable == '0') {
        $publicly_queryable = true;
    } else {
        $publicly_queryable = false;
    }

    if($show_ui == '0') {
        $show_ui = true;
    } else {
        $show_ui = false;
    }

    if($show_in_menu == '0') {
        $show_in_menu = true;
    } else {
        $show_in_menu = false;
    }

    if($show_in_nav_menus == '0') {
        $show_in_nav_menus = true;
    } else {
        $show_in_nav_menus = false;
    }

    if($can_export == '0') {
        $can_export = true;
    } else {
        $can_export = false;
    }

    if($has_archive == '0') {
        $has_archive = true;
    } else {
        $has_archive = false;
    }

    if($capability_type == '0') {
        $capability_type = 'post';
    } else {
        $capability_type = 'page';
    }

    if(!empty($labels)) {
        $args = array(
            'label'               => __( $labels, $domain ),
            'description'         => __( $description, $domain ),
            'menu_icon'           => 'dashicons-' . $menu_icon,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            'hierarchical'        => $hierarchical,
            'public'              => $public,
            'publicly_queryable'  => $publicly_queryable,
            'show_ui'             => $show_ui,
            'show_in_menu'        => $show_in_menu,
            'show_in_nav_menus'   => $show_in_menu,
            'show_in_admin_bar'   => $show_in_nav_menus,
            'menu_position'       => $menu_position,
            'can_export'          => $can_export,
            'has_archive'         => $has_archive,
            'capability_type'     => 'post',
            'show_in_rest'     => true,
        
        );
        
        // Registering your Custom Post Type
        register_post_type( $labels, $args );
    }

?>