<?php

$rename_upload = true;
//echo 'Check 3';
//echo $temp_upload_filename;


/* Proceed with validation if non-malicious values are found */
//if($malicious != true && $FILES != null){
	
	/* Second upload check */
	for ($pi = 0; $pi < count($_FILES); $pi++) {
		$filename = $_FILES['upload']['name'][$pi];
		//$tmpfilename = $_FILES['upload']['filename'][$pi];
		if(isset($_FILES['upload']) && !stristr($postedmessage, $filename) && $filename != ''){
			if($rename_upload == true){
				// Should use temp filename
				$message .= "Upload file:\n ".$filename."\r\r";
				//$message .= "Upload file:\n ".$temp_upload_filename."\r\r";
			} else {
				$message .= "Upload file:\n ".$filename."\r\r";
			}
			$postedmessage .= "\n<h4>Upload file</h4><p>".$filename."</p>\n";
		}
	}
	/*
	if(isset($_FILES['upload']) && !stristr($postedmessage, $_FILES['upload']['name'][0])){
		$filename = $_FILES['upload']['name'][0];
		if($filename != ''){
			$message .= "Upload file:\n ".$filename."\r\r";
			$postedmessage .= "\n<h4>Upload file</h4><p>".$filename."</p>\n";
		}
	}
	*/

//}



// Filesize formatter
if(!function_exists('filesize_formatted')){
	function filesize_formatted($upload_size){
	    //$upload_size = filesize($upload_path);
	    $upload_units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	    $upload_power = $upload_size > 0 ? floor(log($upload_size, 1024)) : 0;
	    return number_format($upload_size / pow(1024, $upload_power), 2, '.', ',') . ' ' . $upload_units[$upload_power];
	}
}



/* Check if uploads were attempted and notify as error */
$upload_errors = '';
if(isset($form_attachments) && $form_attachments == true && $FILES != null){

	AutoLoader::addFile('file_upload', dirname(__FILE__) . '/upload/upload_class.php');
	AutoLoader::addFile('attach_mailer', dirname(__FILE__) . '/attach/attach_mailer_class.php');
	AutoLoader::load('file_upload');
	AutoLoader::load('attach_mailer');
	
	$upload_num_files = count($_FILES['upload']['name']);
	$upload_unsupported = false;
	$upload_too_large = '';
	$file_upload_submit_message = '';

	for ($upload_i = 0; $upload_i < $upload_num_files; $upload_i++) {
		//if ($_FILES['upload']['name'][$upload_i] != '') {
		if ($_FILES['upload']['name'][$upload_i] != '') {

			$upload_my_upload = new file_upload;
			$upload_my_upload->upload_dir = $upload_dir;
			//$upload_my_upload->upload_dir = $_SERVER['DOCUMENT_ROOT']."/public/uploads/";
			$upload_my_upload->extensions = $upload_allowed_extensions;
			$upload_my_upload->rename_file = $rename_upload;
			$upload_my_upload->the_temp_file = $_FILES['upload']['tmp_name'][$upload_i];
			//$upload_my_upload->the_temp_file = strtolower($_FILES['upload']['name'][$upload_i]).'_'.date('Ymd');
			$upload_my_upload->the_file = $_FILES['upload']['name'][$upload_i];
			$upload_my_upload->http_error = $_FILES['upload']['error'][$upload_i];
			$upload_my_upload->replace = "n";
			// new name is an additional filename information, use this to rename the uploaded file
			if ($upload_my_upload->upload()){
				//mysql_query(sprintf("INSERT INTO file_table SET file_name = '%s'", $upload_my_upload->file_copy));
				$temp_upload_filename = $upload_my_upload->file_copy;
			}
			$upload_ext = '.'.pathinfo($_FILES['upload']['name'][$upload_i], PATHINFO_EXTENSION);
			


			// Check extension
			if(!in_array(strtolower($upload_ext), $upload_allowed_extensions)){
				$errors .= '<!-- Uploaded file -->';
				$upload_errors .= '<li>Only '.implode(", ", $upload_allowed_extensions).' can be uploaded</li>';
				$file_upload_submit_message = 'File Upload Type '.ltrim(strtoupper($upload_ext),'.');
				$upload_unsupported = true;
			}

			// Check file size
			if($_FILES['upload']['size'][$upload_i] > $upload_allowed_file_size){
				$errors .= '<!-- Uploaded file -->';
				$upload_errors .= '<li>Uploads must be under '.filesize_formatted($upload_allowed_file_size).' Please re-upload</li>';
				$file_upload_submit_message = 'File Upload Size '.filesize_formatted($_FILES['upload']['size'][$upload_i]);
				$upload_unsupported = true;
			}

		}

	}

	/*
	for ($upload_i = 0; $upload_i < $upload_num_files; $upload_i++) {
		if ($_FILES['upload']['name'][$upload_i] != '') {
			$upload_errors .= '<li><a href="#uploader">Re-upload '.$_FILES['upload']['name'][$upload_i].'</a></li>';
		}
	}
	*/
	
}


/* Check for required fields */
if($errors != "") {

	//echo 'Errors Check 3';

	$errorsresult = '';
	if($_SESSION['errorcount'] > 0 || $upload_errors != ''){
		/* Valid data is still required */
		if($_SESSION['errorcount'] == 1 || $upload_errors != ''){
			$errorsresult = '<strong>Please correct the following error:</strong> ';
		} else {
			$errorsresult = '<strong>Please correct the following '.$_SESSION['errorcount'].' errors:</strong> ';
		}

		if(isset($_FILES['upload']) && $upload_unsupported != true){
			
			for ($checki = 0; $checki < $upload_num_files; $checki++) {
				//if ($_FILES['upload']['name'][$upload_i] != '') {
				if ($_FILES['upload']['name'][$checki] != '') {
					$upload_errors .= '<li>Please re-upload '.$_FILES['upload']['name'][$checki].'</li>';
					$file_upload_submit_message = '';
				}
			}


		}

	}

	$postmessage = '<p class="warning">'.$errorsresult.'</p><ul class="warning">' . str_replace(array('<a','a>'),array('<li><a','a></li>'),$errors) . $upload_errors. '</ul>';
	$postmessage = str_replace(', ',' ',$postmessage);

	/* Strip trailing comma */
	$errors = rtrim($errors,", ");

	/* Clean errors for google analytics */
	//$errorlabels = rtrim(strip_tags($errors),", ");
	$errorlabels = strip_tags($errors);

	/* Gather errors into array */
	$errorArray = explode(",",$errorlabels);

	/* Count error array length */
	$errorCount = sizeof($errorArray);

	/* Check if reply id has been assigned to a form element */
	if($heading == '' && !stristr($postmessage, ' id="reply"')){
		$postmessage = str_replace('<p class="warning">','<p class="warning" id="reply">',$postmessage);
	}

	/* Log Form Errors to Google Analytics, when document (page) has loaded */
	if($analytics == true){
		$postmessage .= "<script type='text/javascript'>";
		$postmessage .= "document.onreadystatechange = function(){";
		$postmessage .= "if(document.readyState == 'loaded' || document.readyState == 'complete'){";



		/*
		$postmessage .= "alert('".ucwords($parentpage->breadcrumb)." Form\\n\ ";
		for($i = 0; $i < $errorCount; $i++){
			if(DEBUG == true){
				$postmessage .= "Error: ".$errorArray[$i]."\\n\ ";
			} else {
				$postmessage .= "_gaq.push(['_trackEvent', 'Errors', '".ucwords($parentpage->breadcrumb)." Form', '".$errorArray[$i]."']);";
			}
		}
		$postmessage .= "');";
		*/



		if(function_exists('analyticsPush')){
			$pusherrors = '';
			for($i = 0; $i < $errorCount; $i++){
				if(DEBUG == true){
					//$errors .= "'Error: ".$errorArray[$i]."' + \"\\n\ \" + ";
					$pusherrors .= $errorArray[$i];
					if($i < ($errorCount - 1)){
						$pusherrors .= ', ';
					} else {
						if(isset($_FILES['upload'])){
							if($file_upload_submit_message != '' && $file_upload_submit_message != ' '){
								$pusherrors .= ', '.$file_upload_submit_message;
							}
						}
						// Fix empty file upload value
						$pusherrors = str_replace(",  ,", ", ", $pusherrors);
					}
				} else {
					$pusherrors = $errorArray[$i];
					//$postmessage .= analyticsPush(false, '_trackEvent', 'Errors', ucfirst($parentpage->breadcrumb).' Form', $errorArray[$i], '0', 'true')."\n";
					if($pusherrors != '' && $pusherrors != ' '){
						$postmessage .= analyticsPush(false, '_trackEvent', "'Errors'", "'".ucwords($parentpage->breadcrumb)." Form'", "'".$pusherrors."'", '0', 'true')."\n";
					}
					if($i == ($errorCount - 1)){
						if(isset($_FILES['upload'])){
							if($file_upload_submit_message != '' && $file_upload_submit_message != ' '){
								$postmessage .= analyticsPush(false, '_trackEvent', "'Errors'", "'".ucwords($parentpage->breadcrumb)." Form'", "'".$file_upload_submit_message."'", '0', 'true')."\n";
							}
						}
					}
				}
			}
			if(DEBUG == true){
				$postmessage .= analyticsPush(false, '_trackEvent', "'Errors'", "'".ucwords($parentpage->breadcrumb)." Form'", "'".$pusherrors."'", '0', 'true')."\n";
			}
		}



		$postmessage .= "}";
		$postmessage .= "}";
		$postmessage .= "</script>";
	}


} else {

	//echo 'No Errors Check 3';

	//if(isset($_SESSION[$sessionid]) && $_SESSION[$sessionid] != "success"){
	if(!isset($_SESSION[$sessionid]) || $_SESSION[$sessionid] != "success"){
		
		//echo 'Session ID Success';

		$_SESSION[$sessionid] = "success";
		$formsuccess = true;
		if(isset($formconfirmation) && $formconfirmation == false){
			$displayform = false;
		}

		/* 1. If email is not required (but telephone or other contact method is provided) then use client email address */
		if(!isset($formconfirmation)) $email = null;
		if($email == null || validEmail($email) == false){
			$email = $emailOut;
		}


		//$headers = "From: \"".$name."\" <".$email.">\n";


		/* Check Mailinglist */
		// Need to make clear that without explicit consent, marketing consent has not been given
		//if(defined('MAILINGLISTCHECKBOX')){
		if($showmailinglist != false){
			if(!stristr($postedmessage,'Mailinglist')){
				//$postedArray[] = 'Mailinglist';
				$postedmessage .= "\n<h4>Mailing List</h4><p>".$mailing_list_noconsent."</p>\n";
				$message .= "\nMailing List:\n".$mailing_list_noconsent."\n";
			}
			$postedmessage = str_replace('<h4>Mailinglist</h4><p>yes</p>', '<h4>Mailing List</h4><p>'.$mailing_list_consent.'</p>', $postedmessage);
			$message = str_replace("Mailinglist:\n yes", "Mailing List:\n ".$mailing_list_consent, $message);
		}


		if($postedmessage != ''){
			//$sessiondata = '<p>Please also take a moment to ensure the information that you provided is correct. ';
			//$sessiondata .= 'If there is a problem, <a href="/contact.html">contact us</a>.</p>';
			$sessiondata = '<div id="postedmessage">';
			//$sessiondata .= '<h3>Your submitted information</h3>';
			$sessiondata .= $postedmessage;
			$sessiondata .= '</div>';
			//ob_start();
			//$parentpage->includeSnippet('privacy');
			//$privacy = ob_get_contents();
			//ob_end_clean();
			//$sessiondata .= $privacy;

			// TO DO: Session data is undefined when forms are submitted, when caching is set on cached top-level parent
			if(!isset($sentdata)) $sentdata = '';
			if(!isset($sessiondata)) $sessiondata = '';
			$_SESSION[$sentdata] = $sessiondata;

		}

		// TO DO: Session data is undefined when forms are submitted, when caching is set on cached top-level parent
		if(isset($thankyouname)) $_SESSION['thankyouname'] = $thankyouname;
		if(isset($thankyouemail)) $_SESSION['thankyouemail'] = $thankyouemail;
		if(isset($thankyoureferrer)) $_SESSION['thankyoureferrer'] = $thankyoureferrer;

		//$message .= "\r\rWe will be in touch with your patient within three days.";
		//$message .= "Submitted from: ".$_SERVER['HTTP_HOST'];
		$message .= "\nSubmitted from: ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		// For Friends form
		$emailmessage = $parentpage->content('email');
		if($emailmessage != '') {

			$emailmessage = str_replace('[thankyouname]',$thankyouname,$emailmessage);
			$emailmessage = str_replace('[thankyouemail]',$thankyouemail,$emailmessage);
			$emailmessage = str_replace('[thankyoureferrer]',$thankyoureferrer,$emailmessage);
			$emailmessage = str_replace('[website]',$_SERVER['SERVER_NAME'],$emailmessage);
			$message = $emailmessage;

		}



		/* Upload Form */
		//if($form_attachments == true && isset($_POST['Submit'], $_FILES['upload'])){
			


		if(isset($form_attachments) && $form_attachments == true && isset($postcheck) && $FILES != null){

			echo 'Size: ' . $_FILES['upload']['size'];
			echo '<pre>'.print_r($_FILES).'</pre>';

				//$upload_errors .= '<li>Deliver to: '."website@".str_replace($unwanted,'',URL_ABSOLUTE).'</li>';
				//$upload_errors .= '<li>Email Out: '.$emailOut.'</li>';
				//$upload_errors .= '<li>Subject: '.$subject.'</li>';
				//$upload_errors .= '<li>Body: '.$message.'</li>';
				

				//$subject = 'Test';
				//$upload_my_mail = new attach_mailer('Steven', $emailFrom, $emailOut, '', '', $subject);
				//$upload_my_mail->text_body = $message;

				# Attachments class doesn't like local domains
				//$emailFrom = 'bluemoth@hotmail.com';
				//$emailFrom = 'website@'.str_replace($unwanted,'',URL_ABSOLUTE);
				//$emailFrom = 'website@bluehorizonsmedia.co.uk';
				$emailFrom = $formsEmail;

				$upload_my_mail = new attach_mailer($clientname, $emailFrom, $emailOut, '', '', $subject);
				//$upload_my_mail = new attach_mailer('Steven', 'bluemoth@hotmail.com', 'steven@bluehorizonsmedia.co.uk', '', '', 'Mutilple Attachment Mailer.');
				//$upload_my_mail->text_body = 'Attachment Test';
				$upload_my_mail->text_body = $message;

				$attachments = '';
				
				for ($upload_i = 0; $upload_i < $upload_num_files; $upload_i++) {
					//if ($_FILES['upload']['name'][$upload_i] != '') {
					if($_FILES['upload']['name'][$upload_i] != '') {

						if($upload_errors == '') {
							if($upload_my_upload->upload()){
								$upload_full_path = $upload_my_upload->upload_dir.$upload_my_upload->file_copy;
								$upload_my_mail->add_attach_file($upload_full_path);
							} else {
								$upload_errors .= '<li>Upload failed</li>';
							}
						} else {
							//break;
							$upload_errors .= '<li>Error uploading file(s)</li>';
						}
						
						$attachments .= $_FILES['upload']['name'][$upload_i].' ';

					}

				}
				
				if($attachments == ''){
					$attachments = 'No attachments';
				}

				if($upload_errors == ''){
					// Process Email via Upload scripts
					if($upload_my_mail->process_mail()){
						$upload_errors .= 'Mail sent. ';
					} else {
						$upload_errors .= 'Error sending mail. ';
					}
				}

				//echo 'To: '.$emailOut."<br>";
				//echo 'From: '.$emailFrom."<br>";
				//echo 'Subject: '.$subject."<br>";
				//echo 'Attachments: '.$attachments."<br>";
				//echo 'Message: '.$message."<br>";
				//echo 'Errors: '.$upload_errors;
				//exit;

		} else {



	
			/* Standard Form */
			//echo 'Standard Form: '.$emailOut;
			//exit;
			/* TO DO: Check hosting environment to determine sender domain */

			$head_from = "website@".str_replace($unwanted,'',URL_ABSOLUTE);
			if(!isset($name)) $name = '';
			//if(AMIN_THEME == 'poppy_media') $head_from = "website@poppymedia.co.uk";
			if($formid == "friend-form"){
				$headers = "Return-Path: ".$head_from."\r\n";
				$headers .= "Reply-To: \"".$name."\" <".$email.">\r\n";
				$headers .= "From: \"".$your_name."\" <".$your_email.">\r\n";
				$headers .= "To: \"".$friends_name."\" <".$friends_email.">\r\n";
				//$headers .= "To: \"".$nameOut."\" <".$emailOut.">, Steven <steven@bluehorizonsmedia.co.uk>\r\n";
			} else {
				//$emailOut = 'steven@bluehorizonsmedia.co.uk';
				$headers = "Return-Path: ".$head_from."\r\n";
				$headers .= "Reply-To: \"".$name."\" <".$email.">\r\n";
				$headers .= "From: ".$email."\r\n";
				$headers .= "To: \"".$nameOut."\" <".$emailOut.">\r\n";
				if(isset($emailCC) && $emailCC != ''){$headers .= "Cc: ".$emailCC."\r\n";}
				//$headers .= "To: \"".$nameOut."\" <".$emailOut.">, Steven <steven@bluehorizonsmedia.co.uk>\r\n";
				//$headers .= "CC: steven@bluehorizonsmedia.co.uk\r\n";
			}
	
			//$headers .= "BCC: steven@bluehorizonsmedia.co.uk\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";

	
			mail($emailOut,$subject,$message,$headers,'-f '.$head_from);


			/* NOT WORKING. TO BE USED WITH ATTACH MAILER as per http://www.phpmagicbook.com/upload-file-attach-send-html-format-email/
			$ok = mail($emailOut,$subject,$message,$headers,'-f '.$head_from);
			if($ok){
				echo "File Sent Successfully.";
				// Delete a file after attachment sent
				unlink($attachment);
			} else {
				die("Sorry but the email could not be sent. Please go back and try again!");
			}
			*/


		}










		/* 2. Reset to blank for when displaying form */
		if($email == $emailOut){
			$email = "";
		}

		if($successredirect != false){
			//header("HTTP/1.0 307 Temporary redirect");
			if($parentpage->content('thankyou') != ''){
				$upload = '';
				if(isset($_FILES['upload'])){
					$upload = '?upload=true';
				}
				//$postmessage = "<p>Thank you.</p><p>Your message has been emailed to us and will be responded to within 24 business hours.</p>";
				$FORCESLASHEDURI = $_SERVER['REQUEST_URI']."/"; $FORCESLASHEDURI = str_replace(URL_SUFFIX,'/',$FORCESLASHEDURI); $CLEANURI = str_replace("//","/",$FORCESLASHEDURI);
				//header("Location: ".str_replace(URL_SUFFIX,'/',$_SERVER['REQUEST_URI'])."success".URL_SUFFIX.$upload."$formanchor");
				header("Location: ".$CLEANURI."success".URL_SUFFIX.$upload."$formanchor");
			} else {
				$postmessage = '<p class="success">Thank you.</p>';
			}
		} else {
			$postmessage = '<p class="success">Thank you.</p>';
		}

	} else {
		
		//echo 'Session ID NO Success';

		$_SESSION[$sessionid] = "sent";

	}

}

?>