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
?>
<!-- <h1><?php echo __(ucfirst($action).' user'); ?></h1> -->

<?php $user_permissions = ($user instanceof User) ? $user->getPermissions(): array(); ?>

<?php //if(!AuthUser::hasPermission('client')){ ?>
<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && !in_array('developer', $user_permissions)) || (AuthUser::hasPermission('client') && in_array('client', $user_permissions))){ ?>

<div class="boxed">
<h2>
<img src="<?php

if(!function_exists('ExternalFileExists')){
	function ExternalFileExists($location,$misc_content_type = false){
		$ch = curl_init($location);
		curl_setopt_array($ch, [
		CURLOPT_AUTOREFERER    => true,
		CURLOPT_CONNECTTIMEOUT => 5,
		CURLOPT_ENCODING       => "",
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_MAXREDIRS      => 1,
		CURLOPT_NOBODY         => true,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_TIMEOUT        => 20,
		CURLOPT_FAILONERROR	   => true,
		// It's very important to let other webmasters know who's probing their servers.
		CURLOPT_USERAGENT      => "Mozilla/5.0 (compatible; StackOverflow/0.0.1; +https://codereview.stackexchange.com/)",
		]);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($code !== 200) {
			throw new LogicException("The URL '".$location."' is unreachable.");
		}
		return TRUE;
	}
}

		$avatar = '';
		//$sourceurl = 'http://www.bluehorizonsmarketing.co.uk/public/users/';
		$sourceurl = 'https://cdn.shopify.com/s/files/1/0671/3113/t/11/assets/';

		//$username = $user->username;
		$username = 'user_'.str_replace(' ', '-', strtolower($user->name));
	
		if(AuthUser::hasPermission('client')){
			if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.$username.'.png')){
				$avatar = '/public/images/users/'.$username.'.png';
			} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.$username.'.jpg')){
				$avatar = '/public/images/users/'.$username.'.jpg';
			} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.$username.'.gif')){
				$avatar = '/public/images/users/'.$username.'.gif';
			} else {
				if (ExternalFileExists($sourceurl.$username.'.png')) {
					$avatar = $sourceurl.$username.'.png';
				} else if (ExternalFileExists($sourceurl.$username.'.jpg')) {
					$avatar = $sourceurl.$username.'.jpg';
				} else if (ExternalFileExists($sourceurl.$username.'.gif')) {
					$avatar = $sourceurl.$username.'.gif';
				} else {
					$avatar = $sourceurl.'user.png';
				}
			}
		} else {
			$png = $sourceurl.$username.'.png';
			$jpg = $sourceurl.$username.'.jpg';
			$gif = $sourceurl.$username.'.gif';

			if(function_exists('file_get_contents')){
				//echo '<!-- File Get Contents Supported -->';
				if(ExternalFileExists($png) || ExternalFileExists($jpg) || ExternalFileExists($gif)){
					//echo '<!-- Get Contents -->';
					// The image exists
					if(stristr($png,'.png')){ $avatar = $png; } else
					if(stristr($jpg,'.jpg')){ $avatar = $jpg; } else
					if(stristr($gif,'.gif')){ $avatar = $gif; }
				} else {
					//echo '<!-- No Image Exists -->';
					// The image doesn't exist
					$avatar = URL_PUBLIC.ADMIN_DIR.'/images/user.png';
				}
			} else {
				 //echo '<!-- File Get Contents Not Supported -->';
			}
	
		}

		echo $avatar;

		?>" align="middle" alt="<?php echo $user->username; ?> icon" class="avatar" />
<?php if($action=='edit') { echo __($user->name); } else { echo __('New user');} ?></h2>
<form action="<?php echo $action=='edit' ? get_url('user/edit/'.$user->id): get_url('user/add'); ; ?>" method="post">
	<input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
	<?php $iconpath = '';
	if($icon != ''){
		if(stristr($icon,'/public/images/users') || stristr($icon,'images/user.png')){ $iconpath = '/users'; }
		echo '<a href="'.URL_PUBLIC.ADMIN_DIR.'/plugin/file_manager/browse/images'.$iconpath.'" style="font-size:80%;position:relative;top:2px">Edit Pic</a>';
	} ?>
  <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	<tr>

	  <td class="label"><label for="user_name"><?php echo __('Name'); ?></label></td>
	  <td class="field"><input class="textbox" id="user_name" maxlength="100" name="user[name]" size="100" type="text" value="<?php echo $user->name; ?>" /></td>
	  <td class="help"><?php echo __('Required.'); ?></td>
	</tr>
	<tr>
	  <td class="label"><label for="user_username"><?php echo __('Username'); ?></label></td>
	  <td class="field"><input class="textbox" id="user_username" maxlength="40" name="user[username]" size="40" type="text" value="<?php echo $user->username; ?>" <?php echo $action == 'edit' ? 'disabled="disabled" ': ''; ?>/></td>
	  <td class="help"><?php if($action!='edit') { echo __('Must be unique.'); } else { echo __('Cannot be changed.'); } ?></td>
	</tr>
	<tr>
	  <td class="label"><label class="optional" for="user_email"><?php echo __('E-mail'); ?></label></td>
	  <td class="field"><input class="textbox" id="user_email" maxlength="255" name="user[email]" size="255" type="text" value="<?php echo $user->email; ?>" /></td>
	  <td class="help"><?php echo __('Optional.'); ?></td>
	</tr>
	<tr>
	  <td class="label"><label for="user_password"><?php echo __('Password'); ?></label></td>
	  <td class="field"><input class="textbox" id="user_password" maxlength="40" name="user[password]" size="40" type="password" value="" /></td>
	  <td class="help" rowspan="2"><?php if($action=='edit') { echo __('Leave blank if unchanged.'); } else { echo __('At least 5 characters.');} ?></td>
	</tr>
	<tr>
	  <td class="label"><label for="user_confirm"><?php echo __('Confirm Password'); ?></label></td>
	  <td class="field"><input class="textbox" id="user_confirm" maxlength="40" name="user[confirm]" size="40" type="password" value="" /></td>
	</tr>
<?php if (AuthUser::hasPermission('administrator')): ?> 
	<tr>
	  <td class="label"><?php echo __('Roles'); ?></td>
	  <td class="field">
<?php $user_permissions = ($user instanceof User) ? $user->getPermissions(): array(); ?>
<?php foreach ($permissions as $perm): ?>
		<?php if(($perm->name != 'developer' && AuthUser::hasPermission('client')) || !AuthUser::hasPermission('client')){ ?>
		<span class="checkbox"><input<?php if (in_array($perm->name, $user_permissions) || ($perm->name != 'developer' && AuthUser::hasPermission('client'))) echo ' checked="checked"'; ?>  id="user_permission-<?php echo $perm->name; ?>" name="user_permission[<?php echo $perm->name; ?>]" type="checkbox" value="<?php echo $perm->id; ?>" <?php if ($perm->name == 'client' && AuthUser::hasPermission('client')) echo ' disabled="disabled"'; ?> />&nbsp;<label for="user_permission-<?php echo $perm->name; ?>"><?php echo __(ucwords($perm->name)); ?></label></span>
		<?php } ?>
<?php endforeach; ?>
	  </td>
	  <td class="help"><?php echo __('Roles restrict user privileges and turn parts of the administrative interface on or off.'); ?> <?php if(!AuthUser::hasPermission('client')) echo "<b>Client</b> role should be checked for third party users."; ?></td>
	</tr>
<?php endif; ?>

	<!--
	<tr>
		<td class="label"><label for="user_language"><?php echo __('Language'); ?></label></td>
		<td class="field">
		  <select class="select" id="user_language" name="user[language]">
<?php foreach (Setting::getLanguages() as $code => $label): ?>
			<option value="<?php echo $code; ?>"<?php if ($code == $user->language) echo ' selected="selected"'; ?>><?php echo __($label); ?></option>
<?php endforeach; ?>
		  </select>
		</td>
		<td class="help"><?php echo __('This will set your preferred language for the backend.'); ?></td>
	  </tr>
	  -->

  </table>

  <p class="buttons">
	 <input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Save then close'); ?>" value="<?php echo __('Save'); ?>" />
		<a href="<?php echo (AuthUser::hasPermission('administrator')) ? get_url('user') : get_url(); ?>" id="site-cancel-page" class="button" title="<?php echo __('Close without saving'); ?>"><?php echo __('Cancel'); ?></a>
  </p>

</form>
</div>

<script type="text/javascript">
// <![CDATA[
	function setConfirmUnload(on, msg) {
		window.onbeforeunload = (on) ? unloadMessage : null;
		return true;
	}

	function unloadMessage() {
		return '<?php echo __('You have modified this page.  If you navigate away from this page without first saving your data, the changes will be lost.'); ?>';
	}

	$j(document).ready(function() {
		// Prevent accidentally navigating away
		$j(':input').bind('change', function() { setConfirmUnload(true); });
		$j('form').submit(function() { setConfirmUnload(false); return true; });
	});
	
Field.activate('user_name');
// ]]>
</script>

<?php } ?>