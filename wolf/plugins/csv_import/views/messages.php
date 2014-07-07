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
echo '<h3>' . __( 'Messages' ) . '</h3>';
echo '<ul>';
foreach ( $messages as $message )
    echo '<li class="' . $message[0] . '">' . $message[1] . '</li>';
echo '</ul>';
?>