<?php
  // Exit If Accessed Directly
  if (!defined('ABSPATH')) {
    header('Location: /');
    die;
  }

  if (isset($_POST['register'])) {
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $user_name = sanitize_text_field($_POST['user_name']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $confirm_password = sanitize_text_field($_POST['confirm_password']);

    if ($password !== $confirm_password) {
      echo 'Password does not match';
    } else {
      $user_data = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'user_login' => $user_name,
        'display_name' => $first_name . ' ' . $last_name,
        'user_email' => $email,
        'user_pass' => $password
      );
      $user_id = wp_insert_user($user_data);
      if (is_wp_error($user_id)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $user_id->get_error_message() . '</div>';
      } else {
        $user = get_user_by('id', $user_id);
        $user->set_role('subscriber');
        update_metadata($user_id, 'show_admin_bar_front', false);
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">User registered successfully</div>';
      }
    }
  }
?>

<div class="form-wrapper">
  <div class="register-form border border-width-3x rounded p-3 my-3">
    <h2>Register</h2>
    <form action="<?php echo get_the_permalink(); ?>" method="post">
      <div class="form-group my-2">
        <label class="form-label" for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" required>
      </div>
      <div class="form-group my-2">
        <label class="form-label" for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" required>
      </div>
      <div class="form-group my-2">
        <label class="form-label" for="user_name">User Name</label>
        <input type="text" name="user_name" id="user_name" class="form-control" required>
      <div class="form-group my-2">
        <label class="form-label" for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <div class="form-group my-2">
        <label class="form-label" for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <div class="form-group my-2">
        <label class="form-label" for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
      </div>
      <div class="form-group text-center my-2">
        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
      </div>
    </form>
  </div>
</div>

