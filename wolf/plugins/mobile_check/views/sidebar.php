<?php

//echo 'MOBILE_VERSION (sidebar): ' . MOBILE_VERSION . '<br/>';
//echo Plugin::getSetting('version', 'mobile_check') . '<br/>';
//exit;

  /* Ensure plugin update is enabled ONLY when new version */
  if (MOBILE_VERSION > Plugin::getSetting('version', 'mobile_check')){
  	  //echo 'INCLUDE (sidebar)' . '<br/>';
	  //exit;
	  define('MOBILE_CHECK_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/mobile_check/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('Design & Mobile Tools');?></h2>
<p>Version <?php echo Plugin::getSetting('version', 'mobile_check'); ?></p>
<p><a href="#design">Design</a> | <a href="#mobile">Mobile</a></p>
</div>



<?php
/* Check to make sure no changes have been made directly to mobile.css since last save. */
//if(DEBUG != true){
//if($csscontents != $cachedcss && Plugin::getSetting('clientname', 'clientdetails') == 'Blue Horizons Client'){
if(!isset($csscontents)) $csscontents = ''; if(!isset($cachedcss)) $cachedcss = '';
if($csscontents != $cachedcss){
?>


	<!-- To Do: Check pdf_data contains no errors before generating download -->

	<!-- Passes data to download layout, which then either prompts download or passes to TCPDF -->
	<div class="box warning">
	<h2><?php echo __('Warning');?></h2>
	<p>Settings cannot be saved because mobile.css has been changed manually.</p>
	<p>In order to save further changes, please download the provided mobile.css and replace it with the one in inc/css folder.</p>
	<!-- <form id="save" action="/download/email<?php echo URL_SUFFIX; ?>" method="post"> -->
	<form id="save" action="/download/email<?php echo URL_SUFFIX; ?>" method="post">
	<input type="submit" name="save" value="Download" class="submit" title="mobile.css" />
	<input type="hidden" name="filename" value="mobile.css" />
	<textarea hidden="hidden" name="pdf_data" class="pdf_data"><?php echo Plugin::getSetting('cachedcss', 'mobile_check'); ?></textarea>
	</form>
	</div>
	
	

	
	<!-- To Do: Restore mobile.css -->
	
	<?php
	if(isset($_GET['download'])){
		$file = htmlspecialchars($_GET['download']);
		$data = $_POST['pdf_data'];
		echo $data;
	}
	?>




<?php
}
//}
?>