<?php


Plugin::setInfos(array(
	'id'					=> 'form_voucher',
	'title'					=> 'Accessible Voucher Form',
	'version'				=> '5.1.0',
	'license'				=> 'GPLv3',
	'author'				=> 'Steven Henderson',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'  				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);

function voucherForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$formconfirmation=true,$buttontype="text"){
	?><div class="contact-form"><?php


	/* Required fields */
	$required = array("Name","Address","Phone Number","Email");

	/* Expected data */
	$submitted_date = htmlentities($_POST["submitted_date"]);
	$name = htmlentities($_POST["name"]);
	$address = htmlentities($_POST["address"]);
	$phone_number = htmlentities($_POST["phone_number"]);
	$email = htmlentities($_POST["email"]);
	$age = htmlentities($_POST["age"]);
	$interest = htmlentities($_POST["interest"]);
	$further_information = htmlentities($_POST["further_information"]);



	$adminemail = "steven@bluehorizonsmedia.co.uk";
	$asterisk = '<strong title="Required" class="required">*</strong> ';
	$displayform = true;
	$malicious = false;
	$errors = "";
	$message = "";
	$contactmethods = array();
	$badStrings = array(
	"content-type:",
	"mime-version:",
	"content-transfer-encoding:",
	"multipart/mixed",
	"charset=",
	"bcc:",
	"cc:",
	"href=",
	"http:",
	"script>",
	"url=",
	"link=");


	if(isset($_SESSION['logic'])) {
		/* Ensure timer is equal to required fields left (not just all required fields). */
		/* Also account for flash-posted date ... maybe initiate session timer when flash form loads? */
		if(time() - $_SESSION['logic'] < (3*(sizeof($required) - $_SESSION['errorcount'])) && isset($_POST["send"])){
			//echo "Restart timer " . (time() - $_SESSION['pagestarted']) . " seconds.";
			$malicious = true;
			$postmessage = "<p class=\"success\"><strong>Message cannot be processed.</strong> Please try again later.</p>";
		} else if (time() - $_SESSION['logic'] > (60*30) && isset($_POST["send"])){
			//echo "Timed out " . (time() - $_SESSION['pagestarted']) . " seconds.";
			$malicious = true;
			$postmessage = "<p class=\"success\"><strong>Message timed out.</strong> Please try re-sending your message.</p>";
		} else {
			//echo "End timer " . (time() - $_SESSION['pagestarted']) . " seconds.");
		}
		unset($_SESSION['logic']);
		//session_regenerate_id();
	} else {
		if(!isset($_SESSION['ipAddress']))
			$_SESSION['ipAddress'] = $_SERVER['REMOTE_ADDR'];
		
		if(!isset($_SESSION['userAgent']))
			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
	}
	$_SESSION['logic'] = time();
	$_SESSION['errorcount'] = 0;

	
	/* Ensure email is only sent to client email when website is live */
	if(stristr($_SERVER['HTTP_HOST'],"127.0.0.1") || stristr($_SERVER['HTTP_HOST'],"bluehorizons")){
		$emailOut = $adminemail;
		$nameOut = "Admin";
		$subject = "Admin Test Email: $subject";
	}


	for($n = 0; $n <= count($required); $n++){
		$k = strtolower(str_replace(' ','_',$required[$n]));
		$req = $k.'_req';
		$id = ucwords(str_replace('_',' ',$k));

		/* Check required fields */
		if(in_array($id, $required)){
			$$req = $asterisk;
		} else {
			if($k != null){
				$$req = "";
			}
		}
	}


	/* Ensure request is from a browser and has been posted */
	if((isset($_SERVER['HTTP_USER_AGENT']) && $_SESSION['userAgent'] == $_SERVER['HTTP_USER_AGENT']) && isset($_POST["send"])) {
		
	/* Windows DNS Checker */
		/*
		if(function_exists('checkdnsrr')){
			  	if(checkdnsrr($matches[1] . '.', 'MX')) return true;
			  	if(checkdnsrr($matches[1] . '.', 'A')) return true;
			  } else {
			  	function checkdnsrr($hostName, $recType = ''){
				if(!empty($hostName)){
							 	if($recType == '' ) $recType = "MX";
							 		exec("nslookup -type=$recType $hostName", $result);
						foreach ($result as $line)
						{
						if(eregi("^$hostName",$line)){
							return true;
						}
					}
					return false;
				}
				return false;
			}
		}
		*/

		/* Validate Email */
		function validEmail($email){
			$isValid = true;
			$atIndex = strrpos($email, "@");
			if (is_bool($atIndex) && !$atIndex){
				$isValid = false;
			} else {
				$domain = substr($email, $atIndex+1);
				$local = substr($email, 0, $atIndex);
				$localLen = strlen($local);
				$domainLen = strlen($domain);
				if ($localLen < 1 || $localLen > 64){
					$isValid = false; // Local part length exceeded
				} else if ($domainLen < 1 || $domainLen > 255){
					$isValid = false; // Domain part length exceeded
				} else if ($local[0] == '.' || $local[$localLen-1] == '.'){
					$isValid = false; // Local part starts or ends with '.'
				} else if (preg_match('/\\.\\./', $local)){
					$isValid = false; // Local part has two consecutive dots
				} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
					$isValid = false; // Character not valid in domain part
				} else if (preg_match('/\\.\\./', $domain)){
					$isValid = false; // Domain part has two consecutive dots
				} else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))){
					if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))){
						$isValid = false; // Character not valid in local part unless local part is quoted
					}
				}
				//if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))){
				//	$isValid = false; // Domain not found in DNS
				//}
			}
			return $isValid;
		}



		/* Check all posted values */
		foreach($_POST as $k => $v){
			foreach($badStrings as $v2){
				if(strpos(strtolower($v), $v2) !== false || strlen($v) > 1000){
					$postmessage = "<p class=\"success\"><strong>Form could not be sent.</strong> Content was deemed potentially-malicious.</p>";
					$malicious = true;
				}
			}
		}
		unset($k, $v, $v2, $badStrings);


		/* Prevent false phone numbers */
		if (ereg('[A-Za-z]', $_POST["tel"])){
			$malicious = true;
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

						/* Tel and email check only */
						if($id == "Phone Number" || $id == "Email"){
							if($phone_number == null && ($email == null || validEmail($email) == false)){
								$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'">'.$id.'</a>, ';
								$_SESSION['errorcount']++;
								$$class = " class=\"red\"";
							} else {
								$errors .= "";
								$$class = "";
								$$req = "";
								/* Tel failed */
								if($id == "Phone Number" && ($email == null || validEmail($email) == false)){
									$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#phone_number">Phone Number</a>, ';
									$_SESSION['errorcount']++;
									$$class = " class=\"red\"";
									$$req = $asterisk;
									$email_class = "";
								}
								/* Email failed */
								if($id == "Email" && $phone_number == null){
									$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#email">Email</a>, ';
									$_SESSION['errorcount']++;
									$$class = " class=\"red\"";
									$$req = $asterisk;
									$phone_number_class = "";
								}
							}
						} else {
							$$req = $asterisk;
							$errors .= '<a href="'.$_SERVER["REQUEST_URI"].'#'.$k.'">'.$id.'</a>, ';
							$_SESSION['errorcount']++;
							$$class = " class=\"red\"";
						}

					} else {
						$message .= $id.": $v\r\r";
						$$req = "";
					}

				} else {
					if($id != "Send" && $id != "Submit" && $id != "onLoad" && $id != "OnLoad" && $id != "OnData"){
						if($v != null){
							$$class = "";
							$message .= $id.': '.str_replace('_',' ',$v)."\r\r";
						}
					}
				}
			}

			/* Check for required fields */
			if($errors != "") {
				$postmessage = '<p class="warning"><strong>Please provide all required information: </strong>' . $errors . '</p>';
				$postmessage = str_replace(', </p>','</p>',$postmessage);
				//die();
			} else {
				$formsuccess = true;
				if($formconfirmation == false){
					$displayform = false;
				}

				/* 1. If email is not required (but tel or other contact method is provided) then use client email address */
				if($email == null || validEmail($email) == false){
					$email = $emailOut;
				}

				$headers = "From: \"".$name."\" <".$email.">\n";
				$headers .= "To: \"".$nameOut."\" <".$emailOut.">\n";
				$headers .= "Return-Path: <".$email.">\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-Type: text/plain; charset=iso-8859-1\n";
				
				
				function add_ending_slash($path){
				    $slash_type = (strpos($path, '\\')===0) ? 'win' : 'unix';
				    $last_char = substr($path, strlen($path)-1, 1);
				    if ($last_char != '/' and $last_char != '\\') {
				        $path .= ($slash_type == 'win') ? '\\' : '/';
				    }
				    return $path;
				}
				
				$myFile = dirname(__FILE__).add_ending_slash()."data.log";
				$fh = fopen($myFile, 'a') or die ("Can't open log file.");
				$lines = count(file($myFile));
				$issueid = '000'.($lines + 1);
				$stamp = time();
				$stringData = $name.', '.$email.', '.$stamp.', '.$issueid;
				if($lines > 0){$stringData = "\n".$stringData;}
				//$stringData = "\n".$stringData;
				fwrite($fh, $stringData);
				fclose($fh);


				$message .= "Voucher issue: ".$issueid." (".$_SERVER['HTTP_HOST']."/voucher/download.php?issue=".$stamp.")\n\n";
				$message .= "Submitted from: ".$_SERVER['HTTP_HOST'];

				mail($emailOut,$subject,$message,$headers);
				$postmessage = '<p class="success"><strong>Thank you</strong>. Download your <a href="/voucher/download.php?issue='.$stamp.'">free &pound;50 voucher</a> now.</p>';

				/* 2. Reset to blank for when displaying form */
				if($email == $emailOut){
					$email = "";
				}

			}
		} else {
			/* Assume form was completed by spanner */
			$postmessage = $postmessage;
		}
	}
	?>

		<form id="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>#form">
			<fieldset>
			<?php
			if($heading != ""){
				echo "<h3>$heading</h3>";
			}
			if($formsuccess != true){?>
					<p>Please complete and submit this form to receive your free &pound;50 voucher to put towards treatments at Stradbrook Skin.</p><?php }
			echo $postmessage;

			/* Display form on success (true/false) */
			if($displayform == true){

				if($formsuccess != true){?>
					<p class="requirednotice">Fields marked <?php echo $asterisk;?> are required</p>
				<?php } ?>




				<label for="name"<?php echo $name_class;?>><span><?php echo $name_req;?>Name</span>
				<input type="text" name="name" id="name" value="<?php echo $name;?>" size="30" /></label>

				<label for="address"<?php echo $address_class;?>><span><?php echo $address_req;?>Address</span>
				<textarea name="address" id="address" cols="25" rows="5"><?php echo $address;?></textarea></label>

				<label for='phone_number'<?php echo $phone_number_class;?>><span><?php echo $phone_number_req;?>Phone Number</span>
				<input type="text" name="phone_number" id="phone_number" value="<?php echo $phone_number;?>" size="30" /></label>

				<label for="email"<?php echo $email_class;?>><span><?php echo $email_req;?>Email</span>
				<input type="text" name="email" id="email" value="<?php echo $email;?>" size="30" /></label>
				
				

				<fieldset class="radio">
				<legend><span><?php echo $interest_req;?>Age</span></legend>
				<?php
				$medical_status = '';
				$interest_cosmetic_status = '';
				$interest_dental_status = '';
				$interest_all_status = '';

					if ($age == 'medical') {
						$medical_status = ' checked="checked"';
					}
					else if ($age == 'cosmetic') {
						$interest_cosmetic_status = ' checked="checked"';
					}
					else if ($age == 'dental') {
						$interest_dental_status = ' checked="checked"';
					}
					else if ($age == 'all') {
						$interest_all_status = ' checked="checked"';
					}

				?>
				<label for="medical"<?php echo $interest_class;?>><span>Under 25</span>
				<input type="radio" name="age" id="medical" value="medical" size="30"<?php echo $medical_status; ?> /></label>

				<label for="interest_cosmetic"<?php echo $interest_class;?>><span>26-35</span>
				<input type="radio" name="age" id="interest_cosmetic" value="cosmetic" size="30"<?php echo $interest_cosmetic_status; ?> /></label>

				<label for="interest_dental"<?php echo $interest_class;?>><span>36-45</span>
				<input type="radio" name="age" id="interest_dental" value="dental" size="30"<?php echo $interest_dental_status; ?> /></label>

				<label for="interest_all"<?php echo $interest_class;?>><span>46 and over</span>
				<input type="radio" name="age" id="interest_all" value="all" size="30"<?php echo $interest_all_status; ?> /></label>
				</fieldset>



				<fieldset class="radio">
				<legend><span><?php echo $interest_req;?>Area of interest</span></legend>
				<?php
				$medical_status = '';
				$interest_cosmetic_status = '';
				$interest_dental_status = '';
				$interest_all_status = '';

					if ($age == 'medical') {
						$medical_status = ' checked="checked"';
					}
					else if ($age == 'cosmetic') {
						$interest_cosmetic_status = ' checked="checked"';
					}
					else if ($age == 'dental') {
						$interest_dental_status = ' checked="checked"';
					}
					else if ($age == 'all') {
						$interest_all_status = ' checked="checked"';
					}

				?>
				<label for="medical"<?php echo $interest_class;?>><span>Medical</span>
				<input type="radio" name="interest" id="medical" value="medical" size="30"<?php echo $medical_status; ?> /></label>

				<label for="interest_cosmetic"<?php echo $interest_class;?>><span>Cosmetic</span>
				<input type="radio" name="interest" id="interest_cosmetic" value="cosmetic" size="30"<?php echo $interest_cosmetic_status; ?> /></label>

				<label for="interest_dental"<?php echo $interest_class;?>><span>Dental</span>
				<input type="radio" name="interest" id="interest_dental" value="dental" size="30"<?php echo $interest_dental_status; ?> /></label>

				<label for="interest_all"<?php echo $interest_class;?>><span>All</span>
				<input type="radio" name="interest" id="interest_all" value="all" size="30"<?php echo $interest_all_status; ?> /></label>
				</fieldset>

				

				
				<label id="further-information" for="further_information"<?php echo $further_information_class;?>><span><?php echo $further_information_req;?>Please tick this box if you would like to receive further information from Stradbrook Skin such as our latest news and details of special offers.</span>
				<input type="checkbox" name="further_information" id="further_information" value="yes" size="30" class="checkbox"<?php if($further_information == "yes"){echo " checked";}?>/></label>




				<div class="submitholder">
				<?php if($buttontype == "image"){
					$type = "image";
					$src = ' src="/includes/images/submit.gif"';
				} else {
					$type = "submit";
					$src = "";
				} ?>
				<input type="hidden" id="send" name="send" value="sent" />
				<input type="<?php echo $type; ?>"<?php echo $src; ?> id="submit" name="submit" value="Send" class="submit" />
				</div>
				
			<?php } ?>

			</fieldset>
		</form>
	</div>
<?php
}
?>