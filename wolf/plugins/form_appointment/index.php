<?php


Plugin::setInfos(array(
	'id'					=> 'form_appointment',
	'title'					=> 'Form - Appointment',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
   	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function appointmentForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "appointment-form";

	/* Required fields */
	$required = array("Your Name","Telephone","Email");
	
	/* Expected data */
	if(isset($_POST["your_name"])){ $your_name = htmlentities($_POST["your_name"]); } else { $your_name = ''; }
	if(isset($_POST["address"])){ $address = htmlentities($_POST["address"]); } else { $address = ''; }
	if(isset($_POST["telephone"])){ $telephone = htmlentities($_POST["telephone"]); } else { $telephone = ''; }
	if(isset($_POST["email"])){ $email = htmlentities($_POST["email"]); } else { $email = ''; }

	if((isset($_GET['media']) && $_GET['media'] == 'mobile') || mobiledevice() == TRUE){
		if(isset($_POST["appointment_time"])){ $appointment_time = htmlentities($_POST["appointment_time"]); if($appointment_time == '') $appointment_time = 'No Preference'; } else { $appointment_time = ''; }
		if(isset($_POST["appointment_date"])){ $appointment_date = htmlentities($_POST["appointment_date"]); if($appointment_date == '') $appointment_date = 'No Preference'; } else { $appointment_date = ''; }
	} else {
		if(isset($_POST["appointment_time_hour"])){ $appointment_time_hour = htmlentities($_POST["appointment_time_hour"]); } else { $appointment_time_hour = ''; }
		if(isset($_POST["appointment_time_minute"])){ $appointment_time_minute = htmlentities($_POST["appointment_time_minute"]); } else { $appointment_time_minute = ''; }
		if(isset($_POST["appointment_time_period"])){ $appointment_time_period = htmlentities($_POST["appointment_time_period"]); } else { $appointment_time_period = ''; }
		if(!stristr($appointment_time_hour, 'hour') && stristr($appointment_time_minute, 'minute')) $appointment_time_minute = '00';
		$appointment_time = $appointment_time_hour.':'.$appointment_time_minute.''.$appointment_time_period;
		if((stristr($appointment_time, 'hour') && stristr($appointment_time, 'minute')) || $appointment_time == '  ') $appointment_time = 'No Preference';

		if(isset($_POST["appointment_date_day"])){ $appointment_date_day = htmlentities($_POST["appointment_date_day"]); } else { $appointment_date_day = ''; }
		if(isset($_POST["appointment_date_month"])){ $appointment_date_month = htmlentities($_POST["appointment_date_month"]); } else { $appointment_date_month = ''; }
		if(isset($_POST["appointment_date_year"])){ $appointment_date_year = htmlentities($_POST["appointment_date_year"]); } else { $appointment_date_year = ''; }
		if($appointment_date_year == 'year') $appointment_date_year = date('Y');
		$appointment_date = $appointment_date_day.' '.$appointment_date_month.' '.$appointment_date_year;
		if(stristr($appointment_date, 'day') || stristr($appointment_date, 'month') || $appointment_date == '  ') $appointment_date = 'No Preference';
		if($appointment_date != 'No Preference') $appointment_date = date('l jS F Y', strtotime(str_replace(' ','-',$appointment_date)));
	}

	if(isset($_POST["further_information"])){ $further_information = htmlentities($_POST["further_information"]); } else { $further_information = ''; }
	if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }
	
	$appointment_date_year_range = 2; //this year and next = 2

	$thankyouname = $your_name;
	$formanchor = '#reply';
	defined($formid);


	$your_name_class = '';
	$address_class = '';
	$telephone_class = '';
	$email_class = '';
	$appointment_time_class = '';
	$appointment_date_class = '';
	$appointment_time_hour_class = '';
	$appointment_time_minute_class = '';
	$appointment_time_period_class = '';
	$appointment_date_day_class = '';
	$appointment_date_month_class = '';
	$appointment_date_year_class = '';
	$further_information_class = '';
	$your_name_req = '';
	$address_req = '';
	$telephone_req = '';
	$email_req = '';
	$appointment_time_req = '';
	$appointment_date_req = '';
	$appointment_time_hour_req = '';
	$appointment_time_minute_req = '';
	$appointment_time_period_req = '';
	$appointment_date_day_req = '';
	$appointment_date_month_req = '';
	$appointment_date_year_req = '';
	$further_information_req = '';

	include('./wolf/plugins/form_core/lib/formSettings.php');
	include_once('./wolf/plugins/form_core/lib/formLogic.php');
	include_once('./wolf/plugins/form_core/lib/formCheck1.php');

	/* Ensure request is from a browser and has been posted */
	include_once('./wolf/plugins/form_core/lib/postcheck.php');
	if(isset($postcheck) && $postcheck == TRUE) {
		
		/* Exclude fields from being posted to email */
		$exclude_from_email[] = 'Appointment Date Day';
		$exclude_from_email[] = 'Appointment Date Month';
		$exclude_from_email[] = 'Appointment Date Year';

		include_once('./wolf/plugins/form_core/lib/formDNScheck.php');
		include_once('./wolf/plugins/form_core/lib/formValidateEmail.php');
		include_once('./wolf/plugins/form_core/lib/formCheck2.php');

		/* Prevent false phone numbers */
		if(preg_match('/[A-Za-z]/', $telephone)){
			$malicious = true;
			$postmessage = $message_is_malicious;
		}

		/* Proceed with validation if non-malicious values are found */
		if($malicious != true){

			/* Check for errors */
			foreach($_POST as $k => $v){
				$class = $k.'_class';
				$req = $k.'_req';
				$id = ucwords(str_replace('_',' ',$k));

				if($id == "Appointment Date" && ($appointment_date != null && $appointment_date != 'No Preference')){
					/* Check date is in the present */
					$start = strtotime($appointment_date);
					$end = strtotime('D jS M Y');
					if($start < $end){
						$$req = $asterisk;
						//$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'">'.$id.'</a>';
						$_SESSION['errorcount']++;
						$$class = " class=\"red\"";
					}
				}

				/* Check required fields */
				if(in_array($id, $required)){

					/* Check for empty fields or invalid email */
					if($v == null || ($id == "Email" && validEmail($email) == false)){
						$$req = $asterisk;
						$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.str_replace('Your ','',$id).' field">'.str_replace('Your ','',$id).'</a>, ';
						$_SESSION['errorcount']++;
						$$class = " class=\"red\"";
					} else {
						//include('./wolf/plugins/form_core/lib/posted.php');
					}

				} else {
					//include_once('./wolf/plugins/form_core/lib/submitcheck.php');
				}
				
				if($k != 'appointment_time_hour' && $k != 'appointment_time_minute' && $k != 'appointment_time_period' && $k != 'appointment_date_day' && $k != 'appointment_date_month' && $k != 'appointment_date_year' && $k != 'appointment_time' && $k != 'appointment_date'){
					include('./wolf/plugins/form_core/lib/posted.php');
				}

			}



			if(!stristr($appointment_time_hour, 'hour') && stristr($appointment_time_minute, 'minute')){
				$appointment_time_minute = '00';
				$appointment_time = $appointment_time_hour.':'.$appointment_time_minute.''.$appointment_time_period;
				$id = 'Appointment Hour';
				$v = $appointment_time;
			}
			if((stristr($appointment_time, 'hour') && stristr($appointment_time, 'minute')) || $appointment_time == '  '){
				$id = 'Appointment Time';
				$v = 'No Preference';
			}
			if($appointment_time != 'No Preference'){
				$id = 'Requested Appointment Time';
				$v = $appointment_time;
			}
			if($appointment_time_hour == 'hour' && $appointment_time_minute == 'minute' && $appointment_time_period == 'am or pm'){
				$id = 'Requested Appointment Time';
				$v = 'No Preference';
			}
			include('./wolf/plugins/form_core/lib/posted.php');



			/*
			if($appointment_date_year == 'year'){
				$appointment_date_year = date('Y');
				$appointment_date = $appointment_date_day.' '.$appointment_date_month.' '.$appointment_date_year;
				$id = 'Appointment Year';
				$v = $appointment_date;
			}
			if(stristr($appointment_date, 'day') || stristr($appointment_date, 'month') || $appointment_date == '  '){
				$appointment_date = 'No Preference';
				$id = 'Appointment Day';
				$v = 'No Preference';
			}
			*/
			if($appointment_date_month != 'month' && $appointment_date_month != '' && $appointment_date_day != 'day' && $appointment_date_day != ''){
				if($appointment_date_year == 'year'){
					$appointment_date_year = date('Y');
				}
				$appointment_date = $appointment_date_day.' '.$appointment_date_month.' '.$appointment_date_year;
				$appointment_date = date('l jS F Y', strtotime(str_replace(' ','-',$appointment_date)));
				$id = 'Requested Appointment Date';
				$v = $appointment_date;
			} else {
			//if($appointment_date != 'No Preference'){
				$appointment_date = date('l jS F Y', strtotime(str_replace(' ','-',$appointment_date)));
				$id = 'Requested Appointment Date';
				$v = 'No Preference';
			}
			include('./wolf/plugins/form_core/lib/posted.php');



			$sessionid = 'appointreply';
			include_once('./wolf/plugins/form_core/lib/formCheck3.php');

		} else {
			/* Assume form was completed by spanner */
			$postmessage = $postmessage;
		}
	}
	

	/* Check required label classes */
	for($i = 0; $i < count($required); $i++){
		$class = strtolower($required[$i]).'_class';
		$class = str_replace(' ','_',$class);
		$req = strtolower($required[$i]).'_req';
		$req = str_replace(' ','_',$req);
		
		$$req = $asterisk;

		if($formsize != false){
			if(stristr($$class,'class=')){
				$$class = str_replace('class="','class="tooltip',$$class);
			} else {
				$$class = ' class="tooltip"';
			}
		}
		
		//if(!isset($$class)){ $$class = ''; }
		//if(stristr($$class,'red')){ $$req = $asterisk; } else { $$req = ''; }
	}


	?>

		<?php if($hideFormWrap != true){ ?>
		<?php if(!isset($formclass)){ $formclass = ''; } ?>
		<form id="<?php echo $formid; ?>" class="form<?php echo $formclass ?>" method="post" action="<?php echo $formtarget; ?>">
		<?php } ?>

			<?php include('./wolf/plugins/form_core/lib/formHeader.php'); ?>

			<?php /* Display form on success (true/false) */
			if($displayform != false){ ?>
			
			<fieldset>
			<<?php echo $grouptag; ?>>Your contact details</<?php echo $grouptag; ?>>

				<?php //$labels = array('name'); ?>
				<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>

				<label for="thisname" id="your_name"<?php echo $your_name_class;?>><span>Name<?php echo $your_name_req;?></span>
				<input id="thisname" type="text" name="your_name" value="<?php echo $your_name;?>" size="30" autocompletetype="name" /></label>

				<label for="thistelephone"<?php echo $telephone_class;?> id="telephone"><span>Telephone<?php echo $telephone_req;?></span>
				<input id="thistelephone" type="tel" name="telephone" value="<?php echo $telephone;?>" size="30" autocompletetype="tel-national" /></label>

				<label for="thisemail"<?php echo $email_class;?> id="email"><span>Email<?php echo $email_req;?></span>
				<input id="thisemail" type="email" name="email" value="<?php echo $email;?>" size="30" autocompletetype="email" /></label>

				<!--
				<label for="thisaddress"<?php echo $address_class;?> id="address"><span>Address<?php echo $address_req;?></span>
				<textarea id="thisaddress" name="address" cols="25" rows="5"><?php echo $address;?></textarea></label>
				-->

			</fieldset>
			<fieldset>
			<<?php echo $grouptag; ?>>Your appointment</<?php echo $grouptag; ?>>

				<?php if((isset($_GET['media']) && $_GET['media'] == 'mobile') || mobiledevice() == TRUE){ ?>
				<label for="thisappointment_time"<?php echo $appointment_time_class;?> id="appointment_time"><span>Appointment Time<?php echo $appointment_time_req;?></span>
				<input id="thisappointment_time" type="time" name="appointment_time" value="<?php echo $appointment_time;?>" size="30" /></label>
				<?php } else { ?>
				
				<?php
				if(!stristr($appointment_time_hour_class,'class=')){
					$appointment_time_hour_class = ' class="date"';
				} else {
					$appointment_time_hour_class = str_replace('class="','class="date ',$appointment_time_day_class);
				}?>
				<div<?php echo $appointment_time_hour_class;?> id="appointment_time"><span>Appointment Time</span>

					<label for="thisappointment_time_hour" id="appointment_time_hour"><span>Hour</span>
					<select id="thisappointment_time_hour" name="appointment_time_hour">
					<?php
					$appointment_time_hour_array = array(
					array ('hour', 'Hour'),
					array ('1', '1'),
					array ('2', '2'),
					array ('3', '3'),
					array ('4', '4'),
					array ('5', '5'),
					array ('6', '6'),
					array ('7', '7'),
					array ('8', '8'),
					array ('9', '9'),
					array ('10', '10'),
					array ('11', '11'),
					array ('12', '12'));
					foreach($appointment_time_hour_array as $subarray) {
						list($val, $text) = $subarray;
						if($val == $appointment_time_hour){
							echo "<option value=\"$val\" selected>$text</option>";
						} else {
							echo "<option value=\"$val\">$text</option>";
						}
					}
					?>
					</select>
					</label>
	
					<label for="thisappointment_time_minute" id="appointment_time_minute"><span>Minute</span>
					<select id="thisappointment_time_minute" name="appointment_time_minute">
					<?php
					$appointment_time_minute_array = array(
					array ('minute', 'Minute'),
					array ('00', '00'),
					array ('05', '05'),
					array ('10', '10'),
					array ('15', '15'),
					array ('20', '20'),
					array ('25', '25'),
					array ('30', '30'),
					array ('35', '35'),
					array ('40', '40'),
					array ('45', '45'),
					array ('50', '50'),
					array ('55', '55'));
					foreach($appointment_time_minute_array as $subarray) {
						list($val, $text) = $subarray;
						if($val == $appointment_time_minute){
							echo "<option value=\"$val\" selected>$text</option>";
						} else {
							echo "<option value=\"$val\">$text</option>";
						}
					}
					?>
					</select>
					</label>
	
					<label for="thisappointment_time_period" id="appointment_time_period"><span>Period</span>
					<select id="thisappointment_time_period" name="appointment_time_period">
					<?php
					$appointment_time_period_array = array(
					array ('am or pm', 'AM or PM'),
					array ('am', 'AM'),
					array ('pm', 'PM'));
					foreach($appointment_time_period_array as $subarray) {
						list($val, $text) = $subarray;
						if($val == $appointment_time_period){
							echo "<option value=\"$val\" selected>$text</option>";
						} else {
							echo "<option value=\"$val\">$text</option>";
						}
					}
					?>
					</select>
					</label>
					
					<input id="thisappointment_time" type="hidden" name="appointment_time" value="<?php echo $appointment_time;?>" />

				</div>
				
				<?php } ?>

				<?php if((isset($_GET['media']) && $_GET['media'] == 'mobile') || mobiledevice() == TRUE){ ?>
				<label for="thisappointment_date"<?php echo $appointment_date_class;?> id="appointment_date"><span>Appointment Date<?php echo $appointment_date_req;?></span>
				<input id="thisappointment_date" type="date" name="appointment_date" value="<?php echo $appointment_date;?>" /></label>
				<?php } else { ?>
				
				<?php
				if(!stristr($appointment_date_month_class,'class=')){
					$appointment_date_month_class = ' class="date"';
				} else {
					$appointment_date_month_class = str_replace('class="','class="date ',$appointment_date_month_class);
				}?>
				<div<?php echo $appointment_date_month_class;?> id="appointment_date"><span>Appointment Date</span>

					<label for="thisappointment_date_month" id="appointment_date_month"><span>Month</span>
					<select id="thisappointment_date_month" name="appointment_date_month">
					<?php
					$appointment_date_month_array = array(
					array ('month', 'Month'),
					array ('1', 'January'),
					array ('2', 'February'),
					array ('3', 'March'),
					array ('4', 'April'),
					array ('5', 'May'),
					array ('6', 'June'),
					array ('7', 'July'),
					array ('8', 'August'),
					array ('9', 'September'),
					array ('10', 'October'),
					array ('11', 'November'),
					array ('12', 'December'));
					foreach($appointment_date_month_array as $subarray) {
						list($val, $text) = $subarray;
						if($val == $appointment_date_month){
							echo "<option value=\"$val\" selected>$text</option>";
						} else {
							echo "<option value=\"$val\">$text</option>";
						}
					}
					?>
					</select>
					</label>
	
					<label for="thisappointment_date_day" id="appointment_date_day"><span>Day</span>
					<select id="thisappointment_date_day" name="appointment_date_day">
					<?php
					$appointment_date_day_array = array(
					array ('day', 'Day'),
					array ('1', '1st'),
					array ('2', '2nd'),
					array ('3', '3rd'),
					array ('4', '4th'),
					array ('5', '5th'),
					array ('6', '6th'),
					array ('7', '7th'),
					array ('8', '8th'),
					array ('9', '9th'),
					array ('10', '10th'),
					array ('11', '11th'),
					array ('12', '12th'),
					array ('13', '13th'),
					array ('14', '14th'),
					array ('15', '15th'),
					array ('16', '16th'),
					array ('17', '17th'),
					array ('18', '18th'),
					array ('19', '19th'),
					array ('20', '20th'),
					array ('21', '21st'),
					array ('22', '22nd'),
					array ('23', '23rd'),
					array ('24', '24th'),
					array ('25', '25th'),
					array ('26', '26th'),
					array ('27', '27th'),
					array ('28', '28th'),
					array ('29', '29th'),
					array ('30', '30th'),
					array ('31', '31st'));
					foreach($appointment_date_day_array as $subarray) {
						list($val, $text) = $subarray;
						if($val == $appointment_date_day){
							echo "<option value=\"$val\" selected>$text</option>";
						} else {
							echo "<option value=\"$val\">$text</option>";
						}
					}
					?>
					</select>
					</label>
	
					<label for="thisappointment_date_year" id="appointment_date_year"><span>Year</span>
					<select id="thisappointment_date_year" name="appointment_date_year">
					<?php
					$appointment_date_year_array = array(array('year','Year'));
					/* Add this year */
					$appointment_date_year_array[] = array(date('Y'), date('Y'));
					/* Add additional years as set by appointment_date_year_range */
					for ($i = 1; $i < $appointment_date_year_range; $i++) {
						$appointment_date_year_array[] = array((date('Y') + $i), (date('Y') + $i));
					}
					foreach($appointment_date_year_array as $subarray) {
						list($val, $text) = $subarray;
						if($val == $appointment_date_year){
							echo "<option value=\"$val\" selected>$text</option>";
						} else {
							echo "<option value=\"$val\">$text</option>";
						}
					}
					?>
					</select>
					</label>
					
					<input id="thisappointment_date" type="hidden" name="appointment_date" value="<?php echo $appointment_date;?>" />

				</div>

				<?php } ?>


				<!--
				<label for='thisdental_implants'<?php echo $dental_implants_class;?> id="dental_implants"><span>Dental Implants</span>
				<select id="thisdental_implants" name="dental_implants">
				<?php
				$dental_implants_array = array(
				array ('Surgical only', 'Surgical only'),
				array ('Surgical &amp; Restorative', 'Surgical &amp; Restorative'),
				array ('Surgical &amp; Abutment Connection', 'Surgical &amp; Abutment Connection'),
				array ('Other Implant System', 'Other Implant System'));
				foreach($dental_implants_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $dental_implants){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</label>
				-->

				<label for="thisfurther_information"<?php echo $further_information_class;?> id="further_information"><span>Do you have any comments or require further information?<?php echo $further_information_req;?></span>
				<textarea id="thisfurther_information" name="further_information" cols="25" rows="5"><?php echo $further_information;?></textarea></label>

			</fieldset>
			<?php include('./wolf/plugins/form_core/lib/formMailingList.php'); ?>
			<?php include('./wolf/plugins/form_core/lib/formFooter.php'); ?>

			<?php } ?>

		<?php if($hideFormWrap != true){ ?>
		</form>
		<?php } ?>

<?php } else {
		include_once('./wolf/plugins/form_core/lib/disableForm.php');
	}
} ?>