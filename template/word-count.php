<h1 class="main_heading">Word Count Manager</h1>

<div class="main_wrapper">
    <h2>Count words and characters</h2>
    <p>Count all the words and characters in our post and tell the read time of post...</p>
    
    <form action="options.php" method="post">
        <?php
            settings_fields( 'byte_wc_setting' );
            do_settings_sections( 'byte_wc_setting' );
            submit_button();
        ?>
    </form>
</div><!--main_wrapper-->