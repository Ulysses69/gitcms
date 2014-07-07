<?php

/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The TinyMCE plugin provides the TinyMCE editor to Frog users.
 *
 * @package frog
 * @subpackage plugin.tinymce
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @version 2.0.0
 * @since Frog version 0.9.4
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Martijn van der Kleijn, 2008
 */

Plugin::setInfos(array(
    'id'          		=> 'tinymce',
    'title'       		=> 'TinyMCE Editor',
    'description' 		=> 'Allows you to use the TinyMCE text editor. 2.0.0_RC1 updated with TinyBrowser and TinyMCE 3.2.5',
    'version'     		=> '2.0.1',
    'license'     		=> 'GPLv3',
    'author'      		=> 'Martijn van der Kleijn and Hypermedia',
    'website'     		=> 'http://www.madebyfrog.com',
    'update_url'  		=> 'http://www.vanderkleijn.net/plugins.xml',
    'require_wolf_version' 	=> '0.5.5'
));

//function tinymce_styles(){
	if(Plugin::isEnabled('tinymce_styles') == true){
		$tinymce_styles_list = Plugin::getSetting('tinymce_styles_list', 'tinymce_styles');
		$list = explode("\r", $tinymce_styles_list);
		$styles = '';
		for ($i = 0; $i < count($list); $i++) {
			$item = str_replace(array(" ","'"), "", $list[$i]);
			$styles .= $list[$i].','.strtolower($item);	if($i < count($list) - 1) $styles .= ";";
		}
		if($styles != ''){
			$styles = '?styles='.str_replace(array("\r\n","\r","\n"), "", $styles);
		}
	} else {
		$styles = '';
	}
//}

Filter::add('tinymce', 'tinymce/filter_tinymce.php');
Plugin::addController('tinymce', 'Tinymce', 'administrator,developer', false);
Plugin::addJavascript('tinymce', 'tinymce/jscripts/tiny_mce/tiny_mce.js');
//Commented out file_exists check at line 270 in core Plugin model to allow file parameters as per below
Plugin::addJavascript('tinymce', 'tiny_init.php'.$styles);
Plugin::addJavascript('tinymce', 'tinymce/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php');