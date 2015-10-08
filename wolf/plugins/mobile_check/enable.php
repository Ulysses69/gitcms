<?php

//echo 'MOBILE_VERSION (enable): ' . MOBILE_VERSION . '<br/>';
//exit;

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'mobile_check');

/* Set version setting */
$settings = array('version' => MOBILE_VERSION);

// Check for existing settings
//if(!Plugin::getSetting('version', 'mobile_check')) $settings['version'] = MOBILE_VERSION;
if(!Plugin::getSetting('enable', 'mobile_check')) $settings['enable'] = true;
if(!Plugin::getSetting('copyright', 'mobile_check')) $settings['copyright'] = true;
if(!Plugin::getSetting('screen_width', 'mobile_check')) $settings['screen_width'] = 640;
if(!Plugin::getSetting('tablet_width', 'mobile_check')) $settings['tablet_width'] = 768;
if(!Plugin::getSetting('website_width', 'mobile_check')) $settings['website_width'] = 960;
if(!Plugin::getSetting('logo', 'mobile_check')) $settings['logo'] = false;
if(!Plugin::getSetting('logo_url', 'mobile_check')) $settings['logo_url'] = '/inc/img/logo.png';
if(!Plugin::getSetting('desktop_text', 'mobile_check')) $settings['desktop_text'] = 'Full Website';
if(!Plugin::getSetting('topnav', 'mobile_check')) $settings['topnav'] = 'labels';
if(!Plugin::getSetting('theme', 'mobile_check')) $settings['theme'] = 'light';
if(!Plugin::getSetting('img_border', 'mobile_check')) $settings['img_border'] = 'none';
if(!Plugin::getSetting('color_img_border', 'mobile_check')) $settings['color_img_border'] = '#DEDEDE';
if(!Plugin::getSetting('color_body_bg', 'mobile_check')) $settings['color_body_bg'] = '#5D5D5D';
if(!Plugin::getSetting('color_body_border', 'mobile_check')) $settings['color_body_border'] = '#4E4E4E';
if(!Plugin::getSetting('color_main_link', 'mobile_check')) $settings['color_main_link'] = '#0689F4';
if(!Plugin::getSetting('color_main_text', 'mobile_check')) $settings['color_main_text'] = '#666666';
if(!Plugin::getSetting('color_footer_link', 'mobile_check')) $settings['color_footer_link'] = '#FFFFFF';
if(!Plugin::getSetting('color_footer_text', 'mobile_check')) $settings['color_footer_text'] = '#B5B5B5';
if(!Plugin::getSetting('color_button_bg', 'mobile_check')) $settings['color_button_bg'] = '#262728';
if(!Plugin::getSetting('color_button_border', 'mobile_check')) $settings['color_button_border'] = '#262728';
if(!Plugin::getSetting('color_button_opacity', 'mobile_check')) $settings['color_button_opacity'] = 'semiopaque';
if(!Plugin::getSetting('color_button_link', 'mobile_check')) $settings['color_button_link'] = '#FFFFFF';
if(!Plugin::getSetting('logo_maxwidth', 'mobile_check')) $settings['logo_maxwidth'] = '160px';
if(!Plugin::getSetting('viewport', 'mobile_check')) $settings['viewport'] = '';
if(!Plugin::getSetting('cachedcss', 'mobile_check')) $settings['cachedcss'] = '';
if(!Plugin::getSetting('color_content_bg', 'mobile_check')) $settings['color_content_bg'] = '#FFFFFF';
if(!Plugin::getSetting('color_content_h1', 'mobile_check')) $settings['color_content_h1'] = '#444444';
if(!Plugin::getSetting('color_content_text', 'mobile_check')) $settings['color_content_text'] = '#666666';
if(!Plugin::getSetting('color_content_link', 'mobile_check')) $settings['color_content_link'] = '#0689F4';
if(!Plugin::getSetting('content_font', 'mobile_check')) $settings['content_font'] = '';
if(!Plugin::getSetting('content_font_h1', 'mobile_check')) $settings['content_font_h1'] = 'yes';
if(!Plugin::getSetting('content_font_h2', 'mobile_check')) $settings['content_font_h2'] = 'no';
if(!Plugin::getSetting('content_font_intro', 'mobile_check')) $settings['content_font_intro'] = 'no';
if(!Plugin::getSetting('topnavhome', 'mobile_check')) $settings['topnavhome'] = 'disabled';
if(!Plugin::getSetting('background_url', 'mobile_check')) $settings['background_url'] = '';
if(!Plugin::getSetting('homecontent', 'mobile_check')) $settings['homecontent'] = 'disabled';
if(!Plugin::getSetting('color_head_bg', 'mobile_check')) $settings['color_head_bg'] = '';
if(!Plugin::getSetting('navpos', 'mobile_check')) $settings['navpos'] = 'top';
if(!Plugin::getSetting('homelogo', 'mobile_check')) $settings['homelogo'] = 'large';
if(!Plugin::getSetting('pagelogo', 'mobile_check')) $settings['pagelogo'] = 'small';
if(!Plugin::getSetting('background_align', 'mobile_check')) $settings['background_align'] = 'no-repeat center top';
if(!Plugin::getSetting('searchbox', 'mobile_check')) $settings['searchbox'] = true;
if(!Plugin::getSetting('logo_pos', 'mobile_check')) $settings['logo_pos'] = 'center';
if(!Plugin::getSetting('sidebar', 'mobile_check')) $settings['sidebar'] = 'false';
if(!Plugin::getSetting('customcss', 'mobile_check')) $settings['customcss'] = '';
if(!Plugin::getSetting('header_banner_home', 'mobile_check')) $settings['header_banner_home'] = '<div id="banner"></div>';
if(!Plugin::getSetting('header_banner', 'mobile_check')) $settings['header_banner'] = '<div id="banner"></div>';

/* TO DO: From version 1.5.3 (or even 1.1.0) Mobilefriendly layout needs updating */


// Check existing plugin settings
if (!$version || $version == null) {

	// This is a clean install.

	// Store settings.
	if (Plugin::setAllSettings($settings, 'mobile_check')) {
		Flash::set('success', __('MobileCheck - plugin settings setup.'));
	}
	else
		Flash::set('error', __('MobileCheck - unable to save plugin settings.'));


} else {

	// Upgrade from previous installation
	if (MOBILE_VERSION > $version) {
		
		//echo 'HEY UPDATE MOBILE_VERSION' . '<br/>';
		//exit;

		/*
		$navcss = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/nav.css';
		$navjs = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/nav.js';
		$toglejs = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/toggle.js';
		$new_navcss = $_SERVER{'DOCUMENT_ROOT'}.'/inc/css/nav.css';
		$new_navjs = $_SERVER{'DOCUMENT_ROOT'}.'/inc/js/nav.js';
		$new_togglejs = $_SERVER{'DOCUMENT_ROOT'}.'/inc/js/toggle.js';
		if (!copy($navcss, $new_navcss)) {
			Flash::set('error', 'Failed to copy nav.css');
		}
		if (!copy($navjs, $new_navjs)) {
			Flash::set('error', 'Failed to copy nav.js');
		}
		if (!copy($toglejs, $new_togglejs)) {
			Flash::set('error', 'Failed to copy toggle.js');
		}

		// Get nav JS Template
		ob_start();
		include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/mobile_check/lib/nav.js";
		$jstemplate = ob_get_contents();
		ob_end_clean();
  
		// Get toggle JS Template
		ob_start();
		include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/mobile_check/lib/toggle.js";
		$toggletemplate = ob_get_contents();
		ob_end_clean();

		// Remove comments array
		$regex = array(
		"`^([\t\s]+)`ism"=>'',
		"`^\/\*(.+?)\*\/`ism"=>"",
		"`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
		"`([\n\A;\s]+)//(.+?)[\n\r]`ism"=>"$1\n",
		"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
		);

		function compressjs($js){
			return preg_replace("/\s+/", " ", $js);
		}

		// Remove comments from nav JS Template
		//$navjstemplate = preg_replace(array_keys($regex),$regex,$jstemplate);

		// Compress nav js
		require_once($_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/elements/lib/class.JavaScriptPacker.php');
		$pack = new JavaScriptPacker($jstemplate, 'Normal', true, false);
		$navjstemplate = $pack->pack();

		// Get public nav js
		$navjspath = '/inc/js/';
		$navjsfile = 'nav.js';
		$navjsfilepath = $_SERVER{'DOCUMENT_ROOT'}.$navjspath.$navjsfile;

		// Try updating nav js
		if (file_exists($navjsfilepath)) {
			chmod($navjsfilepath, 0777);
			if(is_writable($navjsfilepath)){
				$jssave = fopen($navjsfilepath,'rb');
				$jscontents = fread($jssave, filesize($navjsfilepath));
				if($jssave == ''){
					Flash::set('error', $navjsfilepath.' ... cannot be read.');
				}
				if($navjstemplate != ''){
					$navjs = $navjstemplate;
				} else {
					Flash::set('error', $navjsfilepath.' ... cannot be updated.');
				}
				if($navjstemplate != ''){
					$jssave = fopen($navjsfilepath,'w+');
					$newjs = compressjs($navjs);
					// Update nav.js if not empty and contains no php error notices.
					if($newjs != '' && !stristr($newjs, '<b>Notice</b>:') && !stristr($newjs, ' on line <b>')){
						fwrite($jssave,$newjs);
					}
					chmod($navjsfilepath, 0644);
				}
				fclose($jssave);
			} else {
				Flash::set('error', $navjsfilepath.' ... is not writable.');
			}
		} else {
			Flash::set('error', $navjsfilepath.' ... does not exist.');
		}

		// Get public toggle js
		$togglejspath = '/inc/js/';
		$togglejsfile = 'toggle.js';
		$togglejsfilepath = $_SERVER{'DOCUMENT_ROOT'}.$togglejspath.$togglejsfile;

		// Remove comments from toggle JS Template
		$togglejstemplate = preg_replace(array_keys($regex),$regex,$toggletemplate);

		// Try updating toggle js
		if (file_exists($togglejsfilepath)) {
			chmod($togglejsfilepath, 0777);
			if(is_writable($togglejsfilepath)){
				$jssave = fopen($togglejsfilepath,'rb');
				$jscontents = fread($jssave, filesize($togglejsfilepath));
				if($jssave == ''){
					Flash::set('error', $togglejsfilepath.' ... cannot be read.');
				}
				if($togglejstemplate != ''){
					$togglejs = $togglejstemplate;
				} else {
					Flash::set('error', $togglejsfilepath.' ... cannot be updated.');
				}
				if($togglejstemplate != ''){
					$jssave = fopen($togglejsfilepath,'w+');
					$newjs = compressjs($togglejs);
					// Update toggle.js if not empty and contains no php error notices.
					if($newjs != '' && !stristr($newjs, '<b>Notice</b>:') && !stristr($newjs, ' on line <b>')){
						fwrite($jssave,$newjs);
					}
					chmod($togglejsfilepath, 0644);
				}
				fclose($jssave);
			} else {
				Flash::set('error', $togglejsfilepath.' ... is not writable.');
			}
		} else {
			Flash::set('error', $togglejsfilepath.' ... does not exist.');
		}

		//echo $jstemplate;
		//exit;
		
		// Copy nav js required files (overwrite if exists, should images be updates)
		$hamburger = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/hamburger.gif';
		$hamburger_retina = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/hamburger-retina.gif';
		$new_hamburger = $_SERVER{'DOCUMENT_ROOT'}.'/inc/img/hamburger.gif';
		$new_hamburger_retina = $_SERVER{'DOCUMENT_ROOT'}.'/inc/img/hamburger-retina.gif';

		if (!copy($hamburger, $new_hamburger)) {
			Flash::set('error', 'Failed to copy hamburger.gif');
		}
		if (!copy($hamburger_retina, $new_hamburger_retina)) {
			Flash::set('error', 'Failed to copy hamburger-retina.gif');
		}
		*/
		
		

		
		// TO DO: This causes re-direct problem
		updateMobileCSS();
		//echo 'SETTINGS: ' . $settings . '<br/>';
		//exit;











		if(isset($layoutcontent) && $layoutcontent != ''){
			//global $__FROG_CONN__;
			//$sql = "UPDATE ".TABLE_PREFIX."layout SET content='".$layoutcontent."' WHERE name='Mobilefriendly'";
			//$stmt = $__FROG_CONN__->prepare($sql);
			//$stmt->execute();
		}
		
		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'plugin_settings';

		$sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='mobile_check'";
		$sql = "SELECT * FROM $tablename WHERE plugin_id='mobile_check'";

		$result = $PDO->query($sql_check);

		if (!$result) {
			Flash::set('error', __('MobileCheck - unable to access plugin settings.'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
			/* TO DO: Reload page to reflect mobile version */
			//if(defined('MOBILE_CHECK_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/mobile_check'); }
			if (MOBILE_VERSION == $version) {
				redirect(get_url('plugin/mobile_check/update'));
			}
		}
	}


	// Store settings.
	if (isset($settings) && Plugin::setAllSettings($settings, 'mobile_check')) {
		//if (MOBILE_VERSION > $version){
		//	Flash::set('success', __('MobileCheck - plugin settings updated.'));
		//}
	}

}


?>