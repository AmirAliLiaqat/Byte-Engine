<?php
  /****************************** settings, sections and fields for word count page *********************************/
  add_settings_section( 'byte_wc_setting_section', null, null, 'byte_wc_setting' );

  register_setting( 'byte_wc_setting', 'byte_location', array('sanitize_callback' => array($this, 'sanitize_location'), 'default' => '0') );
  add_settings_field( 'byte_location', 'Display Location', 'location_html', 'byte_wc_setting', 'byte_wc_setting_section' );

  register_setting( 'byte_wc_setting', 'byte_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics') );
  add_settings_field( 'byte_headline', 'Headline Text', 'headline_html', 'byte_wc_setting', 'byte_wc_setting_section' );

  register_setting( 'byte_wc_setting', 'byte_post_wc', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );
  add_settings_field( 'byte_post_wc', 'Word count', 'wordcount_html', 'byte_wc_setting', 'byte_wc_setting_section' );

  register_setting( 'byte_wc_setting', 'byte_charactercount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );
  add_settings_field( 'byte_charactercount', 'Character count', 'charactercount_html', 'byte_wc_setting', 'byte_wc_setting_section' );

  register_setting( 'byte_wc_setting', 'byte_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') );
  add_settings_field( 'byte_readtime', 'Read time', 'readtime_html', 'byte_wc_setting', 'byte_wc_setting_section' );

  /******************************* Callback functions for word count page ************************************/
  function location_html() { ?>
    <select name="byte_location">
      <option value="0" <?php selected( get_option('byte_location'), '0' ) ?>>Beginning of post</option>
      <option value="1" <?php selected( get_option('byte_location'), '1' ) ?>>End of post</option>
    </select>
  <?php }

  function sanitize_location($input) {
    if($input != '0' && $input != '1') {
      add_settings_error( 'byte_location', 'byte_location_error', 'Display location must be either beginning or end...' );
      return get_option('byte_location');
    }
    return $input;
  }

  function headline_html() { ?>
    <input type="text" name="byte_headline" value="<?php echo esc_attr(get_option('byte_headline')); ?>">
  <?php }

  function wordcount_html() { ?>
    <input type="checkbox" name="byte_post_wc" value="1" <?php checked(get_option('byte_post_wc'), '1'); ?>>
  <?php }

  function charactercount_html() { ?>
    <input type="checkbox" name="byte_charactercount" value="1" <?php checked(get_option('byte_charactercount'), '1'); ?>>
  <?php }

  function readtime_html() { ?>
    <input type="checkbox" name="byte_readtime" value="1" <?php checked(get_option('byte_readtime'), '1'); ?>>
  <?php }