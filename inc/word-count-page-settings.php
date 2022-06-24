<?php

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

?>