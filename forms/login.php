<?php
  // Exit If Accessed Directly
  if (!defined('ABSPATH')) {
    header('Location: /');
    die;
  }
?>

<div class="form-wrapper">
  <div class="login-form border border-width-3x rounded p-3 my-3">
    <h2>Login</h2>
    <form action="<?php echo get_the_permalink(); ?>" method="post">
      <div class="form-group my-2">
        <label class="form-label" for="login_username">User Name</label>
        <input type="text" name="login_username" id="login_username" class="form-control" required>
      </div>
      <div class="form-group my-2">
        <label class="form-label" for="login_password">Password</label>
        <input type="password" name="login_password" id="login_password" class="form-control" required> 
      </div>
      <div class="form-group text-center my-2">
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
      </div>
    </form>
  </div>
</div>

