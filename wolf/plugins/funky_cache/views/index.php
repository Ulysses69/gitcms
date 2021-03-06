<!-- <h1><?php echo __('Funky Cache Plugin'); ?></h1> -->
<?php error_reporting(E_ALL); ?>

<form action="<?php echo get_url('plugin/funky_cache/clear'); ?>" method="GET">
<fieldset style="padding: 0.5em;">
	<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Cached pages'); ?></legend>
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	<?php foreach ($cached_page as $page): ?>
		<tr>
			<td class="field"><?php echo $page->publicUrl() ?></td>
			<td class="field"><?php echo DateDifference::getString(new DateTime($page->created_on)); ?></td>
			<td class="field"><a href="<?php echo get_url('plugin/funky_cache/delete/') . $page->id; ?>"><img src="<?php echo FUNKY_CACHE_ROOT;?>/images/icon-remove.gif" /></a></td>
		</tr>	
	<?php endforeach; ?>
	</table>
</fieldset>
<p class="buttons">
	<a href="<?php echo get_url('plugin/funky_cache/clear'); ?>" class="button"><?php echo __('Clear all'); ?></a>
</p>
</form>
