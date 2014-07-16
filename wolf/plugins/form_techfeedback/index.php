<?php


Plugin::setInfos(array(
	'id'					=> 'form_techfeedback',
	'title'					=> 'Form - Tech Feedback',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  			=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'	=> '0.9.3')
);
Behavior::add('Form', '');
function techfeedbackForm($emailOut,$nameOut,$subject="Feedback",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "contact-form";

	/* Required fields */
	$required = array("Your Name","Your Email","Your Feedback");

	
	/* Check for passed ref page and pass to subject */
	$ref = ''; if(isset($_GET['ref'])){ $ref = '?ref='.strip_tags($_GET['ref']); $subject = $subject.' ('.$ref.')'; }


	/* Expected data */
	if(isset($_POST["your_name"])){ $your_name = htmlentities($_POST["your_name"]); } else { $your_name = ''; }
	if(isset($_POST["your_email"])){ $your_email = htmlentities($_POST["your_email"]); } else { $your_email = ''; }
	//$feedback_type = htmlentities($_POST["feedback_type"]);
	if(isset($_POST["your_feedback"])){ $your_feedback = htmlentities($_POST["your_feedback"]); } else { $your_feedback = ''; }
	if(isset($_POST["tech_support_details"])){ $tech_support_details = htmlentities($_POST["tech_support_details"]); } else { $tech_support_details = ''; }
	$thankyouname = $your_name;
	$formanchor = $ref.'#reply';
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
					if($v == null || $v == '' || ($id == "Your Email" && validEmail($your_email) == false)){
							$$req = $asterisk;
							$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
							$_SESSION['errorcount']++;
							$$class = " class=\"red\"";
					} else {
						//include('./wolf/plugins/form_core/lib/posted.php');
						$$req = '';
					}

				} else {
					//include_once('./wolf/plugins/form_core/lib/submitcheck.php');
				}
				
				include('./wolf/plugins/form_core/lib/posted.php');

			}

			$sessionid = 'techreply';
			include_once('./wolf/plugins/form_core/lib/formCheck3.php');

		} else {
			/* Assume form was completed by spanner */
			$postmessage = $postmessage;
		}
	}




	if(!isset($your_name_class)){ $your_name_class = ''; }
	if(!isset($your_telephone_class)){ $your_telephone_class = ''; }
	if(!isset($your_email_class)){ $your_email_class = ''; }
	if(!isset($your_feedback_class)){ $your_feedback_class = ''; }

	if(!isset($your_name_req)){ $your_name_req = ''; }
	if(!isset($your_telephone_req)){ $your_telephone_req = ''; }
	if(!isset($your_email_req)){ $your_email_req = ''; }
	if(!isset($your_feedback_req)){ $your_feedback_req = ''; }



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
				
				<div class="group">

					<label for="thisyour_name"<?php echo $your_name_class;?> id="your_name"><span>Name<?php echo $your_name_req;?></span>
					<input id="thisyour_name" type="text" name="your_name" value="<?php echo $your_name;?>" size="30" autocompletetype="name" /></label>
	
					<label for="thisyour_email"<?php echo $your_email_class;?> id="your_email"><span>Email<?php echo $your_email_req;?></span>
					<input id="thisyour_email" type="email" name="your_email" value="<?php echo $your_email;?>" size="30" autocompletetype="email" /></label>
				
				</div>

			</fieldset>
			<fieldset>
			<<?php echo $grouptag; ?>>Your feedback</<?php echo $grouptag; ?>>

				<!--
				<label for="thisfeedback_type"<?php echo $feedback_type_class;?> id="feedback_type"><span>Feedback Type</span>
				<select id="thisfeedback_type" name="feedback_type">
				<?php
				$feedback_type_array = array(
				array ('Comment', 'Comment'),
				array ('Suggestion', 'Suggestion'),
				array ('Complaint', 'Complaint'),
				array ('Report Fault', 'Report Fault'));
				foreach($feedback_type_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $feedback_type){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</label>
				-->

				<div class="group">

					<label for="thisyour_feedback"<?php echo $your_feedback_class;?> id="your_feedback"><span>Message<?php echo $your_feedback_req;?></span>
					<textarea id="thisyour_feedback" name="your_feedback" cols="25" rows="5"><?php echo $your_feedback;?></textarea></label>
					<?php if(!isset($_POST["send"])){
						include('./wolf/plugins/form_core/lib/your_computer_info.php');
						$spec = str_replace('</b>',"</b>\n",$full);
						$spec = str_replace('</p>',"</p>\n\n",$spec);
						$spec .= "IP: \n".$_SERVER['REMOTE_ADDR']."\n\n";
						} else {
							$spec = $tech_support_details;
						}
					?>
				
				</div>

				<input name="tech_support_details" id="tech_support_details" type="hidden" value="<?php echo "\n\n".strip_tags($spec); ?>" />

				<?php if(!isset($_POST["send"])){ ?>

				<script type="text/javascript" src="<?php echo URL_PUBLIC;?>inc/js/flash.detect.js"></script>
				<script type="text/javascript" src="<?php echo URL_PUBLIC;?>inc/js/javascript.cookies.js"></script>
				<script type="text/javascript">
					//<![CDATA[
					var clientplugins = '';
					var num_of_plugins = navigator.plugins.length;
					for (var i=0; i < num_of_plugins; i++) {
						list_number=i+1;
						if (clientplugins.indexOf(navigator.plugins[i].name) == -1){
						   clientplugins += navigator.plugins[i].name + '\n';
						}
					};
					var viewportwidth; var viewportheight; if (typeof window.innerWidth != 'undefined') { viewportwidth = window.innerWidth, viewportheight = window.innerHeight } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) { viewportwidth = document.documentElement.clientWidth, viewportheight = document.documentElement.clientHeight } else { viewportwidth = document.getElementsByTagName('body')[0].clientWidth, viewportheight = document.getElementsByTagName('body')[0].clientHeight };
					var js_full = 'Screen Resolution:\n';width = (screen.width) ? screen.width:'';height = (screen.height) ? screen.height:'';if (typeof(screen.deviceXDPI) == 'number'){width *= screen.deviceXDPI/screen.logicalXDPI;height *= screen.deviceYDPI/screen.logicalYDPI;};js_full += width + ' x ' + height + ' pixels\n\n';js_full += 'Page Resolution:\n' + viewportwidth + ' x ' + viewportheight + ' pixels\n\n' + 'Color Depth:\n' + screen.colorDepth + '\n\nJavaScript:\nEnabled\n\n';js_full += 'Flash:\n';if(FlashDetect.installed){js_full += FlashDetect.major + '.' + FlashDetect.minor + '.' + FlashDetect.revision + '\n\n';}else{js_full += 'Unavailable\n\n';};Set_Cookie( 'test', 'none', '', '/', '', '' );js_full += 'Cookies:\n';if (Get_Cookie('test')){cookie_set = true;Delete_Cookie('test', '/', '');js_full += 'Enabled';} else {cookie_set = false;js_full += 'Disabled';};js_full += '\n\nPlugins:\n' + clientplugins;document.getElementById('tech_support_details').value += js_full;

					//]]>
				</script>
				<?php } ?>

			</fieldset>

			<?php include('./wolf/plugins/form_core/lib/formFooter.php'); ?>

			<?php } ?>

		<?php if($hideFormWrap != true){ ?>
		</form>
		<?php } ?>

<?php } else {
		include_once('./wolf/plugins/form_core/lib/disableForm.php');
	}
} ?>