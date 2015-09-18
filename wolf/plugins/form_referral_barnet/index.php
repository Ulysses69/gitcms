<?php


Plugin::setInfos(array(
	'id'					=> 'form_referral_barnet',
	'title'					=> 'Form - Referral (Barnet Orthodontics)',
	'version'				=> '13.1.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function referralFormBarnet($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$advancedform=false,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "referral-form";
	$form_attachments = true;

	/* Required fields */
	$required = array();
	//$required = array("Dentist Name");

	/* Expected data */
	if(isset($_POST["patient_name"])){ $patient_name = htmlentities($_POST["patient_name"]); } else { $patient_name = ''; }
	if(isset($_POST["patient_email"])){ $patient_email = htmlentities($_POST["patient_email"]); } else { $patient_email = ''; }
	if(isset($_POST["patient_address"])){ $patient_address = htmlentities($_POST["patient_address"]); } else { $patient_address = ''; }
	if(isset($_POST["patient_telephone"])){ $patient_telephone = htmlentities($_POST["patient_telephone"]); } else { $patient_telephone = ''; }
	if(isset($_POST["date_of_birth"])){ $date_of_birth = htmlentities($_POST["date_of_birth"]); } else { $date_of_birth = ''; }
	if(isset($_POST["clinical_details"])){ $clinical_details = htmlentities($_POST["clinical_details"]); } else { $clinical_details = ''; }
	if(isset($_POST["medical_history"])){ $medical_history = htmlentities($_POST["medical_history"]); } else { $medical_history = ''; }
	if(isset($_POST["orthodontic_type"])){ $orthodontic_type = htmlentities($_POST["orthodontic_type"]); } else { $orthodontic_type = ''; }

	if(!isset($patient_name_class)){ $patient_name_class = ''; }
	if(!isset($patient_email_class)){ $patient_email_class = ''; }
	if(!isset($patient_address_class)){ $patient_address_class = ''; }
	if(!isset($patient_telephone_class)){ $patient_telephone_class = ''; }
	if(!isset($date_of_birth_class)){ $date_of_birth_class = ''; }
	if(!isset($clinical_details_class)){ $clinical_details_class = ''; }
	if(!isset($medical_history_class)){ $medical_history_class = ''; }
	if(!isset($implants_required_class)){ $implants_required_class = ''; }
	if(!isset($periodontics_class)){ $periodontics_class = ''; }
	if(!isset($endodontics_class)){ $endodontics_class = ''; }
	if(!isset($prosthodontics_class)){ $prosthodontics_class = ''; }
	if(!isset($orthodontic_type_class)){ $orthodontic_type_class = ''; }
	
	if(!isset($patient_name_req)){ $patient_name_req = ''; }
	if(!isset($patient_email_req)){ $patient_email_req = ''; }
	if(!isset($patient_address_req)){ $patient_address_req = ''; }
	if(!isset($patient_telephone_req)){ $patient_telephone_req = ''; }
	if(!isset($date_of_birth_req)){ $date_of_birth_req = ''; }
	if(!isset($clinical_details_req)){ $clinical_details_req = ''; }
	if(!isset($medical_history_req)){ $medical_history_req = ''; }
	if(!isset($implants_required_req)){ $implants_required_req = ''; }
	if(!isset($periodontics_req)){ $periodontics_req = ''; }
	if(!isset($endodontics_req)){ $endodontics_req = ''; }
	if(!isset($prosthodontics_req)){ $prosthodontics_req = ''; }
	if(!isset($orthodontic_type_req)){ $orthodontic_type_req = ''; }
	


	if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }
	if(isset($_POST["read_nhs_referral_criteria"])){ $read_nhs_referral_criteria = htmlentities($_POST["read_nhs_referral_criteria"]); } else { $read_nhs_referral_criteria = ''; }

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
			
			</fieldset>
			<fieldset class="patient-details">
			<<?php echo $grouptag; ?>>Patient details</<?php echo $grouptag; ?>>

				<div class="smallgroup">
				
					<label for="thispatient_name"<?php echo $patient_name_class;?> id="patient_name"><span>Patient Name<?php echo $patient_name_req;?></span>
					<input id="thispatient_name" type="text" name="patient_name" value="<?php echo $patient_name;?>" size="30" /></label>

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

					<label for="thispatient_telephone"<?php echo $patient_telephone_class;?> id="patient_telephone"><span>Patient Telephone<?php echo $patient_telephone_req;?></span>
					<input id="thispatient_telephone" type="tel" name="patient_telephone" value="<?php echo $patient_telephone;?>" size="30" /></label>

					<label for="thispatient_email"<?php echo $patient_email_class;?> id="patient_email"><span>Patient Email<?php echo $patient_email_req;?></span>
					<input id="thispatient_email" type="email" name="patient_email" value="<?php echo $patient_email;?>" size="30" /></label>

				</div>

			</fieldset>

			<fieldset id="details">
			<<?php echo $grouptag; ?>>Referral details</<?php echo $grouptag; ?>>

				<label for="thismedical_history"<?php echo $medical_history_class;?> id="medical_history"><span>Relevant Medical History<?php echo $medical_history_req;?></span>
				<textarea id="thismedical_history" name="medical_history" cols="25" rows="5" class="length2"><?php echo $medical_history;?></textarea></label>

				<label for="thisclinical_details"<?php echo $clinical_details_class;?> id="clinical_details"><span>Clinical details<?php echo $clinical_details_req;?></span>
				<textarea id="thisclinical_details" name="clinical_details" cols="25" rows="5" class="length2"><?php echo $clinical_details;?></textarea></label>

				<fieldset>
					<?php
					$private_status = '';
					$nhs_status = '';
	
						if ($orthodontic_type == 'private') {
							$private_status = ' checked="checked"';
						}
						else if ($orthodontic_type == 'nhs') {
							$nhs_status = ' checked="checked"';
						}
	
					?>
					<label for="thisprivate"<?php echo $orthodontic_type_class;?> id="private"><span>Private</span>
					<input id="thisprivate" type="radio" name="orthodontic_type" value="private" size="30"<?php echo $private_status; ?> class="checkbox" /></label>

					<label for="thisnhs"<?php echo $orthodontic_type_class;?> id="nhs"><span>NHS</span>
					<input id="thisnhs" type="radio" name="orthodontic_type" value="nhs" size="30"<?php echo $nhs_status; ?> class="checkbox" /></label>
				</fieldset>

				<h2>Be advised of the following</h2>
				<p>NHS England North East London require Orthodontic providers to achieve an assessment to case start ratio of 1:1.9 or less.</p>
				<p>NHS England require that patients are essentially ready to start orthodontic treatment at the time of referral.</p>
				<p>NHS referrals should met the following criteria:</p>
				<ul>
					<li>Dentally fit and excellent oral hygiene</li>
					<li>Permanent dentition established</li>
					<li>IOTN 3.6, 4 and 5</li>
					<li>Interceptive (Mixed dentition cases from 9 years onwards) are accepted for:
						<ul>
							<li>Correction of anterior and buccal cross bites</li>
							<li>Improvement of traumatic overbites</li>
							<li>Improvement of over jets greater than 10 mm</li>
						</ul>
					</li>
				</ul>
				<label for="thisread_nhs_referral_criteria" id="read_nhs_referral_criteria"><input id="thisread_nhs_referral_criteria" type="checkbox" name="read_nhs_referral_criteria" value="yes" title="Confirm reading of NHS referral criteria" class="checkbox" /> I confirm that I have read the criteria for valid NHS referrals.</label>

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