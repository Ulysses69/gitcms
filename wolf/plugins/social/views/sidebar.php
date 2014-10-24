<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (SOCIAL_VERSION > Plugin::getSetting('version', 'social')){
	  define('SOCIAL_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/social/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('Social').' '.Plugin::getSetting('version', 'social'); ?></h2>
<p>Manage social network links. By default, all social links are set to display, but only if their URL is not leaft blank.</p>
<p>Change the appearance of social network icons by selecting icon set and ensuring appearance is set to images rather than text.</p>
</div>

<div class="box sets">
		<?php
		$icon_set = Plugin::getSetting('icon_set', 'social');
        if ($handle = opendir($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/social/icons/'.$icon_set.'/')) {
            $blacklist = array('.', '..','.DS_Store','Thumbs.db');
            echo '<h2>'.ucfirst($icon_set).'</h2>';
            echo '<div>';
            while (false !== ($file = readdir($handle))) {
                if (!in_array($file, $blacklist)) {
					/* Determine path of social icon images */
					$src_path = URI_PUBLIC.'wolf/plugins/social/icons/'.$icon_set.'/'.$file;
					echo '<img src="'.$src_path.'" />';
                }
            }
            echo '</div>';
		}
        ?>
</div>