<h1 class="heading" style="background:#000; color:#fff; margin:20px; padding:20px; font-style:italic; text-align:center;">BB Plugin</h1>

<div class="site_wrap" style="background:#fff; margin:20px; padding:20px; font-style:italic;">
    <h2>Manage All Settings</h2>
    <p>Manage your all settings just clicking on checkbox...</p>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'bb_main_setting' );
            do_settings_sections( 'bb_main_setting' );
            submit_button();
        ?>
    </form>
</div><!--site_wrap-->