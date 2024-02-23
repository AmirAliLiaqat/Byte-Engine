<h1 class="main_heading">Live Chat Manager</h1>

<div class="main_wrapper">
    <h2>Adding Live Chat Section</h2>
    <p>Type your phone number in the given text field.</p>
    
    <form action="options.php" method="post">
        <?php
            settings_fields( 'bb_live_setting' );
            do_settings_sections( 'bb_live_setting' );
            submit_button();
        ?>
    </form>
</div><!--main_wrapper-->