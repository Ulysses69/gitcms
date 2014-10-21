<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (CLIENTDETAILS_VERSION > Plugin::getSetting('version', CLIENTDETAILS_ID)){
	  define('CLIENTDETAILS_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/".CLIENTDETAILS_ID."/enable.php";
  }

?>

<!--
<p class="button"><a href="<?php echo get_url('plugin/clientdetails/documentation'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/clientdetails/images/documentation.png" align="middle" /><?php echo __('Documentation'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/clientdetails/settings'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/clientdetails/images/settings.png" align="middle" /><?php echo __('Settings'); ?></a></p>
-->

<div class="box">
<h2><?php echo __('Client Details').' '.Plugin::getSetting('version', 'clientdetails'); ?></h2>
<p>Manage business details from this page. Changes to these details will be automatically reflected on pages that refer to them.</p>
</div>

<?php if(Plugin::isEnabled('googlemap') == true){ ?>
<div class="box">
<h2><?php echo __('Tip');?></h2>
<p>Contact details are used to generate <a href="/<?php echo ADMIN_DIR; ?>/plugin/googlemap">Google Map</a> longitude and latitude. Best results require same address as Google Maps entry.</p>
</div>
<?php }?>

<div class="box">
<h2><?php echo __('Hours');?></h2>
<p>Business hours can specified as 24-hour format, Closed or left blank.</p>
</div>

<?php if(Plugin::isEnabled('page_part_forms') == true && !AuthUser::hasPermission('client')){ ?>
<p class="button">
<a href="<?php echo get_url('plugin/page_part_forms'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/page_part_forms/images/new_page_part_form.png" align="middle" alt="token icon" /> <?php echo __('Page Profiles'); ?></a>
</p>
<?php } ?>

