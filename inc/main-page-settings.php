<?php

/****************************** settings, sections and fields for main page *********************************/
add_settings_section( 'byte_main_setting_section', null, null,'byte_main_setting' );

add_settings_field( 'byte_live_chat', 'Live Chat', array($this, 'byte_live_chat_html'), 'byte_main_setting', 'byte_main_setting_section' );
register_setting( 'byte_main_setting', 'byte_chat' );

add_settings_field( 'byte_cpt', 'CPT Manager', array($this, 'byte_cpt_html'), 'byte_main_setting', 'byte_main_setting_section' );
register_setting( 'byte_main_setting', 'byte_cpt' );

add_settings_field( 'byte_wordcount', 'Word Count', array($this, 'byte_wordcount_html'), 'byte_main_setting', 'byte_main_setting_section' );
register_setting( 'byte_main_setting', 'byte_wordcount' );

?>