<?php
Plugin::setInfos(array(
	'id'					=> 'form_templates',
	'title'					=> 'Form - Download Templates',
	'version'				=> '13.1.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function templatesForm($emailOut,$nameOut,$subject="Enquiry",$heading='',$displayform=true,$buttontype="Download",$parentpage='',$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true,$template=''){
	if(Plugin::isEnabled('form_core') == true){
		$formid = "templates-form";

		/* Required fields */
		$required = array();



		if($template == 'certificate.pdf' || $template == 'certificate'){
			/* Expected data (telephone line can just be commented out) */
			if(isset($_POST["your_name"])){ $your_name = htmlentities($_POST["your_name"]); } else { $your_name = ''; }
			if(isset($_POST["your_gdc_number"])){ $your_gdc_number = htmlentities($_POST["your_gdc_number"]); } else { $your_gdc_number = ''; }
			if(isset($_POST["your_completion_date"])){ $your_completion_date = htmlentities($_POST["your_completion_date"]); } else { $your_completion_date = ''; }
			
			$your_name_class = '';
			$your_completion_date_class = '';
			$your_name_req = '';
			$your_completion_date_req = '';
			$your_gdc_number_class = '';
			$your_gdc_number_req = '';
		}



		if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }
  		$thankyouname = $your_name;
		$formanchor = '#reply';
		defined($formid);
		
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
			//if (ereg('[A-Za-z]', $your_gdc_number)){
			//if(preg_match('/[A-Za-z]/', $your_gdc_number)){
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

				$sessionid = 'templatesreply';
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
			<<?php echo $grouptag; ?>>Your details</<?php echo $grouptag; ?>>

				<div class="group">
				
					<?php //$labels = array('name'); ?>
					<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>
	
					<label for="thisname" id="your_name"<?php echo $your_name_class;?>><span>Name<?php echo $your_name_req;?></span>
					<input id="thisname" type="text" name="your_name" value="<?php echo $your_name;?>" size="30" /></label>

					<label for="thisgdc_number" id="your_gdc_number"<?php echo $your_gdc_number_class;?>><span>GDC Number<?php echo $your_gdc_number_req;?></span>
					<input id="thisgdc_number" type="text" name="your_gdc_number" value="<?php echo $your_gdc_number;?>" size="30" /></label>

					<label for="thiscompletion_date" id="your_completion_date"<?php echo $your_completion_date_class;?>><span>Completion Date<?php echo $your_completion_date_req;?></span>
					<input id="thiscompletion_date" type="text" name="your_completion_date" value="<?php echo $your_completion_date;?>" /></label>
					
					<input id="thistemplate" type="hidden" name="template" value="<?php echo $template;?>" />

				</div>

			</fieldset>
			<?php //include('./wolf/plugins/form_core/lib/formMailingList.php'); ?>
			<?php include('./wolf/plugins/form_core/lib/formFooter.php'); ?>

			<?php } ?>

		<?php if($hideFormWrap != true){ ?>
		</form>
		<?php } ?>

<?php } else {
		include_once('./wolf/plugins/form_core/lib/disableForm.php');
	}
} ?>