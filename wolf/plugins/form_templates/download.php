<?php

//header("HTTP/1.1 200 OK");
//echo 'hello';
//exit;

$root = $_SERVER['DOCUMENT_ROOT'];
$root = str_replace('/www', '', $root);
$root = str_replace('/public_html', '', $root);

// Use template as filename (template filename should be given with pdf extension - add it if not)
$download_filename = strip_tags($_GET['template']);
//$parse = parse_url($_SERVER['REQUEST_URI']);
$query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$vars = array();
parse_str($query, $variables);

if(array_key_exists('template', $variables)){
	$download_filename = preg_replace('/\?.*/', '', $variables['template']);
	$query = parse_url($variables['template'], PHP_URL_QUERY);
	$vars = array();
	parse_str($query, $variables);
}

$download_filename = str_replace(".pdf", '', $download_filename);
$download_filename = preg_replace("/[^A-Za-z0-9 ]/", '', $download_filename);

// Template source
$templatefile = "../../../private/templates/".$download_filename.".pdf";

//echo '<pre>';
//print_r($variables);
//echo '</pre>';
//exit;

if (file_exists($templatefile)){

	if(isset($variables['your_name'])){ $your_name = htmlentities($variables['your_name']); } else { $your_name = ''; }
	if(isset($variables['your_gdc_number'])){ $your_gdc_number = htmlentities($variables['your_gdc_number']); } else { $your_gdc_number = ''; }
	if(isset($variables['your_completion_date'])){ $your_completion_date = htmlentities($variables['your_completion_date']); } else { $your_completion_date = ''; }

	//echo $download_filename.' <br/> '.$your_name;
	//echo '<pre>';
	//print_r($variables);
	//echo '</pre>';
	//exit;

	//echo 'Start';
	//$insert_name = $_GET['issue'];
	//$vouchers = file("../frog/plugins/form_voucher/data.log");
	//$insert_name = "0001\n";
	
	// Template data
	//$name = "Tom Thumb";
	//$gdc_number = '292015';
	//$completion_date = '29 December 2015';
	//$download_filename = 'voucher';
	
	
	$pagemargin = 30;
	//$vouchers = file("data.log");
	//foreach($vouchers as $Key => $Val){
		//$voucher[$Key] = explode(", ", $Val);
		//echo $Val;
	//}
	//for($K = 0; $K < sizeof($vouchers); $K++){
		//echo ' voucherK3:' . $voucher[$K][3] . ' voucherid:'. $insert_name."\n";
		//if($voucher[$K][2] == $insert_name){
		//if($voucher[$K][3] != $insert_name){
	
			//$insert_name = $voucher[$K][3];

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
			$pdf->SetXY(0, 240);
			$pdf->Cell($w,0,$your_name,0,0,'C',0);
	
			/* Write GDC */
			$pdf->SetFont('Arial','I',12);
			//$pdf->SetDrawColor(255,255,255);
			//$pdf->SetFillColor(255,255,255);
			$pdf->SetTextColor(79,80,82);
			$pdf->SetLineWidth(1);
			//$pdf->SetXY(260, 220);
			//$pdf->Write(0, ucwords(strtolower('29 December 2015')));
			$pdf->SetXY($pagemargin, 290);
			$pdf->Cell(0,0,$your_gdc_number,0,0,'C',0);
	
			/* Write Date */
			$pdf->SetFont('Arial','I',11);
			//$pdf->SetDrawColor(255,255,255);
			//$pdf->SetFillColor(255,255,255);
			$pdf->SetTextColor(79,80,82);
			$pdf->SetLineWidth(1);
			//$pdf->SetXY(260, 220);
			//$pdf->Write(0, ucwords(strtolower('29 December 2015')));
			$pdf->SetXY(0, 470);
			$pdf->Cell(($w - (70)),0,$your_completion_date,0,0,'R',0);
	
	
			//header('Content-type: application/pdf');
			//header('Content-Disposition: attachment; filename="'.$download_filename.'.pdf'.'"');
			//header('Content-Transfer-Encoding', 'binary');
			//header('Cache-Control: maxage=3600');
			//header('Pragma: public');
			$pdf->Output($download_filename.'.pdf', 'D');
			//exit;
		//}
	//}
	//echo 'End';

}

?>