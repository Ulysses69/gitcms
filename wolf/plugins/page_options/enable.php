<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'page_options');

/* Set version setting */
$settings = array('version' => PAGEOPTIONS_VERSION);

/* Set new settings */
if(!Plugin::getSetting('updated_enabled', 'page_options')) $settings['updated_enabled'] = 'show';
if(!Plugin::getSetting('print_enabled', 'page_options')) $settings['print_enabled'] = 'show';
if(!Plugin::getSetting('print_mobile_enabled', 'page_options')) $settings['print_mobile_enabled'] = 'hide';
if(!Plugin::getSetting('print_title', 'page_options')) $settings['print_title'] = 'Print';
if(!Plugin::getSetting('print_icon', 'page_options')) $settings['print_icon'] = 'text';
if(!Plugin::getSetting('mobile_enabled', 'page_options')) $settings['mobile_enabled'] = 'show';
if(!Plugin::getSetting('mobile_desktop_enabled', 'page_options')) $settings['mobile_desktop_enabled'] = 'hide';
if(!Plugin::getSetting('mobile_title', 'page_options')) $settings['mobile_title'] = 'Mobile';
if(!Plugin::getSetting('mobile_icon', 'page_options')) $settings['mobile_icon'] = 'text';
if(!Plugin::getSetting('pdf_enabled', 'page_options')) $settings['pdf_enabled'] = 'show';
if(!Plugin::getSetting('pdf_mobile_enabled', 'page_options')) $settings['pdf_mobile_enabled'] = 'hide';
if(!Plugin::getSetting('pdf_title', 'page_options')) $settings['pdf_title'] = 'PDF';
if(!Plugin::getSetting('pdf_icon', 'page_options')) $settings['pdf_icon'] = 'text';
if(!Plugin::getSetting('top_of_page_enabled', 'page_options')) $settings['top_of_page_enabled'] = 'show';
if(!Plugin::getSetting('top_of_page_mobile_enabled', 'page_options')) $settings['top_of_page_mobile_enabled'] = 'hide';
if(!Plugin::getSetting('top_of_page_title', 'page_options')) $settings['top_of_page_title'] = 'Top of page';
if(!Plugin::getSetting('top_of_page_icon', 'page_options')) $settings['top_of_page_icon'] = 'text';
if(!Plugin::getSetting('pdf_bg_color', 'page_options')) $settings['pdf_bg_color'] = '#ffffff';
if(!Plugin::getSetting('pdf_text_color', 'page_options')) $settings['pdf_text_color'] = '#666666';
if(!Plugin::getSetting('pdf_link_color', 'page_options')) $settings['pdf_link_color'] = '#666666';
if(!Plugin::getSetting('print_logo_enabled', 'page_options')) $settings['print_logo_enabled'] = 'hide';
if(!Plugin::getSetting('print_logo_url', 'page_options')) $settings['print_logo_url'] = 'inc/img/logo.png';
if(!Plugin::getSetting('print_logo_width', 'page_options')) $settings['print_logo_width'] = '';
if(!Plugin::getSetting('print_logo_height', 'page_options')) $settings['print_logo_height'] = '';
if(!Plugin::getSetting('pdf_logo_enabled', 'page_options')) $settings['pdf_logo_enabled'] = 'hide';
if(!Plugin::getSetting('pdf_logo_url', 'page_options')) $settings['pdf_logo_url'] = 'inc/img/logo.png';
if(!Plugin::getSetting('pdf_logo_width', 'page_options')) $settings['pdf_logo_width'] = '';
if(!Plugin::getSetting('pdf_logo_height', 'page_options')) $settings['pdf_logo_height'] = '';
if(!Plugin::getSetting('pdf_download', 'page_options')) $settings['pdf_download'] = '';
if(!Plugin::getSetting('pdf_qrcode_enabled', 'page_options')) $settings['pdf_qrcode_enabled'] = 'show';
if(!Plugin::getSetting('pdf_qrcode_width', 'page_options')) $settings['pdf_qrcode_width'] = '150';
if(!Plugin::getSetting('pdf_qrcode_height', 'page_options')) $settings['pdf_qrcode_height'] = '150';

if(!Plugin::getSetting('pdf_size', 'page_options')) $settings['pdf_size'] = 'A4';
if(!Plugin::getSetting('pdf_orientation', 'page_options')) $settings['pdf_orientation'] = 'P';

if(!Plugin::getSetting('pdf_h1_color', 'page_options')) $settings['pdf_h1_color'] = '#222222';
if(!Plugin::getSetting('pdf_hx_color', 'page_options')) $settings['pdf_hx_color'] = '#666666';

// Check existing plugin settings
if (!$version || $version == null) {

	// This is a clean install.

	// Store settings.
	if (Plugin::setAllSettings($settings, 'page_options')) {
		Flash::set('success', __('Page Options - plugin settings setup.'));
	}
	else
		Flash::set('error', __('Page Options - unable to save plugin settings!'));


} else {


	// Upgrading from previous installation
	if (PAGEOPTIONS_VERSION > $version) {

		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'plugin_settings';

		$sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='page_options'";
		$sql = "SELECT * FROM $tablename WHERE plugin_id='page_options'";

		$result = $PDO->query($sql_check);

		if (!$result) {
			Flash::set('error', __('Page Options - unable to access plugin settings.'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
			if(defined('PAGEOPTIONS_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/page_options'); }
		}
	}

	// Store settings.
	if (isset($settings) && Plugin::setAllSettings($settings, 'page_options')) {
		if (PAGEOPTIONS_VERSION > $version){
			Flash::set('success', __('Page Options - plugin settings updated.'));
		}
	}


}

?>