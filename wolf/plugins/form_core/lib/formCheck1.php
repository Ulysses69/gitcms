<?php

/* Check uploads comply with server upload settings - this is checked first before further upload checks can be carried out */
if(isset($_SERVER['CONTENT_LENGTH']) && intval($_SERVER['CONTENT_LENGTH'])>0 && count($_POST)===0){
	$errors = 'Uploads must be under '.filesize_formatted($upload_allowed_file_size);
	echo '<div id="reply"><p class="warning"><strong>Uploads must be under '.filesize_formatted($upload_allowed_file_size).'</strong></p><p class="warning">Please fill out the form again.</p></div>';
}

/* First upload check */
$FILES = null;
for ($ui = 0; $ui < count($_FILES); $ui++) {
	if($_FILES['upload']['name'][$ui] != '') {
		$FILES = $_FILES['upload']['name'][$ui];
	}
}

/* Ensure email is only sent to client email when website is live */
if(
(!strstr($_SERVER['HTTP_HOST'],"www.") && stristr($_SERVER['HTTP_HOST'],"bluehorizons"))
|| stristr($_SERVER['HTTP_HOST'],".local")
|| stristr($_SERVER['HTTP_HOST'],"bluehorizons")
|| $emailOut == 'info@clientwebsite.com'
|| stristr($nameOut,'Blue Horizons Client')){
	$emailOut = $adminemail;
	$nameOut = "Admin";
	$subject = "Admin Test Email: $subject";
}


for($n = 0; $n < count($required); $n++){
	$k = strtolower(str_replace(' ','_',$required[$n]));
	$req = $k.'_req';
	$id = ucwords(str_replace('_',' ',$k));
	//$id = str_replace('Your ','',$id);

	/* Check required fields */
	if(in_array($id, $required)){
		$$req = $asterisk;
	} else {
		if($k != null){
			$$req = "";
		}
	}
}

$hideFormWrap = false;
if(isset($_GET["return"]) && htmlentities($_GET["return"]) == 'success'){
	$hideFormWrap = true;
}

?>