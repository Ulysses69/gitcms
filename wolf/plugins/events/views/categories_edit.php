<h2><?php echo __('Add/Edit Category'); ?></h2>

<h3><?php echo __('Category'); ?></h3>

<?php if (!$category): ?>

	<p>Invalid Category. Return to <a href="<?php echo get_url('plugin/events/categories'); ?>">a listing of categories</a>.</p>
	
<?php else: ?>


	<form name="category_edit" action="<?php echo get_url('plugin/events/categories_save'); ?>" method="post">
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="category_name">Name</label></td>
				<td class="field"><input class="textbox" id="category_name" maxlength="255" name="category[name]" size="255" type="text" value="<?php echo h($category->name); ?>" /></td>
				<td class="help">Required.</td>
			</tr>
		</table>

		<p class="buttons">
			<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="Save then close" value="Save" />
			<a href="<?php echo get_url('plugin/events/categories'); ?>" id="site-view-page" class="button" title="Close without saving">Cancel</a>
		</p>

		<input type="hidden" name="category[id]" value="<?php echo h($category->id); ?>" />
	</form>

<?php endif ?>
