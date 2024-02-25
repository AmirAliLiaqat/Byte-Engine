<?php

// Function For Adding Register Form
function byte_engine_register_form()
{
  ob_start();
  include('forms/register.php');
  return ob_get_clean();
}
add_shortcode('register_form', 'byte_engine_register_form');

// Function For Adding Login Form
function byte_engine_login_form()
{
  ob_start();
  include('forms/login.php');
  return ob_get_clean();
}
add_shortcode('login_form', 'byte_engine_login_form');

// Function For Adding Login Form
function byte_engine_profile_form()
{
  ob_start();
  include('forms/profile.php');
  return ob_get_clean();
}
add_shortcode('profile_page', 'byte_engine_profile_form');