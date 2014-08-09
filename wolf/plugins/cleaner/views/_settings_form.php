
<form action="<?php echo get_url('plugin/cleaner/save_settings'); ?>" method="post"> 

<input id="push_page_to_top" />
    

    <?php if (!AuthUser::hasPermission('client')) { ?>

    <h2>Delete/Clean List</h2>
    <td class="field url"><?php $cleanlist = Plugin::getSetting('cleanlist', 'cleaner'); ?>
	<textarea name="cleanlist" id="cleanlist"><?php echo $cleanlist; ?></textarea></td>

    <h2>Protected List</h2>
    <?php $protectlist = Plugin::getSetting('protectlist', 'cleaner'); ?>
	<textarea name="protectlist" id="protectlist"><?php echo $protectlist; ?></textarea></td>

    <!--
	<h2>Custom File Conditions</h2>
    <?php $customconditions = Plugin::getSetting('customconditions', 'cleaner'); ?>
	<textarea name="customconditions" id="customconditions"><?php echo $customconditions; ?></textarea></td>
	-->

	<?php } ?>

<<<<<<< HEAD
=======
	
	<?php
	// Determine wolf path
	// As plugins run from admin folder, excluding this folder reveals wolf root
	$lowestpath = getcwd();
	$rep = str_replace('\\', '/', $lowestpath);
	$wolfpath = str_replace('/'.ADMIN_DIR, '', $rep);
	//echo rtrim($wolfpath);
	?>

>>>>>>> FETCH_HEAD

    <!-- <p>Max Execution Time: <?php echo ini_get('max_execution_time'); ?> seconds</p> -->


    <p class="buttons">
        <input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
    </p>

</form>