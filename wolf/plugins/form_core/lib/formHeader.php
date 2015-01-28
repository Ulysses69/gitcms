<?php

if($heading != ''){
	$hid = ' id="reply"';
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
	if(isset($_GET["return"]) && htmlentities($_GET["return"]) == 'success'){
		//echo '<'.$h.' id="reply">Thank you</'.$h.'>'."\n";
		//if(!empty($_POST)){
			echo '<'.$h.$hid.'>Thank you</'.$h.'>'."\n";
		//}
	} else {
		//$newheading = str_replace('<'.$h,'<'.$h.$hid,$heading)."\n";
		if(isset($postcheck) && $postcheck == TRUE){
			if($_SESSION['errorcount'] != 0){
				if($_SESSION['errorcount'] == 1){
					$errors = 'Error in: ';
				} else {
					$errors = 'Errors in: ';
				}
				
				//$newheading = str_replace('</'.$h,' errors</'.$h,$heading)."\n";
				//$newheading = str_replace('<'.$h.'>','<'.$h.$hid.'>'.$errors,$heading)."\n";
				$newheading = '<'.$h.$hid.'>Form Errors</'.$h.">\n";
	
				/* Check all posts and determine class and req statuses */
				foreach($_POST as $name => $value) {
					$class = strtolower($name).'_class';
					$req = strtolower($name).'_req';
	
					if($formsize != false){
						if(stristr($$class,'class=')){
							$$class = str_replace('class="','class="tooltip',$$class);
						} else {
							$$class = ' class="tooltip"';
						}
					}
					
					if(!isset($$class)){ $$class = ''; }
					if(stristr($$class,'red')){ $$req = $asterisk; } else { $$req = ''; }
	
				}

			} else {

				$newheading = '';
				$errors = '';

			}

		} else {
			$newheading = str_replace('<'.$h,'<'.$h.$hid,$heading)."\n";
		}

		echo $newheading;

	}
}


if(!isset($postcheck)){ 
	$postcheck = '';
}
if(!isset($_GET["return"])){
	$get_return = ''; 
} else {
	$get_return = htmlentities($_GET["return"]);
}
if(stristr($_SERVER['REQUEST_URI'],'/success'.URL_SUFFIX)){
	//$get_return = 'success';
	//if(DEBUG == true){
	//	echo '<pre>';
	//	var_dump($_SESSION);
	//	echo '</pre>';
	//}
	//exit;
}


if($postcheck != TRUE && $get_return != 'success'){
	//echo $interlude;
	$formbody = $parentpage->content('formbody');
	//ob_start();$parentpage->includeSnippet('telephone');$clientphone = ob_get_clean();
	//ob_start();$parentpage->includeSnippet('email');$clientemail = ob_get_clean();
	//ob_start();$parentpage->includeSnippet('address');$clientaddress = ob_get_clean();
	$formbody = str_replace('[client]',$clientname,$formbody);
	$formbody = str_replace('[clientname]',$clientname,$formbody);
	$formbody = str_replace('[copyright]',ucfirst(displayCopyright('text')),$formbody);
	$formbody = str_replace('[telephone]',$clientphone,$formbody);
	$formbody = str_replace('[address]',$clientaddress,$formbody);
	$formbody = str_replace('[email]','<a href="mailto:'.$clientemail.'">'.$clientemail.'</a>',$formbody);
	/* Don't display formbody content if low-profile formsize is true */
	//if($formsize != true) echo $formbody.' - '.$parentpage->title();
	if($formsize != true) echo $formbody;
}

/* Check for success or error when page is returned */
if($get_return == 'success'){

	/* Don't display - temporary solution */
	if(!isset($formconfirmation) || (isset($formconfirmation) && $formconfirmation == false)){
		$displayform = false;
	}

	//if(empty($_POST)){

		// TO DO: Ensure google analytics are not measured for this non-submitted success page
		//$postmessage = '<p><a href="' . str_replace('/success', '', $_SERVER['REQUEST_URI']) . '">' . $parentpage->breadcrumb. '</a></p>';

	//} else {

		//$postmessage = $message_successful;
		$thankyou = $parentpage->content('thankyou');

		//ob_start();$parentpage->includeSnippet('telephone');$thankstelephone = ob_get_clean();
		//ob_start();$parentpage->includeSnippet('email');$thanksemail = ob_get_clean();
		//ob_start();$parentpage->includeSnippet('address');$thanksaddress = ob_get_clean();
		$thankstelephone = $clientphone;
		$thanksemail = $clientemail;
		$thanksaddress = $clientaddress;
	
		$thankyou = str_replace('[client]',$clientname,$thankyou);
		$thankyou = str_replace('[clientname]',$clientname,$thankyou);
		$thankyou = str_replace('[copyright]',ucfirst(displayCopyright('text')),$thankyou);
		$thankyou = str_replace('[telephone]',$thankstelephone,$thankyou);
		$thankyou = str_replace('[address]',$thanksaddress,$thankyou);
		$thankyou = str_replace('[email]','<a href="mailto:'.$thanksemail.'">'.$thanksemail.'</a>',$thankyou);
		if(isset($_SESSION['thankyouname'])){ $postmessage = str_replace('[thankyouname]',$_SESSION['thankyouname'],$thankyou); } else { $postmessage = $thankyou; }
		if(isset($_SESSION['thankyouemail'])){ $postmessage = str_replace('[thankyouemail]',$_SESSION['thankyouemail'],$postmessage); } else { $postmessage = $postmessage; }
	
	//}

} else {
	if(isset($postcheck) && $postcheck != TRUE){
		if(sizeof($required) > 0){
			$mandatory = "\r\t\t\t<p id=\"mandatory\">".$mandatorymessage."</p>";
		}
	}
}

if($get_return == 'success'){
	if(!isset($sentdata)){
		$sentdata = '';
	}
	if(isset($_SESSION[$sentdata])){
		$posteddata = $_SESSION[$sentdata];
		session_destroy();
	}
} else {
	$posteddata = '';
}

if(isset($postmessage)){
	$postmessage = str_replace('<p>[formdata]</p>','[formdata]',$postmessage);
	$postmessage = str_replace('<p>[download]</p>','[download]',$postmessage);
} else {
	$postmessage = '';
}


$download = '';
$downloadform = '';

/* Check if download.html page exists */
if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/downloads.php') || Plugin::isEnabled('tcpdf') == true){

	//$pdf_filename = 'pdf-data.pdf';
	$pdf_filename = $parentpage->slug.'.pdf';
	//$pdf_logo = '../images/bug.eps';
	$logo_path = '/inc/img/';

	/* Check if file exists */
	if(file_exists($_SERVER{'DOCUMENT_ROOT'}.$logo_path.'logo.eps')){
		$pdf_logo = $logo_path.'logo.eps';
	} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.$logo_path.'logo.png')){
		$pdf_logo = $logo_path.'logo.png';
	} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.$logo_path.'logo.gif')){
		$pdf_logo = $logo_path.'logo.gif';
	} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.$logo_path.'logo.jpg')){
		$pdf_logo = $logo_path.'logo.jpg';
	} else {
		/* Set logo to empty */
		$pdf_logo = '';
	}
	
	/* Force png header for now */
	$pdf_logo = $logo_path.'logo.png';
	
	if(!isset($posteddata)){
		$posteddata = '';
	}

	$downloadform = '<!-- TEST -->
	<form id="save" action="/download/'.$parentpage->slug.URL_SUFFIX.'" method="post">
		<input type="submit" name="save" value="Download" class="submit" />
		<input type="hidden" name="pdf_data" class="pdf_data" value="'.htmlentities($posteddata).'" />
		<input type="hidden" name="pdf_filename" value="'.$pdf_filename.'" class="pdf_filename" />
	</form>
	';


	$downloadform = trim( preg_replace( '/\s+/', ' ', $downloadform));
	$download = str_replace('[download]',$downloadform,$postmessage);


}

if($posteddata != ''){
	$postmessage = str_replace('[download]',$downloadform,$postmessage);
} else {
	$postmessage = str_replace('[download]','',$postmessage);
}

$postmessage = '<div id="reply">'.$postmessage.'</div>';

if(isset($postcheck)){
	if(isset($posteddata)){
		echo str_replace('[formdata]',$posteddata,$postmessage);
	} else {
		echo $postmessage;
	}
	if(isset($mandatory)){
		echo $mandatory;
	}
}


?>