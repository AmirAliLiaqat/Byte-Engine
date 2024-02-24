<?php
  /****************************** settings, sections and fields for live chat page *********************************/
  add_settings_section( 'byte_live_setting_section', null, null,'byte_live_setting' );

  register_setting( 'byte_live_setting', 'byte_chat_link' );
  add_settings_field( 'byte_chat_link', 'Chat Link', 'chat_link_html', 'byte_live_setting', 'byte_live_setting_section' );

  register_setting( 'byte_live_setting', 'byte_chat_number' );
  add_settings_field( 'byte_chat_number', 'Phone Number', 'phone_number_html', 'byte_live_setting', 'byte_live_setting_section' );
  
  /****************************** Callback functios for live chat page *********************************/
  function chat_link_html() {
    $link = get_option('byte_chat_link');
    echo '<input type="text" name="byte_chat_link" value="'.$link.'">';
  }
  
  function phone_number_html() {
    $number = get_option('byte_chat_number');
    echo '<input type="text" name="byte_chat_number" value="'.$number.'">';
  }