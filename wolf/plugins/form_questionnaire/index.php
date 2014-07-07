<?php


Plugin::setInfos(array(
	'id'					=> 'form_questionnaire',
	'title'					=> 'Form - Questionnaire',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
   	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function questionnaireForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "appointment-form";

	/* Required fields */
	$required = array("Name","Telephone","Email");


	/* Expected data */
	$name = htmlentities($_POST["name"]);
	$address = htmlentities($_POST["address"]);
	$telephone = htmlentities($_POST["telephone"]);
	$email = htmlentities($_POST["email"]);
	
	$age = htmlentities($_POST["age"]);
	$date_of_birth = htmlentities($_POST["date_of_birth"]);

	$appointment_time = htmlentities($_POST["appointment_time"]); if($appointment_time == '') $appointment_time = 'No Preference';
	$appointment_date = htmlentities($_POST["appointment_date"]); if($appointment_date == '') $appointment_date = 'No Preference';
	$further_information = htmlentities($_POST["further_information"]);
	$mailinglist = htmlentities($_POST["mailinglist"]);
	$thankyouname = $name;
	$formanchor = '#reply';
	defined($formid);

	include('./wolf/plugins/form_core/lib/formSettings.php');
	include_once('./wolf/plugins/form_core/lib/formLogic.php');
	include_once('./wolf/plugins/form_core/lib/formCheck1.php');

	/* Ensure request is from a browser and has been posted */
	include_once('./wolf/plugins/form_core/lib/postcheck.php');
	if($postcheck == TRUE) {

		include_once('./wolf/plugins/form_core/lib/formDNScheck.php');
		include_once('./wolf/plugins/form_core/lib/formValidateEmail.php');
		include_once('./wolf/plugins/form_core/lib/formCheck2.php');

		/* Prevent false phone numbers */
		if (ereg('[A-Za-z]', $telephone)){
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
						//$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'">'.$id.'</a>';
						$_SESSION['errorcount']++;
						$$class = " class=\"red\"";
						$$req = $asterisk;
					}
				}

				/* Check required fields */
				if(in_array($id, $required)){

					/* Check for empty fields or invalid email */
					if($v == null || ($id == "Email" && validEmail($email) == false)){
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
				
				include('./wolf/plugins/form_core/lib/posted.php');

			}
			
			$sessionid = 'appointreply';
			include_once('./wolf/plugins/form_core/lib/formCheck3.php');

		} else {
			/* Assume form was completed by spanner */
			$postmessage = $postmessage;
		}
	}

	?>

		<?php if($hideFormWrap != true){ ?>
		<?php if(!isset($formclass)){ $formclass = ''; } ?>
		<form id="<?php echo $formid; ?>" class="form" method="post" action="<?php echo $formtarget; ?>">
		<?php } ?>

			<?php include('./wolf/plugins/form_core/lib/formHeader.php'); ?>

			<?php /* Display form on success (true/false) */
			if($displayform != false){ ?>
			
			<fieldset>
			<<?php echo $grouptag; ?>>Your personal details</<?php echo $grouptag; ?>>

				<label for="thisname"<?php echo $name_class;?> id="name"><span>Name<?php echo $name_req;?></span>
				<input id="thisname" type="text" name="name" value="<?php echo $name;?>" size="30" autocompletetype="name" /></label>

				<label for="thistelephone"<?php echo $telephone_class;?>" id="telephone"><span>Telephone<?php echo $telephone_req;?></span>
				<input id="thistelephone" type="tel" name="telephone" value="<?php echo $telephone;?>" size="30" autocompletetype="tel-national" /></label>

				<label for="thisemail"<?php echo $email_class;?> id="email"><span>Email<?php echo $email_req;?></span>
				<input id="thisemail" type="email" name="email" value="<?php echo $email;?>" size="30" autocompletetype="email" /></label>

				<label for="thisaddress"<?php echo $address_class;?> id="address"><span>Address<?php echo $address_req;?></span>
				<textarea id="thisaddress" name="address" cols="25" rows="5"><?php echo $address;?></textarea></label>

				<label for="thisage"<?php echo $age_class;?> id="age"><span>Age<?php echo $age_req;?></span>
				<input id="thisage" type="number" name="age" value="<?php echo $age;?>" size="30" /></label>

				<label for="thisdate_of_birth"<?php echo $date_of_birth_class;?> id="date_of_birth"><span>Date of birth<?php echo $date_of_birth_req;?></span>
				<input id="thisdate_of_birth" type="date" name="date_of_birth" value="<?php echo $date_of_birth;?>" size="30" /></label>

			</fieldset>

			<fieldset>
			<<?php echo $grouptag; ?>>Medical questions</<?php echo $grouptag; ?>>
			
				<label for='thisdiscuss' id="dental_implants"><span>What do you wish to discuss in your consultation</span>
				<select id="thisdiscuss" name="discuss">
				<?php
				$discuss_array = array(
				array ('Skin care', 'Skin care'),
				array ('Dermal fillers', 'Dermal fillers'),
				array ('Botox', 'Botox'),
				array ('Hyperhydrosis', 'Hyperhydrosis'),
				array ('Sculptra', 'Sculptra'),
				array ('Dermaroller', 'Dermaroller'));
				foreach($discuss_array as $subarray) {
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

				<label for="thiscosmetictreatments" id="cosmetictreatments"><span>Have you had cosmetic treatments before?</span>
				<textarea id="thiscosmetictreatments" name="cosmetictreatments" cols="25" rows="5"><?php echo $cosmetictreatments;?></textarea></label>

				<label for="thisallergies" id="allergies"><span>Have you any known allergies?</span>
				<textarea id="thisallergies" name="allergies" cols="25" rows="5"><?php echo $allergies;?></textarea></label>

				<label for="thisallergicreaction" id="allergicreaction"><span>Have you had a severe allergic reaction to anything?</span>
				<textarea id="thisallergicreaction" name="allergicreaction" cols="25" rows="5"><?php echo $allergicreaction;?></textarea></label>

				<label for="thissuffer" id="suffer"><span>Do you suffer with Neuromuscular disorders/muscle weakness?</span>
				<textarea id="thissuffer" name="suffer" cols="25" rows="5"><?php echo $suffer;?></textarea></label>

				<label for="thismedication" id="medication"><span>Do you currently take any medication?</span>
				<textarea id="thismedication" name="medication" cols="25" rows="5"><?php echo $medication;?></textarea></label>

				<label for="thisherbalremedies" id="herbalremedies"><span>Do you take any herbal remedies?</span>
				<textarea id="thisherbalremedies" name="herbalremedies" cols="25" rows="5"><?php echo $herbalremedies;?></textarea></label>

				<label for="thisoverthecounter" id="overthecounter"><span>Do you regularly purchase over the counter medication such as paracetamol?</span>
				<textarea id="thisoverthecounter" name="overthecounter" cols="25" rows="5"><?php echo $overthecounter;?></textarea></label>

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