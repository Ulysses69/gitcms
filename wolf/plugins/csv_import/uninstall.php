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

if ( Plugin::deleteAllSettings( 'csv_import' ) ) {
    Flash::set( 'success', __( 'Plugin settings deleted!' ) );
} else {
    Flash::set( 'error', __( 'Error deleting plugin settings!' ) );
}

exit();