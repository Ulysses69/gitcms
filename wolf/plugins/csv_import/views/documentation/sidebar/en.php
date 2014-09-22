<?php
/*
 * CSV Import Plugin for Wolf CMS
 * Import .csv, .tsv and .txt spreadsheet files into Wolf CMS pages and page parts.
 *
 * @package Plugins
 * @subpackage multiedit
 *
 * @author Marek Murawski <http://marekmurawski.pl>
 * @copyright Marek Murawski, 2013
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */

if ( !defined( 'IN_CMS' ) ) {
	exit();
}

if(Plugin::isEnabled('file_manager') == true){
	 $public_dir = '<a href="' . URI_PUBLIC . ADMIN_DIR .'/plugin/file_manager">public</a>';
} else {
	$public_dir = 'public';
}

?>
<p>
	You can import <b>.csv, .tsv and .txt </b> files containing tables exported from MS Excel or Open Office Calc.
	These files must be added to the <b><?php echo $public_dir; ?></b> directory.

</p>
<p>
	The <b>first row</b> of your table should contain these headers:
<ul>
	<li><b>slug - <i>required</i></b>, must be unique</li>
	<li>title - if not present - will be converted from slug</li>
	<li>breadcrumb - if not present - will be converted from slug</li>
	<li>content</li>
	<li>keywords</li>
	<li>description</li>
	<li>created_on</li>
	<li>published_on</li>
	<li>valid_until</li>
	<li>tags</li>
</ul>
</p>
<p>Columns above will be treated as imported page properties. Any other columns will be converted to page parts.</p>

