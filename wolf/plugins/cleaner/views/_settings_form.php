<br />
<form action="<?php echo get_url('plugin/cleaner/save_settings'); ?>" method="post">

    <?php if (!AuthUser::hasPermission('client')) { ?>
	<fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Cleaner'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label url"><label for="cleanlist"><?php echo __('Delete/Clean List'); ?></label></td>
                <td class="field url"><?php $cleanlist = Plugin::getSetting('cleanlist', 'cleaner'); ?>
				<textarea name="cleanlist" id="cleanlist"><?php echo $cleanlist; ?></textarea></td>
            </tr>
            <tr>
                <td class="label url"><label for="protectlist"><?php echo __('Protected List'); ?></label></td>
                <td class="field url"><?php $protectlist = Plugin::getSetting('protectlist', 'cleaner'); ?>
				<textarea name="protectlist" id="protectlist"><?php echo $protectlist; ?></textarea></td>
            </tr>
        </table>
    </fieldset>
	<?php
	}
	?>


	<?php cleanCMS(); ?>


    <p class="buttons">
        <input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
    </p>

</form>