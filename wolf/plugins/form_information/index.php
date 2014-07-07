<?php


Plugin::setInfos(array(
	'id'					=> 'form_information',
	'title'					=> 'Form - Information Evenings',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function informationForm($emailOut,$nameOut,$subject="Information evening enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "information-form";

	/* Required fields */
	$required = array("Name","Address","Telephone","Callback Time");


	/* Expected data */
	$name = htmlentities($_POST["name"]);
	$address = htmlentities($_POST["address"]);
	$telephone = htmlentities($_POST["telephone"]);
	$mailinglist = htmlentities($_POST["mailinglist"]);
	//$relative_analgesia = htmlentities($_POST["relative_analgesia"]);
	//$treatments_implants = htmlentities($_POST["treatments_implants"]);
	//$treatments_orthodontics = htmlentities($_POST["treatments_orthodontics"]);
	//$treatments_makeovers = htmlentities($_POST["treatments_makeovers"]);
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

			$sessionid = 'informationreply';
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


			<!--
			<fieldset>
			<<?php echo $grouptag; ?>>Treatment(s) of most interest</<?php echo $grouptag; ?>>

				<label for="relative_analgesia"><span>Relative Analgesia</span>
				<input type="checkbox" name="relative_analgesia" id="relative_analgesia" value="yes" size="30" class="checkbox"<?php if($relative_analgesia == "yes"){echo " checked";}?>/></label>

				<label for="treatments_implants"><span>Dental Implants</span>
				<input type="checkbox" name="treatments_implants" id="treatments_implants" value="yes" size="30" class="checkbox"<?php if($treatments_implants == "yes"){echo " checked";}?>/></label>

				<label for="treatments_orthodontics"><span>Orthodontics</span>
				<input type="checkbox" name="treatments_orthodontics" id="treatments_orthodontics" value="yes" size="30" class="checkbox"<?php if($treatments_orthodontics == "yes"){echo " checked";}?>/></label>

				<label for="treatments_makeovers"><span>Smile Makeovers</span>
				<input type="checkbox" name="treatments_makeovers" id="treatments_makeovers" value="yes" size="30" class="checkbox"<?php if($treatments_makeovers == "yes"){echo " checked";}?>/></label>

			</fieldset>
			-->


			<fieldset>
			<<?php echo $grouptag; ?>>Your contact details</<?php echo $grouptag; ?>>

				<?php //$labels = array('name'); ?>
				<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>

				<label for="thisname"<?php echo $name_class;?> id="name"><span>Name<?php echo $name_req;?></span>
				<input id="thisname" type="text" name="name" value="<?php echo $name;?>" size="30" autocompletetype="name" /></label>

				<label for="thistelephone"<?php echo $telephone_class;?> id="telephone"><span>Telephone<?php echo $telephone_req;?></span>
				<input id="thistelephone" type="tel" name="telephone" value="<?php echo $telephone;?>" size="30" autocompletetype="tel-national" /></label>

				<label for="thisaddress"<?php echo $address_class;?> id="address"><span>Address<?php echo $address_req;?></span>
				<textarea id="thisaddress" name="address" cols="25" rows="5"><?php echo $address;?></textarea></label>

			</fieldset>
			<!--
			<fieldset>
			<<?php echo $grouptag; ?>>Your treatment preference</<?php echo $grouptag; ?>>

				<fieldset>
				<<?php echo $grouptag; ?>>Select your treatment</<?php echo $grouptag; ?>>

					<label for="thistreatments_implants" id="treatments_implants"><span>Dental Implants</span>
					<input id="thistreatments_implants" type="checkbox" name="treatments_implants" value="yes" size="30" class="checkbox"<?php if($treatments_implants == "yes"){echo " checked";}?>/></label>
	
					<label for="thistreatments_orthodontics" id="treatments_orthodontics"><span>Orthodontics</span>
					<input id="thistreatments_orthodontics" type="checkbox" name="treatments_orthodontics" value="yes" size="30" class="checkbox"<?php if($treatments_orthodontics == "yes"){echo " checked";}?>/></label>
	
					<label for="thistreatments_makeovers" id="treatments_makeovers"><span>Smile Makeovers</span>
					<input id="thistreatments_makeovers" type="checkbox" name="treatments_makeovers" value="yes" size="30" class="checkbox"<?php if($treatments_makeovers == "yes"){echo " checked";}?>/></label>

				</fieldset>

			</fieldset>
			-->
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