<?php


Plugin::setInfos(array(
	'id'					=> 'form_referral',
	'title'					=> 'Form - Referral',
	'version'				=> '13.0.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function referralForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$advancedform=false,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "referral-form";
	$form_attachments = true;

	/* Required fields */
	$required = array("Dentist Name","Practice Telephone","Practice Email","Patient Name","Patient Telephone");
	//$required = array("Dentist Name");

	/* Expected data */
	if(isset($_POST["dentist_name"])){ $dentist_name = htmlentities($_POST["dentist_name"]); } else { $dentist_name = ''; }
	if(isset($_POST["practice_name"])){ $practice_name = htmlentities($_POST["practice_name"]); } else { $practice_name = ''; }
	if(isset($_POST["practice_address"])){ $practice_address = htmlentities($_POST["practice_address"]); } else { $practice_address = ''; }
	if(isset($_POST["practice_telephone"])){ $practice_telephone = htmlentities($_POST["practice_telephone"]); } else { $practice_telephone = ''; }
	if(isset($_POST["practice_email"])){ $practice_email = htmlentities($_POST["practice_email"]); } else { $practice_email = ''; }
	if(isset($_POST["patient_name"])){ $patient_name = htmlentities($_POST["patient_name"]); } else { $patient_name = ''; }
	if(isset($_POST["patient_email"])){ $patient_email = htmlentities($_POST["patient_email"]); } else { $patient_email = ''; }
	if(isset($_POST["patient_address"])){ $patient_address = htmlentities($_POST["patient_address"]); } else { $patient_address = ''; }
	if(isset($_POST["patient_telephone"])){ $patient_telephone = htmlentities($_POST["patient_telephone"]); } else { $patient_telephone = ''; }
	if(isset($_POST["date_of_birth"])){ $date_of_birth = htmlentities($_POST["date_of_birth"]); } else { $date_of_birth = ''; }
	if(isset($_POST["referral_information"])){ $referral_information = htmlentities($_POST["referral_information"]); } else { $referral_information = ''; }
	if(isset($_POST["medical_history"])){ $medical_history = htmlentities($_POST["medical_history"]); } else { $medical_history = ''; }

	if(!isset($dentist_name_class)){ $dentist_name_class = ''; }
	if(!isset($practice_name_class)){ $practice_name_class = ''; }
	if(!isset($practice_address_class)){ $practice_address_class = ''; }
	if(!isset($practice_telephone_class)){ $practice_telephone_class = ''; }
	if(!isset($practice_email_class)){ $practice_email_class = ''; }
	if(!isset($patient_name_class)){ $patient_name_class = ''; }
	if(!isset($patient_email_class)){ $patient_email_class = ''; }
	if(!isset($patient_address_class)){ $patient_address_class = ''; }
	if(!isset($patient_telephone_class)){ $patient_telephone_class = ''; }
	if(!isset($date_of_birth_class)){ $date_of_birth_class = ''; }
	if(!isset($referral_information_class)){ $referral_information_class = ''; }
	if(!isset($medical_history_class)){ $medical_history_class = ''; }
	if(!isset($implants_required_class)){ $implants_required_class = ''; }
	if(!isset($periodontics_class)){ $periodontics_class = ''; }
	if(!isset($endodontics_class)){ $endodontics_class = ''; }
	if(!isset($prosthodontics_class)){ $prosthodontics_class = ''; }
	
	if(!isset($dentist_name_req)){ $dentist_name_req = ''; }
	if(!isset($practice_name_req)){ $practice_name_req = ''; }
	if(!isset($practice_address_req)){ $practice_address_req = ''; }
	if(!isset($practice_telephone_req)){ $practice_telephone_req = ''; }
	if(!isset($practice_email_req)){ $practice_email_req = ''; }
	if(!isset($patient_name_req)){ $patient_name_req = ''; }
	if(!isset($patient_email_req)){ $patient_email_req = ''; }
	if(!isset($patient_address_req)){ $patient_address_req = ''; }
	if(!isset($patient_telephone_req)){ $patient_telephone_req = ''; }
	if(!isset($date_of_birth_req)){ $date_of_birth_req = ''; }
	if(!isset($referral_information_req)){ $referral_information_req = ''; }
	if(!isset($medical_history_req)){ $medical_history_req = ''; }
	if(!isset($implants_required_req)){ $implants_required_req = ''; }
	if(!isset($periodontics_req)){ $periodontics_req = ''; }
	if(!isset($endodontics_req)){ $endodontics_req = ''; }
	if(!isset($prosthodontics_req)){ $prosthodontics_req = ''; }
	
	/* Additional data */
	if($advancedform == true){
		if(isset($_POST["implants_required"])){ $implants_required = htmlentities($_POST["implants_required"]); } else { $implants_required = ''; }
		if(isset($_POST["periodontics"])){ $periodontics = htmlentities($_POST["periodontics"]); } else { $periodontics = ''; }
		if(isset($_POST["endodontics"])){ $endodontics = htmlentities($_POST["endodontics"]); } else { $endodontics = ''; }
		if(isset($_POST["prosthodontics"])){ $prosthodontics = htmlentities($_POST["prosthodontics"]); } else { $prosthodontics = ''; }
	}

	if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }
	$thankyouname = $dentist_name;
	$formanchor = '#reply';
	defined($formid);

	include('./wolf/plugins/form_core/lib/formSettings.php');
	include_once('./wolf/plugins/form_core/lib/formLogic.php');
	include_once('./wolf/plugins/form_core/lib/formCheck1.php');

	/* Ensure request is from a browser and has been posted */
	include_once('./wolf/plugins/form_core/lib/postcheck.php');
	if(isset($postcheck) && $postcheck == TRUE) {

		include_once('./wolf/plugins/form_core/lib/formDNScheck.php');
		include_once('./wolf/plugins/form_core/lib/formValidateEmail.php');
		include_once('./wolf/plugins/form_core/lib/formCheck2.php');

		/* Prevent false phone numbers */
		if (preg_match('/[A-Za-z]/', $practice_telephone) || preg_match('/[A-Za-z]/', $patient_telephone)){
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

				/* Check required fields */
				if(in_array($id, $required)){

					/* Check for empty fields or invalid email */
					if($v == null || ($id == "Practice Email" && validEmail($practice_email) == false)){

						/* Telephone and email check only */
						if($id == "Practice Telephone" || $id == "Practice Email"){
							if($practice_telephone == null && ($practice_email == null || validEmail($practice_email) == false)){
								$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
								$_SESSION['errorcount']++;
								$$class = " class=\"red\"";
							} else {
								$errors .= "";
								$$class = "";
								$$req = "";
								/* Telephone failed */
								if($id == "Practice Telephone" && ($practice_email == null || validEmail($practice_email) == false)){
									$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#dentist_tel" title="Skip to '.$id.' field">Practice Telephone</a>, ';
									$_SESSION['errorcount']++;
									$$class = " class=\"red\"";
									$$req = $asterisk;
									$practice_email_class = "";
								}
								/* Email failed */
								if($id == "Practice Email" && $practice_telephone == null){
									$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#practice_email" title="Skip to '.$id.' field">Practice Email</a>, ';
									$_SESSION['errorcount']++;
									$$class = " class=\"red\"";
									$$req = $asterisk;
									$practice_telephone_class = "";
								}
							}
						} else {
							$$req = $asterisk;
							$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
							$_SESSION['errorcount']++;
							$$class = " class=\"red\"";
						}

					} else {
						//include('./wolf/plugins/form_core/lib/posted.php');
					}

				} else {
					//include_once('./wolf/plugins/form_core/lib/submitcheck.php');
				}
				
				include('./wolf/plugins/form_core/lib/posted.php');

			}
			



			$sessionid = 'referralreply';
			include_once('./wolf/plugins/form_core/lib/formCheck3.php');

		} else {
			/* Assume form was completed by spanner */
			$postmessage = $postmessage;
		}
	}




	?>

		<?php if($hideFormWrap != true){ ?>
		<?php if(!isset($formclass)){ $formclass = ''; } ?>
		<form id="<?php echo $formid; ?>" class="form<?php echo $formclass ?>" method="post" action="<?php echo $formtarget; ?>"<?php if($form_attachments == true){ echo ' enctype="multipart/form-data"'; } ?>>
		<?php } ?>

			<?php include('./wolf/plugins/form_core/lib/formHeader.php'); ?>

			<?php /* Display form on success (true/false) */
			if($displayform != false){ ?>
			
			<fieldset>
			<<?php echo $grouptag; ?>>Dentist details</<?php echo $grouptag; ?>>

				<?php //$labels = array('name'); ?>
				<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>

				<label for="thisdentist_name"<?php echo $dentist_name_class;?> id="dentist_name"><span>Dentist Name<?php echo $dentist_name_req;?></span>
				<input id="thisdentist_name" type="text" name="dentist_name" value="<?php echo $dentist_name;?>" size="30" autocompletetype="name" /></label>

				<label for="thispractice_name"<?php echo $practice_name_class;?> id="practice_name"><span>Practice Name<?php echo $practice_name_req;?></span>
				<input id="thispractice_name" type="text" name="practice_name" value="<?php echo $practice_name;?>" size="30" /></label>

				<label for="thispractice_telephone"<?php echo $practice_telephone_class;?> id="practice_telephone"><span>Practice Telephone<?php echo $practice_telephone_req;?></span>
				<input id="thispractice_telephone" type="tel" name="practice_telephone" value="<?php echo $practice_telephone;?>" size="30" /></label>

				<label for="thispractice_email"<?php echo $practice_email_class;?> id="practice_email"><span>Practice Email<?php echo $practice_email_req;?></span>
				<input id="thispractice_email" type="email" name="practice_email" value="<?php echo $practice_email;?>" size="30" /></label>

				<label for="thispractice_address"<?php echo $practice_address_class;?> id="practice_address"><span>Practice Address<?php echo $practice_address_req;?></span>
				<textarea id="thispractice_address" name="practice_address" cols="25" rows="5"><?php echo $practice_address;?></textarea></label>

			</fieldset>
			<fieldset>
			<<?php echo $grouptag; ?>>Patient details</<?php echo $grouptag; ?>>

				<label for="thispatient_name"<?php echo $patient_name_class;?> id="patient_name"><span>Patient Name<?php echo $patient_name_req;?></span>
				<input id="thispatient_name" type="text" name="patient_name" value="<?php echo $patient_name;?>" size="30" /></label>

				<label for="thispatient_telephone"<?php echo $patient_telephone_class;?> id="patient_telephone"><span>Patient Telephone<?php echo $patient_telephone_req;?></span>
				<input id="thispatient_telephone" type="tel" name="patient_telephone" value="<?php echo $patient_telephone;?>" size="30" /></label>

				<label for="thispatient_email"<?php echo $patient_email_class;?> id="patient_email"><span>Patient Email<?php echo $patient_email_req;?></span>
				<input id="thispatient_email" type="email" name="patient_email" value="<?php echo $patient_email;?>" size="30" /></label>

				<label for="thisdate_of_birth"<?php echo $date_of_birth_class;?> id="date_of_birth"><span>Patient Date of Birth<?php echo $date_of_birth_req;?></span>
				<input id="thisdate_of_birth" type="date" name="date_of_birth" value="<?php echo $date_of_birth;?>" size="30" />
				<!-- <fieldset>
					<label for="date_of_birth_dd" id="date_of_birth_day">DD</label>
					<input id="date_of_birth_dd" name="date_of_birth_dd" type="text" class="w2em" value="" maxlength="2" />

					<label for="date_of_birth_mm" id="date_of_birth_mmonth">MM</label>
		            <input id="date_of_birth_mm" name="date_of_birth_mm" type="text" class="w2em" value="" maxlength="2" />

		            <label for="date_of_birth_yyyy" id="date_of_birth_year">YYYY</label>
		            <input id="date_of_birth_yyyy" name="date_of_birth_yyyy" type="text" class="w4em highlight-days-67 range-low-2006-08-11 range-high-2009-09-13 disable-days-12 split-date" value="" maxlength="4" />
				</fieldset>
				-->
				</label>

				<label for="thispatient_address"<?php echo $patient_address_class;?> id="patient_address"><span>Patient Address<?php echo $patient_address_req;?></span>
				<textarea id="thispatient_address" name="patient_address" cols="25" rows="5"><?php echo $patient_address;?></textarea></label>

			</fieldset>



			<?php if($form_attachments == true){
			include('./wolf/plugins/form_core/lib/uploader.php');
			} ?>



			<fieldset id="details">
			<<?php echo $grouptag; ?>>Referral details</<?php echo $grouptag; ?>>

				<?php if($advancedform == true){ ?>

				<label for="thisimplants_required"<?php echo $implants_required_class;?> id="implants_required"><span>Type of work required</span>
				<select id="thisimplants_required" name="implants_required">
				<?php
				$implants_required_array = array(
				array ('Surgical implant', 'Surgical only'),
				array ('Surgical &amp; Restorative implant', 'Surgical &amp; Restorative'),
				array ('Surgical &amp; Abutment Connection', 'Surgical &amp; Abutment Connection'),
				array ('Other Implant System', 'Other Implant System'));
				foreach($implants_required_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $implants_required){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</label>

				<fieldset>
				<<?php echo $grouptag; ?>>Additional work required</<?php echo $grouptag; ?>>
				
	   				<label for="thisperiodontics"<?php echo $periodontics_class;?> id="periodontics"><span>Periodontics<?php echo $periodontics_req;?></span>
					<input id="thisperiodontics" type="checkbox" name="periodontics" value="yes" size="30" class="checkbox"<?php if($periodontics == "yes"){echo " checked";}?>/></label>

					<label for="thisendodontics"<?php echo $endodontics_class;?> id="endodontics"><span>Endodontics<?php echo $endodontics_req;?></span>
					<input id="thisendodontics" type="checkbox" name="endodontics" value="yes" size="30" class="checkbox"<?php if($endodontics == "yes"){echo " checked";}?>/></label>
	
					<label for="thisprosthodontics"<?php echo $prosthodontics_class;?> id="prosthodontics"><span>Prosthodontics<?php echo $prosthodontics_req;?></span>
					<input id="thisprosthodontics" type="checkbox" name="prosthodontics" value="yes" size="30" class="checkbox"<?php if($prosthodontics == "yes"){echo " checked";}?>/></label>

				</fieldset>
				<?php } ?>

				<p>Please provide reason(s) for referral and specific problem area(s)</p>
				<label for="thisreferral_information"<?php echo $referral_information_class;?> id="referral_information"><span>Referral information<?php echo $referral_information_req;?></span>
				<textarea id="thisreferral_information" name="referral_information" cols="25" rows="5" class="length2"><?php echo $referral_information;?></textarea></label>

				<label for="thismedical_history"<?php echo $medical_history_class;?> id="medical_history"><span>Relevant Medical History<?php echo $medical_history_req;?></span>
				<textarea id="thismedical_history" name="medical_history" cols="25" rows="5" class="length2"><?php echo $medical_history;?></textarea></label>

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