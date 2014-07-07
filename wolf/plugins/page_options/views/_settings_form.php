<br />

<?php 
$updated_enabled = Plugin::getSetting('updated_enabled', 'page_options');
$print_enabled = Plugin::getSetting('print_enabled', 'page_options');
$print_title = Plugin::getSetting('print_title', 'page_options');
$print_icon = Plugin::getSetting('print_icon', 'page_options');
$mobile_enabled = Plugin::getSetting('mobile_enabled', 'page_options');
$mobile_title = Plugin::getSetting('mobile_title', 'page_options');
$mobile_icon = Plugin::getSetting('mobile_icon', 'page_options');
$pdf_enabled = Plugin::getSetting('pdf_enabled', 'page_options');
$pdf_title = Plugin::getSetting('pdf_title', 'page_options');
$pdf_icon = Plugin::getSetting('pdf_icon', 'page_options');
$top_of_page_enabled = Plugin::getSetting('top_of_page_enabled', 'page_options');
$top_of_page_title = Plugin::getSetting('top_of_page_title', 'page_options');
$top_of_page_icon = Plugin::getSetting('top_of_page_icon', 'page_options');
?>


<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/jquery.miniColors.js"></script>
<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/jquery.cookie.js"></script>
<link type="text/css" rel="stylesheet" href="/wolf/plugins/mobile_check/js/jquery.miniColors.css" />
<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/scripts.js"></script>

<form action="<?php echo get_url('plugin/page_options/save_settings'); ?>" method="post">




	<fieldset style="padding: 0.5em 1.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Page Options'); ?></legend>

	    <fieldset style="padding: 0.5em;">
	        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Updated'); ?></legend>
	        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
                <td class="label"><label for="updated_enabled"><?php echo __('Display'); ?></label></td>
	            <td class="field display"><input type="checkbox" name="updated_enabled" id="updated_enabled" value="show" class="checkbox"<?php if($updated_enabled == "show"){echo " checked";}?>/></td>
                <td class="help" colspan="2">Apperance of page updated notice</td>
            </tr>
	        </table>
	    </fieldset>

	    <fieldset style="padding: 0.5em;">
	        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Print'); ?></legend>
	        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
	                <td class="label"><label for="print_enabled"><?php echo __('Display'); ?></label></td>
	                <td class="field display"><input type="checkbox" name="print_enabled" id="print_enabled" value="show" class="checkbox"<?php if($print_enabled == "show"){echo " checked";}?>/></td>
					<!-- <td class="label mobile"><label for="print_mobile_enabled"><?php echo __('Mobile'); ?></label></td> -->
	                <!-- <td class="field"><input type="checkbox" name="print_mobile_enabled" id="print_mobile_enabled" value="show" class="checkbox"<?php if($print_mobile_enabled == "show"){echo " checked";}?>/></td> -->

	                <td class="label"><label for="print_title"><?php echo __('Title'); ?></label></td>
	                <td class="field"><input name="print_title" id="print_title" value="<?php echo htmlentities($print_title); ?>" /></td>
	
	                <td class="label"><label for="print_icon"><?php echo __('Icon'); ?></label></td>
	                <td class="field icon"><input name="print_icon" id="print_icon" value="<?php echo htmlentities($print_icon); ?>" /></td>
	
	            </tr>
	        </table>
	    </fieldset>

	    <?php if(Plugin::getSetting('enable', 'mobile_check') == true){ ?>
		<fieldset style="padding: 0.5em;">
	        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Mobile'); ?></legend>
	        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
	                <td class="label"><label for="mobile_enabled"><?php echo __('Display'); ?></label></td>
	                <td class="field display"><input type="checkbox" name="mobile_enabled" id="mobile_enabled" value="show" class="checkbox"<?php if($mobile_enabled == "show"){echo " checked";}?>/></td>
	                <!-- <td class="label mobile"><label for="mobile_desktop_enabled"><?php echo __('Mobile'); ?></label></td> -->
	                <!-- <td class="field"><input type="checkbox" name="mobile_desktop_enabled" id="mobile_desktop_enabled" value="show" class="checkbox"<?php if($mobile_desktop_enabled == "show"){echo " checked";}?>/></td> -->
	
	                <td class="label"><label for="mobile_title"><?php echo __('Title'); ?></label></td>
	                <td class="field"><input name="mobile_title" id="mobile_title" value="<?php echo htmlentities($mobile_title); ?>" /></td>
	
	                <td class="label"><label for="mobile_icon"><?php echo __('Icon'); ?></label></td>
	                <td class="field icon"><input name="mobile_icon" id="mobile_icon" value="<?php echo htmlentities($mobile_icon); ?>" /></td>
	
	            </tr>
	        </table>
	    </fieldset>
	    <?php } ?>
	
	    <?php if(function_exists('downloadPDF')){ ?>
		<fieldset style="padding: 0.5em;">
	        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('PDF'); ?></legend>
	        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
	                <td class="label"><label for="pdf_enabled"><?php echo __('Display'); ?></label></td>
	                <td class="field display"><input type="checkbox" name="pdf_enabled" id="pdf_enabled" value="show" class="checkbox"<?php if($pdf_enabled == "show"){echo " checked";}?>/></td>
	                <!-- <td class="label mobile"><label for="pdf_mobile_enabled"><?php echo __('Mobile'); ?></label></td> -->
	                <!-- <td class="field"><input type="checkbox" name="pdf_mobile_enabled" id="pdf_mobile_enabled" value="show" class="checkbox"<?php if($pdf_mobile_enabled == "show"){echo " checked";}?>/></td> -->
	
	                <td class="label"><label for="pdf_title"><?php echo __('Title'); ?></label></td>
	                <td class="field"><input name="pdf_title" id="pdf_title" value="<?php echo htmlentities($pdf_title); ?>" /></td>

	                <td class="label"><label for="pdf_icon"><?php echo __('Icon'); ?></label></td>
	                <td class="field icon"><input name="pdf_icon" id="pdf_icon" value="<?php echo htmlentities($pdf_icon); ?>" /></td>
	
	            </tr>
	        </table>
	    </fieldset>
	    <?php } ?>
	
	    <fieldset style="padding: 0.5em;">
	        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Top of Page'); ?></legend>
	        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
	                <td class="label"><label for="top_of_page_enabled"><?php echo __('Display'); ?></label></td>
	                <td class="field display"><input type="checkbox" name="top_of_page_enabled" id="top_of_page_enabled" value="show" class="checkbox"<?php if($top_of_page_enabled == "show"){echo " checked";}?>/></td>
	                <!-- <td class="label mobile"><label for="top_of_page_mobile_enabled"><?php echo __('Mobile'); ?></label></td> -->
	                <!-- <td class="field"><input type="checkbox" name="top_of_page_mobile_enabled" id="top_of_page_mobile_enabled" value="show" class="checkbox"<?php if($top_of_page_mobile_enabled == "show"){echo " checked";}?>/></td> -->
	
	                <td class="label"><label for="top_of_page_title"><?php echo __('Title'); ?></label></td>
	                <td class="field"><input name="top_of_page_title" id="top_of_page_title" value="<?php echo htmlentities($top_of_page_title); ?>" /></td>
	
	                <td class="label"><label for="top_of_page_icon"><?php echo __('Icon'); ?></label></td>
	                <td class="field icon"><input name="top_of_page_icon" id="top_of_page_icon" value="<?php echo htmlentities($top_of_page_icon); ?>" /></td>
	
	            </tr>
	        </table>
	    </fieldset>

	</fieldset>











	<?php
	//$filename
	$pdf_bg_color = Plugin::getSetting('pdf_bg_color', 'page_options');
	$pdf_text_color = Plugin::getSetting('pdf_text_color', 'page_options');
	$pdf_link_color = Plugin::getSetting('pdf_link_color', 'page_options');
	$print_logo_enabled = Plugin::getSetting('print_logo_enabled', 'page_options');
	$print_logo_url = Plugin::getSetting('print_logo_url', 'page_options');
	$print_logo_width = Plugin::getSetting('print_logo_width', 'page_options');
	$print_logo_height = Plugin::getSetting('print_logo_height', 'page_options');
	$pdf_logo_enabled = Plugin::getSetting('pdf_logo_enabled', 'page_options');
	$pdf_logo_url = Plugin::getSetting('pdf_logo_url', 'page_options');
	$pdf_logo_width = Plugin::getSetting('pdf_logo_width', 'page_options');
	$pdf_logo_height = Plugin::getSetting('pdf_logo_height', 'page_options');
	$pdf_qrcode_enabled = Plugin::getSetting('pdf_qrcode_enabled', 'page_options');
	$pdf_qrcode_width = Plugin::getSetting('pdf_qrcode_width', 'page_options');
	$pdf_qrcode_height = Plugin::getSetting('pdf_qrcode_height', 'page_options');
	$pdf_download = Plugin::getSetting('pdf_download', 'page_options');

	$pdf_h1_color = Plugin::getSetting('pdf_h1_color', 'page_options');
	$pdf_hx_color = Plugin::getSetting('pdf_hx_color', 'page_options');
	?>




<!-- Print logo is not currently used
	<fieldset style="padding: 0.5em 1.5em !important;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Print Options'); ?></legend>

        <fieldset style="padding: 0.5em;">
		    <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Logo'); ?></legend>
		    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	            <tr>
	                <td class="label"><label for="print_logo_enabled">Display</label></td>
	                <td class="field display"><input type="checkbox" name="print_logo_enabled" id="print_logo_enabled" value="show" class="checkbox"<?php if($print_logo_enabled == "show"){echo " checked";}?> /></td>
	                <td class="label path"><label for="print_logo_url">URL</label></td>
	                <td class="field path"><input class="textbox" type="text" name="print_logo_url" id="print_logo_url" value="<?php echo $print_logo_url; ?>" /></td>
	                <td class="label width"><label for="print_logo_width">Width</label></td>
					<td class="field width"><input class="textbox" type="text" name="print_logo_width" id="print_logo_width" value="<?php echo $print_logo_width; ?>" /></td>
	                <td class="label height"><label for="print_logo_height">Height</label></td>
					<td class="field height"><input class="textbox" type="text" name="print_logo_height" id="print_logo_height" value="<?php echo $print_logo_height; ?>" /></td>
	            </tr>
	        </table>
     
	    </fieldset>

    </fieldset>
-->


	<?php if(function_exists('downloadPDF')){ ?>
	<fieldset style="padding: 0.5em 1.5em !important;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('PDF Options'); ?></legend>
        
 
        <?php if(Plugin::getSetting('pdf_size', 'page_options') && Plugin::getSetting('pdf_orientation', 'page_options')) { ?>
		<fieldset style="padding: 0.5em;" id="pdfsettings">
		    <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Dimensions'); ?></legend>
		    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label for="apdf_size">Size</label></td>
                <td class="field">
				<select name="pdf_size" id="apdf_size">
				<?php
				$pdf_size_array = array(
				array ('A4', 'A4'),
				array ('A5', 'A5'));
				foreach($pdf_size_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $pdf_size){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
                </select>
                </td>

                <td class="label"><label for="apdf_orientation">Orientation</label></td>
                <td class="field">
				<select name="pdf_orientation" id="apdf_orientation">
				<?php
				$pdf_orientation_array = array(
				array ('Portrait', 'P'),
				array ('Landscape', 'L'));
				foreach($pdf_orientation_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $pdf_orientation){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
                </select>
                </td>
            </tr>
            </table>
        </fieldset>
        <?php } ?>


        <?php if(Plugin::getSetting('pdf_bg_color', 'page_options') && Plugin::getSetting('pdf_text_color', 'page_options') && Plugin::getSetting('pdf_link_color', 'page_options')) { ?>
		<fieldset style="padding: 0.5em;" id="pdfsettings">
		    <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Appearance'); ?></legend>
		    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label for="apdf_bg_color">Background Colour</label></td>
                <td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="pdf_bg_color" id="apdf_bg_color" size="30" value="<?php echo $pdf_bg_color; ?>" /></td>
                <td class="help">(#XXXXXX)</td>
            </tr>
			<tr>
                <td class="label"><label for="apdf_h1_color">Heading Colour</label></td>
                <td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="pdf_h1_color" id="apdf_h1_color" size="30" value="<?php echo $pdf_h1_color; ?>" /></td>
                <td class="help">(#XXXXXX)</td>
            </tr>
            <tr>
                <td class="label"><label for="apdf_hx_color">Subheading Colour</label></td>
                <td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="pdf_hx_color" id="apdf_hx_color" size="30" value="<?php echo $pdf_hx_color; ?>" /></td>
                <td class="help">(#XXXXXX)</td>
            </tr>
			<tr>
                <td class="label"><label for="apdf_text_color">Text Colour</label></td>
                <td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="pdf_text_color" id="apdf_text_color" size="30" value="<?php echo $pdf_text_color; ?>" /></td>
                <td class="help">(#XXXXXX)</td>
            </tr>
            <tr>
                <td class="label"><label for="apdf_link_color">Link Colour</label></td>
                <td class="field"><input class="textbox color-picker" autocomplete="on" type="text" name="pdf_link_color" id="apdf_link_color" size="30" value="<?php echo $pdf_link_color; ?>" /></td>
                <td class="help">(#XXXXXX)</td>
            </tr>
            </table>
        </fieldset>
        <?php } ?>


        <fieldset style="padding: 0.5em;">
		    <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Logo'); ?></legend>
		    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	            <tr>
	                <td class="label"><label for="pdf_logo_enabled">Display</label></td>
	                <td class="field display"><input type="checkbox" name="pdf_logo_enabled" id="pdf_logo_enabled" value="show" class="checkbox"<?php if($pdf_logo_enabled == "show"){echo " checked";}?> /></td>
	                <td class="label path"><label for="pdf_logo_url">URL</label></td>
	                <td class="field path"><input class="textbox" type="text" name="pdf_logo_url" id="pdf_logo_url" value="<?php echo $pdf_logo_url; ?>" /></td>
	                <td class="label width"><label for="pdf_logo_width">Width</label></td>
					<td class="field width"><input class="textbox" type="text" name="pdf_logo_width" id="pdf_logo_width" value="<?php echo $pdf_logo_width; ?>" /></td>
	                <td class="label height"><label for="pdf_logo_height">Height</label></td>
					<td class="field height"><input class="textbox" type="text" name="pdf_logo_height" id="pdf_logo_height" value="<?php echo $pdf_logo_height; ?>" /></td>
	            </tr>
	        </table>
     
	    </fieldset>

        <fieldset style="padding: 0.5em;">
		    <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('QR Code'); ?></legend>
		    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	            <tr>
	                <td class="label"><label for="pdf_qrcode_enabled">Display</label></td>
	                <td class="field display"><input type="checkbox" name="pdf_qrcode_enabled" id="pdf_qrcode_enabled" value="show" class="checkbox"<?php if($pdf_qrcode_enabled == "show"){echo " checked";}?> /></td>
	                <td class="label width"><label for="pdf_qrcode_width">Width</label></td>
					<td class="field width"><input class="textbox" type="text" name="pdf_qrcode_width" id="pdf_qrcode_width" value="<?php echo $pdf_qrcode_width; ?>" /></td>
	                <td class="label height"><label for="pdf_qrcode_height">Height</label></td>
					<td class="field height"><input class="textbox" type="text" name="pdf_qrcode_height" id="pdf_qrcode_height" value="<?php echo $pdf_qrcode_height; ?>" /></td>

					<td class="label path"></td>
	                <td class="field path"></td>
	                

	            </tr>
	        </table>
     
	    </fieldset>

        <fieldset style="padding: 0.5em;">
		    <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Form Download'); ?></legend>
		    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	            <tr>
	                <td class="label"><label for="pdf_download"><?php echo __('Title'); ?></label></td>
	                <td class="field"><input name="pdf_download" id="pdf_download" value="<?php echo htmlentities($pdf_download); ?>" /></td>
	                <td class="extra">Text to use for <strong>[download]</strong> link</td>
	           </tr>
	        </table>

	    </fieldset>

    </fieldset>
	<?php }	?>

	











    <p class="buttons">
        <input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
    </p>

</form>