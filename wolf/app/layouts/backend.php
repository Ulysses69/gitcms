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

if(stristr($_SERVER['SERVER_NAME'],'bluehorizons')){
	$theme_dir = Setting::get('theme');
} else {
	//$theme_dir = Setting::get('theme');
	$theme_dir = 'default';
}

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

// Redirect to front page if user doesn't have appropriate roles.
if (!AuthUser::hasPermission('administrator,developer,editor')) {
	header('Location: '.URL_PUBLIC.' ');
	exit();
}

// Setup some stuff...
$ctrl = Dispatcher::getController(Setting::get('default_tab'));
define('DEV_AUTH', AuthUser::getRecord()->id);
// Allow for nice title.
// @todo improve/clean this up.
$title = ($ctrl == 'plugin') ? Plugin::$controllers[Dispatcher::getAction()]->label : ucfirst($ctrl).'s';
if (isset($this->vars['content_for_layout']->vars['action'])) {
	$tmp = $this->vars['content_for_layout']->vars['action'];
	$title .= ' - '.ucfirst($tmp);

	if ($tmp == 'edit' && isset($this->vars['content_for_layout']->vars['page'])) {
		$tmp = $this->vars['content_for_layout']->vars['page'];
		$title .= ' - '.$tmp->breadcrumb;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title><?php if(defined('CMS_TEST_MODE') && CMS_TEST_MODE == true){$local=' (Stage)';}else{$local='';} ?><?php use_helper('Kses');echo kses(Setting::get('admin_title'), array()) .$local . ' / ' . $title; ?></title>

	<link rel="favourites icon" href="<?php echo URL_PUBLIC; ?>inc/img/icon.ico" />
	<link href="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/stylesheets/admin.css" media="screen" rel="Stylesheet" type="text/css" />
	<link href="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/stylesheets/toolbar.css" media="screen" rel="Stylesheet" type="text/css" />
	<link href="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/themes/<?php echo AMIN_THEME; ?>/styles.css" id="css_theme" media="screen" rel="Stylesheet" type="text/css" />
	<!-- IE6 PNG support fix -->
	<!--[if lt IE 7]>
		<script type="text/javascript" charset="utf-8" src="<?php echo URL_PUBLIC . ADMIN_DIR; ?>/javascripts/unitpngfix.js"></script>
	<![endif]-->
	<!--[if IE]>
	<link href="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/stylesheets/ie.css" media="screen" rel="Stylesheet" type="text/css" />
	<![endif]-->
	<!-- <script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/frog.js?cache=js"></script> -->
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/prototype.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/effects.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/dragdrop.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/cp-datepicker.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/wolf.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/control.textarea.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC . ADMIN_DIR; ?>/javascripts/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" charset="utf-8">
	 var $j = jQuery.noConflict();
	</script>

	<script type="text/javascript">
	// <![CDATA[
		$j(document).ready(function() {
			(function showMessages(e) {
				e.fadeIn('slow')
				 .animate({opacity: 1.0}, 1500)
				 .fadeOut('slow', function() {
					if ($j(this).next().attr('class') == 'message') {
						showMessages($j(this).next());
					}
					$j(this).remove();
				 })
			})( $j(".message:first") );

			$j("input:visible:enabled:first").focus();
		});
		// ]]>
		</script>
	
<?php foreach(Plugin::$plugins as $plugin_id => $plugin): ?>
<?php if (file_exists(CORE_ROOT . '/plugins/' . $plugin_id . '/' . $plugin_id . '.js')): ?>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC; ?>wolf/plugins/<?php echo $plugin_id.'/'.$plugin_id; ?>.js"></script>
<?php endif; ?>
<?php if (file_exists(CORE_ROOT . '/plugins/' . $plugin_id . '/' . $plugin_id . '.css')): ?>
	<link href="<?php echo URI_PUBLIC; ?>wolf/plugins/<?php echo $plugin_id.'/'.$plugin_id; ?>.css" media="screen" rel="Stylesheet" type="text/css" />
<?php endif; ?>
<?php endforeach; ?>
<?php foreach(Plugin::$javascripts as $jscript_plugin_id => $javascript): ?>
	<script type="text/javascript" charset="utf-8" src="<?php echo URI_PUBLIC; ?>wolf/plugins/<?php echo $javascript; ?>"></script>
<?php endforeach; ?>

<script type="text/javascript">
function init(){ document.getElementsByTagName('body')[0].className+=' js'; } window.onload = init;
</script>

<?php $action = Dispatcher::getAction(); ?>
  </head>
  <body id="body_<?php echo $ctrl.'_'.Dispatcher::getAction(); ?>"<?php if(DEV_AUTH!=2) echo ' class="admins"'; ?>>
	<div id="header">
	  <div id="site-title"><a href="<?php echo URL_PUBLIC; ?>"><?php echo Setting::get('admin_title'); ?></a></div>
	  <div id="mainTabs">
		<ul>
		  <li><a href="<?php echo get_url('page'); ?>"<?php if ($ctrl=='page') echo ' class="current"'; ?>><?php echo __('Pages'); ?></a></li>
<?php if (!AuthUser::hasPermission('client')): ?>
		  <li><a href="<?php echo get_url('snippet'); ?>"<?php if ($ctrl=='snippet') echo ' class="current"'; ?>><?php echo __('Snippets'); ?></a></li>
		  <?php if (AuthUser::hasPermission('developer') ): ?><li><a href="<?php echo get_url('layout'); ?>"<?php if ($ctrl=='layout') echo ' class="current"'; ?>><?php echo __('Themes'); ?></a></li><?php endif; ?>
<?php endif; ?>

<?php foreach (Plugin::$controllers as $plugin_name => $plugin): ?>
<?php if ($plugin->show_tab && (AuthUser::hasPermission($plugin->permissions) || AuthUser::hasPermission('administrator'))): ?>
		  <?php Observer::notify('view_backend_list_plugin', $plugin_name, $plugin); ?>
		  <li class="plugin" id="plugin-<?php echo $plugin_name; ?>"><a href="<?php echo get_url('plugin/'.$plugin_name); ?>"<?php if ($ctrl=='plugin' && $action==$plugin_name) echo ' class="current"'; ?>><?php echo __($plugin->label); ?></a></li>
	<?php endif; ?>
<?php endforeach; ?>

<?php if (AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')): ?> 
		  <li class="right" id="plugin-config"><a href="<?php echo get_url('setting'); ?>"<?php if ($ctrl=='setting') echo ' class="current"'; ?>><?php echo __('Config'); ?></a></li>
<?php endif; ?>
<?php if (AuthUser::hasPermission('administrator')): ?>
		  <li class="right" id="plugin-users"><a href="<?php echo get_url('user'); ?>"<?php if ($ctrl=='user') echo ' class="current"'; ?>><?php echo __('Users'); ?></a></li>
<?php endif; ?>
		</ul>
	  </div>
	</div>
<?php if (Flash::get('error') !== null): ?>
				<div id="error" class="message" style="display: none;"><?php echo Flash::get('error'); ?></div>
<?php endif; ?>
<?php if (Flash::get('success') !== null): ?>
				<div id="success" class="message" style="display: none"><?php echo Flash::get('success'); ?></div>
<?php endif; ?>
<?php if (Flash::get('info') !== null): ?>
				<div id="info" class="message" style="display: none"><?php echo Flash::get('info'); ?></div>
<?php endif; ?>
	<div id="main">
		<div id="content-wrapper">
			<div id="content">
		<!-- content -->
		<?php echo $content_for_layout; ?>
		<!-- end content -->
			</div>
		</div>
		<?php if (isset($sidebar)) { ?>
		<div id="sidebar-wrapper">
			<div id="sidebar">
			<!-- sidebar -->
			<?php echo $sidebar; ?>
			<!-- end sidebar -->
			</div>
		</div>
		<?php } ?>
	</div>

	<div id="footer">



<?php if (defined('DEBUG')): ?>
		<p class="stats">
			<b><?php echo __('Page render:'); ?></b> <?php echo execution_time(); ?> <?php echo __('seconds'); ?>
			| <b><?php echo __('Memory usage:'); ?></b> <?php echo memory_usage(); ?> | <b><?php echo __('Test mode:'); ?></b> <?php if(defined('CMS_TEST_MODE') && CMS_TEST_MODE == true){ echo 'On'; } else { echo 'Off'; } ?> | <b><?php echo __('Mobile check:'); ?></b> <?php echo MOBILE_CHECK; ?>
		</p>
<?php endif; ?>

	  <p id="site-links">
		<!-- <?php echo __('Logged in as'); ?> <a href="<?php echo get_url('user/edit/'.AuthUser::getId()); ?>"><?php echo AuthUser::getRecord()->name; ?></a>
		<span class="separator"> | </span> -->
		<a href="<?php echo get_url('login/logout'.'?csrf_token='.SecureToken::generateToken(BASE_URL.'login/logout')); ?>" title="Log out as <?php echo AuthUser::getRecord()->name; ?>"><?php echo __('Log Out'); ?></a>
		<span class="separator"> | </span>
		<?php if(Plugin::isEnabled('help_docs') == true && AuthUser::hasPermission('administrator')){ ?>
		<!-- <a href="<?php echo get_url('setting'); ?>" title="Change settings" id="config-link"><?php echo __('Config'); ?></a>
		<span class="separator"> | </span> -->
		<a href="<?php echo get_url('plugin/help_docs'); ?>" title="View help docs" id="help-docs"><?php echo __('Help'); ?></a>
		<span class="separator"> | </span><?php } ?>
		<a id="site-view-link" href="<?php echo URL_PUBLIC; ?>" target="_blank" title="View website in new window/tab"><?php echo __('Preview'); ?></a>
	  </p>
	</div>
  </body>
</html>
