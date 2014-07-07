<?php
/**
 * mbBlog
 * 
 * Simple blog plugin for WolfCMS.
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		enable.php
 * @date		07/04/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

$PDO = Record::getConnection();

// setup the table
$table1 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."mbblog` (
  `id` int(10) NOT NULL auto_increment,
  `posttitle` varchar(255) NOT NULL,
  `urltitle` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `date` int(10) NOT NULL,
  `body` longtext NOT NULL,
  `shortbody` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

$PDO->exec($table1);

// setup the plugin settings
Plugin::setAllSettings(array(
								'blogpath' => '',
								'blogtitle' => 'My Blog',
								'dateformat' => 'jS M Y g:ia',
								'postspp' => '10'
							), 'mbblog');
