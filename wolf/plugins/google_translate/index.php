<?php

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/**
 * The Google Translate plugin just adds a Google Translate 
 * bar to the top of your page
 *
 * @package Plugins
 * @subpackage google_translate
 *
 * @author thulium
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */

Plugin::setInfos(array(
    'id'          => 'google_translate',
    'title'       => __('Google Translate'),
    'description' => __('Adds a translate dropdown to the top of your webpage in a multitude of languages.'),
    'version'     => '0.0.1',
   	'license'     => 'GPL',
	'author'      => 'thulium',
	'update_url'  => 'http://raw.github.com/thulium/wolf_plugins/master/update.xml',
    'website'     => 'http://www.wolfcms.org/',
    //'require_wolf_version' => '0.7.5'
));

Plugin::addController('google_translate', __('Google Translate'), 'administrator', false);

function gt_meta() {
	if (Plugin::isEnabled('google_translate')) {
		/* echo "\t<meta name=\"google-translate-customization\" content=\"6f61b1d69fb7a1cf-ad0664e6e10d5c5e-g94a4057fb75bca59-11\"></meta>"; */
		echo "\t<meta name=\"google-translate-customization\" content=\"0123456789abcdef-0123456789abcdef-g0123456789abcdef-11\"></meta>";
	}
}

function gt_drop() {
	if (Plugin::isEnabled('google_translate')) {
		echo "<div id=\"google_translate_element\" style=\"z-index:10;position:absolute;right:0;top:0;\"></div><script type=\"text/javascript\">\n";
		echo "function googleTranslateElementInit() {\n";
		echo "\tnew google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');\n";
		echo "}\n";
		echo "</script><script type=\"text/javascript\" src=\"//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit\"></script>\n";
	}
}