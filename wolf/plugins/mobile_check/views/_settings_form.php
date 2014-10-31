<?php

$enable					= Plugin::getSetting('enable', 'mobile_check');
$copyright				= Plugin::getSetting('copyright', 'mobile_check');
$screen_width			= Plugin::getSetting('screen_width', 'mobile_check');
$website_width			= Plugin::getSetting('website_width', 'mobile_check');
$logo					= Plugin::getSetting('logo', 'mobile_check');
$logo_url				= Plugin::getSetting('logo_url', 'mobile_check');
$desktop_text			= Plugin::getSetting('desktop_text', 'mobile_check');
$topnav					= Plugin::getSetting('topnav', 'mobile_check');
$theme					= Plugin::getSetting('theme', 'mobile_check');

$color_body_bg			= Plugin::getSetting('color_body_bg', 'mobile_check');
$color_body_border		= Plugin::getSetting('color_body_border', 'mobile_check');
$color_main_link		= Plugin::getSetting('color_main_link', 'mobile_check');
$color_main_text		= Plugin::getSetting('color_main_text', 'mobile_check');
$color_footer_link		= Plugin::getSetting('color_footer_link', 'mobile_check');
$color_footer_text		= Plugin::getSetting('color_footer_text', 'mobile_check');
$color_button_bg		= Plugin::getSetting('color_button_bg', 'mobile_check');
$color_button_border	= Plugin::getSetting('color_button_border', 'mobile_check');
$color_button_opacity	= Plugin::getSetting('color_button_opacity', 'mobile_check');

$color_button_link		= Plugin::getSetting('color_button_link', 'mobile_check');
$logo_maxwidth			= Plugin::getSetting('logo_maxwidth', 'mobile_check');
$viewport				= Plugin::getSetting('viewport', 'mobile_check');

$topnavhome				= Plugin::getSetting('topnavhome', 'mobile_check');
$background_url			= Plugin::getSetting('background_url', 'mobile_check');
$homecontent			= Plugin::getSetting('homecontent', 'mobile_check');
$color_head_bg			= Plugin::getSetting('color_head_bg', 'mobile_check');
$navpos					= Plugin::getSetting('navpos', 'mobile_check');
$homelogo				= Plugin::getSetting('homelogo', 'mobile_check');
$pagelogo				= Plugin::getSetting('pagelogo', 'mobile_check');
$background_align		= Plugin::getSetting('background_align', 'mobile_check');
$searchbox				= Plugin::getSetting('searchbox', 'mobile_check');
$logo_pos				= Plugin::getSetting('logo_pos', 'mobile_check');
$sidebar				= Plugin::getSetting('sidebar', 'mobile_check');
$customcss				= Plugin::getSetting('customcss', 'mobile_check');
$header_banner_home		= Plugin::getSetting('header_banner_home', 'mobile_check');
$header_banner			= Plugin::getSetting('header_banner', 'mobile_check');


?>

<br />

<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/jquery.miniColors.js"></script>
<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/jquery.cookie.js"></script>
<link type="text/css" rel="stylesheet" href="/wolf/plugins/mobile_check/js/jquery.miniColors.css" />
<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/scripts.js"></script>
<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/html5slider.js"></script>
<script type="text/javascript">
onload = function() {
  document.getElementById('one').onchange = function() {
	  document.getElementById('uno').innerHTML = this.value;
  };
  document.getElementById('one').onchange();
  document.getElementById('two').onchange = function() {
	  document.getElementById('dos').innerHTML = this.value;
  };
  document.getElementById('two').onchange();
  document.getElementById('mmm').innerHTML =
	['min: ' + document.getElementById('two').min,
	 'max: ' + document.getElementById('two').max,
	 'step: ' + document.getElementById('two').step].join(', ');
};
</script>


<form action="<?php echo get_url('plugin/mobile_check/save_settings'); ?>" method="post">

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Settings'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="enable"><?php echo __('Detection'); ?></label></td>
				<td class="field">
				<select name="enable" id="enable">
				<?php
				$enable_array = array(
				array ('Disabled', false),
				array ('Enabled', true));
				foreach($enable_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $enable){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Enable/disable mobile detection');?></td>
			</tr>

			<tr>
				<td class="label"><label for="screen_width"><?php echo __('Mobile Width'); ?></label></td>
				<td class="field">
				<input name="screen_width" id="screen_width" value="<?php echo $screen_width; ?>" />
				</td>
				<td class="help"><?php echo __('Pixel width of devices');?></td>
			</tr>

			<tr>
				<td class="label"><label for="website_width"><?php echo __('Website Width'); ?></label></td>
				<td class="field">
				<input name="website_width" id="website_width" value="<?php echo $website_width; ?>" />
				</td>
				<td class="help"><?php echo __('Pixel width of website');?></td>
			</tr>

			<tr>
				<td class="label"><label for="viewport"><?php echo __('Scale Behaviour'); ?></label></td>
				<td class="field">

				<!-- Check if website is responsive. If it is, then set mobile stylesheet (and consequently screen stylesheet) viewport to adapt to width -->
				<!-- Robots plugin handles set-width and assigns it actual website width value -->

				<select name="viewport" id="viewport">
				<?php
				$viewport_array = array(
				array ('Default', ''),
				array ('Fit to Website Width', 'width=set-width'),
				array ('Fit to Device Width', 'width=device-width, initial-scale=1.0, user-scalable=yes'),
				array ('Fit to Device Width (Strict)', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'));
				foreach($viewport_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $viewport){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Page size/scale');?></td>
			</tr>

		</table>
	</fieldset>



	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Navigation Menu'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">




<!-- New to 1.5.3 -->
			<!--
			<tr>
				<td class="label"><label for="nav_url">Icon URL</label></td>
				<td class="field"><input class="textbox" type="text" name="nav_url" id="nav_url" size="30" value="<?php echo $nav_url; ?>" /></td>
				<td class="help">URL of navigation menu icon</td>
			</tr>
			-->
			<tr>
				<td class="label"><label for="topnavhome"><?php echo __('Home Page'); ?></label></td>
				<td class="field">
				<select name="topnavhome" id="topnavhome">
				<?php
				$topnavhome_array = array(
				array ('Label', 'labels'),
				array ('Icon', 'icons'),
				array ('Menu', 'menu'),
				//array ('Menu', 'menu'),
				array ('Disabled', 'disabled'));
				foreach($topnavhome_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $topnavhome){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Enable/disable navigation/type for home page');?></td>
			</tr>




			<tr>
				<td class="label"><label for="topnav"><?php echo __('Main Pages'); ?></label></td>
				<td class="field">
				<select name="topnav" id="topnav">
				<?php
				$topnav_array = array(
				array ('Label', 'labels'),
				array ('Icon', 'icons'),
				array ('Menu', 'menu'),
				//array ('Menu', 'menu'),
				array ('Disabled', 'disabled'));
				foreach($topnav_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $topnav){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Enable/disable navigation/type for other pages');?></td>
			</tr>




			<tr>
				<td class="label"><label for="navpos"><?php echo __('Position'); ?></label></td>
				<td class="field">
				<select name="navpos" id="navpos">
				<?php
				$navpos_array = array(
				array ('Top of page', 'top'),
				array ('Below header', 'header'));
				foreach($navpos_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $navpos){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Position of navigation');?></td>
			</tr>

		</table>
	</fieldset>

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Appearance'); ?></legend>

			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">



			<?php if(Plugin::isEnabled('searchbox') == true){ ?>
			<tr>
				<td class="label"><label for="searchbox"><?php echo __('Search Box'); ?></label></td>
				<td class="field">
				<select name="searchbox" id="searchbox">
				<?php
				$searchbox_array = array(
				array ('Disabled', 'false'),
				array ('Enabled', 'true'));
				foreach($searchbox_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $searchbox){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Enable/disable search box');?></td>
			</tr>
			<?php } ?>

			<tr>
				<td class="label"><label for="asidebar"><?php echo __('Sidebar'); ?></label></td>
				<td class="field">
				<select name="sidebar" id="asidebar">
				<?php
				$sidebar_array = array(
				array ('Disabled', 'false'),
				array ('Enabled', 'true'));
				foreach($sidebar_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $sidebar){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Enable/disable sidebar');?></td>
			</tr>


			<tr>
			<td colspan="4">
			<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Logo'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="logo"><?php echo __('Logo'); ?></label></td>
				<td class="field">
				<select name="logo" id="logo">
				<?php
				if(Plugin::getSetting('clientname', 'clientdetails') != ''){ $logotext = Setting::get('admin_title'); } else { $logotext = 'text'; }
				$logo_array = array(
				array ("Image", 'logo'),
				array ("Text: ".$logotext, 'text'));
				foreach($logo_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $logo){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>

				<td class="help"><?php echo __('Display logo or <b>'.$logotext.'</b>');?></td>
			</tr>
			<tr>
				<td class="label"><label for="alogo_url">Image URL</label></td>
				<td class="field"><input class="textbox" type="text" name="logo_url" id="alogo_url" size="30" value="<?php echo $logo_url; ?>" /></td>
				<td class="help">If set to display. Max width is <b><?php echo $logo_maxwidth; ?></b></td>
			</tr>

			<tr>
				<td class="label"><label for="logo_pos"><?php echo __('Position'); ?></label></td>
				<td class="field">
				<select name="logo_pos" id="logo_pos">
				<?php
				$logo_pos_array = array(
				array ('Center', 'center'),
				array ('Left', 'left'));
				foreach($logo_pos_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $logo_pos){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Logo position');?></td>
			</tr>

			<!--
			<tr>
				<td class="label"><label for="alogo_maxwidth">Max Width</label></td>
				<td class="field"><input class="textbox" type="text" name="logo_maxwidth" id="alogo_maxwidth" size="30" value="<?php echo $logo_maxwidth; ?>" /></td>
				<td class="help">Max width of logo</td>
			</tr>
			-->

			<tr>
				<td class="label"><label for="homelogo"><?php echo __('Home Size'); ?></label></td>
				<td class="field">
				<select name="homelogo" id="homelogo">
				<?php
				$homelogo_array = array(
				array ('Large', 'large'),
				array ('Small', 'small'));
				foreach($homelogo_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $homelogo){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Size of logo on home page');?></td>
			</tr>

			<tr>
				<td class="label"><label for="pagelogo"><?php echo __('Size'); ?></label></td>
				<td class="field">
				<select name="pagelogo" id="pagelogo">
				<?php
				$pagelogo_array = array(
				array ('Large', 'large'),
				array ('Small', 'small'));
				foreach($pagelogo_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $pagelogo){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Size of logo on other pages');?></td>
			</tr>

			</table>
			</fieldset>
			</td>
			</tr>








			<!--
			<tr>
				<td class="label"><label for="theme"><?php echo __('Theme'); ?></label></td>
				<td class="field">
				<select name="theme" id="theme" disabled=disabled>
				<?php
				$theme_array = array(
				array ('Light', 'light'),
				array ('Dark', 'dark'));
				foreach($theme_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $theme){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Choose appearance.');?></td>
			</tr>
			-->


<!-- New to 1.5.3 -->
			<!--
			<?php //if($color_head_bg == ''){ $color_head_bg = $color_body_bg; } ?>
			<tr>
			<td colspan="4">
			<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Head'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="acolor_head_bg">Background Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_head_bg" id="acolor_head_bg" size="30" value="<?php echo $color_head_bg; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			</table>
			</fieldset>
			</td>
			</tr>
			-->




			<tr>
			<td colspan="4">
			<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Header'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="header_banner_home">Home Banner</label></td>
				<td class="field" colspan="2" style="padding-right:12px !important"><textarea name="header_banner_home" id="header_banner_home"><?php echo $header_banner_home; ?></textarea></td>
			</tr>
			<tr>
				<td class="label"><label for="header_banner">Main Banner</label></td>
				<td class="field" colspan="2" style="padding-right:12px !important"><textarea name="header_banner" id="header_banner"><?php echo $header_banner; ?></textarea></td>
			</tr>
			</table>
			</fieldset>
			</td>
			</tr>




			<tr>
			<td colspan="4">
			<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Body'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">

<!-- New to 1.5.4 -->
			<tr>
				<td class="label"><label for="homecontent"><?php echo __('Home Content'); ?></label></td>
				<td class="field">
				<select name="homecontent" id="homecontent">
				<?php
				$homecontent_array = array(
				array ('Show home content', 'enabled'),
				array ('Hide home content', 'disabled'));
				foreach($homecontent_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $homecontent){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Enable/disable home page content');?></td>
			</tr>

			<tr>
				<td class="label"><label for="acolor_body_bg">Background Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_body_bg" id="acolor_body_bg" size="30" value="<?php echo $color_body_bg; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>




<!-- New to 1.5.3 -->
			<tr>
				<td class="label"><label for="background_url">Background URL</label></td>
				<td class="field"><input class="textbox" type="text" name="background_url" id="background_url" size="30" value="<?php echo $background_url; ?>" /></td>
				<td class="help">URL of background image</td>
			</tr>
			<tr>
				<td class="label"><label for="background_align"><?php echo __('Background Align'); ?></label></td>
				<td class="field">
				<select name="background_align" id="background_align">
				<?php
				$background_align_array = array(
				array ('Top Center', 'no-repeat center top'),
				array ('Top Left', 'no-repeat left top'),
				array ('Vertical Tile', 'repeat-y center top'),
				array ('Horizontal Tile', 'repeat-x center top'),
				array ('Full Tile', 'repeat center top'));
				foreach($background_align_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $background_align){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Position background image');?></td>
			</tr>




			<tr>
				<td class="label"><label for="acolor_body_border">Borders Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_body_border" id="acolor_body_border" size="30" value="<?php echo $color_body_border; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			<tr>
				<td class="label"><label for="acolor_main_text">Text Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_main_text" id="acolor_main_text" size="30" value="<?php echo $color_main_text; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			<tr>
				<td class="label"><label for="acolor_main_link">Links Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_main_link" id="acolor_main_link" size="30" value="<?php echo $color_main_link; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			</table>
			</fieldset>
			</td>
			</tr>


			<tr>
			<td colspan="4">
			<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Footer'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="acolor_footer_text">Text Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_footer_text" id="acolor_footer_text" size="30" value="<?php echo $color_footer_text; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			<tr>
				<td class="label"><label for="acolor_footer_link">Links Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_footer_link" id="acolor_footer_link" size="30" value="<?php echo $color_footer_link; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>

			<tr>
				<td class="label"><label for="adesktop_text">Desktop Link</label></td>
				<td class="field"><input class="textbox" type="text" name="desktop_text" id="adesktop_text" size="30" value="<?php echo $desktop_text; ?>" /></td>
				<td class="help">Set text or leave empty to disable link</td>
			</tr>

			<tr>
				<td class="label"><label for="acopyright"><?php echo __('Copyright'); ?></label></td>
				<td class="field">
				<select name="copyright" id="acopyright">
				<?php
				$copyright_array = array(
				array ('Branded', true),
				array ('Unbranded', false));
				foreach($copyright_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $copyright){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Enable/disable branded copyright in footer');?></td>
			</tr>

			</table>
			</fieldset>
			</td>
			</tr>


			<tr>
			<td colspan="4">
			<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Buttons'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="acolor_button_bg">Background Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_button_bg" id="acolor_button_bg" size="30" value="<?php echo $color_button_bg; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			<!--
			<tr>
				<td class="label"><label for="acolor_button_link_opacity">Background Opacity</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_button_link_opacity" id="acolor_button_link_opacity" size="30" value="<?php echo $color_button_link_opacity; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			-->
			<tr>
				<td class="label"><label for="acolor_button_border">Border Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_button_border" id="acolor_button_border" size="30" value="<?php echo $color_button_border; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			<tr>
				<td class="label"><label for="acolor_button_link">Text Colour</label></td>
				<td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="color_button_link" id="acolor_button_link" size="30" value="<?php echo $color_button_link; ?>" /></td>
				<td class="help">(#XXXXXX)</td>
			</tr>
			<tr>
				<td class="label"><label for="color_button_opacity"><?php echo __('Opacity'); ?></label></td>
				<td class="field">
				<select name="color_button_opacity" id="color_button_opacity">
				<?php
				$color_button_opacity_array = array(
				array ("Solid", 'solid'),
				array ("Semiopaque", 'semiopaque'));
				foreach($color_button_opacity_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $color_button_opacity){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Style of background.');?></td>
			</tr>
			</table>
			</fieldset>
			</td>
			</tr>

			<tr>
			<td colspan="4">
			<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Styling'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="customcss">CSS</label></td>
				<td class="field" colspan="2" style="padding-right:12px !important"><textarea name="customcss" id="customcss"><?php echo $customcss; ?></textarea></td>
			</tr>
			</table>
			</fieldset>
			</td>
			</tr>


		</table>
	</fieldset>
	
	<!--
	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Menu'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		   <tr>
			   <td colspan="2">List</td>
		   </tr>
			<tr>
				<td class="label"><label for="page1">Page 1</label></td>
				<td class="field"><input type="checkbox" name="page1" id="page1" value="yes" class="checkbox"<?php if($page1 == "yes"){echo " checked";}?>/></td>
			</tr>
		</table>
	</fieldset>
	-->

	<p class="buttons">
		<input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
	</p>

</form>