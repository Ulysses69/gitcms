<?php if(!defined('IN_CMS')) { exit(); } ?>


<h2>Add IP Access</h2>

<div id="ip_form">
<form method="post" action="<?php echo get_url('maintenance/add'); ?>">
	<table class="fieldset" cellpadding="5" cellspacing="5" border="0" id="add_ip"> 
		<tr>
			<td class="label">IP Address</td>
			<td class="field"><input type="text" class="textbox" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" /></td>
			<td class="help">The IP to set up (automatically your current IP)</td>
		</tr>
		<tr>
			<td class="label">Name</td>
			<td class="field"><input type="text" class="textbox" name="name" /></td>
			<td class="help">An identifier for this IP</td>
		</tr>
		<tr>
			<td class="label">Description</td>
			<td class="field"><textarea name="notes" style="height:75px"></textarea></td>
			<td class="help">Any notes about this IP</td>
		</tr>
		<tr>
			<td class="label">Status</td>
			<td class="field">
				<input type="radio" name="enabled" value="yes" checked="checked" /> Enable<br />
				<input type="radio" name="enabled" value="no" /> Disable
			</td>
			<td class="help">Should we enable access from this IP?</td>
		</tr>
	</table>
    <p class="buttons">
			<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Add and continue'); ?>" value="<?php echo __('Add'); ?>" />
	</p>
</form>
</div>


<!-- <h1>Maintenance Access Control</h1> -->

<p>Below is a whitelist of all IP addresses that will be allowed access to the website, whilst in restricted mode.</p>

<div class="boxed">
<h2>Whitelisted IPs</h2>
<table class="index" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<th>IP</th>
		<th>Name</th>
		<th>Description</th>
		<th>Enabled</th>
		<th colspan="2">Edit</th>
	</thead>
	<tbody>
<?php

	foreach($allowed as $allow) {
		if($allow->enabled == 'yes') $target = 'no';
		if($allow->enabled == 'no') $target = 'yes';
?>
		<tr>
			<td><strong><?php echo $allow->ip; ?></strong></td>
			<td><strong><?php echo $allow->name; ?></strong></td>
<?php //if($allow->notes != '') { ?>
			<td><?php echo $allow->notes; ?></td>
<?php //} ?>
			<td>
				<a href="<?php echo get_url('maintenance/access/update/'.$allow->id.'/'.$target.''); ?>">
				   <img src="<?php echo PLUGINS_URI . 'maintenance/images/'.$allow->enabled.'.png'; ?>" /></a>
			</td>
			<td>
				<a href="<?php echo get_url('maintenance/view/'.$allow->id.''); ?>">
					<img src="<?php echo PLUGINS_URI; ?>maintenance/images/edit.png" /></a>
			</td>
			<td>
				<a href="<?php echo get_url('maintenance/delete/'.$allow->id.''); ?>" onclick="return confirm('You are about to remove access to this site during restricted mode from the IP address <?php echo $allow->ip ?>\n\nYou will also lose any associated notes and names.\n\nAre you sure you wish to do this?\n');">
					<img src="<?php echo URL_PUBLIC.ADMIN_DIR; ?>/images/icon-remove.gif" /></a>
			</td>
		</tr>

<?php

	}
?>
	</tbody>

</table>
</div>

