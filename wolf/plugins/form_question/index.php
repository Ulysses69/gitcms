<?php


Plugin::setInfos(array(
	'id'					=> 'form_question',
	'title'					=> 'Form - Ask a question',
	'version'				=> '12.8.1',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function questionForm($emailOut,$nameOut,$subject="Question",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "question-form";

	/* Required fields */
	$required = array("Your Name","Your Telephone","Your Email","Your Question");


	/* Expected data */
	if(isset($_POST["your_name"])){ $your_name = htmlentities($_POST["your_name"]); } else { $your_name = ''; }
	if(isset($_POST["your_telephone"])){ $your_telephone = htmlentities($_POST["your_telephone"]); } else { $your_telephone = ''; }
	if(isset($_POST["your_email"])){ $your_email = htmlentities($_POST["your_email"]); } else { $your_email = ''; }
	if(isset($_POST["your_question"])){ $your_question = htmlentities($_POST["your_question"]); } else { $your_question = ''; }
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
		$$req = $asterisk;
		//echo 'Class: '.$class.' ';
		if($formsize != false){
			if(stristr($$class,'class=')){
				$$class = str_replace('class="','class="tooltip',$$class);
			} else {
				$$class = ' class="tooltip"';
			}
		}
	}

	if(!isset($your_name_class)){ $your_name_class = ''; }
	if(!isset($your_telephone_class)){ $your_telephone_class = ''; }
	if(!isset($your_email_class)){ $your_email_class = ''; }
	if(!isset($your_question_class)){ $your_question_class = ''; }

	if(!isset($your_name_req)){ $your_name_req = ''; }
	if(!isset($your_telephone_req)){ $your_telephone_req = ''; }
	if(!isset($your_email_req)){ $your_email_req = ''; }
	if(!isset($your_question_req)){ $your_question_req = ''; }


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
				<label for="thisyour_question"<?php echo $your_question_class;?> id="your_question"><span>Question<?php echo $your_question_req;?></span>
				<textarea id="thisyour_question" name="your_question" cols="25" rows="5"><?php echo $your_question;?></textarea></label>
				</div>

			</fieldset>
			<?php //include_once('./wolf/plugins/form_core/lib/formMailingList.php'); ?>
			<?php include('./wolf/plugins/form_core/lib/formFooter.php'); ?>

			<?php } ?>

		<?php if($hideFormWrap != true){ ?>
		</form>
		<?php } ?>


<?php } else {
		include_once('./wolf/plugins/form_core/lib/disableForm.php');
	}
} ?>