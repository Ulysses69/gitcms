<?php


Plugin::setInfos(array(
	'id'					=> 'form_contact',
	'title'					=> 'Form - Contact',
	'version'				=> '7.1.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);

function contactForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text"){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "contact-form";
	$formprefix = str_replace('-','_',$formid);
	?><div class="contact-form"><?php

		defined($formid);

		/* Required fields */
		$required = array("Name","Telephone","Email");


		/* Expected data */
		$name = htmlentities($_POST[$formprefix."_name"]);
		$telephone = htmlentities($_POST[$formprefix."_telephone"]);
		$email = htmlentities($_POST[$formprefix."_email"]);
		$enquiry = htmlentities($_POST[$formprefix."_enquiry"]);
		$mailinglist = htmlentities($_POST["mailinglist"]);
		$formanchor = '#reply';


		include_once('./wolf/plugins/form_core/lib/formSettings.php');
		include_once('./wolf/plugins/form_core/lib/formLogic.php');
		include_once('./wolf/plugins/form_core/lib/formCheck1.php');


		/* Ensure request is from a browser and has been posted */
		if((isset($_SERVER['HTTP_USER_AGENT']) && $_SESSION['userAgent'] == $_SERVER['HTTP_USER_AGENT']) && isset($_POST["send"])) {
	

			include_once('./wolf/plugins/form_core/lib/formDNScheck.php');
			include_once('./wolf/plugins/form_core/lib/formValidateEmail.php');
			include_once('./wolf/plugins/form_core/lib/formCheck2.php');


			/* Prevent false phone numbers */
			if (ereg('[A-Za-z]', $_POST["telephone"])){
				$malicious = true;
			}

			/* Proceed with validation if non-malicious values are found */
			if($malicious != true){

				/* Check for errors */
				foreach($_POST as $k => $v){
					$k = str_replace($formprefix.'_','',$k);
					$class = $k.'_class';
					$req = $k.'_req';
					$id = ucwords(str_replace('_',' ',$k));

					/* Check required fields */
					if(in_array($id, $required)){

						/* Check for empty fields or invalid email */
						if($v == null || ($id == "Email" && validEmail($email) == false)){
								$$req = $asterisk;
								$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$formprefix.'_'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
								$_SESSION['errorcount']++;
								$$class = " class=\"red\"";
						} else {
							$message .= $id.": $v\r\r";
							$$req = "";
						}

					} else {
						if($id != "Send" && $id != "Submit" && $id != "onLoad" && $id != "OnLoad"){
							if($v != null){
								$$class = "";
								$message .= $id.": $v\r\r";
							}
						}
					}
				}


				$sessionid = 'contactreply';
				include_once('./wolf/plugins/form_core/lib/formCheck3.php');


			} else {
				/* Assume form was completed by spanner */
				$postmessage = $postmessage;
			}
		} ?>

		<form id="<?php echo $formprefix; ?>" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?><?php echo $formanchor; ?>">


			<?php include_once('./wolf/plugins/form_core/lib/formHeader.php'); ?>


			<?php /* Display form on success (true/false) */
			if($displayform != false){ ?>
			
		 	<fieldset>
			<legend>Your details</legend>

				<label for="<?php echo $formprefix; ?>_name" id="<?php echo $formprefix; ?>_name"<?php echo $name_class;?>><span>Name<?php echo $name_req;?></span>
				<input id="<?php echo $formprefix; ?>_name" type="text" name="<?php echo $formprefix; ?>_name" value="<?php echo $name;?>" size="30" /></label>

				<label for="<?php echo $formprefix; ?>_telephone" id="<?php echo $formprefix; ?>_telephone"<?php echo $telephone_class;?>><span>Telephone<?php echo $telephone_req;?></span>
				<input id="<?php echo $formprefix; ?>_telephone" type="text" name="<?php echo $formprefix; ?>_telephone" value="<?php echo $telephone;?>" size="30" /></label>

				<label for="<?php echo $formprefix; ?>_email" id="<?php echo $formprefix; ?>_email"<?php echo $email_class;?>><span>Email<?php echo $email_req;?></span>
				<input id="<?php echo $formprefix; ?>_email" type="text" name="<?php echo $formprefix; ?>_email" value="<?php echo $email;?>" size="30" /></label>


			</fieldset>
			<fieldset>
			<legend>Your feedback</legend>

				<label for="<?php echo $formprefix; ?>_enquiry" id="<?php echo $formprefix; ?>_enquiry"<?php echo $enquiry_class;?>><span>Enquiry<?php echo $enquiry_req;?></span>
				<textarea id="<?php echo $formprefix; ?>_enquiry" name="<?php echo $formprefix; ?>_enquiry" cols="25" rows="5"><?php echo $enquiry;?></textarea></label>

				<?php include_once('./wolf/plugins/form_core/lib/formMailingList.php'); ?>

			</fieldset>


			<?php include_once('./wolf/plugins/form_core/lib/formFooter.php'); ?>


			<?php } ?>

		</form>
	</div>
<?php } else {
		include_once('./wolf/plugins/form_core/lib/disableForm.php');
	}
} ?>