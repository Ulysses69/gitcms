<!-- <h1><?php echo __('Tagger'); ?></h1> -->

<?php if ($is_image) { ?>
  <img src="<?php echo BASE_FILES_DIR.'/'.$filename; ?>" />
<?php } else { ?>
<form method="post" action="<?php echo get_url('plugin/file_manager/save'); ?>">
	<div class="form-area">
		<p class="content">
			<input type="hidden" name="file[name]" value="<?php echo $filename; ?>" />
			<textarea class="textarea" id="file_content" name="file[content]" style="width: 100%; height: 400px;" onkeydown="return allowTab(event, this);" rows="20" cols="40"><?php echo htmlentities($content, ENT_COMPAT, 'UTF-8'); ?></textarea><br />
		</p>
	</div>
	<p class="buttons">
		<input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save'); ?>" />
		<input class="button" name="continue" type="submit" accesskey="e" value="<?php echo __('Save and Continue Editing'); ?>" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('plugin/file_manager/browse/'.$progres_path); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>
<?php } ?>