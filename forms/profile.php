<?php
  // Exit If Accessed Directly
  if (!defined('ABSPATH')) {
    header('Location: /');
    die;
  }

  if (isset($_POST['update'])) {
    $user_id = sanitize_text_field($_POST['user_id']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_text_field($_POST['email']);

    if($_FILES['profile_pic']['error'] !== 0) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Profile Pic is required</div>';
    } else {
      $file = $_FILES['profile_pic'];
      $ext = explode('/', $file['type'])[1];
      $file_name = "$user_id.$ext";

      if (!metadata_exists('user', $user_id, 'user_profile_pic_url')) {
        $image = wp_upload_bits($file_name, null, file_get_contents($file['tmp_name']));
        add_user_meta($user_id, 'user_profile_pic_url', sanitize_text_field($image['url']));
        add_user_meta($user_id, 'user_profile_pic_path', sanitize_text_field($image['file']));
      } else {
        $profile_pic_path = get_user_meta($user_id, 'user_profile_pic_path', true);
        wp_delete_file($profile_pic_path);
        $image = wp_upload_bits($file_name, null, file_get_contents($file['tmp_name']));
        update_user_meta($user_id, 'user_profile_pic_url', sanitize_text_field($image['url']));
        update_user_meta($user_id, 'user_profile_pic_path', sanitize_text_field($image['file']));
      }
    }

    $user = wp_update_user(array(
      'ID' => $user_id,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'user_email' => $email,
    ));

    if (is_wp_error($user)) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $user->get_error_message() . '</div>';
    } else {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Profile updated successfully</div>';
    }
  }

  $user_id = get_current_user_id();
  $user = get_userdata($user_id);

  if($user) :
    $first_name = $user->first_name;
    $last_name = $user->last_name;
    $email = $user->user_email;
    $profile_pic_url = get_user_meta($user_id, 'user_profile_pic_url', true);
?>

<h1>Hi <?php echo $first_name . ' ' . $last_name; ?></h1>
<p>Not <?php echo $first_name . ' ' . $last_name; ?> <a href="<?php echo wp_logout_url(site_url('/login')); ?>" class="text-danger">Logout</a> </p>

<div class="form-wrapper">
  <div class="login-form border border-width-3x rounded p-3 my-3">
    <img src="<?php echo $profile_pic_url; ?>" alt="Profile Pic" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
    <form action="<?php echo get_the_permalink(); ?>" method="post" enctype="multipart/form-data">
      <div class="form-group my-2">
        <label class="form-label" for="profile_pic">Profile Pic</label>
        <input type="file" name="profile_pic" id="profile_pic" class="form-control">
      </div>
      <div class="form-group my-2">
        <label class="form-label" for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $first_name; ?>" required>
      </div>
      <div class="form-group my-2">
        <label class="form-label" for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $last_name; ?>" required>
      </div>
      <div class="form-group my-2">
        <label class="form-label" for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" required> 
      </div>
      <div class="form-group text-center my-2">
        <input type="hidden" name="user_id" id="user_id" class="form-control" value="<?php echo $user_id; ?>" required> 
        <button type="submit" name="update" class="btn btn-primary w-100">Update</button>
      </div>
    </form>
  </div>
</div>

<?php
  else :
    echo '<h1>Hi Guest</h1>';
  endif;
?>