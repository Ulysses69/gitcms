
<form action="<?php echo get_url('plugin/cleaner/save_settings'); ?>" method="post">    
    

    <?php if (!AuthUser::hasPermission('client')) { ?>

    <h2>Delete/Clean List</h2>
    <td class="field url"><?php $cleanlist = Plugin::getSetting('cleanlist', 'cleaner'); ?>
	<textarea name="cleanlist" id="cleanlist"><?php echo $cleanlist; ?></textarea></td>

    <h2>Protected List</h2>
    <?php $protectlist = Plugin::getSetting('protectlist', 'cleaner'); ?>
	<textarea name="protectlist" id="protectlist"><?php echo $protectlist; ?></textarea></td>

	<?php } ?>


    <!-- <p>Max Execution Time: <?php echo ini_get('max_execution_time'); ?> seconds</p> -->


    <p class="buttons">
        <input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
    </p>

</form>