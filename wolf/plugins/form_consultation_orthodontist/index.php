<?php


Plugin::setInfos(array(
	'id'					=> 'form_consultation_orthodontist',
	'title'					=> 'Form - Orthodontist Consultation',
	'version'				=> '12.9.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');

if(!function_exists('consultationForm')){
function consultationForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "consultation-form";

	/* Required fields */
	$required = array("Your Name","Telephone","Email");

	/* Expected data */
	if(isset($_POST["your_name"])){ $your_name = htmlentities($_POST["your_name"]); } else { $your_name = ''; }
	if(isset($_POST["address"])){ $address = htmlentities($_POST["address"]); } else { $address = ''; }
	if(isset($_POST["telephone"])){ $telephone = htmlentities($_POST["telephone"]); } else { $telephone = ''; }
	if(isset($_POST["email"])){ $email = htmlentities($_POST["email"]); } else { $email = ''; }
	if(isset($_POST["consultation_time"])){ $consultation_time = htmlentities($_POST["consultation_time"]); } else { $consultation_time = ''; }
	if(isset($_POST["consultation_date"])){ $consultation_date = htmlentities($_POST["consultation_date"]); } else { $consultation_date = ''; } if($consultation_date == '') $consultation_date = 'No Preference';
	if(isset($_POST["service_required"])){ $service_required = htmlentities($_POST["service_required"]); } else { $service_required = ''; }
	if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }

	/*
	$name = htmlentities($_POST["name"]);
	$address = htmlentities($_POST["address"]);
	$telephone = htmlentities($_POST["telephone"]);
	$email = htmlentities($_POST["email"]);
	$consultation_time = htmlentities($_POST["consultation_time"]);
	$consultation_date = htmlentities($_POST["consultation_date"]); if($consultation_date == '') $consultation_date = 'No Preference';
	$service_required = htmlentities($_POST["service_required"]);
	$mailinglist = htmlentities($_POST["mailinglist"]);
	*/

	$thankyouname = $name;
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
		//if (ereg('[A-Za-z]', $your_telephone)){
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

				/* Check required fields */
				if(in_array($id, $required)){

					/* Check for empty fields or invalid email */
					if($v == null || ($id == "Email" && validEmail($email) == false)){

						/* Telephone and email check only */
						if($id == "Telephone" || $id == "Email"){
							if($telephone == null && ($email == null || validEmail($email) == false)){
								$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
								$_SESSION['errorcount']++;
								$$class = " class=\"red\"";
							} else {
								$errors .= "";
								$$class = "";
								$$req = "";
								/* Telephone failed */
								if($id == "Telephone" && ($email == null || validEmail($email) == false)){
									$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#telephone" title="Skip to '.$id.' field">Telephone</a>, ';
									$_SESSION['errorcount']++;
									$$class = " class=\"red\"";
									$$req = $asterisk;
									$email_class = "";
								}
								/* Email failed */
								if($id == "Email" && $telephone == null){
									$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#email" title="Skip to '.$id.' field">Email</a>, ';
									$_SESSION['errorcount']++;
									$$class = " class=\"red\"";
									$$req = $asterisk;
									$telephone_class = "";
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

				$sessionid = 'consultationreply';
				include_once('./wolf/plugins/form_core/lib/formCheck3.php');

		} else {
			/* Assume form was completed by spanner */
			$postmessage = $postmessage;
		}
	}

	?>

		<?php if($hideFormWrap != true){ ?>
		<?php if(!isset($formclass)){ $formclass = ''; } ?>
		<form id="<?php echo $formid; ?>" class="form<?php echo $formclass ?>" method="post" action="<?php echo $formtarget; ?>">
		<?php } ?>

			<?php include('./wolf/plugins/form_core/lib/formHeader.php'); ?>

			<?php /* Display form on success (true/false) */
			if($displayform != false){ ?>
			
			<fieldset class="your-details">
			<<?php echo $grouptag; ?>>Your contact details</<?php echo $grouptag; ?>>

				<?php //$labels = array('name'); ?>
				<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>

				<div class="smallgroup">
				<label for="thisname"<?php echo $your_name_class;?> id="your_name"><span>Name<?php echo $your_name_req;?></span>
				<input id="thisname" type="text" name="your_name" value="<?php echo $your_name;?>" size="30" autocompletetype="name" /></label>

				<label for="thistelephone"<?php echo $telephone_class;?> id="telephone"><span>Telephone<?php echo $telephone_req;?></span>
				<input id="thistelephone" type="tel" name="telephone" value="<?php echo $telephone;?>" size="30" autocompletetype="tel-national" /></label>

				<label for="thisemail"<?php echo $email_class;?> id="email"><span>Email<?php echo $email_req;?></span>
				<input id="thisemail" type="email" name="email" value="<?php echo $email;?>" size="30" autocompletetype="email" /></label>
				</div>

				<div class="smallgroup">
				<label for="thisaddress"<?php echo $address_class;?> id="address"><span>Address<?php echo $address_req;?></span>
				<textarea id="thisaddress" name="address" cols="25" rows="5"><?php echo $address;?></textarea></label>
				</div>

			</fieldset>
			<fieldset>
			<<?php echo $grouptag; ?>>Your consultation</<?php echo $grouptag; ?>>

				<label for="thisconsultation_time"<?php echo $consultation_time_class;?> id="consultation_time"><span>Consultation Time<?php echo $consultation_time_req;?></span>
				<select id="thisconsultation_time" name="consultation_time">
				<?php
				$consultation_time_array = array(
				array ('No Preference', 'No preference'),
				array ('Early Morning', 'Early morning'),
				array ('Late Morning', 'Late morning'),
				array ('Afternoon', 'Afternoon'));
				foreach($consultation_time_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $consultation_time){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select></label>

				<label for="thisconsultation_date"<?php echo $consultation_date_class;?> id="consultation_date"><span>Consultation Date<?php echo $consultation_date_req;?></span>
				<input id="thisconsultation_date" type="date" name="consultation_date" value="<?php echo $consultation_date;?>" size="30" /></label>

				<label for="service_required"<?php echo $service_required_class;?> id="service_required"><span>Service required</span>
				<select id="service_required" name="service_required">
				<?php
				$service_required_array = array(
				array ('No Preference', 'No preference'),
				array ('Child Orthodontics', 'Child orthodontics'),
				array ('Adult Orthodontics', 'Adult orthodontics'),
				array ('Invisible Orthodontics', 'Invisible orthodontics'));
				foreach($service_required_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $service_required){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</label>

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
}
}?>