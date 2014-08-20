<!-- <h1>Google Map <?php echo __('Documentation'); ?></h1> -->

<?php if(cleanCMS('check') == true){ ?>

<h2>Cleaning Recommended</h2>
<p>There are files to <a href="<?php echo get_url('plugin/cleaner'); ?>/clean">clean</a>, according to the cleaning <a href="<?php echo get_url('plugin/cleaner'); ?>'/settings">settings</a>.</p>

<?php } ?>