<h1 class="heading" style="background:#000; color:#fff; margin:20px; padding:20px; font-style:italic; text-align:center;">Live Chat Manager</h1>

<div class="site_wrap" style="background:#fff; margin:20px; padding:20px; font-style:italic;">
    <h2>Adding Live Chat Section</h2>
    <p>Type your phone number in the given text field.</p>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'bb_live_setting' );
            do_settings_sections( 'bb_live_setting' );
            submit_button();
        ?>
    </form>
</div><!--site_wrap-->