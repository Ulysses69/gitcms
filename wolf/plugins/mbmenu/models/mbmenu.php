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
 * @file		/models/mbmenu.php
 * @date		02/05/2010
 * 
*/// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

class mbmenu extends Record
{
	const TABLE_NAME = 'mbmenu';

	/**
	 * getMenus
	 *
	 * @return mixed - array or bool
	*/
	public static function getMenus()
	{
		return self::findAllFrom('mbmenu');
	}
	
	


}
