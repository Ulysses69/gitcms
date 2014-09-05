<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008,2009,2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
*/

/**
 * @package wolf
 * @subpackage controllers
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Martijn van der Kleijn, 2009-2010
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 *
 * @version $Id: SettingController.php 187 2010-03-22 00:58:30Z martijn.niji@gmail.com $
 */

/**
 * Controls the various actions with regards to the settings screen for Wolf CMS.
 *
 * @package wolf
 * @subpackage controllers
 *
 * @since 0.5.5
 */
class SettingController extends Controller {

	/**
	 * Used to check generic permissions for entire the controller.
	 */
	private static final function _checkPermission() {
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
		else {
			if ( ! AuthUser::hasPermission('administrator')) {
				Flash::set('error', __('You do not have permission to access the requested page!'));

				if (Setting::get('default_tab') === 'setting') {
					redirect(get_url('page'));
				}
				else {
					redirect(get_url());
				}
			}
		}
	}

	public final function __construct() {
		SettingController::_checkPermission();
		$this->setLayout('backend');
	}

	/**
	 * Calls save function or displays settings screen.
	 */
	public final function index() {
		// check if trying to save
		if (get_request_method() == 'POST') {
			$this->_save();
		}

		$this->display('setting/index', 
						array('csrf_token' => SecureToken::generateToken(BASE_URL.'setting'))
					  );
	}

	/**
	 * Saves the settings.
	 */
	private final function _save() {
		$data = $_POST['setting'];

		// CSRF checks
		if (isset($_POST['csrf_token'])) {
			$csrf_token = $_POST['csrf_token'];
			if (!SecureToken::validateToken($csrf_token, BASE_URL.'setting')) {
				Flash::set('error', __('Invalid CSRF token found!'));
				Observer::notify('csrf_token_invalid', AuthUser::getUserName());
				redirect(get_url('setting'));
			}
		}
		else {
			Flash::set('error', __('No CSRF token found!'));
			Observer::notify('csrf_token_not_found', AuthUser::getUserName());
			redirect(get_url('setting'));
		}

		if (!isset($data['allow_html_title'])) {
			$data['allow_html_title'] = 'off';
		}

		Setting::saveFromData($data);
		Flash::set('success', __('Settings have been saved!'));
		redirect(get_url('setting'));
	}

	/**
	 * Can be used to activate a plugin.
	 *
	 * @param string $plugin The plugin id.
	 */
	public final function activate_plugin($plugin) {
		Plugin::activate($plugin);
		Observer::notify('plugin_after_enable', $plugin);
	}

	/**
	 * Can be used to deactivate a plugin.
	 *
	 * @param string $plugin The plugin id.
	 */
	public final function deactivate_plugin($plugin) {
		Plugin::deactivate($plugin);
		Observer::notify('plugin_after_disable', $plugin);
	}

	/**
	 * Can be used to uninstall a plugin.
	 *
	 * @param string $plugin The plugin id.
	 */
	public final function uninstall_plugin($plugin) {
		Plugin::uninstall($plugin);
		Observer::notify('plugin_after_uninstall', $plugin);
	}

	/**
	 * @var array All ISO 639-1 language codes.
	 */
	public static $iso_639_1 = array(
			'aa' => 'Afar',
			'ab' => 'Abkhazian',
			'ae' => 'Avestan',
			'af' => 'Afrikaans',
			'ak' => 'Akan',
			'am' => 'Amharic',
			'an' => 'Aragonese',
			'ar' => 'Arabic',
			'as' => 'Assamese',
			'av' => 'Avaric',
			'ay' => 'Aymara',
			'az' => 'Azerbaijani',
			'ba' => 'Bashkir',
			'be' => 'Belarusian',
			'bg' => 'Bulgarian',
			'bh' => 'Bihari',
			'bi' => 'Bislama',
			'bm' => 'Bambara',
			'bn' => 'Bengali',
			'bo' => 'Tibetan',
			'br' => 'Breton',
			'bs' => 'Bosnian',
			'ca' => 'Catalan',
			'ce' => 'Chechen',
			'ch' => 'Chamorro',
			'co' => 'Corsican',
			'cr' => 'Cree',
			'cs' => 'Czech',
			'cu' => 'Church Slavic',
			'cv' => 'Chuvash',
			'cy' => 'Welsh',
			'da' => 'Danish',
			'de' => 'German',
			'dv' => 'Dhivehi',
			'dz' => 'Dzongkha',
			'ee' => 'Ewe',
			'el' => 'Greek',
			'en' => 'English',
			'eo' => 'Esperanto',
			'es' => 'Spanish',
			'et' => 'Estonian',
			'eu' => 'Basque',
			'fa' => 'Persian',
			'ff' => 'Fulah',
			'fi' => 'Finnish',
			'fj' => 'Fijian',
			'fo' => 'Faroese',
			'fr' => 'French',
			'fy' => 'Western Frisian',
			'ga' => 'Irish',
			'gd' => 'Gaelic',
			'gl' => 'Galician',
			'gn' => 'Guarani',
			'gu' => 'Gujarati',
			'gv' => 'Manx',
			'ha' => 'Hausa',
			'he' => 'Hebrew',
			'hi' => 'Hindi',
			'ho' => 'Hiri Motu',
			'hr' => 'Croatian',
			'ht' => 'Haitian',
			'hu' => 'Hungarian',
			'hy' => 'Armenian',
			'hz' => 'Herero',
			'ia' => 'Interlingua',
			'id' => 'Indonesian',
			'ie' => 'Interlingue',
			'ig' => 'Igbo',
			'ii' => 'Sichuan Yi',
			'ik' => 'Inupiak',
			'io' => 'Ido',
			'is' => 'Icelandic',
			'it' => 'Italian',
			'iu' => 'Inuktitut',
			'ja' => 'Japanese',
			'jv' => 'Javanese',
			'ka' => 'Georgian',
			'kg' => 'Kongo',
			'ki' => 'Kikuyu',
			'kj' => 'Kuanyama',
			'kk' => 'Kazakh',
			'kl' => 'Greenlandic',
			'km' => 'Cambodian',
			'kn' => 'Kannada',
			'ko' => 'Korean',
			'kr' => 'Kanuri',
			'ks' => 'Kashmiri',
			'ku' => 'Kurdish',
			'kv' => 'Komi',
			'kw' => 'Cornish',
			'ky' => 'Kirghiz',
			'la' => 'Latin',
			'lb' => 'Luxembourgish',
			'lg' => 'Ganda',
			'li' => 'Limburgan',
			'ln' => 'Lingala',
			'lo' => 'Laothian',
			'lt' => 'Lithuanian',
			'lu' => 'Luba-Katanga',
			'lv' => 'Latvian',
			'mg' => 'Malagasy',
			'mh' => 'Marshallese',
			'mi' => 'Maori',
			'mk' => 'Macedonian',
			'ml' => 'Malayalam',
			'mn' => 'Mongolian',
			'mo' => 'Moldavian',
			'mr' => 'Marathi',
			'ms' => 'Malay',
			'mt' => 'Maltese',
			'my' => 'Burmese',
			'na' => 'Nauru',
			'nb' => 'Norwegian Bokmal',
			'nd' => 'North Ndebele',
			'ne' => 'Nepali',
			'ng' => 'Ndonga',
			'nl' => 'Dutch',
			'nn' => 'Norwegian Nynorsk',
			'no' => 'Norwegian',
			'nr' => 'South Ndebele',
			'nv' => 'Navajo',
			'ny' => 'Nyanja',
			'oc' => 'Occitan',
			'oj' => 'Ojibwa',
			'om' => 'Oromo',
			'or' => 'Oriya',
			'os' => 'Ossetian',
			'pa' => 'Punjabi',
			'pi' => 'Pali',
			'pl' => 'Polish',
			'ps' => 'Pushto',
			'pt' => 'Portuguese',
			'qu' => 'Quechua',
			'rm' => 'Romansh',
			'rn' => 'Rundi',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'rw' => 'Kinyarwanda',
			'sa' => 'Sanskrit',
			'sc' => 'Sardinian',
			'sd' => 'Sindhi',
			'se' => 'Northern Sami',
			'sg' => 'Sangro',
			'sh' => 'Serbo-Croatian',
			'si' => 'Sinhala',
			'sk' => 'Slovak',
			'sl' => 'Slovenian',
			'sm' => 'Samoan',
			'sn' => 'Shona',
			'so' => 'Somali',
			'sq' => 'Albanian',
			'sr' => 'Serbian',
			'ss' => 'Siswati',
			'st' => 'Sesotho',
			'su' => 'Sudanese',
			'sv' => 'Swedish',
			'sw' => 'Swahili',
			'ta' => 'Tamil',
			'te' => 'Tegulu',
			'tg' => 'Tajik',
			'th' => 'Thai',
			'ti' => 'Tigrinya',
			'tk' => 'Turkmen',
			'tl' => 'Tagalog',
			'tn' => 'Tswana',
			'to' => 'Tonga',
			'tr' => 'Turkish',
			'ts' => 'Tsonga',
			'tt' => 'Tatar',
			'tw' => 'Twi',
			'ty' => 'Tahitian',
			'ug' => 'Uighur',
			'uk' => 'Ukrainian',
			'ur' => 'Urdu',
			'uz' => 'Uzbek',
			've' => 'Venda',
			'vi' => 'Vietnamese',
			'vo' => 'Volapuk',
			'wa' => 'Walloon',
			'wo' => 'Wolof',
			'xh' => 'Xhosa',
			'yi' => 'Yiddish',
			'yo' => 'Yoruba',
			'za' => 'Zhuang',
			'zh' => 'Chinese',
			'zu' => 'Zulu');

}