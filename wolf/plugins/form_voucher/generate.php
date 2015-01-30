<?php

//====================================================================
// Include required libs
//
// FPDF and FPDI needs to be included for this script to work
//====================================================================

// lib to write to PDF
require_once(dirname(__FILE__)."/lib/fpdf/fpdf.php");

// lib to import existing PDF documents into FPDF
require_once(dirname(__FILE__)."/lib/fpdi/fpdi.php");


//====================================================================
// Set up parameters
//
// We need to set the filename for the template which we want to use
// as the template for our generated PDF.
//
// In addition we supply the information which we want to write to the
// document. This data would usually be sent as GET / POST or be stored
// in session from the order confirmation page.
//====================================================================

// the template PDF file
$filename = "voucher_tpl.pdf";

// info we want to place in the template
$vouchernumber = "NUMBER 00001";



//====================================================================
// Set up the PDF objects and initialize
//
// This section sets up FPDF and imports our template document. No need
// for changes in this section.
//====================================================================

$pdf = new FPDI();
$pdf->AddPage();

// import the template PFD
$pdf->setSourceFile($filename);

// select the first page
$tplIdx = $pdf->importPage(1);

// use the page we imported
$pdf->useTemplate($tplIdx);





//====================================================================
// Write to the document
//
// The following section writes the actual texts into the document
// template. Expect some trying and failing when placing the texts :)
//
// References:
// http://www.fpdf.org/
// http://www.fpdf.org/en/doc/setfont.htm
// http://www.fpdf.org/en/doc/setxy.htm
// http://www.fpdf.org/en/doc/setx.htm
// http://www.fpdf.org/en/doc/ln.htm
//====================================================================

// set font, font style, font size, frame color, background color,text color and border thickness.
$pdf->SetFont('Arial','B',15);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(84,46,100);
$pdf->SetLineWidth(1);


// set initial placement
$pdf->SetXY(90, 210);

// write
$pdf->Write(0, ucwords(strtolower($vouchernumber)));

// all changes to PDF is now complete.


//====================================================================
// Output document
// This section will give the user a download file dialog with the
// generated document. The filename will be document.pdf
//====================================================================

// MSIE hacks. Need this to be able to download the file over https
// All kudos to http://in2.php.net/manual/en/function.header.php#74736
header("Content-Transfer-Encoding", "binary");
header('Cache-Control: maxage=3600'); //Adjust maxage appropriately
header('Pragma: public');

$pdf->Output('voucher.pdf', 'D');


?>
