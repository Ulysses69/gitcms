<?php

$version = Plugin::getSetting('version', 'ads');

  /* Ensure plugin update is enabled ONLY when new version */
  if (ADS_VERSION > Plugin::getSetting('version', 'ads')){
	  define('ADS_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/ads/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('Ads').' '.ADS_VERSION; ?></h2>
<p>Boxes can be used for adverts or call-to-actions. Similar to related pages, boxes can be added to pages using the 'ad' tab.</p>
</div>


<?php //include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/_htaccess/views/sidebar.php'; ?>
