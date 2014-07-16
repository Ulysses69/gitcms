<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'seobox');

/* Set version setting */
$settings = array('version' => SEOBOX_VERSION);

// Check for existing settings
if(!Plugin::getSetting('sitemaplink', 'seobox')) $settings['sitemaplink'] = '';
if(!Plugin::getSetting('sitemaptitle', 'seobox')) $settings['sitemaptitle'] = 'breadcrumb';
if(!Plugin::getSetting('sitemapdescription', 'seobox')) $settings['sitemapdescription'] = '';
if(!Plugin::getSetting('sitemapheadings', 'seobox')) $settings['sitemapheadings'] = '';
if(!Plugin::getSetting('sitemaparchives', 'seobox')) $settings['sitemaparchives'] = '';
if(!Plugin::getSetting('clientlocation', 'seobox')) $settings['clientlocation'] = 'Cheltenham, Gloucestershire';
if(!Plugin::getSetting('clientanalytics', 'seobox')) $settings['clientanalytics'] = 'UA-XXXXX-X';
if(!Plugin::getSetting('clientanalyticssubdomain', 'seobox')) $settings['clientanalyticssubdomain'] = '';
if(!Plugin::getSetting('clientanalyticsstatus', 'seobox')) $settings['clientanalyticsstatus'] = 'on';
if(!Plugin::getSetting('clientanalyticslinks', 'seobox')) $settings['clientanalyticslinks'] = 'on';
if(!Plugin::getSetting('clientanalyticspolicy', 'seobox')) $settings['clientanalyticspolicy'] = '';
if(!Plugin::getSetting('clientanalyticsnoscript', 'seobox')) $settings['clientanalyticsnoscript'] = '';
if(!Plugin::getSetting('noticestatus', 'seobox')) $settings['noticestatus'] = 'on';
if(!Plugin::getSetting('noticedays', 'seobox')) $settings['noticedays'] = '30';
if(!Plugin::getSetting('noticelivecheck', 'seobox')) $settings['noticelivecheck'] = 'on';
if(!Plugin::getSetting('bots', 'seobox')) $settings['bots'] = 'disallow';
if(!Plugin::getSetting('clientanalyticsscreenstats', 'seobox')) $settings['clientanalyticsscreenstats'] = '';
if(!Plugin::getSetting('clientanalyticsversion', 'seobox')) $settings['clientanalyticsversion'] = 'classic';


// Check existing plugin settings
if (!$version || $version == null) {
	
    // This is a clean install.

    // Store settings.
    if (Plugin::setAllSettings($settings, 'seobox')) {
        Flash::set('success', __('SEO Box - plugin settings setup.'));
    }
    else
        Flash::set('error', __('SEO Box - unable to save plugin settings.'));


} else {


    // Upgrade from previous installation
    if (SEOBOX_VERSION > $version) {
		
        // Retrieve the old settings.
        $PDO = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';

        $sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='seobox'";
        $sql = "SELECT * FROM $tablename WHERE plugin_id='seobox'";

        $result = $PDO->query($sql_check);

        if (!$result) {
            Flash::set('error', __('SEO Box - unable to access plugin settings.'));
            return;
        }

        // Fetch the old installation's records.
        $result = $PDO->query($sql);

        if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
            if(defined('SEOBOX_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'plugin/seobox'); }
        }
    }


    // Store settings.
    if (isset($settings) && Plugin::setAllSettings($settings, 'seobox')) {
        if (SEOBOX_VERSION > $version){
			Flash::set('success', __('SEO Box - plugin settings updated.'));
		}
    }

}


?>