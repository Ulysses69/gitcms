<?php

/*
 * Redirector - Wolf CMS URL redirection plugin
 *
 * Copyright (c) 2010 Design Spike
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://themes.designspike.ca/redirector/help/
 *
 */

?>
<!-- <h1><?php echo __('Redirector'); ?></h1> -->

<h2 id="redirect_form_anchor"><?php echo __('Add Redirect'); ?></h2>
<div id="redirect_form">
	<form action="<?php echo get_url('plugin/redirector/save'); ?>" method="post">
		<table cellpadding="5" cellspacing="5" border="0" id="redirect_form_table"> 
		  <tr>
				<td>
					<label for="redirect_url"><?php echo __('Request URL from'); ?></label><br />
					<input class="textbox" id="redirect_url" maxlength="255" name="redirect[url]" type="text" value="" />
				</td>
				<td>
					<label for="redirect_destination"><?php echo __('Redirect URL to'); ?></label><br />
					<input class="textbox" id="redirect_destination" maxlength="255" name="redirect[destination]" type="text" value="" />
				</td>
				<!--
				<td class="status">
					<label for="redirect_status"><?php echo __('Status'); ?></label><br />
					<select id="redirect_status" name="redirect[status]" type="text" >
					<option value="301">Permanent</option>
					<option value="302">Temporary</option>
					</select>
				</td>
				-->
		  </tr> 
		</table>	
		  <p class="buttons">
				<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Add and continue'); ?>" value="<?php echo __('Add'); ?>" />
		  </p>
	</form>
</div>

<div class="boxed">
<h2><?php echo __('Redirects'); ?></h2>
<?php if(sizeof($current_redirects) > 0) { ?>
<table id="redirects" class="index">
	<thead id="requests" class="node_heading">
	<tr>
		<th class="url"><?php echo __('Requested URL'); ?></th>
		<th class="destination"><?php echo __('Redirects to'); ?></th>
		<!-- <th class="hits"><?php echo __('Hits'); ?></th> -->
		<!-- <th class="status"><?php echo __('Status'); ?></th> -->
		<th class="action"><?php echo __(''); ?></th>
	</tr>
	</thead>
	<?php foreach ($current_redirects as $redirect): ?>
	<tbody id="redirects_<?php echo $redirect->id; ?>" class="node">
	<tr>
	<?php $testlink = '/'.$redirect->url; $testlink = str_replace('//','/',$testlink) ?>
	 <!-- <img align="middle" alt="layout-icon" src="../../../wolf/plugins/redirector/images/redirect.png" title="" class="node_image" /> -->
		<td class="url"><!-- <?php echo $redirect->url; ?> --><a href="<?php echo $testlink; ?>" target="_blank" class="url_link"><?php echo $redirect->url; ?></a></td>
		<td class="destination"><?php echo $redirect->destination; ?></td>
		<!-- <td class="hits"><?php echo $redirect->hits; ?></td> -->
		<!-- <td class="status"><?php echo $redirect->status; ?></td> -->
		<td class="action"><a href="<?php echo get_url('plugin/redirector/remove/'.$redirect->id); ?>" onclick="return confirm('Are you sure you wish to delete this redirect?');"><img alt="Remove Redirect" src="../../../wolf/plugins/redirector/images/icon-remove.gif" /></a></td>
	</tr>
	</tbody>
	<?php endforeach ?>
</table>
<?php } else { ?>
	<p><em><?php echo __('There are no redirects set up yet.'); ?></em></p>
<?php } ?>
</div>






<?php
// Restrict access to enabled whitelist IPs, when IPs have been granted authorized access.
$settings = Plugin::getAllSettings('maintenance');
//if(Plugin::isEnabled('maintenance') == true && $settings['maintenanceAuthorizedAccess'] == 'on'){
if(Plugin::isEnabled('maintenance') == true){
?>
<div class="boxed">
<h2>Allowed IPs</h2>
<table class="index" cellpadding="0" cellspacing="0" border="0">

	<thead>
		<th>IP</th>
		<th>Name</th>
	</thead>

	<tbody>
    <?php
	$allowed = MaintenanceAccessControl::getAllowed();
    foreach($allowed as $allow) {
		if($allow->enabled == 'yes'){ ?>
		<tr>
			<td><strong><?php echo $allow->ip; ?></strong></td>
			<td><strong><?php echo $allow->name; ?></strong></td>
		</tr>

        <?php }

	} ?>
	</tbody>

</table>
</div>
<?php } ?>


<?php
	/* Check for existence of notfound scripts tab */
	$behavior_sql = "SELECT * FROM ".TABLE_PREFIX."page WHERE behavior_id='page_not_found'";
	$behavior_q = Record::getConnection()->query($behavior_sql);
	$behavior_f = $behavior_q->fetchAll(PDO::FETCH_OBJ);
	foreach ($behavior_f as $behavior) {
        $notfoundid = $behavior->id;
        if($notfoundid){
            $scripts_sql = "SELECT * FROM ".TABLE_PREFIX."page_part WHERE page_id='".$notfoundid."' AND name='scripts'";
            $scripts_q = Record::getConnection()->query($scripts_sql);
            $scripts_f = $scripts_q->fetchAll(PDO::FETCH_OBJ);
            if(count($scripts_f) > 0){
                echo '<p>Page '.$notfoundid.' Scripts Exists.</p>';
            }
            foreach ($scripts_f as $script) {
                $name = $script->name;
                $body = $script->id;
                $body_html = $script->content_html;
                if($body != '' || $body_html != ''){
                    //echo '<p>Page 10 Scripts Exists: '.$name.', '.$body.'</p>';
                }
            }
        }
	}

?>






<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($) {
		$('#jquery_notice').hide();
	});
</script>

