<?php

//	security measure
if (!defined('IN_CMS')) { exit(); }

//	include the Installer helper
use_helper('Installer');

if ( ! Installer::removeTable(TABLE_PREFIX.'ads_boxes') ) Installer::failUninstall( 'ads', __('Could not remove table.') );

if ( ! Installer::removePermissions('ads_view,ads_new,ads_edit,ads_delete,ads_settings') ) Installer::failUninstall( 'ads' );

if ( ! Installer::removeRoles('ads admin,ads editor,ads user') ) Installer::failUninstall( 'ads' );

if ( ! Plugin::deleteAllSettings('ads') ) Installer::failUninstall( 'ads', __('Could not remove plugin settings.') );

Flash::set('success', __('Successfully uninstalled plugin.'));
redirect(get_url('setting'));

// EOF