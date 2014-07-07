<?php
Plugin::setInfos(array(
	'id'					=> 'form_contact',
	'title'					=> 'Form - Contact',
	'version'				=> '13.1.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function contactForm($emailOut,$nameOut,$subject="Enquiry",$heading='',$displayform=true,$buttontype="text",$parentpage='',$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
		$formid = "contact-form";

		/* Required fields */
		$required = array("Your Name","Your Email","Your Message");


		/* Expected data */
		if(isset($_POST["your_name"])){ $your_name = htmlentities($_POST["your_name"]); } else { $your_name = ''; }
		//if(isset($_POST["your_telephone"])){ $your_telephone = htmlentities($_POST["your_telephone"]); } else { $your_telephone = ''; }
		if(isset($_POST["your_email"])){ $your_email = htmlentities($_POST["your_email"]); } else { $your_email = ''; }
		if(isset($_POST["your_message"])){ $your_message = htmlentities($_POST["your_message"]); } else { $your_message = ''; }
		if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }
  		$thankyouname = $your_name;
		$formanchor = '#reply';
		defined($formid);
		
		$your_name_class = '';
		//$your_telephone_class = '';
		$your_email_class = '';
		$your_message_class = '';
		$your_name_req = '';
		//$your_telephone_req = '';
		$your_email_req = '';
		$your_message_req = '';


		// Handle CC emails
		$get_emails = str_replace(array("\r\n", "\r", "\n", " "), '', $emailOut);
		$emails = explode(',',$get_emails);$e=0;$emailCC='';$firstEmail='';
		foreach($emails as $em){
			if($e == 0){
				$firstEmail = $emails[0];
				$emailOut = $emails[0];
			} else {
				$em = $emails[$e];
				if($e == 1){
					$emailCC .= $em;
				} else {
					$emailCC .= ",".$em;
				}
			}
			$e++;
		}


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
			//if(preg_match('/[A-Za-z]/', $your_telephone)){
			//	$malicious = true;
			//	$postmessage = $message_is_malicious;
			//}

			/* Proceed with validation if non-malicious values are found */
			if($malicious != true){

				/* Check for errors */
				foreach($_POST as $k => $v){
					$class = $k.'_class';
					$req = $k.'_req';
					$id = ucwords(str_replace('_',' ',$k));
					//$id = str_replace('Your ','',$id);

					/* Check required fields */
					if(in_array($id, $required)){

						/* Check for empty fields or invalid email */
						if($v == null || ($id == "Your Email" && validEmail($your_email) == false)){
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
					
					include('./wolf/plugins/form_core/lib/posted.php');

					//echo 'Formsize: '.$formsize;


					if($formsize != false){
						if(stristr($$class,'class=')){
							$$class = str_replace('class="','class="tooltip',$$class);
						} else {
							$$class = ' class="tooltip"';
						}
					}


				}

				$sessionid = 'contactreply';
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
			//if(isset($postcheck) && $postcheck == TRUE) {
			//	if(stristr($$class,'red')){ $$req = $asterisk; } else { $$req = ''; }
			//}
		}

		/*
		if(!isset($your_name_class)){ $your_name_class = ''; }
		if(!isset($your_telephone_class)){ $your_telephone_class = ''; }
		if(!isset($your_email_class)){ $your_email_class = ''; }
		if(!isset($your_message_class)){ $your_message_class = ''; }

		if(!isset($your_name_req)){ $your_name_req = ''; }
		if(!isset($your_telephone_req)){ $your_telephone_req = ''; }
		if(!isset($your_email_req)){ $your_email_req = ''; }
		if(!isset($your_message_req)){ $your_message_req = ''; }
		*/

		?>

		<?php if($hideFormWrap != true){ ?>
		<?php if(!isset($formclass)){ $formclass = ''; } ?>

		<form id="<?php echo $formid; ?>" class="form<?php echo $formclass ?>" method="post" action="<?php echo $formtarget; ?>">
		<?php } ?>

			<?php include('./wolf/plugins/form_core/lib/formHeader.php'); ?>

			<?php /* Display form on success (true/false) */
			if($displayform != false){ ?>

		 	<fieldset>
			<<?php echo $grouptag; ?>>Your details</<?php echo $grouptag; ?>>

				<div class="group">
				
					<?php //$labels = array('name'); ?>
					<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>
	
					<label for="thisname" id="your_name"<?php echo $your_name_class;?>><span>Name<?php echo $your_name_req;?></span>
					<input id="thisname" type="text" name="your_name" value="<?php echo $your_name;?>" size="30" autocompletetype="name" /></label>

					<!--
					<label for="thistelephone" id="your_telephone"<?php echo $your_telephone_class;?>><span>Telephone<?php echo $your_telephone_req;?></span>
					<input id="thistelephone" type="tel" name="your_telephone" value="<?php echo $your_telephone;?>" size="30" autocompletetype="tel-national" /></label>
					-->

					<label for="thisemail" id="your_email"<?php echo $your_email_class;?>><span>Email<?php echo $your_email_req;?></span>
					<input id="thisemail" type="email" name="your_email" value="<?php echo $your_email;?>" size="30" autocompletetype="email" /></label>

				</div>

				<div class="group">

					<label for="thismessage" id="your_message"<?php echo $your_message_class;?>><span>Message<?php echo $your_message_req;?></span>
					<textarea id="thismessage" name="your_message" cols="25" rows="5"><?php echo $your_message;?></textarea></label>

				</div>

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