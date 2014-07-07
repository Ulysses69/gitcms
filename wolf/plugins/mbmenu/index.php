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
 * @file		index.php
 * @date		01/05/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

if(!defined("PLUGINS_ROOT")) // done to allow mbmenu to run on 0.6.0
{
	define('PLUGINS_ROOT', CORE_ROOT.'/plugins');
}
if(!defined("MBMENU"))
{
	define('MBMENU', PLUGINS_ROOT.'/mbmenu');
}

// setup the plugin info
Plugin::setInfos(array(
    'id'          => 'mbmenu',
    'title'       => 'mbMenu', 
    'description' => 'Menu Management Plugin for WolfCMS.', 
    'version'     => '1.0.1',
    'require_wolf_version' => '0.6',
    'type' => 'both',
    'author' 	  => 'Mike Barlow',
    'website'     => 'http://www.mikebarlow.co.uk',
	'update_url'  => 'http://www.mikebarlow.co.uk/mbplugins_version.xml'
	)
);
 
// Add the controller and tab for admin
Plugin::addController('mbmenu', 'Menus');

// Add the models to the autoLoader
AutoLoader::addFile('mbmenu', MBMENU.'/models/mbmenu.php');
AutoLoader::addFile('mbmenuItem', MBMENU.'/models/mbmenuItem.php');

// add the JS file
Plugin::addJavascript('mbmenu', 'js/mbajax.js');

// function to load menu

function loadMbMenu($menucode)
{
	global $__CMS_CONN__;
	
	$menu = mbmenu::findOneFrom('mbmenu', "`menucode` = ".mbmenu::escape($menucode));
	$itemSQL = $__CMS_CONN__->prepare("SELECT * FROM `".TABLE_PREFIX."mbmenu_items` WHERE `menuid` = ".$menu->id." && active = '1'
										ORDER BY `linkparent` ASC, `linkorder` ASC");
	$itemSQL->execute();
	$items = $itemSQL->fetchAll(PDO::FETCH_OBJ);
	
	$menuItems = array();
	if(count($items) > 0)
	{
		foreach($items as $k => $v)
		{
			if($v->linkparent == 0)
			{
				$menuItems[$v->id] = $v;
			} elseif($v->linkparent > 0)
			{        		
				if(isset($menuItems[$v->linkparent]->subitems))
				{
					$menuItems[$v->linkparent]->subitems[$v->id] = $v;
				} else
				{
					$menuItems[$v->linkparent]->subitems = array($v->id => $v);
				}
			}	
		}
	} else
	{
		$menuItems = false;
	}

	return $menuItems;	
}
