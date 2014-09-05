<?php
	$servpath 		= dirname(__FILE__);
	$bannerid		= Plugin::getSetting('bannerid', 'banner5');
	$bannerwidth	= Plugin::getSetting('bannerwidth', 'banner5');
	$bannerheight	= Plugin::getSetting('bannerheight', 'banner5');
	$bannerradius	= Plugin::getSetting('bannerradius', 'banner5');
	$bannercode		= Plugin::getSetting('bannercode', 'banner5');
	$bannerimages	= Plugin::getSetting('bannerimages', 'banner5');
	$pref_controls	= Plugin::getSetting('pref_controls', 'banner5');
	$bannerinclude	= Plugin::getSetting('bannerinclude', 'banner5');
	$bannerexclude	= Plugin::getSetting('bannerexclude', 'banner5');
	$imagesarray	= Plugin::getSetting('imagesarray', 'banner5');
	$descriptionsarray	= Plugin::getSetting('descriptionsarray', 'banner5');
	$pref_random	= Plugin::getSetting('pref_random', 'banner5');
	$pref_preload	= Plugin::getSetting('pref_preload', 'banner5');
	$pref_transition= Plugin::getSetting('pref_transition', 'banner5');
	$pref_burns		= Plugin::getSetting('pref_burns', 'banner5');
	$pref_burntime	= Plugin::getSetting('pref_burntime', 'banner5');
	$pref_time		= Plugin::getSetting('pref_time', 'banner5');
	$pref_pause		= Plugin::getSetting('pref_pause', 'banner5');
	$pref_delay		= Plugin::getSetting('pref_delay', 'banner5');
?>

<form action="<?php echo get_url('plugin/banner5/save_settings'); ?>" method="post">

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Configuration'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="bannerimages"><?php echo __('Images path'); ?></label></td>
				<td class="field"><input class="textbox" name="bannerimages" id="bannerimages" value="<?php echo $bannerimages; ?>" /></td>
				<td class="help"><?php echo __('Path where banner images reside.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_controls"><?php echo __('Controls'); ?></label></td>
				<td class="field">
				<select name="pref_controls" id="pref_controls">
				<?php
				$pref_controls_array = array(
				array ('True', 'true'),
				array ('False', 'false'));
				foreach($pref_controls_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $pref_controls){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Options for banner controls.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_random"><?php echo __('Random'); ?></label></td>
				<td class="field">
				<select name="pref_random" id="pref_random">
				<?php
				$pref_random_array = array(
				array ('True', 'true'),
				array ('False', 'false'));
				foreach($pref_random_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $pref_random){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Option to randomise images.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_preload"><?php echo __('Preload'); ?></label></td>
				<td class="field"><input class="textbox" name="pref_preload" id="pref_preload" value="<?php echo $pref_preload; ?>" /></td>
				<td class="help"><?php echo __('Number of images to preload (0 - 1000).');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_transition"><?php echo __('Transition type'); ?></label></td>
				<td class="field">
				<select name="pref_transition" id="pref_transition">
				<?php
				$pref_transition_array = array(
				array ('None', 'noTransition'),
				array ('Blend', 'blend'),
				array ('Left to Right', 'leftToRight'),
				array ('Right to Left', 'rightToLeft'),
				array ('Top to Bottom', 'topToBottom'),
				array ('Bottom to Top', 'bottomToTop'),
				array ('Left to Right Blend', 'leftToRightBlend'),
				array ('Right to Left Blend', 'rightToLeftBlend'),
				array ('Top to Bottom Blend', 'topToBottomBlend'),
				array ('Bottom to Top Blend', 'bottomToTopBlend'),
				array ('Left to Right Fade Out Backwards', 'leftToRightFadeOutBackwards'),
				array ('Right to Left Fade Out Backwards', 'rightToLeftFadeOutBackwards'),
				array ('Top to Bottom Fade Out Backwards', 'topToBottomFadeOutBackwards'),
				array ('Bottom to Top Fade Out Backwards', 'bottomToTopFadeOutBackwards'),
				array ('Pinhole', 'pinhole'),
				array ('Pinhole Blend', 'pinholeBlend'),
				array ('Fade In/Fade Out', 'fadeInOut'),
				array ('Bubbles', 'bubbles'),
				array ('Bubbles Blend', 'bubblesBlend'),
				array ('Photo Flash', 'photoFlash'),
				array ('Star Swipe', 'starWipe'),
				array ('Star Swipe Blend', 'starWipeBlend'));
				foreach($pref_transition_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $pref_transition){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Type of transition between images.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_time"><?php echo __('Transition time'); ?></label></td>
				<td class="field"><input class="textbox" name="pref_time" id="pref_time" value="<?php echo $pref_time; ?>" /></td>
				<td class="help"><?php echo __('Duration of transition. (0.1 - 1000)');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_pause"><?php echo __('Transition interval'); ?></label></td>
				<td class="field"><input class="textbox" name="pref_pause" id="pref_pause" value="<?php echo $pref_pause; ?>" /></td>
				<td class="help"><?php echo __('Time delay between transitions. (0.5+)');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_delay"><?php echo __('Transition delay'); ?></label></td>
				<td class="field"><input class="textbox" name="pref_delay" id="pref_delay" value="<?php echo $pref_delay; ?>" /></td>
				<td class="help"><?php echo __('Set to same value as Transition interval.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_burns"><?php echo __('Tweening'); ?></label></td>
				<td class="field">
				<select name="pref_burns" id="pref_burns">
				<?php
				$pref_burns_array = array(
				array ('None', 'none'),
				array ('Random', 'random'),
				array ('Random Pan', 'randomPan'),
				array ('Random Zoom In', 'randomZoomIn'),
				array ('Random Zoom Out', 'randomZoomOut'));
				foreach($pref_burns_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $pref_burns){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Transition easing.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pref_burntime"><?php echo __('Tween time'); ?></label></td>
				<td class="field"><input class="textbox" name="pref_burntime" id="pref_burntime" value="<?php echo $pref_burntime; ?>" /></td>
				<td class="help"><?php echo __('Duration of easing. (0.1 - 1000)');?></td>
			</tr>
		</table>
	</fieldset>
	<!--
	<br/>
	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Page association'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label" style="text-align:left"><?php echo __('Include on pages'); ?></label><p style="margin:0;color:#666"><small>List of page slugs, seperated by comma.</small></p></td>
				<td class="label" style="text-align:left"><?php echo __('Exclude from pages'); ?></label><p style="margin:0;color:#666"><small>List of page slugs, seperated by comma.</small></p></td>
			</tr>
			<tr>
				<td class="field"><input class="textbox" name="bannerinclude" id="bannerinclude" value="<?php echo $bannerinclude; ?>" /></td>
				<td class="field"><input class="textbox" name="bannerexclude" id="bannerexclude" value="<?php echo $bannerexclude; ?>" /></td>
			</tr>
		</table>
	</fieldset>
	<br/>
	-->
	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Properties'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="bannerid" id="abannerid"><?php echo __('Banner ID'); ?></label></td>
				<td class="field"><input class="textbox" name="bannerid" value="<?php echo $bannerid; ?>" /></td>
				<td class="help"><?php echo __('ID of the banner.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="bannerwidth"><?php echo __('Width'); ?></label></td>
				<td class="field"><input class="textbox" type="text" name="bannerwidth" id="abannerwidth" size="4" maxlength="4" value="<?php echo $bannerwidth; ?>" /></td>
				<td class="help"><?php echo __('Banner width in pixels.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="bannerheight"><?php echo __('Height'); ?></label></td>
				<td class="field"><input class="textbox" type="text" name="bannerheight" id="abannerheight" size="4" maxlength="4" value="<?php echo $bannerheight; ?>" /></td>
				<td class="help"><?php echo __('Banner height in pixels.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="bannerradius"><?php echo __('Corner radius'); ?></label></td>
				<td class="field"><input class="textbox" type="text" name="bannerradius" id="abannerradius" size="4" maxlength="4" value="<?php echo $bannerradius; ?>" /></td>
				<td class="help"><?php echo __('Corner radius in pixels.');?></td>
			</tr>
			<!-- <tr>
				<td class="label"><label for="bannercode"><?php echo __('Banner code'); ?></label></td>
				<td class="field"><textarea class="textbox" style="height:6em;font-size: 100%" type="text" name="bannercode" id="abannercode" rows="6" cols="10" /><?php echo $bannercode; ?></textarea></td>
				<td class="help"><?php echo __('The element you wish to replace with a banner. If you wish to replace the ID of your banner element here, be sure to update the <a href="'.$_SERVER['REQUEST_URI'].'#abannerid">Banner ID</a> too.');?></td>
			</tr> -->
		</table>
	</fieldset>


	<?php
	$servpath = dirname(__FILE__);
	if (stristr($servpath, '/')){
		$strike = '/';
		$bannerpath = $bannerimages;
		$servpath = str_replace('/wolf/plugins/banner5/views','',$servpath);
	} else {
		$strike = '\\';
		$bannerpath = str_replace('/','\\',$bannerimages);
		$servpath = str_replace('\wolf\plugins\banner5\views','',$servpath);
	}
	//$files = banner5files($servpath.$bannerpath, $bannerimages, 'table');
	$files = banner5files($servpath.$bannerpath, $bannerimages, 'images');

	/*
	if($files != ''){?>
	<fieldset style="padding: 0.5em;" id="bannerimages">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Banner Images'); ?></legend>
		<?php echo $files; ?>
	</fieldset>
	<?php } ?>
	*/

	if($files != ''){?>
	<fieldset style="padding: 0.5em;" id="bannerimages">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Banner Images'); ?></legend>
		<ul>
		<?php
		$banners = banner5files($servpath.$bannerpath, $bannerimages, 'comma'); //echo rtrim($banners, ',');
		$banner_array = explode(',', rtrim($banners, ','));
		$banner_title_array = explode('|', rtrim($descriptionsarray, '|'));
	
		$getimagesarray = '';
		$title_array = array();
		for ($i = 0; $i < sizeof($banner_array); $i++) {
			$img = exif_read_data($servpath.$bannerpath.$banner_array[$i]);
			$title = $banner_title_array[$i];
			//$title = $img['FileSize'];
			//array_push($title_array, $title);
			echo '<li>';
			//echo $banner_array[$i];
			$imgpath = str_replace('view/public','view',ADMIN_DIR.'/plugin/file_manager/view'.$bannerimages);
			echo '<a href="/'.$imgpath.$banner_array[$i].'" target="_blank"><img src="'.Plugin::getSetting('bannerimages', 'banner5').'_thumbs/_'.$banner_array[$i].'" alt="'.$title.'" /></a>';
			echo '<textarea name="title'.$i.'" id="title'.$i.'">'.$title.'</textarea></li>';
			/* Images array is built to measure number of images to assign title fields to */
			$getimagesarray .= $banner_array[$i].',';
		} ?>
		</ul>
	</fieldset>	
	<input value="<?php echo substr_replace($getimagesarray,'',-1); ?>" name="imagesarray" id="imagesarray" type="hidden" />
	<?php } ?>



	<p class="buttons">
		<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Save then close'); ?>" value="<?php echo __('Save'); ?>" />
		<a href="<?php echo get_url('setting/'); ?>" id="site-cancel-page" class="button" title="<?php echo __('Close without saving'); ?>"><?php echo __('Cancel'); ?></a>
	</p>

</form>
