<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (JSCRIPTS_VERSION > Plugin::getSetting('version', 'jscripts')){
	  define('JSCRIPTS_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/jscripts/enable.php";
  }
  
?>

<div class="box">
<h2><?php echo __('Setup');?></h2>
<p>By default, your scripts are <strong>Auto</strong> added to page head/body and setscripts() calls are ignored.</p>
<p>Setting <strong>Manual</strong> embedding allows you to place your scripts in your layout/snippet by simply calling setscripts() in your header or footer etc.</p>
<p>Example for header scripts:</p>
<p><code>&lt;?php setscripts($this,'head'); ?&gt;</code></p>
<p>Example for body/footer scripts:</p>
<p><code>&lt;?php setscripts($this,'body'); ?&gt;</code></p>
</div>

<div class="box">
<h2><?php echo __('Pages');?></h2>
<p>If most pages are to include a specific script, set include list to <strong>all</strong> (nothing else should be in the list) and additionally add your excluded pages to the excludes list.</p>
<p>To display a script on a few pages, add page slugs to the includes list (comma separate). Leave excludes list empty.</p>
<?php if(function_exists('pagelevel')) ?><p>Numerical page levels can also be used.</p><?php ; ?>
</div>

<div class="box">
<h2><?php echo __('Markup');?></h2>
<p>Only js script and css link tags will be inserted. Additionally, css link tags default to screen media.</p>
</div>