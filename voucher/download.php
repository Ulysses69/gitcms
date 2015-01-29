<?php
//echo 'Start';
//$voucherid = $_GET['issue'];
//$vouchers = file("../frog/plugins/form_voucher/data.log");
$voucherid = "0001\n";
$vouchers = file("data.log");
foreach($vouchers as $Key => $Val){
	$voucher[$Key] = explode(", ", $Val);
	//echo $Val;
}
for($K = 0; $K < sizeof($vouchers); $K++){
	//echo ' voucherK3:' . $voucher[$K][3] . ' voucherid:'. $voucherid."\n";
	//if($voucher[$K][2] == $voucherid){
	if($voucher[$K][3] == $voucherid){
		$thisvoucherid = $voucher[$K][3];
		require_once(dirname(__FILE__)."/lib/fpdf/fpdf.php");
		require_once(dirname(__FILE__)."/lib/fpdi/fpdi.php");
		$filename = "voucher-tpl.pdf";
		$pdf = new FPDI('L','pt','voucher');
		$pdf->AddPage();
		$pdf->setSourceFile($filename);
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx);

		/* Write ID */
		$pdf->SetFont('Arial','I',15);
		$pdf->SetDrawColor(255,255,255);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(84,46,100);
		$pdf->SetLineWidth(1);
		$pdf->SetXY(280, 208);
		$pdf->Write(0, ucwords(strtolower($thisvoucherid)));

		/* Write Date */
		$pdf->SetFont('Arial','I',8);
		$pdf->SetDrawColor(255,255,255);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(84,46,100);
		$pdf->SetLineWidth(1);
		$pdf->SetXY(260, 220);
		$pdf->Write(0, ucwords(strtolower('29 December 2015')));

		header("Content-Transfer-Encoding", "binary");
		header('Cache-Control: maxage=3600');
		header('Pragma: public');
		$pdf->Output('voucher.pdf', 'D');
	}
}
//echo 'End';
?>