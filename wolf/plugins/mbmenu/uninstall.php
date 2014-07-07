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
 * @file		uninstall.php
 * @date		07/05/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

$PDO = Record::getConnection();

$table1 = "DROP TABLE `".TABLE_PREFIX."mbmenu`;";
$table2 = "DROP TABLE `".TABLE_PREFIX."mbmenu_items`;";

$PDO->exec($table1);
$PDO->exec($table2);
