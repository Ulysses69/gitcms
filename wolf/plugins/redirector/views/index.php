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
<p id="jquery_notice"><img align="top" alt="layout-icon" src="../../../wolf/plugins/redirector/images/error_16.png" title="" class="node_image" />&nbsp;<strong>Note</strong>: It appears jQuery is not available. Please install and activate the <a href="http://github.com/tuupola/frog_jquery">jQuery plugin</a>.</p>

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
				<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Save and continue'); ?>" value="<?php echo __('Save'); ?>" />
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



<!--
<h2>Rules</h2>

<?php
$redirects_sql = "SELECT * FROM redirector_redirects ORDER BY destination, url";
$redirects_q = Record::getConnection()->query($redirects_sql);
$redirects_f = $redirects_q->fetchAll(PDO::FETCH_OBJ);
foreach ($redirects_f as $redirects) {
 	$url = stripslashes($redirects->url);
  	$destination = stripslashes($redirects->destination);
  	$status = $redirects->status;
  	if($url == '/'){
		echo "RewriteCond %{REQUEST_URI} ^/+$<br/>";
		echo "RewriteRule ^/*$ ".$destination." [L,R=".$status."]<br/>";
	} else {
  	 	if(stristr($destination,'?')){
			echo 'redirect 301 '.$url.' '.$destination."<br/>";
		} else if(stristr($url, '?')){

			//$url = $url."$"; $destination = $destination."?";
			$url = str_replace("?","$<br/>RewriteCond %{QUERY_STRING} ^",$url)."$";
			echo "RewriteCond %{REQUEST_URI} ^".$url."<br/>";
			echo "RewriteRule ^(.*)$ ".$destination."? [L,R=".$status."]<br/>";

		} else {
			echo "RewriteRule ^".ltrim($url,'/').' '.$destination." [L,R=".$status."]<br/>";
		}
	}
}
?>
-->




<!--
<div class="boxed">
<h2><?php echo __('Pages Errors'); ?></h2>
<?php if(sizeof($current_404s) > 0) { ?>
<ul id="redirects" class="index"> 
	  <li id="redirects" class="node_heading">
		<div class="url"><?php echo __('Requested URL'); ?></div>
		<div class="hits"><?php echo __('Hits'); ?></div>
	</li>
	<?php foreach ($current_404s as $error): ?>
	  <li id="redirects_<?php echo $error->id; ?>" class="node"> 
		<img align="middle" alt="layout-icon" src="../../../wolf/plugins/redirector/images/error.png" title="" class="node_image" /> 
		<a href="#" class="url_link"><?php echo $error->url; ?></a>
		<div class="hits"><?php echo $error->hits; ?></div>
		<div class="remove"><a href="<?php echo get_url('plugin/redirector/remove_404/'.$error->id); ?>" onclick="return confirm('Are you sure you wish to delete this redirect?');"><img alt="Remove Redirect" src="../../../wolf/plugins/redirector/images/icon-remove.gif" /></a></div>
	  </li> 
	<?php endforeach ?>
</ul>
<?php } else { ?>
	<p><?php echo __('No pages have been logged as not found.'); ?></p>
<?php } ?>
</div>
-->


<!-- Click existing redirects to copy to new redirect
<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($) {
		$('#jquery_notice').hide();
		$('#redirect_url').focus();
		$('.url').click(function(){
			$('#redirect_url').val($(this).html());
			$('#redirect_destination').val($(this).siblings('.destination').html());
			$.scrollTo('#redirect_form_anchor', 400);
			$('#redirect_destination').focus();
			return false;
		});
		$('.destination').click(function(){
			$('#redirect_url').val($(this).siblings('.url').html());
			$('#redirect_destination').val($(this).html());
			$.scrollTo('#redirect_form_anchor', 400);
			$('#redirect_destination').focus();
			return false;
		});
	});
</script>
-->



<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($) {
		$('#jquery_notice').hide();
	});
</script>


<!--
<style type="text/css" media="screen">
	#redirect_form {
		position: relative;
		background-color: #fff;
		padding: 10px 10px 40px 10px;
		margin: 0 0 20px 0;
	}
	#redirect_form p {
		margin: 15px 0 10px 0;
	}
	#redirect_form_table {
		width: 100%;
	}
	#redirect_form_table td {
		padding: 0 10px 10px 0;
	}
	#redirect_url, #redirect_destination {
		width: 100%;
		height: 20px;
	}
	.node_heading, .node {
		height: 32px;
	}
	.node_image {
		margin-right: 3px;
	}
	.url{
		position:absolute;
		top:7px; 		
	}
	.destination { 
		padding: 0;
		margin: 0;
		display: block;
		position:absolute;
		left:45%;
		top:7px;
		cursor: pointer;
	}
	#requests .url, #requests .destination {
		position: relative;
		width: 45%;
		left: 0;
	}
	.hits { 
		position:absolute;
		right:60px;
		top:7px; 
	}
</style>
-->