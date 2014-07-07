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
 * @file		uninstall.php
 * @date		07/04/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

$PDO = Record::getConnection();

// delete amin tbl
$table1 = "DROP TABLE `".TABLE_PREFIX."mbblog`;";
$PDO->exec($table1);

// delete settings
Plugin::deleteAllSettings('mbblog');