<?php


Plugin::setInfos(array(
	'id'					=> 'form_nhs',
	'title'					=> 'Form - NHS Patient Registration',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
   	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function nhsForm($emailOut,$nameOut,$subject="Registration",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "registration-form";

	/* Required fields */
	$required = array("Salutation","First Name","Last Name","Home Telephone","Email","Verify Email","Address","Postcode","Date Of Birth");
	
	/* Expected data */
	if(isset($_POST["salutation"])){ $salutation = htmlentities($_POST["salutation"]); } else { $salutation = ''; }
	if(isset($_POST["first_name"])){ $first_name = htmlentities($_POST["first_name"]); } else { $first_name = ''; }
	if(isset($_POST["last_name"])){ $last_name = htmlentities($_POST["last_name"]); } else { $last_name = ''; }
	if(isset($_POST["home_telephone"])){ $home_telephone = htmlentities($_POST["home_telephone"]); } else { $home_telephone = ''; }
	if(isset($_POST["work_telephone"])){ $work_telephone = htmlentities($_POST["work_telephone"]); } else { $work_telephone = ''; }
	if(isset($_POST["mobile_telephone"])){ $mobile_telephone = htmlentities($_POST["mobile_telephone"]); } else { $mobile_telephone = ''; }
	if(isset($_POST["email"])){ $email = htmlentities($_POST["email"]); } else { $email = ''; }
	if(isset($_POST["verify_email"])){ $verify_email = htmlentities($_POST["verify_email"]); } else { $verify_email = ''; }
	if(isset($_POST["address"])){ $address = htmlentities($_POST["address"]); } else { $address = ''; }
	if(isset($_POST["postcode"])){ $postcode = htmlentities($_POST["postcode"]); } else { $postcode = ''; }
	if(isset($_POST["date_of_birth"])){ $date_of_birth = htmlentities($_POST["date_of_birth"]); } else { $date_of_birth = ''; }
	if(isset($_POST["how_did_you_hear_about_us"])){ $how_did_you_hear_about_us = htmlentities($_POST["how_did_you_hear_about_us"]); } else { $how_did_you_hear_about_us = ''; }
	if(isset($_POST["how_can_we_best_contact_you"])){ $how_can_we_best_contact_you = htmlentities($_POST["how_can_we_best_contact_you"]); } else { $how_can_we_best_contact_you = ''; }
	if(isset($_POST["notes"])){ $notes = htmlentities($_POST["notes"]); } else { $notes = ''; }
	if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }
	$thankyouname = $first_name.' '.$last_name;
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
		if (preg_match('/[A-Za-z]/', $home_telephone) || preg_match('/[A-Za-z]/', $work_telephone) || preg_match('/[A-Za-z]/', $mobile_telephone)){
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
					if($v == null || ($id == "Email" && validEmail($email) == false) || ($id == "Verify Email" && validEmail($verify_email) == false) || ($id == "Email" || $id == "Verify Email" && $email != $verify_email)){
						$$req = $asterisk;
						$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
						$_SESSION['errorcount']++;
						$$class = " class=\"red\"";
					} else {
						//include('./wolf/plugins/form_core/lib/posted.php');
					}

				} else {
					//include_once('./wolf/plugins/form_core/lib/submitcheck.php');
				}

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
		//$$req = $asterisk;
		//echo 'Class: '.$class.' ';
		if($formsize != false){
			if(stristr($$class,'class=')){
				$$class = str_replace('class="','class="tooltip',$$class);
			} else {
				$$class = ' class="tooltip"';
			}
		}
		
		if(!isset($$class)){ $$class = ''; }
		if(stristr($$class,'red')){ $$req = $asterisk; } else { $$req = ''; }
	}

	if(!isset($work_telephone_class)){ $work_telephone_class = ''; }
	if(!isset($mobile_telephone_class)){ $mobile_telephone_class = ''; }
	if(!isset($how_did_you_hear_about_us_class)){ $how_did_you_hear_about_us_class = ''; }
	if(!isset($how_can_we_best_contact_you_class)){ $how_can_we_best_contact_you_class = ''; }
	if(!isset($notes_class)){ $notes_class = ''; }

	if(!isset($work_telephone_req)){ $work_telephone_req = ''; }
	if(!isset($mobile_telephone_req)){ $mobile_telephone_req = ''; }
	if(!isset($notes_req)){ $notes_req = ''; }

	?>

		<?php if($hideFormWrap != true){ ?>
		<?php if(!isset($formclass)){ $formclass = ''; } ?>
		<form id="<?php echo $formid; ?>" class="form<?php echo $formclass ?>" method="post" action="<?php echo $formtarget; ?>">
		<?php } ?>

			<?php include('./wolf/plugins/form_core/lib/formHeader.php'); ?>

			<?php /* Display form on success (true/false) */
			if($displayform != false){ ?>
			
			<fieldset>
			<<?php echo $grouptag; ?>>Your personal details</<?php echo $grouptag; ?>>

				<?php //$labels = array('name'); ?>
				<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>

				<label for="thissalutation"<?php echo $salutation_class;?> id="name"><span>Salutation<?php echo $salutation_req;?></span>
				<input id="thissalutation" type="text" name="salutation" value="<?php echo $salutation;?>" size="30" autocompletetype="honorific-prefix" /></label>

				<label for="thisfirst_name"<?php echo $first_name_class;?> id="first_name"><span>First Name<?php echo $first_name_req;?></span>
				<input id="thisfirst_name" type="text" name="first_name" value="<?php echo $first_name;?>" size="30" autocompletetype="given-name" /></label>

				<label for="thislast_name"<?php echo $last_name_class;?> id="last_name"><span>Last Name<?php echo $last_name_req;?></span>
				<input id="thislast_name" type="text" name="last_name" value="<?php echo $last_name;?>" size="30" autocompletetype="family-name" /></label>

			</fieldset>

			<fieldset>
			<<?php echo $grouptag; ?>>Your contact details</<?php echo $grouptag; ?>>

				<label for="thishome_telephone"<?php echo $home_telephone_class;?> id="home_telephone"><span>Home Telephone<?php echo $home_telephone_req;?></span>
				<input id="thishome_telephone" type="tel" name="home_telephone" value="<?php echo $home_telephone;?>" size="30" /></label>

				<label for="thiswork_telephone"<?php echo $work_telephone_class;?> id="work_telephone"><span>Work Telephone<?php echo $work_telephone_req;?></span>
				<input id="thiswork_telephone" type="tel" name="work_telephone" value="<?php echo $work_telephone;?>" size="30" /></label>

				<label for="thismobile_telephone"<?php echo $mobile_telephone_class;?> id="mobile_telephone"><span>Mobile Telephone<?php echo $mobile_telephone_req;?></span>
				<input id="thismobile_telephone" type="tel" name="mobile_telephone" value="<?php echo $mobile_telephone;?>" size="30" /></label>

				<label for="thisemail"<?php echo $email_class;?> id="email"><span>Email<?php echo $email_req;?></span>
				<input id="thisemail" type="email" name="email" value="<?php echo $email;?>" size="30" /></label>

				<label for="thisverify_email"<?php echo $verify_email_class;?> id="verify_email"><span>Verify Email<?php echo $verify_email_req;?></span>
				<input id="thisverify_email" type="email" name="verify_email" value="<?php echo $verify_email;?>" size="30" /></label>

				<label for="thisaddress"<?php echo $address_class;?> id="address"><span>Address<?php echo $address_req;?></span>
				<textarea id="thisaddress" name="address" cols="25" rows="5"><?php echo $address;?></textarea></label>

				<label for="thispostcode"<?php echo $postcode_class;?> id="postcode"><span>Postcode<?php echo $postcode_req;?></span>
				<input id="thispostcode" type="text" name="postcode" value="<?php echo $postcode;?>" size="30" /></label>

				<label for="thisdate_of_birth"<?php echo $date_of_birth_class;?> id="date_of_birth"><span>Date of Birth<?php echo $date_of_birth_req;?></span>
				<input id="thisdate_of_birth" type="text" name="date_of_birth" value="<?php echo $date_of_birth;?>" size="30" /></label>

				<label for='thishow_can_we_best_contact_you'<?php echo $how_can_we_best_contact_you_class;?> id="how_can_we_best_contact_you"><span>How can we best contact you?</span>
				<select id="thishow_can_we_best_contact_you" name="how_can_we_best_contact_you">
				<?php
				$how_can_we_best_contact_you_array = array(
				array ('Letter', 'letter'),
				array ('Email', 'email'),
				array ('Phone', 'phone'));
				foreach($how_can_we_best_contact_you_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $how_can_we_best_contact_you){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</label>

			</fieldset>

			<fieldset>
			<<?php echo $grouptag; ?>>Your feedback</<?php echo $grouptag; ?>>

				<label for='how_did_you_hear_about_us'<?php echo $how_did_you_hear_about_us_class;?> id="list_how_did_you_hear_about_us"><span>How did you hear about us?</span>
				<input type="text" name="how_did_you_hear_about_us" id="how_did_you_hear_about_us" list="thishow_did_you_hear_about_us">
				<datalist id="thishow_did_you_hear_about_us">
				<?php
				$how_did_you_hear_about_us_array = array(
				array ('Family &amp Friends', 'Family & Friends'),
				array ('Internet', 'Internet'),
				array ('GP Recommendation', 'GP Recommendation'),
				array ('Walk in', 'Walk in'),
				array ('Other', 'Other'));
				foreach($how_did_you_hear_about_us_array as $subarray) {
					list($text, $val) = $subarray;
					echo "<option value=\"$val\">";
					}
				?>
				</datalist>
				</label>
				
				<label for="thisnotes"<?php echo $notes_class;?> id="notes"><span>Additional registration notes<?php echo $notes_req;?></span>
				<textarea id="thisnotes" name="notes" cols="25" rows="5"><?php echo $notes;?></textarea></label>
				
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