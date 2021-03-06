<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
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

/**
 * @package wolf
 * @subpackage views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

//if (Dispatcher::getAction() == 'index'):
?>
<?php //if(!AuthUser::hasPermission('client')){ ?>
<?php if(AuthUser::hasPermission('administrator')){ ?>


<?php if(!AuthUser::hasPermission('client') && Plugin::isEnabled('dashboard') == true && Plugin::isEnabled('maintenance')) { ?>
<p class="button"><a href="/<?php echo ADMIN_DIR; ?>/plugin/maintenance"><img src="/wolf/plugins/dashboard/img/keys.png" align="middle" alt="maintenance icon" /><?php echo __('Access'); ?></a></p>
<?php } ?>


<?php if(Plugin::isEnabled('registered_users') == true){ ?>
<p class="button"><a href="/<?php echo ADMIN_DIR; ?>/plugin/registered_users/settings"><img src="/wolf/plugins/registered_users/images/settings.png" align="middle" alt="settings icon" /><?php echo __('Settings'); ?></a></p>
<p class="button"><a href="/<?php echo ADMIN_DIR; ?>/plugin/registered_users/groups"><img src="/wolf/plugins/registered_users/images/groups.png" align="middle" alt="user groups icon" /><?php echo __('User Groups'); ?></a></p><?php } ?>
<p class="button"><a href="/<?php echo ADMIN_DIR; ?>/user"><img src="/wolf/plugins/registered_users/images/users.png" align="middle" alt="users icon" /><?php echo __('Users'); ?></a></p>
<!-- <div class="box">
<h3>Registered Users</h3>
<p>This plugin allows you to manage user registrations through your Frog site.</p>
<p>It controls the administration of user groups as well as the front end bits (forms, registrations etc)</p>
</div> -->
<p class="button"><a href="<?php echo get_url('user/add'); ?>"><img src="/wolf/plugins/registered_users/images/user_add.png" align="middle" alt="user icon" /><?php echo __('New User'); ?></a></p>
<!--
<div class="box">
	<h2><?php echo __('Where do the avatars come from?'); ?></h2>
	<p><?php echo __('The avatars are automatically linked for those with a <a href="http://www.gravatar.com/" target="_blank">Gravatar</a> (a free service) account.'); ?></p>
</div>
-->
<?php //endif; ?>

<?php } ?>