<h1 class="main_heading">BB Plugin</h1>

<div class="main_wrapper">
    <h2>Manage All Settings</h2>
    <p>Manage your all settings just clicking on checkbox...</p>
    
    <form action="options.php" method="post">
        <?php
            settings_fields( 'bb_main_setting' );
            do_settings_sections( 'bb_main_setting' );
            submit_button();
        ?>
    </form>
</div><!--main_wrapper-->