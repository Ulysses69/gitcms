<?php

//$postedmessage .= "Posted: ".$id.'<br/>';

#Check against posted array
if(!in_array($id,$postedArray)){

	//$postedmessage .= "Posted Loop: ".$id.'<br/>';

	//if($v != '' && $id != 'Send' && $id != 'Submit' && $id != 'send' && $id != 'submit' &&  $id != 'Submit X' &&  $id != 'Submit Y') {
	if($v != '' && !in_array($id,$exclude_from_email)) {
		$message .= str_replace('Your ','',$id).":\n $v\r\r";
		$postedmessage .= "\n<h4>".str_replace('Your ','',$id).'</h4><p>'.$v."</p>\n";
	}

	if(isset($$class)){
		if($$class == ''){
			$$req = "";
		}
		if($$class == ''){
			$$class = "";
		}
	}

	#Populate posted array
	$postedArray[] = $id;

}

?>