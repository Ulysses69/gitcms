<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (SOCIAL_VERSION > Plugin::getSetting('version', 'social')){
	  define('SOCIAL_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/social/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('Social');?></h2>
<p>Manage social network links. By default, all social links are set to display, but only if their URL is not leaft blank.</p>
<p>Change the appearance of social network icons by selecting icon set and ensuring appearance is set to images rather than text.</p>
</div>
