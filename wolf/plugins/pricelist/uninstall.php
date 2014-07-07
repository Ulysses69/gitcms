<?php

//	security measure
if (!defined('IN_CMS')) { exit(); }

//	include the Installer helper
use_helper('Installer');

if ( ! Installer::removeTable(TABLE_PREFIX.'pricelist_prices') ) Installer::failUninstall( 'pricelist', __('Could not remove table.') );

if ( ! Installer::removePermissions('pricelist_view,pricelist_new,pricelist_edit,pricelist_delete,pricelist_settings') ) Installer::failUninstall( 'pricelist' );

if ( ! Installer::removeRoles('pricelist admin,pricelist editor,pricelist user') ) Installer::failUninstall( 'pricelist' );

if ( ! Plugin::deleteAllSettings('pricelist') ) Installer::failUninstall( 'pricelist', __('Could not remove plugin settings.') );

Flash::set('success', __('Successfully uninstalled plugin.'));
redirect(get_url('setting'));

// EOF