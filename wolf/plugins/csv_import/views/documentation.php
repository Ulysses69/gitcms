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
<?php Observer::notify('mm_core_stylesheet'); ?>
<h1><?php echo __( 'Documentation' ); ?></h1>

