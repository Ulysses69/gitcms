<?php

if (!defined('IN_CMS')) { exit(); }

Plugin::setInfos(array(
	'id'		  			=> 'layout_switch',
	'title'	   			=> __('Layout Switch'),
	'description' 			=> __('Currently conflicts with Page Metadata plugin.'),
	'version'	 			=> '6.1.0',
	'license'	 			=> 'GPL',
	'require_wolf_version' 		=> '0.5.5'
));

Observer::observe('page_found', 'layout_switch_check');
Behavior::add('LayoutSwitch', '');
function sanitize_output($page){
	$search = array(
		'/\>[^\S ]+/s', // Strip whitespaces after tags, except space
		'/[^\S ]+\</s', // Strip whitespaces before tags, except space
		'/(\s)+/s'  // Shorten multiple whitespace sequences
		);
	$replace = array(
		'>',
		'<',
		'\\1'
		);
	$page = preg_replace($search, $replace, $page);
	return $page;
}
/* Mobile stylesheets */
function mobilecss($parent=''){
	$css = ''; $pages = array();
	if(in_array($parent->id,$pages) || stristr($parent->behavior_id, 'Form')){ $css .= "<link rel='stylesheet' href='/inc/css/forms.css' type='text/css' media='screen' />"; }
	$css .= "<link rel='stylesheet' href='/inc/css/mobile.css' type='text/css' media='screen' />";
	$css .= "<link rel='stylesheet' href='/inc/css/print.css' type='text/css' media='print' />";
	// $css .= "<link rel='stylesheet' href='/inc/css/mobile.css' type='text/css' media='only screen and (max-device-width: 480px)' />";
	echo $css;
}

function mobiledevice(){
	if(isset($_GET['mobile'])){ $GET_mobile = htmlspecialchars($_GET['mobile']); } else { $GET_mobile = ''; }
	$mobile_set = $GET_mobile;
	/*
	$mobile_browser = '0';
	if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		$mobile_browser++;
		//define('BROWSERAGENT', 'mobile');

	if(isset($_SERVER['HTTP_ACCEPT']) && (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
		$mobile_browser++;
		if(isset($_SERVER['HTTP_USER_AGENT'])){ $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4)); } else { $mobile_ua = ''; }
		//echo '<!-- ' . $_SERVER['HTTP_USER_AGENT'] . " -->";
		//echo '<!-- ' . $mobile_ua . " -->\n";
		$mobile_agents = array(
		'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
		'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		'wapr','webc','winw','winw','xda','xda-');
	if(in_array($mobile_ua,$mobile_agents)){
		$mobile_browser++;
		//echo "<!-- m:mobile -->\n";
		$browseragent = 'mobile';
	}
	//if(isset($_SERVER['ALL_HTTP'])){ if (strpos(strtolower($_SERVER['ALL_HTTP']),'operamini')>0){
	if(isset($_SERVER['ALL_HTTP']) && preg_match('/(operamini)/i', strtolower($_SERVER['ALL_HTTP']))){
		$mobile_browser++;
		$browseragent = 'operamini';
	}
	//}
	if (isset($_SERVER['HTTP_USER_AGENT']) && strpos(strtolower($_SERVER['HTTP_USER_AGENT']),' ppc')>0){
		//Don't detect Power PC as mobile device. $mobile_browser++;
		//echo "<!-- m:ppc -->\n";
	}
	//if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iphone')>0){
	if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(iphone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))){
		$mobile_browser++;
		$browseragent = 'iphone';
		//echo "<!-- m:iphone -->\n";
	}

	if (isset($_SERVER['HTTP_USER_AGENT']) && strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') !== false)
		$mobile_browser = 0;
		$browseragent = 'windows';

	if(isset($_SERVER['HTTP_USER_AGENT']) && strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
		$mobile_browser++;
		$browseragent = 'windows phone';

	if(!defined('BROWSERAGENT')) define('BROWSERAGENT', $browseragent);
	if($mobile_browser > 0 && $_SESSION['mobilemode'] != 'set'){
		return TRUE; // If mobile, or mobile detected user wishes to keep using mobile site
	} else {
		return FALSE;
	}
	*/
	if($mobile_set != 'n'){
		require_once('./wolf/plugins/layout_switch/lib/Mobile-Detect/Mobile_Detect.php');
		$detect = new Mobile_Detect;
		//if(!defined('BROWSERAGENT')) define('BROWSERAGENT', $browseragent);
		if($detect->isMobile() && !$detect->isTablet()){ return TRUE; } else { return FALSE; }
	}
}

function tabletdevice(){
	require_once('./wolf/plugins/layout_switch/lib/Mobile-Detect/Mobile_Detect.php');
	$detect = new Mobile_Detect;
	if($detect->isTablet()){ return TRUE; } else { return FALSE; }
}



function layoutMetaTest($content,$get='ob_get_contents'){

	$page = $content;

	if($get == 'ob_get_contents'){
		ob_start();
		$page->_executeLayout();
		$page = ob_get_contents();
		$get = $page;
	}

	$page = str_replace('<meta name="Functions" content="setscripts">', '<meta name="Functions" content="setscripts">'."\n".'<meta name="LayoutSwitch" content="setscripts">'."\n", $get);

	if($get == 'ob_get_contents'){
		ob_end_clean();
	}

	//$page = str_replace('<meta name="Functions" content="setscripts">', '<meta name="Functions" content="setscripts">'."\n".'<meta name="LayoutSwitch" content="setscripts">'."\n", $get);

	return $page;
}
function layoutFormCss($content,$get='ob_get_contents'){
	$thispage = Page::findByUri(str_replace(URL_SUFFIX,'',$_SERVER['REQUEST_URI']));
	$page = $content;
	
	//echo 'hello '.$page->slug; exit;

	//if(is_object($thispage) && $thispage->behavior_id == 'Form' && function_exists('str_replace_once')){
	if(is_object($page) && $page->behavior_id == 'Form' && function_exists('str_replace_once')){
		if($get == 'ob_get_contents'){
			ob_start();
			$page->_executeLayout();
			$page = ob_get_contents();
			$get = $page;
		}

		if(!stristr($get,'forms.css')){
			if(function_exists('str_replace_once')) $page = str_replace_once('<link type="text/css', '<link type="text/css" href="/inc/css/forms.css" rel="stylesheet" media="all">'."\n".'<link type="text/css', $get);
		} else {
			$page = $get;
		}

		if($get == 'ob_get_contents'){
			ob_end_clean();
		}

		return $page;
	} else {
		if($get == 'ob_get_contents'){
			// DO DO: We don't really want to run ob_get_contents here, if referring page also did so
			ob_start();
			$page->_executeLayout();
			$page = ob_get_contents();
			return $page;
		} else {
			return $get;
		}
	}
}
function layoutScreenCss($content,$get='ob_get_contents'){

	$page = $content;
	if(stristr($page->behavior_id, 'Form')){

		if($get == 'ob_get_contents'){

			ob_start();
			$page->_executeLayout();
			$page = ob_get_contents();
			$get = $page;
		}

		$page = str_replace('screen.css" rel="stylesheet" media="screen">', 'forms.css" rel="stylesheet" media="screen">'."\n".'<link type="text/css" href="/inc/css/screen.css" rel="stylesheet" media="screen">', $get);

		if($get == 'ob_get_contents'){
			ob_end_clean();
		}

		return $page;
	} else {
		if($get == 'ob_get_contents'){
			// DO DO: We don't really want to run ob_get_contents here, if referring page also did so
			ob_start();
			$page->_executeLayout();
			$page = ob_get_contents();
			return $page;
		} else {
			return $get;
		}
	}
}


function layout_switch_check($page) {
	
	/* Check for notfound page (as per invalid admin redirects) */
	if(strpos($_SERVER["REQUEST_URI"], 'notfound'.URL_SUFFIX)){
		header("HTTP/1.0 401 Unauthorized");
		header("Status: 401 Unauthorized");
		//echo $_SERVER["DOCUMENT_ROOT"].'/../admin-log.txt';
		//echo 'NOT FOUND';
		//exit;
		
		$log_file = $_SERVER["DOCUMENT_ROOT"].'/../admin-log.txt';
		
		// Allow valid IP addresses only
		if(filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {
	
			// Check if log file exists and is smaller than 1MB (else create new file)
			if(file_exists($log_file) && filesize($log_file) < 1048576){
				// TODO: Prepend or reverse the data (new to old)
	
				// Write IP to existing file
				file_put_contents($log_file, date("d/m/y", time()) . ', ' . date("H:i:s", time()) . ', ' . $_SERVER['REMOTE_ADDR'] . "\n", FILE_APPEND);
			} else {
				// Write IP to new file
				file_put_contents($log_file, date("d/m/y", time()) . ', ' . date("H:i:s", time()) . ', ' . $_SERVER['REMOTE_ADDR'] . "\n");
			}
		
		}

	}

	/* Check for mockups pages */
	if(strpos($_SERVER["REQUEST_URI"], 'mockup')){
		//echo $_SERVER["DOCUMENT_ROOT"].'/../admin-log.txt';
		//echo 'NOT FOUND';
		//exit;

		$log_file = $_SERVER["DOCUMENT_ROOT"].'/../mockup-log.txt';

		// Allow valid IP addresses only
		if(filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {

			// Check if log file exists and is smaller than 1MB (else create new file)
			if(file_exists($log_file) && filesize($log_file) < 1048576){
				// TODO: Prepend or reverse the data (new to old)
	
				// Write IP to existing file
				file_put_contents($log_file, date("d/m/y", time()) . ', ' . date("H:i:s", time()) . ', ' . $_SERVER['REMOTE_ADDR'] . "\n", FILE_APPEND);
			} else {
				// Write IP to new file
				file_put_contents($log_file, date("d/m/y", time()) . ', ' . date("H:i:s", time()) . ', ' . $_SERVER['REMOTE_ADDR'] . "\n");
			}

		}

	}

	/* Check for suggested not found pages (as passed via URL) */
	if(strpos($_SERVER["REQUEST_URI"], '301=Error')){
		header("HTTP/1.0 301 Moved Permanently");
		header("Status: 301 Moved Permanently");
	}



	/* Check for search results pages */
	if(strpos($_SERVER['REQUEST_URI'], 'search/')){
		//header("HTTP/1.0 301 Moved Permanently");
		//header("Status: 301 Moved Permanently");
	}



	//echo 'Layout Loaded'; exit;
	if(is_object($page)){
		if(isset($_GET['media']) && $_GET['media'] == 'standard'){
			define('MOBILEMODE', FALSE);
			$page->includeSnippet('registerfunctions'); // Include custom functions snippet
			$page->_executeLayout();
			$page = ob_get_contents();
			//$page = strtr($page, array("\t" => "", "\n" => "", "\r" => "", 'href="'.URL_PUBLIC => 'href="'.URL_PUBLIC.'mobile/', 'action="'.URL_PUBLIC.'search.html' => 'action="'.URL_PUBLIC.'mobile/search.html'));
			//$page = str_replace('="'.URL_PUBLIC, '="'.URL_PUBLIC.'standard/', $page);
	
			/* Don't follow or index standard layout */
			$standard_canonical = '<meta name="robots" content="nofollow,noindex" />'."\n";
			$standard_canonical .= '<link rel="canonical" href="'.str_replace('standard/','',$_SERVER['REQUEST_URI']).'" />'."\n";
			$page = str_replace('</head',$standard_canonical.'</head', $page);

			$page = str_replace('<a href="/', '<a href="/standard/', $page);
			$page = str_replace('/standard/public/', '/public/', $page);
			$page = str_replace('/standard/mobile/', '/mobile/', $page);
			$page = str_replace('/standard/print/', '/print/', $page);
			$page = str_replace('/print/standard/', '/print/', $page);
			$page = str_replace('action="/search.html"', 'action="/standard/search.html"', $page);
			ob_end_clean();
			echo $page;
			exit();
		} else {
	
			if((isset($_GET['media']) && $_GET['media'] == 'mobile') || mobiledevice() == TRUE){
				if( Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('enable', 'mobile_check') == true){
					define('MOBILEMODE', TRUE);
				} else {
					define('MOBILEMODE', FALSE);
				}
			} else {
				define('MOBILEMODE', FALSE);
			}
			$page->includeSnippet('registerfunctions'); // Include custom functions snippet
			if(isset($_GET['media']) && $_GET['media'] == 'flash' && $page->content('flash') != ''){
				$page->layout_id = 13; // Force layout change
				ob_start();
				$page->_executeLayout();
				$page = ob_get_contents();
				ob_end_clean();
				echo $page;
				exit();
			}
			if(isset($_GET['media']) && $_GET['media'] == 'proposal'){
				$page->layout_id = 10; // Force layout change
				ob_start();
				$page->_executeLayout();
				$page = ob_get_contents();
				$page = str_replace('href="', 'href="/proposal/', $page);
				$page = str_replace('proposal//', 'proposal/', $page);
				ob_end_clean();
				echo $page;
				exit();
			}
			if(isset($_GET['media']) && $_GET['media'] == 'print'){
				define('PRINTMODE', TRUE);
				$page->layout_id = 5; // Force layout change
				ob_start();
				$page->_executeLayout();
				$page = ob_get_contents();
				$page = str_replace('href="'.URL_PUBLIC, 'href="'.URL_PUBLIC.'print/', $page);
				$page = str_replace('print/mobile/','mobile/', $page);
				$page = str_replace('print/public/','public/', $page);
				ob_end_clean();
				echo $page;
				exit();
			}
	/*
			if(isset($_GET['media']) && $_GET['media'] == 'pdf'){
				define('PDFMODE', TRUE);
				$page->layout_id = 21; // Force layout change
				ob_start();
				$page->_executeLayout();
				$page = ob_get_contents();
				ob_end_clean();
				$page = str_replace('href="/', 'href="'.URL_ABSOLUTE.'', $page);
				$page = str_replace("href='/","href='".URL_ABSOLUTE."", $page);
				$page = str_replace("='",'="', $page);
				$page = str_replace("'>",'">', $page);
				echo $page;
				exit();
			}
	*/
			if((isset($_GET['media']) && $_GET['media'] == 'contrast')){
				$page->layout_id = 12; // Force layout change
				ob_start();
				$page->_executeLayout();
				$page = ob_get_contents();
				$page = str_replace('href="'.URL_PUBLIC, 'href="'.URL_PUBLIC.'contrast/', $page);
				$page = str_replace('contrast/mobile/','mobile/', $page);
				if(stristr($page,'class="popup') && stristr($page,'shadowbox')){
						$page = str_replace('class="popup', 'rel="shadowbox', $page);
				}
				ob_end_clean();
				echo $page;
				exit();
			}
	
			//$mobile_redirect = true; // true/false
			if(Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('enable', 'mobile_check') == true){
	
				if((isset($_GET['media']) && $_GET['media'] == 'mobile') || mobiledevice() == TRUE){
	
					/* UNDER CONSTRUCTION - Funky Cache Support */
					if(Plugin::isEnabled('funky_cache') == true){
						funky_cache_create($page);
					}
	
					if(mobiledevice() == TRUE && stristr($_SERVER['REQUEST_URI'],'mobile/') === FALSE){ // Force mobile page redirect
						$_SESSION['mobilemode'] = 'set'; /* Mobile has been detected, or chosen. */
						header("HTTP/1.1 307 Temporary Redirect");
						header("location: /mobile".$page->url());
					}
					if(stristr($page->behavior_id, 'Form')){
						$formpage = true;
					}
					$page->layout_id = 7; // Force layout change
					ob_start();
					$page->_executeLayout();
					$page = ob_get_contents();
					ob_end_clean();
	
					$page = strtr($page, array("\t" => "", "\n" => "", "\r" => "", 'href="'.URL_PUBLIC => 'href="'.URL_PUBLIC.'mobile/', 'action="'.URL_PUBLIC.'search.html' => 'action="'.URL_PUBLIC.'mobile/search.html'));
	
					$page = str_replace('="'.URL_PUBLIC.'mobile/public/', '="'.URL_PUBLIC.'public/', $page);
					$page = str_replace('="'.URL_PUBLIC.'mobile/inc/', '="'.URL_PUBLIC.'inc/', $page);
					$page = str_replace('="'.URL_PUBLIC.'mobile/includes/', '="'.URL_PUBLIC.'includes/', $page);
					$page = str_replace("rel='canonical' href='/", "rel='canonical' href='".URL_ABSOLUTE, $page);
	
					$page = str_replace("Terms of use</a></li>", "Terms</a></li>", $page);
					$page = str_replace("Privacy policy</a></li>", "Privacy</a></li>", $page);
	
					$page = preg_replace('/<!--[^[](.|\s)*?-->/', '', $page);
	
					/* Clean flattened address (minus client name) */
					if(stristr($page,'class="popup') && stristr($page,'shadowbox')){
						$page = str_replace('class="popup', 'rel="shadowbox', $page);
					}
					echo $page;
					exit();
	
				} else {
	
	
					//echo 'hello: '.$page->slug; exit;
					$newpage = '';


					// For some reason, forms with string parameters require update
					if(stristr($page->behavior_id, 'Form')){
						//echo 'hello'; exit;
						$newpage = layoutFormCss($page,$newpage);
					}
	
					// This page requires post-rebuilding as it isn't built via funky cache
					if(Plugin::isEnabled('funky_cache') == false || (Plugin::isEnabled('funky_cache') == true && $page->funky_cache_enabled == 0)){
						ob_start();
						$page->_executeLayout();
						$newpage = ob_get_contents();
					}
	
					// Funky cache calls these changes via direct functions if required. Run here only if funky cache is disabled, or enabled but this page is not cached
					if(Plugin::isEnabled('funky_cache') == false || (Plugin::isEnabled('funky_cache') == true && $page->funky_cache_enabled == 0)){
						// Form page
						$newpage = layoutScreenCss($page,$newpage);
						//$newpage = layoutScreenCss($page);
						//echo $page;
						//exit();
					}
	
					// Funky cache calls these changes via direct functions if required. Run here only if funky cache is disabled, or enabled but this page is not cached
					if(Plugin::isEnabled('funky_cache') == false || (Plugin::isEnabled('funky_cache') == true && $page->funky_cache_enabled == 0)){
						$newpage = layoutFormCss($page,$newpage);
						//$newpage = layoutFormCss($page);
						//echo $page;
						//exit();
					}
	
					// Funky cache calls these changes via direct functions if required. Run here only if funky cache is disabled
					if(Plugin::isEnabled('funky_cache') == false || (Plugin::isEnabled('funky_cache') == true && $page->funky_cache_enabled == 0)){
						//$newpage = layoutMetaTest($page,$newpage);
						//echo $page;
						//exit;
					}
	
	
	
	
					// For some reason, cached pages (when cache is disabled) return blank pages if ob_end_clean is used here
					if(Plugin::isEnabled('funky_cache') == false || (Plugin::isEnabled('funky_cache') == true && $page->funky_cache_enabled == 0)){
					//if(Plugin::isEnabled('funky_cache') == true && $page->funky_cache_enabled == 1){
	
						if($newpage != ''){
							ob_end_clean();
							echo $newpage;
							exit;
						}
					}
					//exit;
	
	
	
	
					/*
					// Ordinary Page (perform setscripts here, as last page changes)
					$cachepage = $page;
					ob_start();
					$page->_executeLayout();
					$page = ob_get_contents();
					ob_end_clean();
					$page = str_replace('<meta name="Functions" content="setscripts">', '<meta name="Functions" content="setscripts">'."\n".'<meta name="LayoutSwitch" content="setscripts">'."\n", $page);
					if($page->layout_id == '17') header('X-UA-Compatible: IE=edge,chrome=1');
					//echo $page;
					*/
	
	
					/*
					ob_start();
					$page->_executeLayout();
					$page = ob_get_contents();
					$page = layoutMetaTest($page);
					ob_end_clean();
					echo $page;
					//exit;
					*/
	
	
	
	
	
				}
			} else {
				/*
				if(stristr($page->behavior_id, 'Form')){
					ob_start();
					$page->_executeLayout();
					$page = ob_get_contents();
					ob_end_clean();
					$page = str_replace('screen.css" rel="stylesheet" media="screen">', 'form.css" rel="stylesheet" media="screen">'."\n".'<link type="text/css" href="/inc/css/screen.css" rel="stylesheet" media="screen">', $page);
					echo $page;
					exit();
				}
				*/
				
				if($page->layout_id == '17') header('X-UA-Compatible: IE=edge,chrome=1');
			}
		}
	}
}