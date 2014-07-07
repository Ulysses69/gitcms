<?php
/**
 * mbMenu
 * 
 * Menu Management Plugin for WolfCMS
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		enable.php
 * @date		07/05/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

$PDO = Record::getConnection();

$table1 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."mbmenu` (
  `id` int(10) NOT NULL auto_increment,
  `menutitle` varchar(200) NOT NULL,
  `menucode` varchar(200) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$table2 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."mbmenu_items` (
  `id` int(10) NOT NULL auto_increment,
  `menuid` int(10) NOT NULL,
  `linktext` text NOT NULL,
  `linkurl` text NOT NULL,
  `linkoptions` text NOT NULL,
  `linkorder` int(5) NOT NULL,
  `linkparent` int(10) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$PDO->exec($table1);
$PDO->exec($table2);
