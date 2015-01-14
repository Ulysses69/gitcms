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
<p>Boxes can be used for adverts or call-to-actions. They are added to the bottom of associated page content by default.</p>
</div>

<div class="box">
<h2><?php echo __('Notes'); ?></h2>
<p>Once created on this page, boxes are added to pages by selecting them from a list under the 'ad' tab.</p>
<p>Boxes can either be linked via entering a <b>Link URL</b> or scattered manually within the <b>Text</b> itself.</p>
</div>


<?php //include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/_htaccess/views/sidebar.php'; ?>
