<!-- <h1>Google Map <?php echo __('Documentation'); ?></h1> -->

<?php if(cleanCMS('check') == true){ ?>

	<h2>Cleaning Recommended</h2>
	<p>There are files to <a href="<?php echo get_url('plugin/cleaner'); ?>/clean">clean</a>, according to the cleaning <a href="<?php echo get_url('plugin/cleaner'); ?>'/settings">settings</a>.</p>

<?php } else { ?>

	<h2>Clean</h2>
	<p>No cleaning is required.</p>

<?php } ?>


<?php
//echo strip_tags(file_get_contents($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/cleaner/lib/cleanlist.txt', true));
?> 