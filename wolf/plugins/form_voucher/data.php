<?php
//$vouchers = file(dirname(__FILE__).add_ending_slash(dirname(__FILE__))."data.log");
$vouchers = file("data.log");
//echo $vouchers;
foreach($vouchers as $Key => $Val){
$voucher[$Key] = explode(", ", $Val);}
for($K = 0; $K < sizeof($vouchers); $K++){
$thisvoucherid = $voucher[$K][2];}
$message .= "/voucher/download.php?issue=".$thisvoucherid.")\n\n";
$message .= "Submitted from: ".$_SERVER['HTTP_HOST'];
echo "issueid=".$thisvoucherid;
?>