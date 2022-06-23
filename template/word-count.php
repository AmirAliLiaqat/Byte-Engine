<h1 class="heading" style="background:#000; color:#fff; margin:20px; padding:20px; font-style:italic; text-align:center;">Word Count Settings</h1>

<div class="site_wrap" style="background:#fff; margin:20px; padding:20px; font-style:italic;">
    <h2>Count words and characters</h2>
    <p>Count all the words and characters in our post and tell the read time of post...</p>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'wordCount' );
            do_settings_sections( 'word_count_settings' );
            submit_button();
        ?>
    </form>
</div><!--site_wrap-->