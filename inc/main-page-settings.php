<?php

/****************************** settings, sections and fields for main page *********************************/
add_settings_section( 'bb_main_setting_section', null, null,'bb_main_setting' );

add_settings_field( 'bb_live_chat', 'Live Chat', array($this, 'bb_live_chat_html'), 'bb_main_setting', 'bb_main_setting_section' );
register_setting( 'bb_main_setting', 'bb_chat' );

add_settings_field( 'bb_cpt', 'CPT Manager', array($this, 'bb_cpt_html'), 'bb_main_setting', 'bb_main_setting_section' );
register_setting( 'bb_main_setting', 'bb_cpt' );

add_settings_field( 'bb_wordcount', 'Word Count', array($this, 'bb_wordcount_html'), 'bb_main_setting', 'bb_main_setting_section' );
register_setting( 'bb_main_setting', 'bb_wordcount' );

?>