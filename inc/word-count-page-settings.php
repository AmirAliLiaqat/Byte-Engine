<?php

/****************************** settings, sections and fields for word count page *********************************/
add_settings_section( 'byte_first_section', null, null, 'word_count_settings' );

add_settings_field( 'byte_location', 'Display Location', array($this, 'location_html'), 'word_count_settings', 'byte_first_section' );
register_setting( 'wordCount', 'byte_location', array('sanitize_callback' => array($this, 'sanitize_location'), 'default' => '0') );

add_settings_field( 'byte_headline', 'Headline Text', array($this, 'headline_html'), 'word_count_settings', 'byte_first_section' );
register_setting( 'wordCount', 'byte_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics') );

add_settings_field( 'byte_wordcount', 'Word count', array($this, 'wordcount_html'), 'word_count_settings', 'byte_first_section' );
register_setting( 'wordCount', 'byte_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );

add_settings_field( 'byte_charactercount', 'Character count', array($this, 'charactercount_html'), 'word_count_settings', 'byte_first_section' );
register_setting( 'wordCount', 'byte_charactercount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );

add_settings_field( 'byte_readtime', 'Read time', array($this, 'readtime_html'), 'word_count_settings', 'byte_first_section' );
register_setting( 'wordCount', 'byte_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );

?>