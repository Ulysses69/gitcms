<?php


Plugin::setInfos(array(
	'id'					=> 'form_company_contact',
	'title'					=> 'Form - Company Contact',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'			=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'	=> '0.9.3')
);
Behavior::add('Form', '');
function companyContactForm($emailOut,$nameOut,$subject="Enquiry",$heading="",$displayform=true,$buttontype="text",$parentpage,$formtarget='',$formsize=false,$grouptag="legend",$showmailinglist=true){
	if(Plugin::isEnabled('form_core') == true){
		$formid = "contact-form";

		/* Required fields */
		$required = array("Name","Telephone","Email");

		/* Expected data */
		$name = htmlentities($_POST["name"]);
		$address = htmlentities($_POST["address"]);
		$postcode = htmlentities($_POST["postcode"]);
		$telephone = htmlentities($_POST["telephone"]);
		$email = htmlentities($_POST["email"]);
		$product_of_interest = htmlentities($_POST["product_of_interest"]);
		if($product_of_interest == '' && stristr($_SERVER['HTTP_REFERER'],'/products/')){
			//$product_of_interest = substr(strrchr($_SERVER['HTTP_REFERER'],'/'), 1);
			$product_of_interest = $_SERVER['HTTP_REFERER'];
			$product_of_interest = str_replace('.html','',$product_of_interest);
			$product_of_interest = str_replace(URL_ABSOLUTE,'/',$product_of_interest);
			//$product_of_interest = str_replace('-',' ',$product_of_interest);
			//$product_of_interest = ucfirst($product_of_interest);
			$product_brochure = Page::find($product_of_interest)->content('documents');
			$product_of_interest = Page::find($product_of_interest)->title;
		} else {
			$product_of_interest = htmlentities($_POST["product_of_interest"]);
		}
		$enquiry = htmlentities($_POST["enquiry"]);
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
						if($v == null || ($id == "Email" && validEmail($_email) == false)){
	
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

				$sessionid = 'contactreply';
				include_once('./wolf/plugins/form_core/lib/formCheck3.php');

			} else {
				/* Assume form was completed by spanner */
				$postmessage = $postmessage;
			}
		}

		?>




		<?php

		/* Checking for available download */
		$productLinks = explode("</li>", $product_brochure);
		for($i = 0; $i < count($productLinks); $i++){
			if(stristr($productLinks[$i], 'Brochure')) {
				$brochureDownload = strip_tags($productLinks[$i],'<a>'); ?>
				<?php
			}
		}

		?>



		<?php if($hideFormWrap != true){ ?>
		<?php if(!isset($formclass)){ $formclass = ''; } ?>
		<form id="<?php echo $formid; ?>" class="form<?php echo $formclass ?>" method="post" action="<?php echo $formtarget; ?>">
		<?php } ?>

			<?php //include_once('./wolf/plugins/form_core/lib/formHeader.php');
			if($heading != ''){
				if(stristr($heading,'h1')){
					$h = 'h1';
				}
				if(stristr($heading,'h2')){
					$h = 'h2';
				}
				if(stristr($heading,'h3')){
					$h = 'h3';
				}
				if(stristr($heading,'h4')){
					$h = 'h4';
				}
				if(htmlentities($_GET["return"]) == 'success'){
					echo '<'.$h.' id="reply">Thank you</'.$h.'>'."\n";
				} else {
					$newheading = str_replace('<'.$h,'<'.$h.' id="reply"',$heading)."\n";
					if($postcheck == TRUE){
						$newheading = str_replace('</'.$h,' errors</'.$h,$newheading)."\n";
					}
					echo $newheading;
				}
			}
			if($postcheck != TRUE && htmlentities($_GET["return"]) != 'success'){
				//echo $interlude;
				if($product_of_interest != '' && stristr($_SERVER['HTTP_REFERER'],'/products/')){
					$formbody = $parentpage->content('formbody');
					$formbody = str_replace('[product brochure]',$brochureDownload,$formbody);
					$formbody = str_replace('Brochure',$product_of_interest.' brochure',$formbody);
				}
				if(Plugin::isEnabled('clientdetails') == true){
					$formtelephone = Plugin::getSetting('clientphone', 'clientdetails');
				} else {
					ob_start();$parentpage->includeSnippet('telephone');$formtelephone = ob_get_clean();
				}
				if(Plugin::isEnabled('clientdetails') == true){
					$formemail = Plugin::getSetting('clientemail', 'clientdetails');
				} else {
					ob_start();$parentpage->includeSnippet('email');$formemail = ob_get_clean();
				}
				if(Plugin::isEnabled('clientdetails') == true){
					$formaddress = Plugin::getSetting('clientaddress', 'clientdetails');
				} else {
					ob_start();$parentpage->includeSnippet('address');$formaddress = ob_get_clean();
				}
				$formbody = str_replace('[client]',clientname(),$formbody);
				$formbody = str_replace('[clientname]',clientname(),$formbody);
				$formbody = str_replace('[copyright]',ucfirst(displayCopyright('text')),$formbody);
				$formbody = str_replace('[telephone]',$formtelephone,$formbody);
				$formbody = str_replace('[address]',$formaddress,$formbody);
				$formbody = str_replace('[email]','<a href="mailto:'.$formemail.'">'.$formemail.'</a>',$formbody);
				echo $formbody;
			}
			/* Check for success or error when page is returned */
			if(htmlentities($_GET["return"]) == 'success'){
				/* Don't display - temporary solution */
				if($formconfirmation == false){ $displayform = false; }
				//$postmessage = $message_successful;
				$thankyou = $parentpage->content('thankyou');
				if(Plugin::isEnabled('clientdetails') == true){
					$formtelephone = Plugin::getSetting('clientphone', 'clientdetails');
				} else {
					ob_start();$parentpage->includeSnippet('telephone');$thankstelephone = ob_get_clean();
				}
				if(Plugin::isEnabled('clientdetails') == true){
					$formemail = Plugin::getSetting('clientemail', 'clientdetails');
				} else {
					ob_start();$parentpage->includeSnippet('email');$thanksemail = ob_get_clean();
				}
				if(Plugin::isEnabled('clientdetails') == true){
					$formaddress = Plugin::getSetting('clientaddress', 'clientdetails');
				} else {
					ob_start();$parentpage->includeSnippet('address');$thanksaddress = ob_get_clean();
				}
				$thankyou = str_replace('[client]',clientname(),$thankyou);
				$thankyou = str_replace('[clientname]',clientname(),$thankyou);
				$thankyou = str_replace('[copyright]',ucfirst(displayCopyright('text')),$thankyou);
				$thankyou = str_replace('[telephone]',$thankstelephone,$thankyou);
				$thankyou = str_replace('[address]',$thanksaddress,$thankyou);
				$thankyou = str_replace('[email]','<a href="mailto:'.$thanksemail.'">'.$thanksemail.'</a>',$thankyou);
				$postmessage = str_replace('[thankyouname]',$_SESSION['thankyouname'],$thankyou);
				$postmessage = str_replace('[thankyouemail]',$_SESSION['thankyouemail'],$postmessage);
			} else {
				if($postcheck != TRUE){
					$mandatory = "\r\t\t\t<p id=\"mandatory\"></p>";
				}
			}
			echo $postmessage;
			echo $mandatory;
			if(htmlentities($_GET["return"]) == 'success'){
				echo $_SESSION[$sentdata];
				session_destroy();
			}
			?>

			<?php /* Display form on success (true/false) */
			if($displayform != false){ ?>

		 	<fieldset id="yourdetails">
			<<?php echo $grouptag; ?>>Your contact details</<?php echo $grouptag; ?>>

				<?php //$labels = array('name'); ?>
				<?php //include('./wolf/plugins/form_core/lib/labels.php'); ?>

				<label for="thisname" id="name"<?php echo $name_class;?>><span>Name<?php echo $name_req;?></span>
				<input id="thisname" type="text" name="name" value="<?php echo $name;?>" size="30" autocompletetype="name" /></label>

				<label for="thisaddress" id="address"<?php echo $address_class;?>><span>Address<?php echo $address_req;?></span>
				<textarea id="thisaddress" type="text" name="address" size="30" /><?php echo $address;?></textarea></label>

				<label for="thispostcode" id="postcode"<?php echo $postcode_class;?>><span>Postcode<?php echo $postcode_req;?></span>
				<input id="thispostcode" type="text" name="postcode" value="<?php echo $postcode;?>" size="30" autocompletetype="postal-code" /></label>

				<label for="thistelephone" id="telephone"<?php echo $telephone_class;?>><span>Telephone<?php echo $telephone_req;?></span>
				<input id="thistelephone" type="tel" name="telephone" value="<?php echo $telephone;?>" size="30" autocompletetype="tel-national" /></label>

				<label for="thisemail" id="email"<?php echo $email_class;?>><span>Email<?php echo $email_req;?></span>
				<input id="thisemail" type="email" name="email" value="<?php echo $email;?>" size="30" autocompletetype="email" /></label>

			</fieldset>
			<fieldset id="yourfeedback">
			<<?php echo $grouptag; ?>>How can we help</<?php echo $grouptag; ?>>

				<label for="thisproduct_of_interest" id="product_of_interest"<?php echo $product_of_interest_class;?>><span>Product(s) of interest<?php echo $product_of_interest_req;?></span>
				<input id="thisproduct_of_interest" type="text" name="product_of_interest" value="<?php echo $product_of_interest;?>" size="30" /></label>

				<label for="thisenquiry" id="enquiry"<?php echo $enquiry_class;?>><span>Message<?php echo $enquiry_req;?></span>
				<textarea id="thisenquiry" name="enquiry" cols="25" rows="5"><?php echo $enquiry;?></textarea></label>
				
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