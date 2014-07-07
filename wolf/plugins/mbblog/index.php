<?php
/**
 * mbBlog
 * 
 * Simple blog plugin for WolfCMS.
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author        Mike Barlow
 * @email        mike@mikebarlow.co.uk
 * 
 * @file        index.php
 * @date        07/04/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
    die("Invalid Action");
}

if(!defined("PLUGINS_ROOT")) // done to allow mbblog to run on 0.6.0
{
    define('PLUGINS_ROOT', CORE_ROOT.'/plugins');
}
if(!defined("MBBLOG"))
{
    define('MBBLOG', PLUGINS_ROOT.'/mbblog');
}

// setup the plugin info
Plugin::setInfos(array(
    'id'          => 'mbblog',
    'title'       => 'mbBlog', 
    'description' => 'Simple and easy to use Blog System.', 
    'version'     => '2.0.1',
    'require_wolf_version' => '0.6',
    'type' => 'both',
    'author'       => 'Mike Barlow',
    'website'     => 'http://www.mikebarlow.co.uk',
    'update_url'  => 'http://www.mikebarlow.co.uk/mbplugins_version.xml'
    )
);
 
// Add the controller and tab for admin
Plugin::addController('mbblog', 'Blog');

// setup the routes - get the settings first though for url location of blog.
$blogpath = Plugin::getSetting('blogpath', 'mbblog');

// add the routes

Dispatcher::addRoute(array( 
    '/'.$blogpath => '/plugin/mbblog/index/', 
    '/'.$blogpath.':num' => '/plugin/mbblog/index/$1',    
    '/'.$blogpath.'view/:any' => '/plugin/mbblog/view/$1'
));
