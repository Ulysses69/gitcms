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

/* Security measure */
if ( !defined( 'IN_CMS' ) ) {
	exit();
}
?>
<p class="button"><a href="<?php echo get_url( 'plugin/csv_import/documentation' ); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/csv_import/icons/help.png" align="middle" /><?php echo __( 'Documentation' ); ?></a></p>

<div class="box">
	<h2><?php echo __( 'CSV Import' ) . ' - v.' . Plugin::$plugins_infos['csv_import']->version; ?></h2>
	<?php
	echo $sidebarContents;
	?>
	<h2><?php echo __( 'Author' ); ?></h2>
	<small>
		<p>Marek Murawski - <a href="http://marekmurawski.pl" />website</a></p>
	</small>
</div>
