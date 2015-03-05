<?php


Plugin::setInfos(array(
	'id'					=> 'form_preregistration',
	'title'					=> 'Form - Child Pre-Registration',
	'version'				=> '12.9.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function preregistrationForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "preregistration-form";

	/* Required fields */
	$required = array("Your Name","Your Telephone","Your Email","Childs Name");


	/* Expected data */
	if(isset($_POST["your_name"])){ $your_name = htmlentities($_POST["your_name"]); } else { $your_name = ''; }
	if(isset($_POST["your_address"])){ $your_address = htmlentities($_POST["your_address"]); } else { $your_address = ''; }
	if(isset($_POST["your_telephone"])){ $your_telephone = htmlentities($_POST["your_telephone"]); } else { $your_telephone = ''; }
	if(isset($_POST["your_email"])){ $your_email = htmlentities($_POST["your_email"]); } else { $your_email = ''; }
	if(isset($_POST["childs_name"])){ $childs_name = htmlentities($_POST["childs_name"]); } else { $childs_name = ''; }
	if(isset($_POST["childs_date_of_birth"])){ $childs_date_of_birth = htmlentities($_POST["childs_date_of_birth"]); } else { $childs_date_of_birth = ''; }
	if(isset($_POST["gender"])){ $gender = htmlentities($_POST["gender"]); } else { $gender = ''; }
	if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }
	$thankyouname = $your_name;
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
		if(preg_match('/[A-Za-z]/', $your_telephone)){
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
					if($v == null || ($id == "Your Email" && validEmail($your_email) == false)){

						/* Telephone and email check only */
						if($id == "Your Telephone" || $id == "Your Email"){
							if($your_telephone == null && ($your_email == null || validEmail($your_email) == false)){
								$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
								$_SESSION['errorcount']++;
								$$class = " class=\"red\"";
							} else {
								$errors .= "";
								$$class = "";
								$$req = "";
								/* Telephone failed */
								if($id == "Your Telephone" && ($your_email == null || validEmail($your_email) == false)){
									$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#your_telephone" title="Skip to '.$id.' field">Your Telephone</a>, ';
									$_SESSION['errorcount']++;
									$$class = " class=\"red\"";
									$$req = $asterisk;
									$email_class = "";
								}
								/* Email failed */
								if($id == "Your Email" && $your_telephone == null){
									$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#your_email" title="Skip to '.$id.' field">Your Email</a>, ';
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

			$sessionid = 'preregistrationreply';
			include_once('./wolf/plugins/form_core/lib/formCheck3.php');

		} else {
			/* Assume form was completed by spanner */
			$postmessage = $postmessage;
		}
	}

	if(!isset($your_name_class)){ $your_name_class = ''; }
	if(!isset($your_address_class)){ $your_address_class = ''; }
	if(!isset($your_telephone_class)){ $your_telephone_class = ''; }
	if(!isset($your_email_class)){ $your_email_class = ''; }
	if(!isset($childs_name_class)){ $childs_name_class = ''; }
	if(!isset($childs_date_of_birth_class)){ $childs_date_of_birth_class = ''; }
	if(!isset($gender_class)){ $gender_class = ''; }
	if(!isset($mailinglist_class)){ $mailinglist_class = ''; }
	
	if(!isset($your_name_req)){ $your_name_req = ''; }
	if(!isset($your_address_req)){ $your_address_req = ''; }
	if(!isset($your_telephone_req)){ $your_telephone_req = ''; }
	if(!isset($your_email_req)){ $your_email_req = ''; }
	if(!isset($childs_name_req)){ $childs_name_req = ''; }
	if(!isset($childs_date_of_birth_req)){ $childs_date_of_birth_req = ''; }
	if(!isset($gender_req)){ $gender_req = ''; }
	if(!isset($mailinglist_req)){ $mailinglist_req = ''; }

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

				<div class="smallgroup">

					<label for="thisyour_name"<?php echo $your_name_class;?> id="your_name"><span>Name<?php echo $your_name_req;?></span>
					<input id="thisyour_name" type="text" name="your_name" value="<?php echo $your_name;?>" size="30" autocompletetype="name" /></label>
	
					<label for="thisyour_telephone"<?php echo $your_telephone_class;?> id="your_telephone"><span>Telephone<?php echo $your_telephone_req;?></span>
					<input id="thisyour_telephone" type="tel" name="your_telephone" value="<?php echo $your_telephone;?>" size="30" autocompletetype="tel-national" /></label>
	
					<label for="thisyour_email"<?php echo $your_email_class;?> id="your_email"><span>Email<?php echo $your_email_req;?></span>
					<input id="thisyour_email" type="email" name="your_email" value="<?php echo $your_email;?>" size="30" autocompletetype="email" /></label>
					
				</div>
				
				<div class="smallgroup">
				
					<label for="thisyour_address"<?php echo $your_address_class;?> id="your_address"><span>Address<?php echo $your_address_req;?></span>
					<textarea id="thisyour_address" name="your_address" cols="25" rows="5"><?php echo $your_address;?></textarea></label>
	
				</div>

			</fieldset>
			<fieldset>
			<<?php echo $grouptag; ?>>Your child's details</<?php echo $grouptag; ?>>

				<div class="smallgroup">
				
					<label for="thischilds_name"<?php echo $childs_name_class;?> id="childs_name"><span>Child's Name<?php echo $childs_name_req;?></span>
					<input id="thischilds_name" type="text" name="childs_name" value="<?php echo $childs_name;?>" size="30" /></label>
					
				</div>

				<div class="smallgroup">

					<label for="thischilds_date_of_birth"<?php echo $childs_date_of_birth_class;?> id="childs_date_of_birth"><span>Child's date of birth<?php echo $childs_date_of_birth_req;?></span>
					<input id="thischilds_date_of_birth" type="date" name="childs_date_of_birth" value="<?php echo $childs_date_of_birth;?>" size="30" /></label>

				</div>

				<fieldset>
				<<?php echo $grouptag; ?>>Child's gender<?php echo $gender_req;?></<?php echo $grouptag; ?>>
					<?php
					$male_status = '';
					$female_status = '';
	
						if ($gender == 'male') {
							$male_status = ' checked="checked"';
						}
						else if ($gender == 'female') {
							$female_status = ' checked="checked"';
						}
	
					?>
					<label for="thismale"<?php echo $gender_class;?> id="male"><span>Male</span>
					<input id="thismale" type="radio" name="gender" value="male" size="30"<?php echo $male_status; ?> class="checkbox" /></label>

					<label for="thisfemale"<?php echo $gender_class;?> id="female"><span>Female</span>
					<input id="thisfemale" type="radio" name="gender" value="female" size="30"<?php echo $female_status; ?> class="checkbox" /></label>
				</fieldset>

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