<?php


Plugin::setInfos(array(
	'id'					=> 'form_request',
	'title'					=> 'Form - Request',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function requestForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
	$formid = "request-form";

	/* Required fields */
	$required = array("Name","Telephone","Email");


	/* Expected data */
	$name = htmlentities($_POST["name"]);
	$address = htmlentities($_POST["address"]);
	$telephone = htmlentities($_POST["telephone"]);
	$email = htmlentities($_POST["email"]);
	$post_method = htmlentities($_POST["post_method"]);
	$mailinglist = htmlentities($_POST["mailinglist"]);
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
			
			/* Post check only */
			if($address == null && $post_method == "Post"){
				$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#address">Address</a>, ';
				$address_class = " class=\"red\"";
				$address_req = $asterisk;
			}

			$sessionid = 'requestreply';
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

				<label for="thisname"<?php echo $name_class;?> id="name"><span>Name<?php echo $name_req;?></span>
				<input id="thisname" type="text" name="name" value="<?php echo $name;?>" size="30" autocompletetype="name" /></label>

				<label for="thistelephone"<?php echo $telephone_class;?> id="telephone"><span>Telephone<?php echo $telephone_req;?></span>
				<input id="thistelephone" type="tel" name="telephone" value="<?php echo $telephone;?>" size="30" autocompletetype="tel-national" /></label>

				<label for="thisemail"<?php echo $email_class;?> id="email"><span>Email<?php echo $email_req;?></span>
				<input id="thisemail" type="email" name="email" value="<?php echo $email;?>" size="30" autocompletetype="email" /></label>

				<label for="thisaddress"<?php echo $address_class;?> id="address"><span>Address<?php echo $address_req;?></span>
				<textarea id="thisaddress" name="address" cols="25" rows="5"><?php echo $address;?></textarea></label>

			</fieldset>
			<fieldset>
			<<?php echo $grouptag; ?>>You brochure preference</<?php echo $grouptag; ?>>

				<label for="thispost_method"<?php echo $post_method_class;?> id="post_method"><span>Delivery method</span>
				<select id="thispost_method" name="post_method">
				<?php
				$post_method_array = array(
				array ('Email', 'Email'),
				array ('Post', 'Post'));
				foreach($post_method_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $post_method){
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
} ?>