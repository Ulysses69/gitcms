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


Plugin::setInfos( array(
			'id'				   => 'csv_import',
			'title'				=> __( 'CSV Import' ),
			'description'		  => __( 'Import .csv, .tsv and .txt spreadsheet files into Wolf CMS pages and parts' ),
			'version'			  => '0.1.3',
			'license'			  => 'GPL',
			'author'			   => 'Marek Murawski',
			'website'			  => 'http://marekmurawski.pl/',
			'update_url'		   => 'http://marekmurawski.pl/static/wolfplugins/plugin-versions.xml',
			'require_wolf_version' => '0.5.5' // 0.7.5SP-1 fix -> downgrading requirement to 0.7.3
) );

if(Plugin::isEnabled('dashboard') == true) {
	Plugin::addController( 'csv_import', __( 'CSV Import' ), 'admin_edit', false );
} else {
	Plugin::addController( 'csv_import', __( 'CSV Import' ), 'admin_edit', true );
}