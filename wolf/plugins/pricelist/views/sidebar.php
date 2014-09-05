<?php

$version = Plugin::getSetting('version', 'pricelist');
$itempricelabel = Plugin::getSetting('itempricelabel', 'pricelist');
$itemprice2label = Plugin::getSetting('itemprice2label', 'pricelist');

  /* Ensure plugin update is enabled ONLY when new version */
  if (PRICELIST_VERSION > Plugin::getSetting('version', 'pricelist')){
	  define('PRICELIST_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/pricelist/enable.php";
  }

?>

<div class="box warning">
<h2><?php echo __('Pricelist').' '.PRICELIST_VERSION; ?></h2>
<p>UNDER DEVELOPMENT</p>
<p>Prices can be created here and then further managed/formatted independently. To display an item, reference the token like: [price id="1"] or [price id="1" show="price"].</p>
</div>

<form action="<?php echo get_url('plugin/pricelist/save'); ?>" method="post">

	<div class="box">
	<h2>Currency</h2>

			<table cellpadding="5" cellspacing="5" border="0" id="price_form_sidebar">
			  <tr>
					<td>
						<label for="itempricecurrency"><span>Symbol</span>
							<?php if(!isset($itempricecurrency)) $itempricecurrency = ''; ?>
							<select name="<?php echo $itempricecurrency; ?>" >
							<?php
							$currency_array = array(
							array ('&pound;', '&pound;'),
							array ('&euro;', '&euro;'),
							array ('&#36;', '&#36;'), // dollar
							array ('', ''));
							foreach($currency_array as $subarray) {
								list($text, $val) = $subarray;
								if($val == $itempricecurrency){
									echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
								} else {
									echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
								}
							}
							?>
							</select>
							<br />
					</td>
			  </tr>
			</table>	


	<h2>Prefix and Suffix</h2>
	<p>Example usage:</p>
	<ul>
	<li>&pound;2.00 each</li>
	<li>from &pound;2.00 each</li>
	<li>&pound;2.00 per roll</li>
	</ul>
	

	<h2>Price Labels</h2>
	<!-- <p>The price label can be changed from <strong><?php echo $itempricelabel; ?></strong> to any other desired label, as can <strong><?php echo $itemprice2label; ?></strong>. Simply select a label, change the value, then save the changes.</p> -->
	
			<table cellpadding="5" cellspacing="5" border="0" id="price_form_sidebar">
			  <tr>
					<td>
						<label for="itempricelabel"><span>Label A</span>
						<input class="textbox" id="itempricelabel" maxlength="255" name="itempricelabel" type="text" value="<?php echo $itempricelabel; ?>" /></label><br />
					</td>
					<td>
						<label for="itemprice2label"><span>Label B</span>
						<input class="textbox" id="itemprice2label" maxlength="255" name="itemprice2label" type="text" value="<?php echo $itemprice2label; ?>" /></label><br />
					</td>
			  </tr>
			</table>	
	
			<p class="buttons">
				<input class="button" id="save-sidebar" name="save-sidebar" title="Save" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
			</p>
	
	</div>

</form>

<?php //include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/_htaccess/views/sidebar.php'; ?>
