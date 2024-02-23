<?php

 /****************************** settings, sections and fields for live chat page *********************************/
 add_settings_section( 'byte_live_setting_section', null, null,'byte_live_setting' );

 register_setting( 'byte_live_setting', 'byte_chat_link' );
 add_settings_field( 'chat_link', 'Chat Link', array($this, 'chat_link_cb'), 'byte_live_setting', 'byte_live_setting_section' );

 register_setting( 'byte_live_setting', 'byte_chat_label' );
 add_settings_field( 'phone_number', 'Phone Number', array($this, 'phone_number_cb'), 'byte_live_setting', 'byte_live_setting_section' );

?>