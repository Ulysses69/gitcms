<?php
//$vouchers = file(dirname(__FILE__).add_ending_slash(dirname(__FILE__))."data.log");
$vouchers = file("data.log");
//echo $vouchers;
foreach($vouchers as $Key => $Val){
$voucher[$Key] = explode(", ", $Val);}
for($K = 0; $K < sizeof($vouchers); $K++){
$insert_name = $voucher[$K][2];}
$message .= "/voucher/download.php?issue=".$insert_name.")\n\n";
$message .= "Submitted from: ".$_SERVER['HTTP_HOST'];
echo "issueid=".$insert_name;
?>