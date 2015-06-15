<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (SIMPLE_BANNERS_VERSION > Plugin::getSetting('version', 'simple_banners')){
	  define('SIMPLE_BANNERS_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/simple_banners/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('Simple Banners').' '.Plugin::getSetting('version', 'simple_banners'); ?></h2>
<p>Manage simple image banners. By default, banners are set to display, but only if a folder has been selected.</p>
</div>

<?php //simplebanner(); ?>