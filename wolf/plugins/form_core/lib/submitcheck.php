<?php

if(!in_array($id,$postedArray)){
//if($id != "Send" && $id != "Submit" && $id != $buttontype && $id != "onLoad" && $id != "OnLoad"){
	if($v != null){
		$$class = "";
		$message .= $id.": $v\r\r";
		$postedmessage .= "\n<h4>".$id.'</h4><p>'.$v."</p>\n";
	}
//}
}

?>