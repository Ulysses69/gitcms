<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (SKELETON_VERSION > Plugin::getSetting('version', SKELETON_ID)){
	  define('SKELETON_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/".SKELETON_ID."/enable.php";
  }

?>

<div class="box">
<h2><?php echo __(SKELETON_TITLE).' '.SKELETON_VERSION; ?></h2>
<p><?php echo SKELETON_DESC; ?></p>
</div>
