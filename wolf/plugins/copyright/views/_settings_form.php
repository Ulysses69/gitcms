<br />
<form action="<?php echo get_url('plugin/copyright/save_settings'); ?>" method="post">

	<?php if (!AuthUser::hasPermission('client')) { ?>
	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Copyright'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="linkback"><?php echo __('Linkback'); ?></label></td>
				<td class="field">
				<select name="linkback" id="linkback">
				<?php
				$linkback = Plugin::getSetting('linkback', 'copyright');
				$linkback_array = array(
				array ('Not set', ''),
				array ('Blue Horizons Marketing Company', 'Blue Horizons <a href="http://www.bluehorizonsmarketing.co.uk" rel="nofollow">Marketing Company</a>'),
				array ('Dental Marketing / Dental Website by Blue Horizons', '<a href="http://www.bluehorizonsmarketing.co.uk/dental-marketing.html" rel="nofollow">Dental Marketing</a> / <a href="http://www.bluehorizonsmarketing.co.uk/dental-marketing/dental-websites.html">Dental Website</a> by Blue Horizons'),
				array ('Website by Blue Horizons', '<a href="http://www.bluehorizonsmarketing.co.uk" rel="nofollow">Website by Blue Horizons</a>'));
				foreach($linkback_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $linkback){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Keywords/URL linking back to us.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="linkcustom"><?php echo __('Custom'); ?></label></td>
				<td class="field">
				<?php
				$linkcustom = Plugin::getSetting('linkcustom', 'copyright');
				?>
				<input name="linkcustom" id="linkcustom" value="<?php echo htmlentities($linkcustom); ?>" />
				</td>
				<td class="help"><?php echo __('Custom copyright text/link.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="livedate"><?php echo __('Live date'); ?></label></td>
				<td class="field">
				<?php
				$livedate = Plugin::getSetting('livedate', 'copyright');
				/*
				if($livedate == ''){
					$livedate = date('Y-m-d');
				}
				*/
				?>
				<input name="livedate" id="livedate" value="<?php echo htmlentities($livedate); ?>" />
				<img onclick="displayDatePicker('livedate');" src="/admin/images/icon_cal.gif" alt="Show Calendar" title="Show Calendar" />
				</td>
				<td class="help"><?php echo __('When website went live.');?></td>
			</tr>
		</table>
	</fieldset>
	<?php } ?>

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('VAT / Company Registration'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="vatnumber"><?php echo __('VAT Number'); ?></label></td>
				<td class="field">
				<?php
				$vatnumber = Plugin::getSetting('vatnumber', 'copyright');
				?>
				<input name="vatnumber" id="vatnumber" value="<?php echo htmlentities($vatnumber); ?>" />
				</td>
				<td class="help"><?php echo __('Company VAT number.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="companyregistration"><?php echo __('Registration Number'); ?></label></td>
				<td class="field">
				<?php
				$companyregistration = Plugin::getSetting('companyregistration', 'copyright');
				?>
				<input name="companyregistration" id="companyregistration" value="<?php echo htmlentities($companyregistration); ?>" />
				</td>
				<td class="help"><?php echo __('Company registration number.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="countryregistration"><?php echo __('Registration Country'); ?></label></td>
				<td class="field">
				<?php
				$countryregistration = Plugin::getSetting('countryregistration', 'copyright');
				?>
				<input name="countryregistration" id="countryregistration" value="<?php echo htmlentities($countryregistration); ?>" />
				</td>
				<td class="help"><?php echo __('Country of company registration.');?></td>
			</tr>
		</table>
	</fieldset>






	<?php
	/* Display new content when plugin is updates */
	$version = Plugin::getSetting('version', 'copyright');
	if(COPYRIGHT_VERSION == $version){
	?>
	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('ICO / Data Protection'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label number"><?php echo __('Registrant / Controller'); ?></td>
				<td class="field number"><?php $icoregistrant = Plugin::getSetting('icoregistrant', 'copyright'); ?>
				<input name="icoregistrant" id="icoregistrant" value="<?php echo $icoregistrant; ?>" /></td>
				<td class="label"><label for="icoaddress"><?php echo __('Registrant Address'); ?></label></td>
				<td rowspan="3" class="field address"><textarea name="icoaddress" id="icoaddress"><?php echo Plugin::getSetting('icoaddress', 'copyright'); ?></textarea></td>
			</tr>
			<tr>
				<td class="label number"><label for="iconumber"><?php echo __('Registration Number'); ?></label></td>
				<td class="field number"><?php $iconumber = Plugin::getSetting('iconumber', 'copyright'); ?>
				<input name="cqcnumber" id="iconumber" value="<?php echo $iconumber; ?>" /></td>
				<td rowspac="2" class="label url">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</fieldset>

	<!--
	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('GDC'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label number"><label for="gdcnumber"><?php echo __('Registration Number'); ?></label></td>
				<td class="field number"><?php $gdcnumber = Plugin::getSetting('gdcnumber', 'copyright'); ?>
				<input name="gdcnumber" id="gdcnumber" value="<?php echo $gdcnumber; ?>" /></td>

				<td class="label url"><label for="gdcurl"><?php echo __('Registration URL'); ?></label></td>
				<td class="field url"><?php $gdcurl = Plugin::getSetting('gdcurl', 'copyright'); ?>
				<input name="gdcurl" id="gdcurl" value="<?php echo $gdcurl; ?>" /></td>
			</tr>
		</table>
	</fieldset>
	-->

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('CQC'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label number"><label for="cqcnumber"><?php echo __('Registration Number'); ?></label></td>
				<td colspan="2" class="field"><?php $cqcnumber = Plugin::getSetting('cqcnumber', 'copyright'); ?>
				<input name="cqcnumber" id="cqcnumber" value="<?php echo $cqcnumber; ?>" /></td>
				<td class="help"></td>
			</tr>
			<tr>
				<td class="label name"><label for="cqcname"><?php echo __('Registered Name'); ?></label></td>
				<td colspan="2" class="field name"><?php $cqcname = Plugin::getSetting('cqcname', 'copyright'); ?>
				<input name="cqcname" id="cqcname" value="<?php echo $cqcname; ?>" /></td>
				<td class="help"><?php echo __('As per CQC website.');?></td>
			</tr>
			<tr>
				<td class="label url"><label for="cqcurl"><?php echo __('Registration URL'); ?></label></td>
				<td colspan="2" class="field url"><?php $cqcurl = Plugin::getSetting('cqcurl', 'copyright'); ?>
				<input name="cqcurl" id="cqcurl" value="<?php echo $cqcurl; ?>" /></td>
				<td class="help"><?php echo __('Leave blank to auto-generate.');?></td>
			</tr>
		</table>
	</fieldset>
	<?php
	}
	?>









	<p class="buttons">
		<input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
	</p>

</form>