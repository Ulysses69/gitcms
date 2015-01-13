<?php

if (!defined('PAGEOPTIONS_VERSION')) { define('PAGEOPTIONS_VERSION', '1.5.1'); }
if (!defined('PAGEOPTIONS_ROOT')) { define('PAGEOPTIONS_ROOT', URI_PUBLIC.'wolf/plugins/page_options'); }
Plugin::setInfos(array(
	'id'					=> 'page_options',
	'title'					=> 'Page Options',
	'description'			=> 'Set page_options',
	'version'				=> PAGEOPTIONS_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));


if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	if(!AuthUser::hasPermission('client')){
		if(Plugin::isEnabled('dashboard') == true) {
			Plugin::addController('page_options', 'Page Options', 'administrator', false);
		} else {
			Plugin::addController('page_options', 'Options', 'administrator', true);
		}
	}
}

/* Check if this plugin is enabled */
if(Plugin::isEnabled('page_options')){

	/* Page options - new */
	if(!function_exists('pagedate')){
		function pagedate($parent){
			$updated_enabled = Plugin::getSetting('updated_enabled', 'page_options');
			if($updated_enabled == 'show'){
				return '<p class="updated"><small>This page was last updated on the '.displayUpdated($parent,'return').'</small></p>';
			}
		}
	}

	/* Page options - new */
	if(!function_exists('pagereporterror')){
		function pagereporterror($parent){
			$report_enabled = Plugin::getSetting('report_enabled', 'page_options');
			if($report_enabled == 'show'){
				//if($parent->id != 16){
					$ref = $_SERVER["REQUEST_URI"];
					$addref = ''; if(!stristr($_SERVER["REQUEST_URI"],'?ref=')){ $addref = '?ref='.$ref; }
					$letusknow = str_replace('?ref=/', '?ref=', Page::urlById(16).URL_SUFFIX.$addref);
					return '<p class="report"><small>See any errors on this page? <a href="'.$letusknow.'">Let us know</a></small></p>';
				//}
			}
		}
	}

	/* Page options - new */
	if(!function_exists('pageoptions')){
		function pageoptions($parent, $display='', $heading=''){

			/* Proceed by ignoring parameters from previous versions */
			/* For backwards compatability, use page options saved by this plugin */
			$display = array();
	
			$print_title = Plugin::getSetting('print_title', 'page_options');
			$print_icon = Plugin::getSetting('print_icon', 'page_options');
			//$print_mobile_enabled = Plugin::getSetting('print_mobile_enabled', 'page_options');
			$print_enabled = Plugin::getSetting('print_enabled', 'page_options');
			$mobile_title = Plugin::getSetting('mobile_title', 'page_options');
			$mobile_icon = Plugin::getSetting('mobile_icon', 'page_options');
			//$mobile_desktop_enabled = Plugin::getSetting('mobile_desktop_enabled', 'page_options');
			$mobile_enabled = Plugin::getSetting('mobile_enabled', 'page_options');
			$pdf_title = Plugin::getSetting('pdf_title', 'page_options');
			$pdf_icon = Plugin::getSetting('pdf_icon', 'page_options');
			$pdf_bg_color = Plugin::getSetting('pdf_bg_color', 'page_options');
			$pdf_text_color = Plugin::getSetting('pdf_text_color', 'page_options');
			$pdf_link_color = Plugin::getSetting('pdf_link_color', 'page_options');
			//$pdf_mobile_enabled = Plugin::getSetting('pdf_mobile_enabled', 'page_options');
			$pdf_enabled = Plugin::getSetting('pdf_enabled', 'page_options');
			$top_of_page_title = Plugin::getSetting('top_of_page_title', 'page_options'); if($top_of_page_title == ''){ $top_of_page_title = 'Top of page'; }
			$top_of_page_icon = Plugin::getSetting('top_of_page_icon', 'page_options');
			//$top_of_page_mobile_enabled = Plugin::getSetting('top_of_page_mobile_enabled', 'page_options');
			$top_of_page_enabled = Plugin::getSetting('top_of_page_enabled', 'page_options');
	
			
			if($print_enabled == 'show'){ $display[] = array($parent,'print',$print_title,'',$print_icon); }
			if($mobile_enabled == 'show' && Plugin::getSetting('enable', 'mobile_check') == true){ $display[] = array($parent,'mobile',$mobile_title,'',$mobile_icon); }
			if($pdf_enabled == 'show'){ $display[] = array($parent,'pdf',$pdf_title,'',$pdf_icon); }
			if($top_of_page_enabled == 'show'){ $display[] = array($parent,'top',$top_of_page_title,'',$top_of_page_icon); }
			
			if(!empty($display)) {
	
				echo "\n".$heading."\n";
				echo '<ul id="options">';
				
				// Hide dynamic page options for temporary template pages (such as database error pages etc)
				if($parent->slug == 'template'){
					
					if(!isset($title)) $title = '';
					echo '<li id="top-option"><a href="#top"'.$title.'>'.$top_of_page_title.'</a></li>';

				// Show page options for working pages
				} else {

					/*
					if(MOBILEMODE != TRUE){
						$title = '';
						//$title = ' title="Mobile page view"';
						echo '<li id="mobile-option"><a href="/mobile'.$_SERVER['REQUEST_URI'].'"'.$title.'>Mobile</a></li>';
					}
					*/
					for ($row = 0; $row < sizeof($display); $row++){
						$url = $parent->url;
						$class = $display[$row][1];
						$text = $display[$row][2];
						$title = '';
						//$title = ucfirst($class).' page';
						$icon = $display[$row][4];
						if($icon != ''){
							$icon = $display[$row][4];
						} else {
							$icon = 'text';
						}
		
						if(isset($_GET["return"])){
							$get_return = htmlentities($_GET["return"]);
						} else {
							$get_return = '';
						}
		
						if($class == 'pdf'){
							/* Check that PDF function exists */
							//if(function_exists('downloadPDF') && !stristr($_SERVER['REQUEST_URI'],'/search/')){
							if(function_exists('downloadPDF')){
								$url = '/download'.$url;
	
								/* Remove trailing quesry string */
								//$url = reset(explode("?", $url));
	
								//if($url == '') $url = 'home';
								//echo '<li id="pdf-option"><a href="/download'.$download_file.'" title="Save page as PDF">Download</a></li>';
								if($get_return == 'success' || $parent->behavior_id == 'Form'){
									/* Don't display pdf link if submitted form - not working */
								} else {
									echo '<li id="pdf-option">'.switchlink($url, 'pdf', $text, $title, $icon).'</li>';
								}
							}
						} else if($class == 'top'){
							/* Check that PDF function exists */
							echo '<li id="top-option"><a href="#top"'.$title.'>'.$top_of_page_title.'</a></li>';
						} else if($class == 'mobile'){
							/* Check that mobile function exists */


							/* Check if mobile is set to n */
							if(isset($_GET['mobile'])){ $GET_mobile = htmlspecialchars($_GET['mobile']); } else { $GET_mobile = ''; }
							$mobile_string_var = '?mobile=n'; $mobile_set = $GET_mobile;
							if($mobile_set == 'n'){
								$url = str_replace($mobile_string_var,'',$url);
							}


							echo '<li id="'.$class.'-option">'.switchlink($url, $class, $text, $title, $icon).'</li>';
						} else {
							if($class == 'print' && ($get_return == 'success' || $parent->behavior_id == 'Form')){
								/* Don't display print link if submitted form - not working */
							} else {
								echo '<li id="'.$class.'-option">'.switchlink($url, $class, $text, $title, $icon).'</li>';
							}
						}
			
					}

				}

				$title = '';
				//$title = ' title="Top of page"';
				//echo '<li id="top-option"><a href="#top"'.$title.'>Top of page</a></li>';
				echo '</ul>';
				
			}
			

	
		}
	}

}