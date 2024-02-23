<h1 class="main_heading">Custom Post Type Manager</h1>

<div class="main_wrapper">
    <h2>Add Custom Post Type</h2>
    <p>Fill all the fields and hit the submit button for adding new custom post type in your wordpress...</p>
    
    <form action="options.php" method="post">
        <?php
            settings_fields( 'bb_cpt_setting' );
            do_settings_sections( 'bb_cpt_setting' );
            submit_button('Add Post Type');
        ?>
    </form>
</div><!--main_wrapper-->