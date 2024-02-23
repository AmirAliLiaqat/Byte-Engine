<h1 class="main_heading">Word Count Settings</h1>

<div class="main_wrapper">
    <h2>Count words and characters</h2>
    <p>Count all the words and characters in our post and tell the read time of post...</p>
    
    <form action="options.php" method="post">
        <?php
            settings_fields( 'wordCount' );
            do_settings_sections( 'word_count_settings' );
            submit_button();
        ?>
    </form>
</div><!--main_wrapper-->