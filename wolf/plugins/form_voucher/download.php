<?php

//echo 'Start';
//$insert_name = $_GET['issue'];
//$vouchers = file("../frog/plugins/form_voucher/data.log");
//$insert_name = "0001\n";

$insert_name = "Tom Thumb\n";
$insert_date = '29 December 2015';
$insert_gdc = '292015';

$templatefile = "../../../voucher/A4certificate.pdf";
$vouchers = file("data.log");
$pagemargin = 30;
foreach($vouchers as $Key => $Val){
	$voucher[$Key] = explode(", ", $Val);
	//echo $Val;
}
for($K = 0; $K < sizeof($vouchers); $K++){
	//echo ' voucherK3:' . $voucher[$K][3] . ' voucherid:'. $insert_name."\n";
	//if($voucher[$K][2] == $insert_name){
	if($voucher[$K][3] != $insert_name){

		$insert_name = $voucher[$K][3];
		
		require_once(dirname(__FILE__)."/lib/fpdf/fpdf.php");
		require_once(dirname(__FILE__)."/lib/fpdi/fpdi.php");
		//$templatefile = "voucher-tpl.pdf";
		//$pdf = new FPDI('L','pt','voucher');
		$pdf = new FPDI('L','pt','A4');
		$pdf->AddPage();
		$pdf->setSourceFile($templatefile);
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx);
		$page_dimensions = $pdf->getTemplateSize($tplIdx);
		$w = $page_dimensions['w'];
		$h = $page_dimensions['h'];

		/* Write Name  */
		$pdf->SetFont('Arial','I',28);
		//$pdf->SetDrawColor(255,255,255);
		//$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(79,80,82);
		$pdf->SetLineWidth(1);
		//$pdf->SetXY(280, 208);
		//$pdf->Write(0, ucwords(strtolower($insert_name)));
		$pdf->SetXY($pagemargin, 240);
		$pdf->Cell(0,0,$insert_name,0,0,'C',0);

		/* Write GDC */
		$pdf->SetFont('Arial','I',12);
		//$pdf->SetDrawColor(255,255,255);
		//$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(79,80,82);
		$pdf->SetLineWidth(1);
		//$pdf->SetXY(260, 220);
		//$pdf->Write(0, ucwords(strtolower('29 December 2015')));
		$pdf->SetXY($pagemargin, 290);
		$pdf->Cell(0,0,$insert_gdc,0,0,'C',0);

		/* Write Date */
		$pdf->SetFont('Arial','I',11);
		//$pdf->SetDrawColor(255,255,255);
		//$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(79,80,82);
		$pdf->SetLineWidth(1);
		//$pdf->SetXY(260, 220);
		//$pdf->Write(0, ucwords(strtolower('29 December 2015')));
		$pdf->SetXY(0, 470);
		$pdf->Cell(($w - (70)),0,$insert_date,0,0,'R',0);


		header("Content-Transfer-Encoding", "binary");
		header('Cache-Control: maxage=3600');
		header('Pragma: public');
		$pdf->Output('voucher.pdf', 'D');
	}
}
//echo 'End';


?>