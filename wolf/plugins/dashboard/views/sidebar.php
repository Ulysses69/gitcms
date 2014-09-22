<?php
/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/**
 * The BackupRestore plugin provides administrators with the option of backing
 * up their pages and settings to an XML file.
 *
 * @package wolf
 * @subpackage plugin.backup_restore
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @version 0.0.1
 * @since Wolf version 0.6.0
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 License
 * @copyright Martijn van der Kleijn, 2009
 */
?>
<?php if(Plugin::isEnabled('backup_restore') == true){ ?>
	<p class="button"><a href="<?php echo get_url('plugin/backup_restore/backup'); ?>"><img src="<?php echo BACKUPRESTORE_ROOT;?>/images/snippet.png" align="middle" alt="backup icon" /> <?php echo __('Create a backup'); ?></a></p>
	<p class="button"><a href="<?php echo get_url('plugin/backup_restore/restore'); ?>"><img src="<?php echo BACKUPRESTORE_ROOT;?>/images/upload.png" align="middle" alt="restore icon" /> <?php echo __('Restore a backup'); ?></a></p>
	<!-- <p class="button"><a href="<?php echo get_url('plugin/backup_restore/documentation'); ?>"><img src="<?php echo BACKUPRESTORE_ROOT;?>/images/page.png" align="middle" alt="documentation icon" /> <?php echo __('Documentation'); ?></a></p> -->
<?php } ?>

<?php if(Plugin::isEnabled('csv_import') == true){ ?>
	<p class="button"><a href="<?php echo get_url('plugin/csv_import'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/dashboard/img/import.png" align="middle" alt="import icon" /> <?php echo __('Import from CSV'); ?></a></p>
<?php } ?>

<?php if (!AuthUser::hasPermission('client')) { ?>
	<?php if(Plugin::isEnabled('clientdetails') == true && AuthUser::hasPermission('administrator')){ ?><p class="button"><a href="<?php echo get_url('plugin/clientdetails'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/clientdetails/images/details.png" align="middle" alt="client icon" /> <?php echo __('Client details'); ?></a></p><?php } ?>
	<?php if(Plugin::isEnabled('token') == true && AuthUser::hasPermission('administrator')){ ?><p class="button"><a href="<?php echo get_url('plugin/token'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/token/images/dashboard.png" align="middle" alt="token icon" /> <?php echo __('Tokens'); ?></a></p><?php } ?>
	<?php if(Plugin::isEnabled('redirector') == true && AuthUser::hasPermission('administrator')){ ?><p class="button"><a href="<?php echo get_url('plugin/redirector'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/dashboard/img/redirector.png" align="middle" alt="redirector icon" /> <?php echo __('Redirect pages'); ?></a></p><?php } ?>
	<?php if(Plugin::isEnabled('googlemap') == true && AuthUser::hasPermission('administrator')){ ?><p class="button"><a href="<?php echo get_url('plugin/googlemap'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/googlemap/images/map.png" align="middle" alt="map icon" /> <?php echo __('Google Map'); ?></a></p><?php } ?>
	<?php if(Plugin::isEnabled('copyright') == true && AuthUser::hasPermission('administrator')){ ?><p class="button"><a href="<?php echo get_url('plugin/copyright'); ?>"><img src="<?php echo COPYRIGHT_ROOT;?>/images/law.png" align="middle" alt="legal icon" /> <?php echo __('Legal'); ?></a></p><?php } ?>

	<?php if(is_dir($_SERVER["DOCUMENT_ROOT"].'/wolf/plugins/dashboard')) { ?>
	<?php if(Plugin::isEnabled('funky_cache') == true){ $button = 'ENABLED'; } else { $button = 'DISABLED'; }  ?>
	<p class="button"><a href="<?php echo get_url('plugin/dashboard/save?funkycache='.$button); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/dashboard/img/cache_<?php echo $button; ?>.png" align="middle" alt="cache icon" /> Cache is <?php echo $button; ?></a></p>
	<?php } ?>

<?php } ?>






<?php if(AuthUser::hasPermission('client')) { ?>
<br />
<div class="box">
<h2><?php echo __('Tip');?></h2>
<p>To update a user profile picture (avatar), simply upload a picture with the same filename as your username. For example, upload <b><?php echo AuthUser::getRecord()->username; ?>.jpg</b> to the images/users folder to update your own profile avatar (images will be resized accordingly). <a href="/<?php echo ADMIN_DIR; ?>/plugin/file_manager/browse/images/users">Update avatar</a></p>
</div>
<?php } ?>
