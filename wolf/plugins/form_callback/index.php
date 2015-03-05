<?php


Plugin::setInfos(array(
	'id'					=> 'form_callback',
	'title'					=> 'Form - Callback',
	'version'				=> '12.9.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function callbackForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "callback-form";

	/* Required fields */
	$required = array("Name","Telephone","Callback Time");


	/* Expected data */
	$name = htmlentities($_POST["name"]);
	$telephone = htmlentities($_POST["telephone"]);
	//$email = htmlentities($_POST["email"]);
	$callback_time = htmlentities($_POST["callback_time"]);
	$mailinglist = htmlentities($_POST["mailinglist"]);
	$thankyouname = $name;
	$formanchor = '#reply';
	defined($formid);

	include('./wolf/plugins/form_core/lib/formSettings.php');
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
							$$class = " class=\"red\"";
						}

					} else {
						//include('./wolf/plugins/form_core/lib/posted.php');
					}

				} else {
					if($id != "Send" && $id != "Submit" && $id != "onLoad" && $id != "OnLoad"){
					//if($id != "Submit"){
						if($v != null){
							$$class = "";
							$message .= $id.": $v\r\r";
							$postedmessage .= "\n<h3>".$id.'</h3><p>'.$v."</p>\n";
						}
					}
				}
				
				include('./wolf/plugins/form_core/lib/posted.php');
			}

			$sessionid = 'callbackreply';
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

				<div class="group">
				
					<div class="smallgroup">

						<?php //$labels = array('name'); ?>
						<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>
		
						<label for="thisname"<?php echo $name_class;?> id="name"><span>Name<?php echo $name_req;?></span>
						<input id="thisname" type="text" name="name" value="<?php echo $name;?>" size="30" autocompletetype="name" /></label>

					</div>

					<div class="smallgroup">
					
						<label for="thistelephone"<?php echo $telephone_class;?> id="telephone"><span>Telephone<?php echo $telephone_req;?></span>
						<input id="thistelephone" type="tel" name="telephone" value="<?php echo $telephone;?>" size="30" autocompletetype="tel-national" /></label>

					</div>

					<!--
					<label for="thisemail" id="email"<?php echo $email_class;?>><span>Email<?php echo $email_req;?></span>
					<input id="thisemail" type="email" name="email" value="<?php echo $email;?>" size="30" autocompletetype="email" /></label>
					-->

				</div>

			</fieldset>
			<fieldset class="preferences">
			<<?php echo $grouptag; ?>>Your call back preference</<?php echo $grouptag; ?>>

				<div class="group">
				
					<div class="smallgroup">
	
						<label for="thiscallback_time"<?php echo $callback_time_class;?> id="callback_time"><span>Call back time<?php echo $callback_time_req;?></span>
						<select id="thiscallback_time" name="callback_time">
						<?php
						$callback_time_array = array(
						array ('No Preference', 'No preference'),
						array ('Early Morning', 'Early morning'),
						array ('Late Morning', 'Late morning'),
						array ('Afternoon', 'Afternoon'));
						foreach($callback_time_array as $subarray) {
							list($text, $val) = $subarray;
							if($val == $callback_time){
								echo "<option value=\"$val\" selected>$text</option>";
							} else {
								echo "<option value=\"$val\">$text</option>";
							}
						}
						?>
						</select>
						</label>
					
					</div>

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