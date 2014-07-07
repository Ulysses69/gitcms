<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (SEOBOX_VERSION > Plugin::getSetting('version', 'seobox')){
	  define('SEOBOX_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/seobox/enable.php";
  }

?>

<!--
<p class="button"><a href="<?php echo get_url('plugin/seobox/documentation'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/seobox/images/documentation.png" align="middle" /><?php echo __('Documentation'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/seobox/settings'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/seobox/images/settings.png" align="middle" /><?php echo __('Settings'); ?></a></p>
-->

<div class="box">
<h2><?php echo __('SEO Box Plugin').' '.Plugin::getSetting('version', 'seobox'); ?></h2>
<p>SEO box plugin lets you optimize your website for search engines.</p>
</div>

<div class="box">
<h2><?php echo __('Tools');?></h2>
<ul>
<li><a href="https://www.google.com/analytics/home/?hl=en" target="_blank">Google Analytics</a></li>
<li><a href="https://www.google.co.uk/places" target="_blank">Google Places</a></li>
<li><a href="http://www.google.com/webmasters/tools" target="_blank">Google Webmaster Tools</a></li>
<li><a href="http://www.opensiteexplorer.org/anchors?site=<?php echo $_SERVER["SERVER_NAME"]; ?>" target="_blank">Website Metrics</a></li>
</ul>
</div>