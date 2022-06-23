<h1 class="heading" style="background:#000; color:#fff; margin:20px; padding:20px; font-style:italic; text-align:center;">BB Plugin</h1>

<div class="site_wrap" style="background:#fff; margin:20px; padding:20px; font-style:italic;">
    <h2>Manage All Settings</h2>
    <p>Manage your all settings just clicking on checkbox...</p>
    <form action="options.php" method="post">
        <div class="my_wrap" style="">
            <label for="title">Title</label>
            <input type="checkbox" name="title" value="title" class="toggle"></br>
            <label for="editor">Editor</label>
            <input type="checkbox" name="editor" value="editor"></br>
            <label for="feature-img">Featured Image</label>
            <input type="checkbox" name="feature-img" value="feature-img"></br>
            <label for="excerpt">Excerpt</label>
            <input type="checkbox" name="excerpt" value="excerpt"></br>
            <label for="trackbacks">Trackbacks</label>
            <input type="checkbox" name="trackbacks" value="trackbacks"></br>
            <label for="custom-fields">Custom Fields</label>
            <input type="checkbox" name="custom-fields" value="custom-fields"></br>
            <label for="comments">Comments</label>
            <input type="checkbox" name="comments" value="comments"></br>
            <label for="revisions">Revisions</label>
            <input type="checkbox" name="revisions" value="revisions"></br>
            <label for="author">Author</label>
            <input type="checkbox" name="author" value="author"></br>
            <label for="page-attributes">Page Attributes</label>
            <input type="checkbox" name="page-attributes" value="page-attributes"></br>
            <label for="post-formats">Post Formats</label>
            <input type="checkbox" name="post-formats" value="post-formats"></br>
            <label for="none">None</label>
            <input type="checkbox" name="none" value="none"></br>
        </div><!--my_wrap-->
        <?php
            settings_fields( '' );
            do_settings_sections( '' );
            submit_button();
        ?>
    </form>
</div><!--site_wrap-->