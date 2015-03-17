<?php

if (!defined('TCPDF_VERSION')) { define('TCPDF_VERSION', '1.3.0'); }
Plugin::setInfos(array(
	'id'		  			=> 'tcpdf',
	'title'	   			=> __('PDF Classes (TCPDF)'),
	'description' 			=> __('PDF Classes (TCPDF).'),
	'version'	 			=> TCPDF_VERSION,
	'license'	 			=> 'GPL',
	'require_wolf_version' 		=> '0.5.5'
));

// http://sourceforge.net/p/tcpdf/code/ci/master/tree/CHANGELOG.TXT

Behavior::add('Download', '');

if(!function_exists('downloadPDF')){
function downloadPDF($page){

 	// For testing
 	// Additionally, set K_TCPDF_THROW_EXCEPTION_ERROR to true for maximum error handling
	// $test = false;
	$test = false;


	//require_once('./wolf/plugins/tcpdf/lib/config/lang/eng.php');
	//require_once('./wolf/plugins/tcpdf/lib/tcpdf.php');
	
	require_once('./wolf/plugins/tcpdf/lib/tcpdf.php');


	/* For manual debugging */
	if($test == 'dump'){

		$thefilename = strip_tags($_GET['filename']);
		$filename = '../'.$thefilename;

		if($thefilename == 'home.html'){
			$thefilename = '../home.html';
			//$thepage = $page;
			$thepage = Page::findById(1);
		} else {
			$thepage = $page->find(str_replace(URL_SUFFIX,'',$thefilename));
		}

		$content = preg_replace('#<script[^>]*>.*?</script>#is','',maincontent($thepage));
		$content = str_replace('<span class="h2">Address</span>', '<h3>Address</h3>', $content);
		$content = str_replace('<span class="h2">Telephone</span>', '<h3>Telephone</h3>', $content);
		$content = str_replace('<span class="h2">Email</span>', '<h3>Email</h3>', $content);
		$content .= preg_replace('#<script[^>]*>.*?</script>#is','',$thepage->content('scripts'));
		$content = strip_tags($content,'<h1><h2><h3><h4><p><img><ul><ol><li><a><small><br>');

		// QR Code
		if(Plugin::isEnabled('page_options') == true && Plugin::getSetting('pdf_qrcode_enabled', 'page_options') == 'show'){
			$qrcode_width = Plugin::getSetting('pdf_qrcode_width', 'page_options');
			$qrcode_height = Plugin::getSetting('pdf_qrcode_height', 'page_options');
			// Strip metric such as px and em
			$qrcode_width = preg_replace("/[^0-9,.]/", "", $qrcode_width);
			$qrcode_height = preg_replace("/[^0-9,.]/", "", $qrcode_height);
			if($qrcode_width != '' && $qrcode_height != ''){
				$content .= qrimg($thepage->url,$qrcode_width.'x'.$qrcode_height);
			} else {
				$content .= qrimg($thepage->url);
			}
			$content .= '<p>QR Code Passed: '.URL_ABSOLUTE.$thepage->url.'</p>';
		}

		$html = $content;

		$html = str_replace('href="/', 'href="'.URL_ABSOLUTE.'', $html);
		$html = str_replace("href='/","href='".URL_ABSOLUTE."", $html);
		$html = str_replace("='",'="', $html);
		$html = str_replace("'>",'">', $html);
		
		echo $html;

	/* For core TCPDF testing */
	} else if($test == true){

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Blue Horizons');
		$pdf->SetTitle('PDF Example');
		$pdf->SetSubject('PDF Example');
		$pdf->SetKeywords('PDF, example');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->setListIndentWidth(4);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setLanguageArray($l);
		$pdf->AddPage();
		$txt = 'PDF Example';
		$pdf->Write($h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
		$pdf->Output('example.pdf', 'D');

	/* Generate PDF */
	} else {

		// Clean filename.
		$filename = '';

		/* Override logo with page options logo, if plugin available. Else, default to displaying specified logo - not checked with passed pdf_logo */
		$logo = 'inc/img/logo.png';
		//unset($logo);

		$pdf_bg_color = '#ffffff';
		$pdf_h1_color = '#222222';
		$pdf_hx_color = '#666666';
		$pdf_text_color = '#666666';
		$pdf_link_color = '#666666';

		if(Plugin::getSetting('pdf_bg_color', 'page_options')) $pdf_bg_color = Plugin::getSetting('pdf_bg_color', 'page_options');
		if(Plugin::getSetting('pdf_text_color', 'page_options')) $pdf_text_color = Plugin::getSetting('pdf_text_color', 'page_options');
		if(Plugin::getSetting('pdf_link_color', 'page_options')) $pdf_text_color = Plugin::getSetting('pdf_link_color', 'page_options');
		if(Plugin::getSetting('pdf_h1_color', 'page_options')) $pdf_h1_color = Plugin::getSetting('pdf_h1_color', 'page_options');
		if(Plugin::getSetting('pdf_hx_color', 'page_options')) $pdf_hx_color = Plugin::getSetting('pdf_hx_color', 'page_options');

		Flash::setNow('pdf_bg_color', $pdf_bg_color);
		Flash::setNow('pdf_text_color', $pdf_text_color);
		Flash::setNow('pdf_link_color', $pdf_link_color);
		Flash::setNow('pdf_h1_color', $pdf_h1_color);
		Flash::setNow('pdf_hx_color', $pdf_hx_color);


$styles = <<<EOS
<style>
body {
color: {$pdf_text_color};
}
h1 {
color: {$pdf_h1_color};
}
h2 {
color: {$pdf_hx_color};
}
h3 {
color: {$pdf_hx_color};
}
h4 {
color: {$pdf_hx_color};
}
p {
color: {$pdf_text_color};
}
em {
color: {$pdf_text_color};
}
strong {
color: {$pdf_text_color};
}
blockquote {
color: {$pdf_text_color};
}
li {
color: {$pdf_text_color};
}
a {
text-decoration: none;
color: {$pdf_link_color};
}
</style>
EOS;


		if(isset($_GET['filename']) && !stristr($_GET['filename'],'://')){
			$thefilename = strip_tags($_GET['filename']);
			$filename = '../'.$thefilename;

			//echo $thefilename;
			//echo $filename;
			//exit;


			// Get content from page.
			if(!isset($_POST['pdf_data'])){
				//$html = @file_get_contents(URL_ABSOLUTE.'/pdf/'.$thefilename);
				//$html = 'Hello';
				//$html = $page->find($filename)->content();
				


				// Page object
				if($thefilename == 'home.html'){
					$thefilename = '../home.html';
					//$thepage = $page;
					$thepage = Page::findById(1);
				} else {
					$thepage = $page->find(str_replace(URL_SUFFIX,'',$thefilename));
				}

				//$thepage = $page->find(str_replace(URL_SUFFIX,'',$thefilename));

				//echo $thepage->content();
				//exit;
				
				// Handle Search Pages
				if(stristr($thefilename,'search/')){
					$searchpage = file_get_contents(URL_ABSOLUTE.'print/'.$thefilename);
					if('.'.strtolower(pathinfo($thefilename, PATHINFO_EXTENSION)) != URL_SUFFIX){
						$filename .= URL_SUFFIX;
						$thepage = $filename;
					}
					
					$pageurl = $thepage;

					//$searchpage = strip_tags($searchpage,"<h1><h2><h3><h4><h5><p><ul><ol><li><a><em><b><strong><small><img>");
					//echo $searchpage;
					//exit;
					$thepage = $searchpage;
					$content = preg_replace('#<script[^>]*>.*?</script>#is','',$thepage);
					$content = str_replace('<span class="h2">Address</span>', '<h3>Address</h3>', $content);
					$content = str_replace('<span class="h2">Telephone</span>', '<h3>Telephone</h3>', $content);
					$content = str_replace('<span class="h2">Email</span>', '<h3>Email</h3>', $content);
					//$content .= preg_replace('#<script[^>]*>.*?</script>#is','',$thepage);

					$dom = new DOMDocument;
					$dom->loadHTML($content);
					$main = $dom->getElementById('content');
					//$dom->saveHTML();
					$html = $dom->saveHTML($main);
					
					$html = strip_tags($html,'<h1><h2><h3><h4><p><img><ul><ol><li><a><small><br>');

					$html = str_replace('href="/', 'href="'.URL_ABSOLUTE.'', $html);
					$html = str_replace("href='/","href='".URL_ABSOLUTE."", $html);
					
					//echo $html;
					//exit;

				// Handle Non-Search Pages
				} else {

					// Page object check
					if(is_object($thepage)){

						$pageurl = $thepage->url;
	
						$content = preg_replace('#<script[^>]*>.*?</script>#is','',maincontent($thepage));
						$content = str_replace('<span class="h2">Address</span>', '<h3>Address</h3>', $content);
						$content = str_replace('<span class="h2">Telephone</span>', '<h3>Telephone</h3>', $content);
						$content = str_replace('<span class="h2">Email</span>', '<h3>Email</h3>', $content);
						$content .= preg_replace('#<script[^>]*>.*?</script>#is','',$thepage->content('scripts'));
						$content = strip_tags($content,'<h1><h2><h3><h4><p><img><ul><ol><li><a><small><br>');
	
						$html = $content;
		
						$html = str_replace('href="/', 'href="'.URL_ABSOLUTE.'', $html);
						$html = str_replace("href='/","href='".URL_ABSOLUTE."", $html);
						$html = str_replace("='",'="', $html);
						$html = str_replace("'>",'">', $html);
					
					}

				}

				// Google QR Code
				/*
				if(Plugin::isEnabled('page_options') == true && Plugin::getSetting('pdf_qrcode_enabled', 'page_options') == 'show'){
					$qrcode_width = Plugin::getSetting('pdf_qrcode_width', 'page_options');
					$qrcode_height = Plugin::getSetting('pdf_qrcode_height', 'page_options');
					// Strip metric such as px and em
					$qrcode_width = preg_replace("/[^0-9,.]/", "", $qrcode_width);
					$qrcode_height = preg_replace("/[^0-9,.]/", "", $qrcode_height);
					if($qrcode_width != '' && $qrcode_height != ''){
						$content .= qrimg($thepage->url,$qrcode_width.'x'.$qrcode_height);
					} else {
						$content .= qrimg($thepage->url);
					}
				}
				*/




				//echo $html;
				//exit;
			}

		}

	
		//echo "filename: ".$filename."<br>";
		//echo "getcontents: ".URL_ABSOLUTE.'/pdf/'.$thefilename."<br>";
		//echo $html."<br>";
		//exit;
	
	
		//if(strtolower(pathinfo($filename, PATHINFO_EXTENSION)) == URL_SUFFIX){

			// Get content from posted data.
			if(isset($_POST['pdf_data']) && !stristr($_GET['filename'],'://')){
				$html = strip_tags($_POST['pdf_data'], '<p><div><span><em><strong><b><h1><h2><h3><h4><img>');
			}

			// Absolute document URLs not allowed, nor pages that don't match site URL suffix.
			if($filename == '' || '.'.strtolower(pathinfo($filename, PATHINFO_EXTENSION)) != URL_SUFFIX){
	
				// Return dummy page to prompt formatted searchbox page.
				header('Location: /not-specified.html');
				//echo "You did not specify a valid page or document to download.";
				//exit;
		
			} else {

				//echo "Document specified: ".$filename;
				//echo " Page URL: ".$page->url;
				//exit;

				// Get filename from page name, changing page extension and dropping preceding directory paths.
				if(isset($_POST['pdf_filename'])){
					$filename = strip_tags($_POST['pdf_filename']);
					// Remove existing filename extension to prevent double extension
					$filename = str_replace('.'.strtolower(pathinfo($filename, PATHINFO_EXTENSION)),'',$filename);
				} else {
					$filename = str_replace('../','',$filename);
					//if(strtolower(pathinfo($filename, PATHINFO_EXTENSION)) != 'pdf'){
						//$filename = str_replace(strtolower(pathinfo($filename, PATHINFO_EXTENSION)),'pdf',$filename);
						$filename = str_replace('.'.strtolower(pathinfo($filename, PATHINFO_EXTENSION)),'',$filename);
					//}
					$filename = basename($filename);
				}
				//if(!stristr($filename,'.pdf')) $filename = $filename.'.pdf';
				if(isset($_GET['pdf_logo'])) $logo = strip_tags($_POST['pdf_logo']);







				if(Plugin::isEnabled('page_options') == true){
					$logo_enabled = Plugin::getSetting('pdf_logo_enabled', 'page_options');
					$logo_w = Plugin::getSetting('pdf_logo_width', 'page_options');
					$logo_h = Plugin::getSetting('pdf_logo_height', 'page_options');
					if($logo_enabled == 'show'){
						// Replace default logo
						$logo = Plugin::getSetting('pdf_logo_url', 'page_options');
					} else if($logo_enabled != 'hide'){
						// Remove logo
						unset($logo);
					}
				}

	


				if(isset($logo)){

					//list($logo_width, $logo_height, $logo_type, $logo_attr) = getimagesize($logo);
					list($logo_width, $logo_height, $logo_type, $logo_attr) = getimagesize($logo);
					$logo_ext = strtolower(pathinfo($logo, PATHINFO_EXTENSION));
					$logo_y = 15;

					// Override logo dimensions if set
					if($logo_w == '' && $logo_h == ''){
						$logo_h = 30;
						$logo_w = ''; // Should be derived from height but can be manually specified if needed.
						if($logo_width == '' || $logo_width > ($logo_height * 2)){
							$logo_h = $logo_h / 1.4;
						}
						if($logo_width > ($logo_height * 3)){
							$logo_h = $logo_h / 1.8;
						}
						if($logo_width > ($logo_height * 4)){
							$logo_h = $logo_h / 2.2;
						}
					} 

					Flash::setNow('logo', $logo);
					Flash::setNow('logo_w', $logo_w);
					Flash::setNow('logo_h', $logo_h);
					Flash::setNow('logo_y', $logo_y);
					Flash::setNow('logo_ext', $logo_ext);


				} else {
					//$logo_h = 0;
					//$logo_w = 0;
				}


				$qrwidth = Plugin::getSetting('pdf_qrcode_width', 'page_options');
				$qrwidth = $qrwidth / 10;
				$qrx = 'R';
				//$qrx = 20;
				//$qry = $logo_y;
				$qry = 'T';

				Flash::setNow('qrwidth', $qrwidth);
				Flash::setNow('qrx', $qrx);
				Flash::setNow('qry', $qry);
				if(isset($pageurl)) Flash::setNow('qrURL', qrurl($pageurl));
				Flash::setNow('qrtype', 'QRCODE,M');
				Flash::setNow('qralign', 'N');


				$header = false;


				AutoLoader::addFile('MYPDF', dirname(__FILE__) . '/models/MYPDF.php');
				AutoLoader::load('MYPDF');
	

				// Check logo exists for header.
				if(isset($logo_ext) && ($logo_ext == 'ai' || $logo_ext == 'eps' || $logo_ext == 'jpg' || $logo_ext == 'gif' || $logo_ext == 'png')){
	
					// Set header status to true
					$header = true;
				}
	
	

				//$html .= '<p><small>Logo: '.$logo.'</small></p>';
	
	
				// create new PDF document
				if(class_exists('MYPDF')){

					//echo "Class exists<br>";
					if(isset($logo)){
						//echo "<br>".$logo .' '. $logo_width .'px x '. $logo_height .'px ('. $logo_ext .')'."<br>";
					}
					//echo "<br>".$html;
					//echo "<br>".$filename;
					//exit;
	

					$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

					// set document information
					$pdf->SetCreator(PDF_CREATOR);
					//$pdf->SetAuthor(Plugin::getSetting('clientname', 'clientdetails'));
					//$pdf->SetTitle($page->title);
					if(isset($_GET['pdf_author'])) $pdf->SetAuthor(strip_tags($_GET['pdf_author']));
					if(isset($_GET['pdf_title'])) $pdf->SetTitle(strip_tags($_GET['pdf_title']));
					//$pdf->SetSubject('TCPDF Tutorial');
					//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


					// set default header data
					if($header == true){
						$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
					}
				
					// remove default header/footer
					if($header == false){
						$pdf->setPrintHeader(false);
					}
					$pdf->setPrintFooter(false);  

					// set header and footer fonts
					if($header == true){
						$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					}
					//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    
					// set default monospaced font
					$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		
					if($header == true){
						//set margins
						if(isset($logo)){
							//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
							$pdf->SetMargins(PDF_MARGIN_LEFT, ($logo_y + $logo_h + ($logo_y)), PDF_MARGIN_RIGHT);
						} else {
							$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
						}
						$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					}
		

					//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

					//set auto page breaks
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
					
					if(isset($logo)){
						//set image scale factor
						$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
					}

					//set some language-dependent strings
					//$pdf->setLanguageArray($l);                                      

					// Setup font type/encoding
					//$fontPath = K_PATH_FONTS; $fontFile = 'DejaVuSans.ttf'; $fontType = 'TrueTypeUnicode'; $fontEnc = ''; $fontFlags = 32;
					$fontEnc = 'ansi'; $fontFlags = 32;

					$mainFont = 'Roboto-Regular.ttf';
					//$mainFont = 'Ubuntu.ttf';

                    if(Plugin::isEnabled('mobile_check') == true){
                    	$content_font = Plugin::getSetting('content_font', 'mobile_check');
                    	if($content_font != ''){
                    		// Google font filenames need to changing to local filenames
							$mainFont = str_replace('+', '_', $content_font).'.ttf';
						}
					}

					// Check if specified font exists and is ttf
                    $custom_font = realpath('inc/font/' . $mainFont); 
                    if(file_exists($custom_font) && stripos($custom_font, '.ttf')){                     
                        // Add font
                        $fontType = 'TrueType';
                        $fontname = $pdf->addTTFfont(realpath('inc/font/' . $mainFont), $fontType, $fontEnc, $fontFlags);
                        //$pdf->SetFont($fontname, '', 14, '', false);                        
                    } else {
                        // Use default font
                        $fontType = 'TrueType';
                        $fontPath = K_PATH_FONTS; $fontFile = 'helvetica.ttf';
                        $fontname = $pdf->addTTFfont($fontPath . $fontFile, $fontType, $fontEnc, $fontFlags);
                        //$pdf->SetFont($fontname, '', 14, '', false);
                    }

                    if(Plugin::isEnabled('mobile_check') == true){
                    	if(Plugin::getSetting('content_font_h1', 'mobile_check') == 'yes'){
		                    // Custom h1 font
							$html = str_replace('<h1>', '<h1 style="font-family:'.$fontname.'">', $html);
						}
                    	if(Plugin::getSetting('content_font_h2', 'mobile_check') == 'yes'){
		                    // Custom h1 font
							$html = str_replace('<h2>', '<h2 style="font-family:'.$fontname.'">', $html);
						}
                    	if(Plugin::getSetting('content_font_intro', 'mobile_check') == 'yes'){
		                    // Custom h1 font
							$html = str_replace('<p class="introduction">', '<p class="introduction" style="font-family:'.$fontname.'">', $html);
						}
					}

					//echo $fontname;

                    //echo 'HALT: '.realpath('inc/font/Roboto-Regular.ttf');
                    //exit;

					// set font
					//$pdf->SetFont('helvetica', '', 9);
					//$pdf->AddFont($fontname, '', $fontname.'.php');
					//$pdf->SetFont($fontname, '', 9);

					//echo 'K_PATH_URL: '.K_PATH_URL.'<br>';
					//echo 'K_PATH_FONTS: '.K_PATH_FONTS.'<br>';
					//echo 'K_PATH_CACHE: '.K_PATH_CACHE.'<br>';
					//echo 'K_PATH_URL_CACHE: '.K_PATH_URL_CACHE.'<br>';
					//echo 'K_PATH_IMAGES: '.K_PATH_IMAGES.'<br>';
					//echo 'K_BLANK_IMAGE: '.K_BLANK_IMAGE.'<br>';
					//echo 'PDF_PAGE_FORMAT: '.PDF_PAGE_FORMAT.'<br>';
					//echo 'PDF_PAGE_ORIENTATION: '.PDF_PAGE_ORIENTATION.'<br>';
					//echo 'PDF_HEADER_LOGO: '.PDF_HEADER_LOGO.'<br>';

					// Check for PDF dimension settings
					$pdf_size = ''; $pdf_orientation = '';
					if(Plugin::getSetting('pdf_size', 'page_options')) $pdf_size = Plugin::getSetting('pdf_size', 'page_options');
					if(Plugin::getSetting('pdf_orientation', 'page_options')) $pdf_orientation = Plugin::getSetting('pdf_orientation', 'page_options');

					// add a page
					if($pdf_size != '' && $pdf_orientation != ''){
						$pdf->AddPage($pdf_orientation, $pdf_size);
					} else {
						$pdf->AddPage();
					}




					/* QR COde */
					/*
					// Style for barcodes (Google QR not working, plus Google white padding is annoying)
					$qrstyle = array(
						'border' => 0,
						'padding' => 0
					);
					// Place QR code top right of page
					$qrwidth = 20;
					$qrwidth_x = $pdf->getPageWidth() - $qrwidth - PDF_MARGIN_RIGHT;
					$pdf->write2DBarcode(qrurl($thepage->url), 'QRCODE,M', $qrwidth_x, $logo_y, 30, 30, $qrstyle, 'N');
					*/



					// output the HTML content
					$html = $styles.$html;
					//$html = '<style>body{font-family:Calibri,Arial,Verdana,Helvetica,Georgia,"Times New Roman",Serif;color:#222;font-size:0.6em;}a{color:#222;text-decoration:none;}img{max-width:100% !important;}</style>'.$html;
					$pdf->writeHTML($html, true, false, true, false, '');

					// reset pointer to the last page
					$pdf->lastPage();
					
					if(stristr($thefilename,'search/')){
						$filename = 'search-results-for-'.$filename;
					}

					// Coanonical header
					if($thepage->url != '' && URL_SUFFIX != ''){ $link = URL_ABSOLUTE.$thepage->url.URL_SUFFIX; } else { $link = URL_ABSOLUTE.$thepage->url; }
					//$rel = get_headers($link); $ur = $rel[0];
					//if(strpos($ur,"200")){ 
						header('Link:<'.$link.'>; rel="canonical"'); 
					//}

					// Close and output PDF document
					$pdf->Output($filename.'.pdf', 'D');
		
				} else {
	
					//echo 'Class DOES NOT exist';
					//echo "<br>".$logo .' '. $logo_width .'px x '. $logo_height .'px ('. $logo_ext .')';
					//exit;
	
				}
	
	
	
		
			}
			
		//}

		
	}



}
}

?>