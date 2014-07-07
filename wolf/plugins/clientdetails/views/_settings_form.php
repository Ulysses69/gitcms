<?php
if(Setting::get('admin_title') != Plugin::getSetting('clientname', 'clientdetails')){
	$clientname = Setting::get('admin_title');
} else {
	$clientname = Plugin::getSetting('clientname', 'clientdetails');
}
$clientaddress = Plugin::getSetting('clientaddress', 'clientdetails');
$clientslogan = Plugin::getSetting('clientslogan', 'clientdetails');
$clientaddress_building = Plugin::getSetting('clientaddress_building', 'clientdetails');
$clientaddress_thoroughfare = Plugin::getSetting('clientaddress_thoroughfare', 'clientdetails');
$clientaddress_street = Plugin::getSetting('clientaddress_street', 'clientdetails');
$clientaddress_locality = Plugin::getSetting('clientaddress_locality', 'clientdetails');
$clientaddress_town = Plugin::getSetting('clientaddress_town', 'clientdetails');
$clientaddress_county = Plugin::getSetting('clientaddress_county', 'clientdetails');
$clientaddress_postcode = Plugin::getSetting('clientaddress_postcode', 'clientdetails');
$clientphone = Plugin::getSetting('clientphone', 'clientdetails');
$clientemail = Plugin::getSetting('clientemail', 'clientdetails');
//$clientlocation = Plugin::getSetting('clientlocation', 'clientdetails');
//$clientanalytics = Plugin::getSetting('clientanalytics', 'clientdetails');

$schema = Plugin::getSetting('schema', 'clientdetails'); $schema_disabled = ''; $schema_help = __('Supported <a href="http://schema.org/docs/full.html" target="_blank">scheme types</a>');
if(Plugin::isEnabled('copyright') == true){
	// Update if business copyright is set to dental
	if(stristr(Plugin::getSetting('linkcustom', 'copyright'),'Dental') || stristr(Plugin::getSetting('linkback', 'copyright'),'Dental')){
		$schema = 'Dentist'; 
		$schema_disabled = 'disabled="disabled"'; 
		$schema_help = 'Set by <a href="/'.ADMIN_DIR.'/plugin/clientdetails">copyright</a>';
	}
}

$mondayopen = Plugin::getSetting('mondayopen', 'clientdetails');
$mondayclose = Plugin::getSetting('mondayclose', 'clientdetails');
$tuesdayopen = Plugin::getSetting('tuesdayopen', 'clientdetails');
$tuesdayclose = Plugin::getSetting('tuesdayclose', 'clientdetails');
$wednesdayopen = Plugin::getSetting('wednesdayopen', 'clientdetails');
$wednesdayclose = Plugin::getSetting('wednesdayclose', 'clientdetails');
$thursdayopen = Plugin::getSetting('thursdayopen', 'clientdetails');
$thursdayclose = Plugin::getSetting('thursdayclose', 'clientdetails');
$fridayopen = Plugin::getSetting('fridayopen', 'clientdetails');
$fridayclose = Plugin::getSetting('fridayclose', 'clientdetails');
$saturdayopen = Plugin::getSetting('saturdayopen', 'clientdetails');
$saturdayclose = Plugin::getSetting('saturdayclose', 'clientdetails');
$sundayopen = Plugin::getSetting('sundayopen', 'clientdetails');
$sundayclose = Plugin::getSetting('sundayclose', 'clientdetails');

$mondayappt = Plugin::getSetting('mondayappt', 'clientdetails');
$tuesdayappt = Plugin::getSetting('tuesdayappt', 'clientdetails');
$wednesdayappt = Plugin::getSetting('wednesdayappt', 'clientdetails');
$thursdayappt = Plugin::getSetting('thursdayappt', 'clientdetails');
$fridayappt = Plugin::getSetting('fridayappt', 'clientdetails');
$saturdayappt = Plugin::getSetting('saturdayappt', 'clientdetails');
$sundayappt = Plugin::getSetting('sundayappt', 'clientdetails');

//$lunchstart = Plugin::getSetting('lunchstart', 'clientdetails');
//$lunchend = Plugin::getSetting('lunchend', 'clientdetails');

$mondaylunchstart = Plugin::getSetting('mondaylunchstart', 'clientdetails');
$mondaylunchend = Plugin::getSetting('mondaylunchend', 'clientdetails');
$tuesdaylunchstart = Plugin::getSetting('tuesdaylunchstart', 'clientdetails');
$tuesdaylunchend = Plugin::getSetting('tuesdaylunchend', 'clientdetails');
$wednesdaylunchstart = Plugin::getSetting('wednesdaylunchstart', 'clientdetails');
$wednesdaylunchend = Plugin::getSetting('wednesdaylunchend', 'clientdetails');
$thursdaylunchstart = Plugin::getSetting('thursdaylunchstart', 'clientdetails');
$thursdaylunchend = Plugin::getSetting('thursdaylunchend', 'clientdetails');
$fridaylunchstart = Plugin::getSetting('fridaylunchstart', 'clientdetails');
$fridaylunchend = Plugin::getSetting('fridaylunchend', 'clientdetails');
$saturdaylunchstart = Plugin::getSetting('saturdaylunchstart', 'clientdetails');
$saturdaylunchend = Plugin::getSetting('saturdaylunchend', 'clientdetails');
$sundaylunchstart = Plugin::getSetting('sundaylunchstart', 'clientdetails');
$sundaylunchend = Plugin::getSetting('sundaylunchend', 'clientdetails');

$showcurrentday = Plugin::getSetting('showcurrentday', 'clientdetails');

$hournotation = Plugin::getSetting('hournotation', 'clientdetails');
$mergelunch = Plugin::getSetting('mergelunch', 'clientdetails');
$daytag = Plugin::getSetting('daytag', 'clientdetails');

?>

<h2>Client / company information</h2>

<form action="<?php echo get_url('plugin/clientdetails/save_settings'); ?>" method="post">

    <fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Contact details'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label for="clientname"><?php echo __('Name'); ?></label></td>
                <td class="field">
				<input name="clientname" id="clientname" value="<?php echo $clientname; ?>" />
				</td>
                <td class="help"><?php echo __('Client or Company Name. Use [client] to display.');?></td>
            </tr>
            <!--
			<tr>
                <td class="label"><label for="clientaddress"><?php echo __('Address'); ?></label></td>
                <td class="field">
				<textarea name="clientaddress" id="clientaddress"><?php echo $clientaddress; ?></textarea>
				</td>
                <td class="help"><?php echo __('Client or Company Address.');?></td>
            </tr>
            -->
			<tr>
                <td class="label"><label for="clientaddress_building"><?php echo __('Building'); ?></label></td>
                <td class="field">
				<input name="clientaddress_building" id="clientaddress_building" value="<?php echo $clientaddress_building; ?>" />
				</td>
                <td class="help"><?php echo __('Building or Premise Name/Number.');?></td>
            </tr>
			
			<tr>
                <td class="label"><label for="clientaddress_thoroughfare"><?php echo __('Thoroughfare'); ?></label></td>
                <td class="field">
				<input name="clientaddress_thoroughfare" id="clientaddress_thoroughfare" value="<?php echo $clientaddress_thoroughfare; ?>" />
				</td>
                <td class="help"><?php echo __('Name or Description such as Park.');?></td>
            </tr>
			
			<tr>
                <td class="label"><label for="clientaddress_street"><?php echo __('Street'); ?></label></td>
                <td class="field">
				<input name="clientaddress_street" id="clientaddress_street" value="<?php echo $clientaddress_street; ?>" />
				</td>
                <td class="help"><?php echo __('Street or Road including Premise Number.');?></td>
            </tr>
			<tr>
                <td class="label"><label for="clientaddress_locality"><?php echo __('Locality'); ?></label></td>
                <td class="field">
				<input name="clientaddress_locality" id="clientaddress_locality" value="<?php echo $clientaddress_locality; ?>" />
				</td>
                <td class="help"><?php echo __('Local Village or Suburb or Thoroughfare.');?></td>
            </tr>
			<tr>
                <td class="label"><label for="clientaddress_town"><?php echo __('Town / City'); ?></label></td>
                <td class="field">
				<input name="clientaddress_town" id="clientaddress_town" value="<?php echo $clientaddress_town; ?>" />
				</td>
                <td class="help"><?php echo __('');?></td>
            </tr>
			<tr>
                <td class="label"><label for="clientaddress_county"><?php echo __('County'); ?></label></td>
                <td class="field">
				<input name="clientaddress_county" id="clientaddress_county" value="<?php echo $clientaddress_county; ?>" />
				</td>
                <td class="help"><?php echo __('');?></td>
            </tr>
			<tr>
                <td class="label"><label for="clientaddress_postcode"><?php echo __('Postcode'); ?></label></td>
                <td class="field">
				<input name="clientaddress_postcode" id="clientaddress_postcode" value="<?php echo $clientaddress_postcode; ?>" />
				</td>
                <td class="help"><?php echo __('');?></td>
            </tr>

			<tr>
                <td class="label"><label for="clientphone"><?php echo __('Telephone'); ?></label></td>
                <td class="field">
				<input name="clientphone" id="clientphone" value="<?php echo $clientphone; ?>" />
				</td>
                <td class="help"><?php echo __('Client or Company Telephone Number.');?></td>
            </tr>
			<tr>
                <td class="label"><label for="clientemail"><?php echo __('Email'); ?></label></td>
                <td class="field">
				<input name="clientemail" id="clientemail" value="<?php echo $clientemail; ?>" />
				</td>
                <td class="help"><?php echo __('Client or Company Email.');?></td>
            </tr>
        </table>
    </fieldset>

<?php if (!AuthUser::hasPermission('client')) { ?>
	<fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Business details'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
                <td class="label"><label for="clientslogan"><?php echo __('Slogan'); ?></label></td>
                <td class="field">
				<input name="clientslogan" id="clientslogan" value="<?php echo $clientslogan; ?>" />
				</td>
                <td class="help"><?php echo __('Use [clientslogan] to display or leave blank.');?></td>
            </tr>

            <tr>
                <td class="label"><label for="schema"><?php echo __('Business type'); ?></label></td>
                <td class="field">
				<!--
				<input name="schema" id="schema" value="<?php echo $schema; ?>" />
				-->
				<select name="schema" id="schema"<?php echo $schema_disabled; ?>>
				<?php
				$schema_array = array(
				array ('Local Business', 'LocalBusiness'),
				array ('Dentist', 'Dentist'));
				foreach($schema_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $schema){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
                <td class="help"><?php echo $schema_help; ?></td>
            </tr>
        </table>
    </fieldset>
<?php } ?>

    <!--
	<fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('SEO settings'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
                <td class="label"><label for="clientanalytics"><?php echo __('Analytics'); ?></label></td>
                <td class="field">
				<input name="clientanalytics" id="clientanalytics" value="<?php echo $clientanalytics; ?>" />
				</td>
                <td class="help"><?php echo __('Google UA code or script. <a href="https://www.google.com/analytics/settings/home" target="_blank">Get code</a>');?></td>
            </tr>
            <tr>
                <td class="label"><label for="clientlocation"><?php echo __('Location'); ?></label></td>
                <td class="field">
				<input name="clientlocation" id="clientlocation" value="<?php echo $clientlocation; ?>" />
				</td>
                <td class="help"><?php echo __('Client or company city.');?></td>
            </tr>
        </table>
    </fieldset>
    -->




	<fieldset style="padding: 0.5em;" class="hours open">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Business hours (24-hour clock)'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<?php $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'); ?>

        <?php for($d = 0; $d < count($days); $d++){ ?>
        	<?php $day = strtolower($days[$d]); ?>
			<tr>
				<td class="header"><h4><?php echo $days[$d]; ?></h4></td>
                <td class="label open"><label for="<?php echo strtolower($days[$d]); ?>open"><?php echo __('Open'); ?></label></td>
                <td class="field">
				<input name="<?php echo strtolower($days[$d]); ?>open" id="<?php echo strtolower($days[$d]); ?>open" value="<?php echo ${$day.'open'}; ?>" />
				</td>
                <td class="label close"><label for="<?php echo strtolower($days[$d]); ?>close"><?php echo __('Close'); ?></label></td>
                <td class="field">
				<input name="<?php echo strtolower($days[$d]); ?>close" id="<?php echo strtolower($days[$d]); ?>close" value="<?php echo ${$day.'close'}; ?>" />
				</td>
				<td class="appt"><label for="<?php echo strtolower($days[$d]); ?>appt"><span><?php echo __('Appointment required?'); ?></span></label><input type="checkbox" name="<?php echo strtolower($days[$d]); ?>appt" id="<?php echo strtolower($days[$d]); ?>appt" value="yes" class="checkbox"<?php if(${$day.'appt'} == "yes"){echo " checked";}?>/></td>
            </tr>
        <?php } ?>

		<!--
			<tr>
				<td class="header"><h4>Monday</h4></td>
                <td class="label open"><label for="mondayopen"><?php echo __('Open'); ?></label></td>
                <td class="field">
				<input name="mondayopen" id="mondayopen" value="<?php echo $mondayopen; ?>" />
				</td>
                <td class="label close"><label for="mondayclose"><?php echo __('Close'); ?></label></td>
                <td class="field">
				<input name="mondayclose" id="mondayclose" value="<?php echo $mondayclose; ?>" />
				</td>
				<td class="appt"><label for="mondayappt"><?php echo __('Appointment required?'); ?></label><input type="checkbox" name="mondayappt" id="mondayappt" value="yes" class="checkbox"<?php if($mondayappt == "yes"){echo " checked";}?>/></td>
            </tr>
			<tr>
				<td class="header"><h4>Tuesday</h4></td>
                <td class="label open"><label for="tuesdayopen"><?php echo __('Open'); ?></label></td>
                <td class="field">
				<input name="tuesdayopen" id="tuesdayopen" value="<?php echo $tuesdayopen; ?>" />
				</td>
                <td class="label close"><label for="tuesdayclose"><?php echo __('Close'); ?></label></td>
                <td class="field">
				<input name="tuesdayclose" id="tuesdayclose" value="<?php echo $tuesdayclose; ?>" />
				</td>
				<td class="appt"><label for="tuesdayappt"><?php echo __('Appointment required?'); ?></label><input type="checkbox" name="tuesdayappt" id="tuesdayappt" value="yes" class="checkbox"<?php if($tuesdayappt == "yes"){echo " checked";}?>/></td>
            </tr>
			<tr>
				<td class="header"><h4>Wednesday</h4></td>
                <td class="label open"><label for="wednesdayopen"><?php echo __('Open'); ?></label></td>
                <td class="field">
				<input name="wednesdayopen" id="wednesdayopen" value="<?php echo $wednesdayopen; ?>" />
				</td>
                <td class="label close"><label for="wednesdayclose"><?php echo __('Close'); ?></label></td>
                <td class="field">
				<input name="wednesdayclose" id="wednesdayclose" value="<?php echo $wednesdayclose; ?>" />
				</td>
				<td class="appt"><label for="wednesdayappt"><?php echo __('Appointment required?'); ?></label><input type="checkbox" name="wednesdayappt" id="wednesdayappt" value="yes" class="checkbox"<?php if($wednesdayappt == "yes"){echo " checked";}?>/></td>
            </tr>
			<tr>
				<td class="header"><h4>Thursday</h4></td>
                <td class="label open"><label for="thursdayopen"><?php echo __('Open'); ?></label></td>
                <td class="field">
				<input name="thursdayopen" id="thursdayopen" value="<?php echo $thursdayopen; ?>" />
				</td>
                <td class="label close"><label for="thursdayclose"><?php echo __('Close'); ?></label></td>
                <td class="field">
				<input name="thursdayclose" id="thursdayclose" value="<?php echo $thursdayclose; ?>" />
				</td>
				<td class="appt"><label for="thursdayappt"><?php echo __('Appointment required?'); ?></label><input type="checkbox" name="thursdayappt" id="thursdayappt" value="yes" class="checkbox"<?php if($thursdayappt == "yes"){echo " checked";}?>/></td>
            </tr>
			<tr>
				<td class="header"><h4>Friday</h4></td>
                <td class="label open"><label for="fridayopen"><?php echo __('Open'); ?></label></td>
                <td class="field">
				<input name="fridayopen" id="fridayopen" value="<?php echo $fridayopen; ?>" />
				</td>
                <td class="label close"><label for="fridayclose"><?php echo __('Close'); ?></label></td>
                <td class="field">
				<input name="fridayclose" id="fridayclose" value="<?php echo $fridayclose; ?>" />
				</td>
				<td class="appt"><label for="fridayappt"><?php echo __('Appointment required?'); ?></label><input type="checkbox" name="fridayappt" id="fridayappt" value="yes" class="checkbox"<?php if($fridayappt == "yes"){echo " checked";}?>/></td>
            </tr>
			<tr>
				<td class="header"><h4>Saturday</h4></td>
                <td class="label open"><label for="saturdayopen"><?php echo __('Open'); ?></label></td>
                <td class="field">
				<input name="saturdayopen" id="saturdayopen" value="<?php echo $saturdayopen; ?>" />
				</td>
                <td class="label close"><label for="saturdayclose"><?php echo __('Close'); ?></label></td>
                <td class="field">
				<input name="saturdayclose" id="saturdayclose" value="<?php echo $saturdayclose; ?>" />
				</td>
				<td class="appt"><label for="saturdayappt"><?php echo __('Appointment required?'); ?></label><input type="checkbox" name="saturdayappt" id="saturdayappt" value="yes" class="checkbox"<?php if($saturdayappt == "yes"){echo " checked";}?>/></td>
            </tr>
			<tr>
				<td class="header"><h4>Sunday</h4></td>
                <td class="label open"><label for="sundayopen"><?php echo __('Open'); ?></label></td>
                <td class="field">
				<input name="sundayopen" id="sundayopen" value="<?php echo $sundayopen; ?>" />
				</td>
                <td class="label close"><label for="sundayclose"><?php echo __('Close'); ?></label></td>
                <td class="field">
				<input name="sundayclose" id="sundayclose" value="<?php echo $sundayclose; ?>" />
				</td>
				<td class="appt"><label for="sundayappt"><?php echo __('Appointment required?'); ?></label><input type="checkbox" name="sundayappt" id="sundayappt" value="yes" class="checkbox"<?php if($sundayappt == "yes"){echo " checked";}?>/></td>
            </tr>
        -->
        </table>
    </fieldset>



    <fieldset style="padding: 0.5em;" class="hours closed">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Lunch hours (24-hour clock)'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<!--
			<tr>
				<td class="header"><h4>Lunch</h4></td>
                <td class="label open"><label for="lunchstart"><?php echo __('Start'); ?></label></td>
                <td class="field">
				<input name="lunchstart" id="lunchstart" value="<?php echo $lunchstart; ?>" />
				</td>
                <td class="label close"><label for="lunchend"><?php echo __('End'); ?></label></td>
                <td class="field">
				<input name="lunchend" id="lunchend" value="<?php echo $lunchend; ?>" />
				</td>
            </tr>
            -->
            <tr>
				<td class="header"><h4>Monday</h4></td>
                <td class="label open"><label for="mondaylunchstart"><?php echo __('Start'); ?></label></td>
                <td class="field">
				<input name="mondaylunchstart" id="mondaylunchstart" value="<?php echo $mondaylunchstart; ?>" />
				</td>
                <td class="label close"><label for="mondaylunchend"><?php echo __('End'); ?></label></td>
                <td class="field">
				<input name="mondaylunchend" id="mondaylunchend" value="<?php echo $mondaylunchend; ?>" />
				</td>
            </tr>
			<tr>
				<td class="header"><h4>Tuesday</h4></td>
                <td class="label open"><label for="tuesdaylunchstart"><?php echo __('Start'); ?></label></td>
                <td class="field">
				<input name="tuesdaylunchstart" id="tuesdaylunchstart" value="<?php echo $tuesdaylunchstart; ?>" />
				</td>
                <td class="label close"><label for="tuesdaylunchend"><?php echo __('End'); ?></label></td>
                <td class="field">
				<input name="tuesdaylunchend" id="tuesdaylunchend" value="<?php echo $tuesdaylunchend; ?>" />
				</td>
            </tr>
			<tr>
				<td class="header"><h4>Wednesday</h4></td>
                <td class="label open"><label for="wednesdaylunchstart"><?php echo __('Start'); ?></label></td>
                <td class="field">
				<input name="wednesdaylunchstart" id="wednesdaylunchstart" value="<?php echo $wednesdaylunchstart; ?>" />
				</td>
                <td class="label close"><label for="wednesdaylunchend"><?php echo __('End'); ?></label></td>
                <td class="field">
				<input name="wednesdaylunchend" id="wednesdaylunchend" value="<?php echo $wednesdaylunchend; ?>" />
				</td>
            </tr>
			<tr>
				<td class="header"><h4>Thursday</h4></td>
                <td class="label open"><label for="thursdaylunchstart"><?php echo __('Start'); ?></label></td>
                <td class="field">
				<input name="thursdaylunchstart" id="thursdaylunchstart" value="<?php echo $thursdaylunchstart; ?>" />
				</td>
                <td class="label close"><label for="thursdaylunchend"><?php echo __('End'); ?></label></td>
                <td class="field">
				<input name="thursdaylunchend" id="thursdaylunchend" value="<?php echo $thursdaylunchend; ?>" />
				</td>
            </tr>
			<tr>
				<td class="header"><h4>Friday</h4></td>
                <td class="label open"><label for="fridaylunchstart"><?php echo __('Start'); ?></label></td>
                <td class="field">
				<input name="fridaylunchstart" id="fridaylunchstart" value="<?php echo $fridaylunchstart; ?>" />
				</td>
                <td class="label close"><label for="fridaylunchend"><?php echo __('End'); ?></label></td>
                <td class="field">
				<input name="fridaylunchend" id="fridaylunchend" value="<?php echo $fridaylunchend; ?>" />
				</td>
            </tr>
			<tr>
				<td class="header"><h4>Saturday</h4></td>
                <td class="label open"><label for="saturdaylunchstart"><?php echo __('Start'); ?></label></td>
                <td class="field">
				<input name="saturdaylunchstart" id="saturdaylunchstart" value="<?php echo $saturdaylunchstart; ?>" />
				</td>
                <td class="label close"><label for="saturdaylunchend"><?php echo __('End'); ?></label></td>
                <td class="field">
				<input name="saturdaylunchend" id="saturdaylunchend" value="<?php echo $saturdaylunchend; ?>" />
				</td>
            </tr>
			<tr>
				<td class="header"><h4>Sunday</h4></td>
                <td class="label open"><label for="sundaylunchstart"><?php echo __('Start'); ?></label></td>
                <td class="field">
				<input name="sundaylunchstart" id="sundaylunchstart" value="<?php echo $sundaylunchstart; ?>" />
				</td>
                <td class="label close"><label for="sundaylunchend"><?php echo __('End'); ?></label></td>
                <td class="field">
				<input name="sundaylunchend" id="sundaylunchend" value="<?php echo $sundaylunchend; ?>" />
				</td>
            </tr>
        </table>
    </fieldset>



	<fieldset style="padding: 0.5em;" id="hours_format_fields">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Hours format'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label for="hournotation"><?php echo __('Notation'); ?></label></td>
                <td class="field">
				<select name="hournotation" id="hournotation">
				<?php
				$hournotation_array = array(
				array ('12-Hour Clock', '12'),
				array ('24-Hour Clock', '24'));
				foreach($hournotation_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $hournotation){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Convention of time keeping.');?></td>
            </tr>

    <!--
        </table>
	</fieldset>



	<fieldset style="padding: 0.5em;" id="hours_format_fields">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Hours format'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	-->

            <tr>
                <td class="label"><label for="mergelunch"><?php echo __('Lunch Hours'); ?></label></td>
                <td class="field">
				<select name="mergelunch" id="mergelunch">
				<?php
				$mergelunch_array = array(
				array ('Show Separately', 'separate'),
				array ('Combine with Business Hours', 'mergelunch'));
				foreach($mergelunch_array as $subarray){
					list($text, $val) = $subarray;
					if($val == $mergelunch){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Choose whether to display lunch with business hours.');?></td>
            </tr>
            <tr>
                <td class="label"><label for="daytag"><?php echo __('Day tag'); ?></label></td>
                <td class="field">
				<select name="daytag" id="daytag">
				<?php
				$daytag_array = array(
				array ('Heading 2', 'h2'),
				array ('Heading 3', 'h3'),
				array ('Span', 'span'),
				array ('Strong', 'strong'),
				array ('Div', 'div'),
				array ('None', ''));
				foreach($daytag_array as $subarray){
					list($text, $val) = $subarray;
					if($val == $daytag){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Format day within tag or without (None).');?></td>
            </tr>
        </table>
    </fieldset>



    <fieldset style="padding: 0.5em;" id="current_day_fields">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Current day'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label for="showcurrentday"><?php echo __('Highlight'); ?></label></td>
                <td class="field">
				<select name="showcurrentday" id="showcurrentday">
				<?php
				$showcurrentday_array = array(
				array ('Yes', 'true'),
				array ('No', 'false'));
				foreach($showcurrentday_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $showcurrentday){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Highlight current day (if page is not cached).');?></td>
            </tr>
        </table>
    </fieldset>

    <p class="buttons">
       <input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="Save and continue" value="Save" />
        <a href="<?php echo get_url('plugin/product'); ?>" id="site-cancel-page" class="button" title="Close without saving">Cancel</a>
    </p>

</form>