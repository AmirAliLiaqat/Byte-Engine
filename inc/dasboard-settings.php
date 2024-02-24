<?php
  /****************************** settings, sections and fields for main page *********************************/
  add_settings_section( 'byte_main_setting_section', null, null,'byte_main_setting' );

  add_settings_field( 'byte_live_chat', 'Live Chat', 'byte_live_chat_html', 'byte_main_setting', 'byte_main_setting_section' );
  register_setting( 'byte_main_setting', 'byte_chat' );

  add_settings_field( 'byte_cpt', 'CPT Manager', 'byte_cpt_html', 'byte_main_setting', 'byte_main_setting_section' );
  register_setting( 'byte_main_setting', 'byte_cpt' );

  add_settings_field( 'byte_wordcount', 'Word Count', 'byte_wordcount_html', 'byte_main_setting', 'byte_main_setting_section' );
  register_setting( 'byte_main_setting', 'byte_wordcount' );

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