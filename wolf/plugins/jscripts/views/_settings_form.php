<?php
//$rows = Plugin::getSetting('rows', 'jscripts');
$rows = 9;
?>
<form action="<?php echo get_url('plugin/jscripts/save_settings'); ?>" method="post">
	<input name="rows" id="rows" type="hidden" value="<?php echo $rows;?>" />

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Configuration'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="embedding"><?php echo __('Embedding'); ?></label></td>
				<td class="field">
			<select name="embedding" id="embedding">
			<?php
			$embedding_array = array(
			array ('Auto', 'auto'),
			array ('Manual', 'manual'));
			foreach($embedding_array as $subarray) {
				list($text, $val) = $subarray;
				if($val == $embedding){
					echo "<option value=\"$val\" selected>$text</option>";
				} else {
					echo "<option value=\"$val\">$text</option>";
				}
			}
			?>
			</select>
		</td>
		<td class="help"><?php echo __('Automatically embed scripts or embed manually.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="minify"><?php echo __('Minify'); ?></label></td>
				<td class="field">
			<select name="minify" id="minify">
			<?php
			$minify_array = array(
			array ('Enable', 'true'),
			array ('Disable', 'false'));
			foreach($minify_array as $subarray) {
				list($text, $val) = $subarray;
				if($val == $minify){
					echo "<option value=\"$val\" selected>$text</option>";
				} else {
					echo "<option value=\"$val\">$text</option>";
				}
			}
			?>
			</select>
		</td>
		<td class="help"><?php echo __('Merge scripts (under development).');?></td>
			</tr>
		</table>
	</fieldset>

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Files'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label" style="text-align:left"><?php echo __('Script URL'); ?><p style="margin:0;color:#666"><small>Public URL of script file.</small></p></td>
				<td class="label" style="text-align:left"><?php echo __('Include on pages'); ?><p style="margin:0;color:#666"><small>List of page slugs<?php if(function_exists('pagelevel')) ?> or page level<?php ; ?>.</small></p></td>
				<td class="label" style="text-align:left"><?php echo __('Exclude from pages'); ?><p style="margin:0;color:#666"><small>List of page slugs<?php if(function_exists('pagelevel')) ?> or page level<?php ; ?>.</small></p></td>
				<td class="label" style="text-align:left;width:1%"><?php echo __('Insert'); ?><p style="margin:0;color:#666"><small>Document placement.</small></p></td>
			</tr>

			<?php
			//$rows = 1;
			//$script3 = 'test';
			//if($script0 != ''){ $rows++; }
			for($r=0;$r<$rows+1;$r++){
			?>

			<tr<?php if($r>0){ $td = ' style="border:none;padding-top:4px"';} else {$td = ' style="padding-top:10px;padding-bottom:4px"';} ?>>
				<td class="field"<?php echo $td; ?>><input class="textbox" name="script<?php echo $r; ?>" id="script<?php echo $r; ?>" value="<?php echo ${'script'.$r}; ?>" /></td>
				<td class="field"<?php echo $td; ?>><input class="textbox" name="include<?php echo $r; ?>" id="include<?php echo $r; ?>" value="<?php echo ${'include'.$r}; ?>" /></td>
				<td class="field"<?php echo $td; ?>><input class="textbox" name="exclude<?php echo $r; ?>" id="exclude<?php echo $r; ?>" value="<?php echo ${'exclude'.$r}; ?>" /></td>
				<td class="field"<?php echo $td; ?>><select name="insert<?php echo $r; ?>" id="insert<?php echo $r; ?>">
			<?php
			$insert_array = array(
			array ('', ''),
			array ('head', 'head'),
			array ('body', 'body'));
			foreach($insert_array as $subarray) {
				list($text, $val) = $subarray;
				if($val == ${'insert'.$r}){
					echo "<option value=\"$val\" selected>$text</option>";
				} else {
					echo "<option value=\"$val\">$text</option>";
				}
			}
			?>
			</select></td>
			</tr>

			<?php } ?>

		</table>
		<!--
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0" style="margin-top:-5px">
			<tr class="buttons">
			<td colspan="3" style="padding-top:15px"><input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Add Script');?>" /></td>
		</tr>
		</table>
		-->
	</fieldset>




	<?php
	if($version > '3.0.0'){ 
		$marqueeparent = Plugin::getSetting('marqueeparent', 'jscripts');
		$marqueecontent = Plugin::getSetting('marqueecontent', 'jscripts');
		$marqueedisplaynum = Plugin::getSetting('marqueedisplaynum', 'jscripts');
		$marqueeorder = Plugin::getSetting('marqueeorder', 'jscripts');
		$marqueesort = Plugin::getSetting('marqueesort', 'jscripts');
		$marqueeduration = Plugin::getSetting('marqueeduration', 'jscripts');
		$marqueetransition = Plugin::getSetting('marqueetransition', 'jscripts');
		?>


		<fieldset style="padding: 0.5em;" class="marquee">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Marquee'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="label"><label for="marqueeparent"><?php echo __('Page Slug'); ?></label>
					<input class="textbox" name="marqueeparent" id="marqueeparent" value="<?php echo $marqueeparent; ?>" /></td>

				   	<td class="label"><label for="marqueecontent"><?php echo __('Content'); ?></label>
						<select name="marqueecontent" id="marqueecontent">
						<?php
						$marqueecontent_array = array(
						array ('Body', 'body'),
						array ('Excerpt', 'excerpt'),
						array ('Title', 'title'),
						array ('Breadcrumb', 'breadcrumb'),
						array ('Description', 'description'));
						foreach($marqueecontent_array as $subarray) {
							list($text, $val) = $subarray;
							if($val == $marqueecontent){
								echo "<option value=\"$val\" selected>$text</option>";
							} else {
								echo "<option value=\"$val\">$text</option>";
							}
						}
						?>
						</select>
					</td>

				   	<td class="label"><label for="marqueedisplaynum"><?php echo __('Items per Group'); ?></label>
					<input class="textbox" name="marqueedisplaynum" id="marqueedisplaynum" value="<?php echo $marqueedisplaynum; ?>" /></td>
				   	<td class="label"><label for="marqueesort"><?php echo __('Order by'); ?></label>
						<select name="marqueeorder" id="marqueeorder">
						<?php
						$marqueeorder_array = array(
						array ('Title', 'title'),
						array ('Slug', 'slug'),
						array ('Breadcrumb', 'breadcrumb'),
						array ('Date created', 'created_on'),
						array ('Date published', 'published_on'),
						array ('Date updated', 'updated_on'));
						foreach($marqueeorder_array as $subarray) {
							list($text, $val) = $subarray;
							if($val == $marqueeorder){
								echo "<option value=\"$val\" selected>$text</option>";
							} else {
								echo "<option value=\"$val\">$text</option>";
							}
						}
						?>
						</select>
					</td>
				   	<td class="label"><label for="marqueesort"><?php echo __('Sort by'); ?></label>
						<select name="marqueesort" id="marqueesort">
						<?php
						$marqueesort_array = array(
						array ('Ascend', 'ascend'),
						array ('Descend', 'descend'));
						foreach($marqueesort_array as $subarray) {
							list($text, $val) = $subarray;
							if($val == $marqueesort){
								echo "<option value=\"$val\" selected>$text</option>";
							} else {
								echo "<option value=\"$val\">$text</option>";
							}
						}
						?>
						</select>
					</td>

				   	<td class="label"><label for="marqueeduration"><?php echo __('Duration'); ?></label>
						<select name="marqueeduration" id="marqueeduration">
						<?php
						$marqueeduration_array = array(
						array ('3 Seconds', '3000'),
						array ('4 Seconds', '4000'),
						array ('5 Seconds', '5000'),
						array ('6 Seconds', '6000'));
						foreach($marqueeduration_array as $subarray) {
							list($text, $val) = $subarray;
							if($val == $marqueeduration){
								echo "<option value=\"$val\" selected>$text</option>";
							} else {
								echo "<option value=\"$val\">$text</option>";
							}
						}
						?>
						</select>
					</td>

				   	<td class="label"><label for="marqueetransition"><?php echo __('Transition'); ?></label>
						<select name="marqueetransition" id="marqueetransition">
						<?php
						$marqueetransition_array = array(
						array ('0.25 Second', '250'),
						array ('0.5 Second', '500'),
						array ('1 Second', '1000'),
						array ('2 Seconds', '2000'),
						array ('3 Seconds', '3000'));
						foreach($marqueetransition_array as $subarray) {
							list($text, $val) = $subarray;
							if($val == $marqueetransition){
								echo "<option value=\"$val\" selected>$text</option>";
							} else {
								echo "<option value=\"$val\">$text</option>";
							}
						}
						?>
						</select>
					</td>

				</tr>
			</table>
		</fieldset>

	<?php }
	?>




	<p class="buttons">
		<input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
	</p>


</form>