<?php

$version = Plugin::getSetting('version', 'ads');
$box = Plugin::getSetting('box', 'ads');

?>
<!-- <h1><?php echo __('Ads'); ?></h1> -->
<!--
<p id="jquery_notice"><img align="top" alt="layout-icon" src="../../../wolf/plugins/ads/images/error_16.png" title="" class="node_image" />&nbsp;<strong>Note</strong>: It appears jQuery is not available. Please install and activate the <a href="http://github.com/tuupola/frog_jquery">jQuery plugin</a>.</p>
-->

<h2 id="box_form_anchor"><?php echo __('New Ad'); ?></h2>
<div id="box_form">
	<form action="<?php echo get_url('plugin/ads/save'); ?>" method="post">
		<table cellpadding="5" cellspacing="5" border="0" id="box_form_table"> 
		  <tr>
				<td class="boxlabel">
					<label for="box_boxlabel"><?php echo __('Name'); ?></label><br />
					<input class="textbox" id="box_boxlabel" maxlength="255" name="box[boxlabel]" type="text" value="" />
				</td>
				<td class="boxcontent" rowspan="2">
					<label for="box_boxcontent"><?php echo __('Text'); ?></label><br />
					<textarea class="textbox" id="box_boxcontent" maxlength="255" name="box[boxcontent]" type="text"></textarea>
				</td>
		  </tr>
		  <tr>
				<td class="boxurl">
					<label for="box_boxlinkurl"><?php echo __('Link URL'); ?></label><br />
					<input class="textbox" id="box_boxlinkurl" maxlength="55" name="box[boxlinkurl]" type="text" value="" />
				</td>
				<!--
				<td class="boxstatus">
					<label for="box_boxstatus"><?php echo __('Status'); ?></label><br />
					<input class="textbox" id="box_boxstatus" maxlength="55" name="box[boxstatus]" type="text" value="" />
				</td>
				-->
				<!--
				<td>
					<label for="box_itemkey"><?php echo __('Token'); ?></label><br />
					<input class="textbox" id="box_itemkey" maxlength="55" name="box[itemkey]" type="text" value="" />
				</td>
				-->

		  </tr>
		</table>	

		<p class="buttons">
			<input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Create');?>" />
		</p>

	</form>
</div>

<div class="boxed">
<h2><?php echo __('Ads'); ?></h2>
<?php if(sizeof($current_boxes) > 0) { ?>
<table id="boxes" class="index">
	<thead id="requests" class="node_heading">
	<tr>
		<th class="boxlabel"><?php echo __('Name'); ?></th>
		<th class="boxcontent"><?php echo __('Text'); ?></th>
		<th class="boxlinkurl"><?php echo __('Link URL'); ?></th>
		<th class="boxstatus"><?php echo __('Show'); ?></th>
		<th class="action"><?php echo __('Action'); ?></th>
	</tr>
	</thead>
	<?php foreach ($current_boxes as $box): ?>
	<tbody id="boxes_<?php echo $box->id; ?>" class="node">
	<form action="<?php echo get_url('plugin/ads/update'); ?>" method="post">
	<input type="hidden" name="boxes_id" value="<?php echo $box->id; ?>" />
	<tr>
	 <!-- <img align="middle" alt="layout-icon" src="../../../wolf/plugins/ads/images/box.png" title="" class="node_image" /> -->
		<td class="boxlabel"><input class="textbox" maxlength="255" name="<?php echo $box->id; ?>[boxlabel]" type="text" value="<?php echo htmlentities($box->boxlabel); ?>" /></td>
		<td class="boxcontent"><input class="textbox" maxlength="255" name="<?php echo $box->id; ?>[boxcontent]" type="text" value="<?php echo htmlentities($box->boxcontent); ?>" /></td>
		<td class="boxlinkurl"><input class="textbox" maxlength="255" name="<?php echo $box->id; ?>[boxlinkurl]" type="text" value="<?php echo htmlentities($box->boxlinkurl); ?>" /></td>
		<td class="boxstatus"><input class="checkbox" name="<?php echo $box->id; ?>[boxstatus]" id="<?php echo $box->id; ?>[boxstatus]" type="checkbox" value="yes"<?php if($box->boxstatus == "yes"){echo ' checked';} ?> /></td>

		<td class="action">
		<!-- <a href="<?php echo get_url('plugin/ads/remove/'.$box->id); ?>" onclick="return confirm('Are you sure you wish to delete <?php echo $box->boxlabel; ?>?');"><img alt="Remove Ad" src="../../../wolf/plugins/ads/images/icon-remove.gif" /></a> -->
		<button class="btn" type="submit" name="remove" onclick="return confirm('Are you sure you wish to delete <?php echo $box->boxlabel; ?>?');"><img alt="Remove Ad" src="../../../wolf/plugins/ads/images/icon-remove.gif" /></button><button class="btn" type="submit" name="update" onclick="return confirm('Are you sure you wish to update <?php echo $box->boxlabel; ?>?');"><img alt="Update Ad" src="../../../wolf/plugins/ads/images/icon-update.gif" /></button>
		</td>
	</tr>
	</form>
	</tbody>
	<?php endforeach ?>
</table>
<?php } else { ?>
	<p><em><?php echo __('There are no ads created yet.'); ?></em></p>
<?php } ?>
</div>



<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($) {
		$('#jquery_notice').hide();
	});
</script>

