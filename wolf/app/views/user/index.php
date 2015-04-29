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
<!-- <h1><?php echo __('Users'); ?></h1> -->
<?php //if(!AuthUser::hasPermission('client')){ ?>
<?php if(AuthUser::hasPermission('administrator')){ ?>

<div class="boxed">
<h2>Users</h2>
<table id="users" class="index" cellpadding="0" cellspacing="0" border="0">
  <thead id="site-map-def">
	<tr>
	  <th class="name"><?php echo __('Name'); ?></th>
	  <th class="username"><?php echo __('Username'); ?></th>
	  <?php if (DEV_AUTH==2){ ?><!-- <th class="email"><?php echo __('Email'); ?></th> --><?php } ?>
	  <th class="roles"><?php echo __('Roles'); ?></th>
	  <th class="delete"><?php echo __('Action'); ?></th>
	</tr>
  </thead>
  <tbody>
<?php 

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

//$sourceurl = 'http://www.bluehorizonsmarketing.co.uk/public/users/';
$sourceurl = 'https://cdn.shopify.com/s/files/1/0671/3113/t/11/assets/';

foreach($users as $user): ?>

<?php if((AuthUser::hasPermission('client') && in_array("client", $user->getPermissions())) || !AuthUser::hasPermission('client')){ ?>

	<tr class="node <?php echo odd_even(); ?>">
	  <td class="user">
		<img src="<?php
		
  //$username = $user->username;
		$username = 'user_'.str_replace(' ', '-', strtolower($user->name));
	
		if(AuthUser::hasPermission('client')){
			if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.$username.'.png')){
				$avatar .= '/public/images/users/'.$username.'.png';
			} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.$username.'.jpg')){
				$avatar .= '/public/images/users/'.$username.'.jpg';
			} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.$username.'.gif')){
				$avatar .= '/public/images/users/'.$username.'.gif';
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
					// The image doesn't exist
					$avatar = URL_PUBLIC.ADMIN_DIR.'/images/user.png';
				}
			} else {
				 echo '<!-- File Get Contents Not Supported -->';
			}
	
		}
		
		echo $avatar;

		?>" align="middle" alt="<?php echo $user->username; ?> icon" class="avatar" />
		<a href="<?php echo get_url('user/edit/'.$user->id); ?>" title="Name"><?php echo $user->name; ?></a>
	  </td>
	  <td title="Username"><?php echo $user->username; ?></td>
	  <?php if (DEV_AUTH==2){ ?><!-- <td><?php echo $user->email; ?></td> --><?php } ?>
	  <td title="Roles">
	  <?php $roles = implode(', ', $user->getPermissions()); 
	  if(AuthUser::hasPermission('client')){ $roles = str_replace('developer','',$roles); $roles = str_replace(", ,",",",$roles); }
	  echo $roles; ?>
	  </td>
	  <td class="action">
<?php if ($user->id > 1): ?>
		<a href="<?php echo get_url('user/delete/'.$user->id.'?csrf_token='.SecureToken::generateToken(BASE_URL.'user/delete/'.$user->id)); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete').' '.$user->name.'?'; ?>');"><img src="images/icon-remove.gif" alt="<?php echo __('delete '.$user->username.' icon'); ?>" title="<?php echo __('Delete '.$user->name); ?>" /></a>
<?php else: ?>
		<img src="images/icon-remove-disabled.gif" alt="<?php echo __('delete '.$user->username.' icon disabled'); ?>" title="<?php echo __('Delete '.$user->name.' unavailable'); ?>" />
<?php endif; ?>
	  </td>
	</tr>

<?php } ?>

<?php endforeach; ?>
  </tbody>
</table>
</div>

<?php } ?>