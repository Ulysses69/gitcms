<br />
<form action="<?php echo get_url('plugin/'.SKELETON_ID.'/save_settings'); ?>" method="post">

	<?php
	/* Display new content when plugin is updates */
	$version = Plugin::getSetting('version', SKELETON_ID);
	$test1 = Plugin::getSetting('test1', SKELETON_ID);


//if(SKELETON_VERSION == $version){ ?>
    <fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Test 1'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
	            <td><input name="test1" id="test1" value="<?php echo $test1; ?>" /></td>
            </tr>
        </table>
    </fieldset>
<?php //}


	?>

    <p class="buttons">
        <input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
    </p>

</form>