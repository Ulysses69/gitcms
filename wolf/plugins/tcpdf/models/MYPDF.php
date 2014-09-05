<?php

if (!defined('IN_CMS')) { exit(); }

			if(!class_exists('MYPDF')){
			//if(isset($logo_ext) && ($logo_ext == 'ai' || $logo_ext == 'eps' || $logo_ext == 'jpg' || $logo_ext == 'gif' || $logo_ext == 'png')){
				class MYPDF extends TCPDF {

					// Page header
					public function Header(){



						/* QR COde */
						// Style for barcodes (Google QR not working, plus Google white padding is annoying)
						$qrstyle = array(
							'border' => 0,
							'padding' => 0
						);
						
						/* Get values from tcpdf plugin */
						$logo = Flash::get('logo');
						$logo_w = Flash::get('logo_w');
						$logo_h = Flash::get('logo_h');
						$logo_y = Flash::get('logo_y');
						$logo_ext = Flash::get('logo_ext');

						$qrwidth = Flash::get('qrwidth');
						$qrx = Flash::get('qrx');
						$qry = Flash::get('qry');
						$qrURL = Flash::get('qrURL');
						$qrtype = Flash::get('qrtype');
						$qralign = Flash::get('qralign');

						$pdf_bg_color = Flash::get('pdf_bg_color');
						$pdf_text_color = Flash::get('pdf_text_color');
						$pdf_link_color = Flash::get('pdf_link_color');
						$pdf_h1_color = Flash::get('pdf_h1_color');
						$pdf_hx_color = Flash::get('pdf_hx_color');

						// HTML HEX Colour to RGB
						if(!function_exists('hex2rgb')){
						function hex2rgb($hex) {
						   $hex = str_replace("#", "", $hex);
						   if(strlen($hex) == 3) {
							  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
							  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
							  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
						   } else {
							  $r = hexdec(substr($hex,0,2));
							  $g = hexdec(substr($hex,2,2));
							  $b = hexdec(substr($hex,4,2));
						   }
						   $rgb = array($r, $g, $b);
						   //return implode(",", $rgb); // returns the rgb values separated by commas
						   return $rgb; // returns an array with the rgb values
						}
						}

						// Background color
						$bgcolor = hex2rgb($pdf_bg_color);
						$this->Rect(0,0,210,297,'F','',$fill_color = array($bgcolor[0], $bgcolor[1], $bgcolor[2]));
						//$this->Rect(0,0,210,297,'F','',$fill_color = array(255, 170, 96));

						// Set Logo
						if($logo_ext == 'eps' || $logo_ext == 'ai'){
							$this->ImageEps($file=$logo, $x=PDF_MARGIN_LEFT, $y=$logo_y, $w=$logo_w, $h=$logo_h, $link='', $useBoundingBox=true, $align='', $palign='', $border=0, $fitonpage=false);
						} else {
							//$this->Image($logo, PDF_MARGIN_LEFT, $logo_y, '', $logo_h, strtoupper($logo_ext), '', 'T', false, 300, '', false, false, 0, false, false, false);
							$this->Image($logo, PDF_MARGIN_LEFT, $logo_y, $logo_w, $logo_h, strtoupper($logo_ext), '', 'T', false, 300, '', false, false, 0, false, false, false);
						}

						// Place QR code (top right of page)
						if(Plugin::isEnabled('page_options') == true && Plugin::getSetting('pdf_qrcode_enabled', 'page_options') == 'show'){
							if($qrx == 'R') $qrx = $this->getPageWidth() - $qrwidth - PDF_MARGIN_RIGHT;
							if($qry == 'T') $qry = $logo_y;
							$this->write2DBarcode($qrURL, $qrtype, $qrx, $qry, $qrwidth, $qrwidth, $qrstyle, $qralign);
							//$this->write2DBarcode('http://clientcms.local/privacy.html', 'QRCODE,M', 10, 10, 20, 20, $qrstyle, 'N');
						}


						
						// Header Text color
						//$textcolor = hex2rgb($pdf_text_color);
						//$this->SetTextColor($textcolor[0], $textcolor[1], $textcolor[2]);

						// Set font
						//$this->SetFont('helvetica', 'B', 20);
					}

				}				

			//}
			}

?>