<?php


Plugin::setInfos(array(
	'id'					=> 'form_friend',
	'title'					=> 'Form - Friend',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function friendForm($subject="",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "friend-form";

	/* Required fields */
	$required = array("Your Name","Your Email","Friends Name","Friends Email");


	/* Expected data */
	$your_name = htmlentities($_POST["your_name"]);
	$your_email = htmlentities($_POST["your_email"]);
	$friends_name = htmlentities($_POST["friends_name"]);
	$friends_email = htmlentities($_POST["friends_email"]);
	$mailinglist = htmlentities($_POST["mailinglist"]);
	$thankyouname = $friends_name;
	$thankyouemail = $friends_email;
	$thankyoureferrer = $your_name;
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
					if($v == null || ($id == "Your Email" && validEmail($your_email) == false) || ($id == "Friends Email" && validEmail($friends_email) == false)){

						/* Email check only */
						if($id == "Friends Email" || $id == "Your Email"){
							if($your_email == null || validEmail($your_email) == false || $friends_email == null || validEmail($friends_email) == false){
								$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
								$_SESSION['errorcount']++;
								$$class = " class=\"red\"";
							} else {
								$errors .= "";
								$$class = "";
								$$req = "";
							}
						} else {
							$$req = $asterisk;
							$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'" title="Skip to '.$id.' field">'.$id.'</a>, ';
							$_SESSION['errorcount']++;
							$$class = " class=\"red\"";
						}

					} else {
						//$message .= $id.": $v\r";
						$$req = "";
					}

				} else {
					if($id != "Send" && $id != "Submit" && $id != "onLoad" && $id != "OnLoad"){
						if($v != null){
							$$class = "";
							//$message .= $id.": $v\r";
						}
					}
				}
			}

				$sessionid = 'friendreply';
				//$formbody = $parentpage->content('formbody');
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

				<?php //$labels = array('name'); ?>
				<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>

				<label for="thisyour_name"<?php echo $your_name_class;?> id="your_name"><span>Your Name<?php echo $your_name_req;?></span>
				<input id="thisyour_name" type="text" name="your_name" value="<?php echo $your_name;?>" size="30" autocompletetype="name" /></label>

				<label for="thisyour_email"<?php echo $your_email_class;?> id="your_email"><span>Your Email<?php echo $your_email_req;?></span>
				<input id="thisyour_email" type="email" name="your_email" value="<?php echo $your_email;?>" size="30" autocompletetype="email" /></label>

			</fieldset>
			<fieldset>
			<<?php echo $grouptag; ?>>Your friend's details</<?php echo $grouptag; ?>>

				<label for="thisfriends_name"<?php echo $friends_name_class;?> id="friends_name"><span>Friend's Name<?php echo $friends_name_req;?></span>
				<input id="thisfriends_name" type="text" name="friends_name" value="<?php echo $friends_name;?>" size="30" /></label>

				<label for="thisfriends_email"<?php echo $friends_email_class;?> id="friends_email"><span>Friend's Email<?php echo $friends_email_req;?></span>
				<input id="thisfriends_email" type="email" name="friends_email" value="<?php echo $friends_email;?>" size="30" /></label>

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