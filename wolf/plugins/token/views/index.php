<?php


/*
 * Token - Wolf CMS URL token plugin
 *
 * Copyright (c) 2012 Steven Henderson
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 *
 */

?>
<!-- <h1><?php echo __('Token'); ?></h1> -->
<p id="jquery_notice"><img align="top" alt="layout-icon" src="../../../wolf/plugins/token/images/error_16.png" title="" class="node_image" />&nbsp;<strong>Note</strong>: It appears jQuery is not available. Please install and activate the <a href="http://github.com/tuupola/frog_jquery">jQuery plugin</a>.</p>
<h2 id="token_form_anchor"><?php echo __('Add Token'); ?></h2>
<div id="token_form">
	<form action="<?php echo get_url('plugin/token/save'); ?>" method="post">
		<table cellpadding="5" cellspacing="5" border="0" id="token_form_table"> 
		  <tr> 
				<td class="token_placeholder">
					<label for="token_placeholder"><?php echo __('Name'); ?></label><br />
					<input class="textbox" id="token_placeholder" maxlength="255" name="token[placeholder]" type="text" value="" title="Placeholder" />
				</td>
				<td class="token_literal_main">
					<label for="token_literal_main"><?php echo __('Value'); ?></label><br />
					<input class="textbox" id="token_literal_main" maxlength="255" name="token[literal_main]" type="text" value="" title="Literal value" />
				</td>
				<td class="token_literal_mobile">
					<label for="token_literal_mobile"><?php echo __('Equiv'); ?></label><br />
					<input class="textbox" id="token_literal_mobile" maxlength="255" name="token[literal_mobile]" type="text" value="" title="Literal value for mobile devices etc" />
				</td>
		  </tr> 
		</table>	
		  <p class="buttons">
				<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Save and continue'); ?>" value="<?php echo __('Save'); ?>" />
		  </p>
	</form>
</div>

<h2><?php echo __('Tokens'); ?></h2>

<div id="history">
<?php if(sizeof($current_tokens) > 0) { ?>
<ul id="tokens" class="index">
	  <li id="tokens" class="node_heading">
		<div class="placeholder"><?php echo __('Name'); ?></div>
		<div class="literal_main"><?php echo __('Value'); ?></div>
		<div class="literal_mobile"><?php echo __('Mobile Value'); ?></div>
	</li>
	<?php foreach ($current_tokens as $token): ?>
	  <li id="tokens_<?php echo $token->id; ?>" class="node">
		<img align="middle" alt="layout-icon" src="../../../wolf/plugins/token/images/label.png" title="" class="node_image" />
		<a href="#" class="placeholder_link"><?php echo $token->placeholder; ?></a>
		<div class="literal_main"><?php echo $token->literal_main; ?></div>
		<div class="literal_mobile"><?php echo $token->literal_mobile; ?></div>
		<div class="remove"><a href="<?php echo get_url('plugin/token/remove/'.$token->id); ?>" onclick="return confirm('Are you sure you wish to delete this token?');"><img alt="Remove Token" src="../../../wolf/plugins/token/images/icon-remove.gif" /></a></div>
	</li>
	<?php endforeach ?>
</ul>
<?php } else { ?>
	<p id="noactivity"><?php echo __('There are no tokens yet.'); ?></p>
<?php } ?>
</div>


