<?php ?>
<h1><?php echo __('SiteSearch'); ?></h1>
<p id="jquery_notice"><img align="top" alt="layout-icon" src="../../../wolf/plugins/site_search/images/error_16.png" title="" class="node_image" />&nbsp;<strong>Note</strong>: It appears jQuery is not available. Please install and activate the <a href="http://github.com/tuupola/frog_jquery">jQuery plugin</a>.</p>
<p id="searchquery_form_anchor"><strong><?php echo __('Add Redirect'); ?></strong></p> 
<div id="searchquery_form">
	<form action="<?php echo get_url('plugin/site_search/save'); ?>" method="post">
		<table cellpadding="5" cellspacing="5" border="0" id="searchquery_form_table"> 
		  <tr> 
				<td>
					<label for="searchquery_url"><?php echo __('Requested URL'); ?></label><br />
					<input class="textbox" id="searchquery_url" maxlength="255" name="searchquery[url]" type="text" value="" />
				</td>
				<td>
					<label for="searchquery_destination"><?php echo __('Queries to'); ?></label><br />
					<input class="textbox" id="searchquery_destination" maxlength="255" name="searchquery[destination]" type="text" value="" />
				</td> 
		  </tr> 
		</table>	
		  <p> 
				<input class="button" name="commit" type="submit" accesskey="s" value="Save" /> 
		  </p> 
	</form>
</div>
<p><strong><?php echo __('Queries'); ?></strong></p> 
<?php if(sizeof($current_searchquerys) > 0) { ?>
<ul id="searchquerys" class="index"> 
	  <li id="searchquerys" class="node_heading"> 
		<div class="url"><?php echo __('Requested URL'); ?></div>
		<div class="destination"><?php echo __('Queries to'); ?></div>
		<div class="hits"><?php echo __('Hits'); ?></div>
	</li>
	<?php foreach ($current_searchquerys as $searchquery): ?>
	  <li id="searchquerys_<?php echo $searchquery->id; ?>" class="node"> 
		<img align="middle" alt="layout-icon" src="../../../wolf/plugins/site_search/images/searchquery.png" title="" class="node_image" /> 
		<a href="#" class="url_link"><?php echo $searchquery->url; ?></a> 
		<div class="destination"><?php echo $searchquery->destination; ?></div>
		<div class="hits"><?php echo $searchquery->hits; ?></div>
		<div class="remove"><a href="<?php echo get_url('plugin/site_search/remove/'.$searchquery->id); ?>" onclick="return confirm('Are you sure you wish to delete this searchquery?');"><img alt="Remove Redirect" src="../../../wolf/plugins/site_search/images/icon-remove.gif" /></a></div> 
	</li>
	<?php endforeach ?>
</ul>
<?php } else { ?>
	<p><em><?php echo __('There are no searchquerys set up yet.'); ?></em></p>
<?php } ?>

<p><strong><?php echo __('Match Errors'); ?></strong></p> 
<?php if(sizeof($current_Matches) > 0) { ?>
<ul id="searchquerys" class="index"> 
	  <li id="searchquerys" class="node_heading"> 
		<div class="url"><?php echo __('Requested URL'); ?></div>
		<div class="hits"><?php echo __('Hits'); ?></div>
	</li>
	<?php foreach ($current_Matches as $error): ?>
	  <li id="searchquerys_<?php echo $error->id; ?>" class="node"> 
		<img align="middle" alt="layout-icon" src="../../../wolf/plugins/site_search/images/error.png" title="" class="node_image" /> 
		<a href="#" class="url_link"><?php echo $error->url; ?></a>
		<div class="hits"><?php echo $error->hits; ?></div>
		<div class="remove"><a href="<?php echo get_url('plugin/site_search/remove_Match/'.$error->id); ?>" onclick="return confirm('Are you sure you wish to delete this searchquery?');"><img alt="Remove Redirect" src="../../../wolf/plugins/site_search/images/icon-remove.gif" /></a></div>
	  </li> 
	<?php endforeach ?>
</ul>
<?php } else { ?>
	<p><em><?php echo __('There are no Match errors collected yet.'); ?></em></p>
<?php } ?>

<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($) {
		$('#jquery_notice').hide();
		$('#searchquery_url').focus();
		$('.url_link').click(function(){
			$('#searchquery_url').val($(this).html());
			$('#searchquery_destination').val($(this).siblings('.destination').html());
			$.scrollTo('#searchquery_form_anchor', 400);
			$('#searchquery_destination').focus();
			return false;
		});
		$('.destination').click(function(){
			$('#searchquery_url').val($(this).siblings('.url_link').html());
			$('#searchquery_destination').val($(this).html());
			$.scrollTo('#searchquery_form_anchor', 400);
			$('#searchquery_destination').focus();
			return false;
		});
	});
</script>
<style type="text/css" media="screen">
	#searchquery_form {
		background-color: #fff;
		padding: 10px;
	}
	#searchquery_form p {
		margin: 15px 0 10px 0;
	}
	#searchquery_form_table {
		width: 100%;
	}
	#searchquery_form_table td {
		padding: 0 10px 10px 0;
	}
	#searchquery_url, #searchquery_destination {
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
	.hits { 
		position:absolute;
		right:60px;
		top:7px; 
	}
</style>