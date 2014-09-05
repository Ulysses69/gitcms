<?php
/* Security measure */
if (!defined('IN_CMS')) {
	exit();
}

/**
 * Provides Code Mirror editor for backend
 *
 * @package Plugins
 * @subpackage codemirror
 *
 * @author Jasper Palfree <jasper@wellcaffeinated.net> http://wellcaffeinated.net
 * @copyright Jasper Palfree, 2012
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */

Plugin::setInfos(array(
		'id'		  => 'codemirror',
		'title'	   => __('Code Mirror'),
		'description' => __('Provides Code Mirror editor.'),
		'version'	 => '0.1b',
		'website'	 => 'https://github.com/wellcaffeinated/Code-Mirror-for-Wolf-CMS',
		'update_url'  => 'https://raw.github.com/wellcaffeinated/Code-Mirror-for-Wolf-CMS/master/version.xml'
));

Plugin::addJavascript('codemirror', 'CodeMirror-2.33/lib/codemirror.js');
Plugin::addJavascript('codemirror', 'CodeMirror-2.33/mode/markdown/markdown.js');
Plugin::addJavascript('codemirror', 'CodeMirror-2.33/mode/javascript/javascript.js');
Plugin::addJavascript('codemirror', 'CodeMirror-2.33/mode/xml/xml.js');
Plugin::addJavascript('codemirror', 'CodeMirror-2.33/mode/css/css.js');
Plugin::addJavascript('codemirror', 'CodeMirror-2.33/mode/clike/clike.js');
Plugin::addJavascript('codemirror', 'CodeMirror-2.33/mode/php/php.js');
Plugin::addJavascript('codemirror', 'CodeMirror-2.33/mode/gfm/gfm.js');
