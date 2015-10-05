<?php

if (!defined('MOBILE_VERSION')) { define('MOBILE_VERSION', '2.2.2'); }
if (!defined('MOBILE_ROOT')) { define('MOBILE_ROOT', URI_PUBLIC.'wolf/plugins/mobile_check'); }
Plugin::setInfos(array(
	'id'					=> 'mobile_check',
	'title'					=> 'Mobile Tools',
	'description'			=> 'Mobile detection checker.',
	'version'				=> MOBILE_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));

//define('MOBILE_CHECK', URI_PUBLIC.'wolf/plugins/mobile_check');
if(Plugin::getSetting('enable', 'mobile_check') == true){
	if (!defined('MOBILE_CHECK')) { define('MOBILE_CHECK', 'Enabled'); }
} else {
	if (!defined('MOBILE_CHECK')) { define('MOBILE_CHECK', 'Disabled'); }
}
if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	Plugin::addController('mobile_check', 'Mobile', 'administrator', false);
}

if(!function_exists('getMobileCheck')){
function getMobileCheck(){
	$mobile_enable = Plugin::getSetting('enable', 'mobile_check');
	return $mobile_enable;
}
}

if(!function_exists('desktopText')){
function desktopText(){
	$desktop_text = Plugin::getSetting('desktop_text', 'mobile_check');
	return $desktop_text;
}
}

if(!function_exists('mobileLogo')){
function mobileLogo(){
	$logo = Plugin::getSetting('logo', 'mobile_check');
	$logo_url = Plugin::getSetting('logo_url', 'mobile_check');
	$clientname = clientname(); ?>

	<div id="logo">
		<a href="/">
		<?php if($logo == 'logo' && $logo_url != ''){ ?>
			<img src="<?php echo $logo_url; ?>" alt="<?php echo $clientname; ?>" /><?php
		} else {
			echo $clientname;
		} ?>
		</a>
	</div>

	<?php //return $mobile_enable;
}
}

if(!function_exists('mobileTopNav')){
function mobileTopNav(){

	$topnav = Plugin::getSetting('topnav', 'mobile_check');
	$topnavhome = Plugin::getSetting('topnavhome', 'mobile_check');
	$background_url = Plugin::getSetting('background_url', 'mobile_check');

	$header_banner_home = Plugin::getSetting('header_banner_home', 'mobile_check');
	$header_banner = Plugin::getSetting('header_banner', 'mobile_check');

	/* Wrap banner in banner div, if not present within banner content itself */
	if($header_banner_home != '' && !stristr($header_banner_home, 'id="banner')){
		'<div id="banner">'.$header_banner_home.'</div>';
	}
	if($header_banner != '' && !stristr($header_banner, 'id="banner')){
		'<div id="banner">'.$header_banner.'</div>';
	}

	/* Build page object, set page to home page id, 1 */
	$page = Page::findById(1);
	$uri = $_SERVER['REQUEST_URI'];
	/* Filter out virtual pages (such as success pages) */
	if(stristr($uri,'/success'.URL_SUFFIX)){
		$uri = str_replace('/success', '', $uri);
	}
	$find = str_replace(array(URL_SUFFIX,'mobile/','search/'),array('','',''),$uri);
	$parent = $page->find($find);

	if(is_object($parent)){
	
		if($parent->url == ''){
			/* Handle banners */
			if($header_banner_home != ''){
				echo $header_banner_home;
			}
		}
	
		if($parent->url != ''){
			if($topnav == 'labels'){ ?>
	
			<ul id="menu">
			<li id="gomenu"><a href="/" title="Go to menu">Menu</a></li>
			</ul><?php } else if($topnav == 'icons'){ ?>
		
			<ul id="menu">
			<li id="gomenu" title="Go to menu"><a href="/"><img src='/inc/img/mobile/menu.png' /></a></li>
			</ul><?php } else {}
	
			/* Handle banners */
			if($header_banner != ''){
				echo $header_banner;
			}
	
		}

	}

}
}





if(!function_exists('html2rgb')){
	function html2rgb($color){
		if ($color[0] == '#')
			$color = substr($color, 1);
	
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
									 $color[2].$color[3],
									 $color[4].$color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;
	
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
		return array($r, $g, $b);
	}
}

if(!function_exists('compressspaces')){
	function compressspaces($css){
		return preg_replace("/\s+/", " ", $css);
	}
}

if(!function_exists('updateMobileCSS')){
	function updateMobileCSS(){

  		if(isset($_POST['version'])){ $version = $_POST['version']; } else { $version = Plugin::getSetting('version', 'mobile_check'); }
		if(isset($_POST['enable'])){ $enable = $_POST['enable']; } else { $enable = Plugin::getSetting('enable', 'mobile_check'); }
		if(isset($_POST['copyright'])){ $copyright = $_POST['copyright']; } else { $copyright = Plugin::getSetting('copyright', 'mobile_check'); }
		if(isset($_POST['screen_width'])){ $screen_width = $_POST['screen_width']; } else { $screen_width = Plugin::getSetting('screen_width', 'mobile_check'); }
		if(isset($_POST['tablet_width'])){ $tablet_width = $_POST['tablet_width']; } else { $tablet_width = Plugin::getSetting('tablet_width', 'mobile_check'); }
		if(isset($_POST['website_width'])){ $website_width = $_POST['website_width']; } else { $website_width = Plugin::getSetting('website_width', 'mobile_check'); }
		if(isset($_POST['desktop_text'])){ $desktop_text = $_POST['desktop_text']; } else { $desktop_text = Plugin::getSetting('desktop_text', 'mobile_check'); }
		if(isset($_POST['topnav'])){ $topnav = $_POST['topnav']; } else { $topnav = Plugin::getSetting('topnav', 'mobile_check'); }
		if(isset($_POST['theme'])){ $theme = $_POST['theme']; } else { $theme = Plugin::getSetting('theme', 'mobile_check'); }

		if(isset($_POST['logo'])){ $logo = $_POST['logo']; } else { $logo = Plugin::getSetting('logo', 'mobile_check'); }
		if(isset($_POST['logo_url'])){ $logo_url = $_POST['logo_url']; } else { $logo_url = Plugin::getSetting('logo_url', 'mobile_check'); }
		if(isset($_POST['color_body_bg'])){ $color_body_bg = $_POST['color_body_bg']; } else { $color_body_bg = Plugin::getSetting('color_body_bg', 'mobile_check'); }
		if(isset($_POST['color_body_border'])){ $color_body_border = $_POST['color_body_border']; } else { $color_body_border = Plugin::getSetting('color_body_border', 'mobile_check'); }
		if(isset($_POST['color_main_link'])){ $color_main_link = $_POST['color_main_link']; } else { $color_main_link = Plugin::getSetting('color_main_link', 'mobile_check'); }
		if(isset($_POST['color_main_text'])){ $color_main_text = $_POST['color_main_text']; } else { $color_main_text = Plugin::getSetting('color_main_text', 'mobile_check'); }
		if(isset($_POST['color_footer_link'])){ $color_footer_link = $_POST['color_footer_link']; } else { $color_footer_link = Plugin::getSetting('color_footer_link', 'mobile_check'); }
		if(isset($_POST['color_footer_text'])){ $color_footer_text = $_POST['color_footer_text']; } else { $color_footer_text = Plugin::getSetting('color_footer_text', 'mobile_check'); }
		if(isset($_POST['color_button_bg'])){ $color_button_bg = $_POST['color_button_bg']; } else { $color_button_bg = Plugin::getSetting('color_button_bg', 'mobile_check'); }
		if(isset($_POST['color_button_border'])){ $color_button_border = $_POST['color_button_border']; } else { $color_button_border = Plugin::getSetting('color_button_border', 'mobile_check'); }
		if(isset($_POST['color_button_opacity'])){ $color_button_opacity = $_POST['color_button_opacity']; } else { $color_button_opacity = Plugin::getSetting('color_button_opacity', 'mobile_check'); }
		if(isset($_POST['color_button_link'])){ $color_button_link = $_POST['color_button_link']; } else { $color_button_link = Plugin::getSetting('color_button_link', 'mobile_check'); }
		if(isset($_POST['logo_maxwidth'])){ $logo_maxwidth = $_POST['logo_maxwidth']; } else { $logo_maxwidth = Plugin::getSetting('logo_maxwidth', 'mobile_check'); }
		if(isset($_POST['viewport'])){ $viewport = $_POST['viewport']; } else { $viewport = Plugin::getSetting('viewport', 'mobile_check'); }
		if(isset($_POST['cachedcss'])){ $cachedcss = $_POST['cachedcss']; } else { $cachedcss = Plugin::getSetting('cachedcss', 'mobile_check'); }
		if(isset($_POST['color_content_bg'])){ $color_content_bg = $_POST['color_content_bg']; } else { $color_content_bg = Plugin::getSetting('color_content_bg', 'mobile_check'); }
		if(isset($_POST['color_content_h1'])){ $color_content_h1 = $_POST['color_content_h1']; } else { $color_content_h1 = Plugin::getSetting('color_content_h1', 'mobile_check'); }
		if(isset($_POST['color_content_text'])){ $color_content_text = $_POST['color_content_text']; } else { $color_content_text = Plugin::getSetting('color_content_text', 'mobile_check'); }
		if(isset($_POST['color_content_link'])){ $color_content_link = $_POST['color_content_link']; } else { $color_content_link = Plugin::getSetting('color_content_link', 'mobile_check'); }
		if(isset($_POST['content_font'])){ $content_font = $_POST['content_font']; } else { $content_font = Plugin::getSetting('content_font', 'mobile_check'); }
		if(isset($_POST['content_font_h1'])){ $content_font_h1 = $_POST['content_font_h1']; } else { $content_font_h1 = Plugin::getSetting('content_font_h1', 'mobile_check'); }
		if(isset($_POST['content_font_h2'])){ $content_font_h2 = $_POST['content_font_h2']; } else { $content_font_h2 = Plugin::getSetting('content_font_h2', 'mobile_check'); }
		if(isset($_POST['content_font_intro'])){ $content_font_intro = $_POST['content_font_intro']; } else { $content_font_intro = Plugin::getSetting('content_font_intro', 'mobile_check'); }
		if(isset($_POST['topnavhome'])){ $topnavhome = $_POST['topnavhome']; } else { $topnavhome = Plugin::getSetting('topnavhome', 'mobile_check'); }
		if(isset($_POST['background_url'])){ $background_url = $_POST['background_url']; } else { $background_url = Plugin::getSetting('background_url', 'mobile_check'); }
		if(isset($_POST['homecontent'])){ $homecontent = $_POST['homecontent']; } else { $homecontent = Plugin::getSetting('homecontent', 'mobile_check'); }
		if(isset($_POST['color_head_bg'])){ $color_head_bg = $_POST['color_head_bg']; } else { $color_head_bg = Plugin::getSetting('color_head_bg', 'mobile_check'); }
		if(isset($_POST['navpos'])){ $navpos = $_POST['navpos']; } else { $navpos = Plugin::getSetting('navpos', 'mobile_check'); }
		if(isset($_POST['homelogo'])){ $homelogo = $_POST['homelogo']; } else { $homelogo = Plugin::getSetting('homelogo', 'mobile_check'); }
		if(isset($_POST['pagelogo'])){ $pagelogo = $_POST['pagelogo']; } else { $pagelogo = Plugin::getSetting('pagelogo', 'mobile_check'); }
		if(isset($_POST['background_align'])){ $background_align = $_POST['background_align']; } else { $background_align = Plugin::getSetting('background_align', 'mobile_check'); }
		if(isset($_POST['searchbox'])){ $searchbox = $_POST['searchbox']; } else { $searchbox = Plugin::getSetting('searchbox', 'mobile_check'); }
		if(isset($_POST['logo_pos'])){ $logo_pos = $_POST['logo_pos']; } else { $logo_pos = Plugin::getSetting('logo_pos', 'mobile_check'); }
		if(isset($_POST['sidebar'])){ $sidebar = $_POST['sidebar']; } else { $sidebar = Plugin::getSetting('sidebar', 'mobile_check'); }
		if(isset($_POST['customcss'])){ $customcss = $_POST['customcss']; } else { $customcss = Plugin::getSetting('customcss', 'mobile_check'); }
		if(isset($_POST['header_banner_home'])){ $header_banner_home = $_POST['header_banner_home']; } else { $header_banner_home = Plugin::getSetting('header_banner_home', 'mobile_check'); }
		if(isset($_POST['header_banner'])){ $header_banner = $_POST['header_banner']; } else { $header_banner = Plugin::getSetting('header_banner', 'mobile_check'); }

		$color_button_bg_rgb = html2rgb($color_button_bg);
		$newcss = $cachedcss;
		
		if($color_button_opacity == 'solid'){
			$color_button_bg_rgb = $color_button_bg;
		} else {
			$color_button_bg_rgb = $color_button_bg_rgb[0].','.$color_button_bg_rgb[1].','.$color_button_bg_rgb[2];
		}

		/* Get CSS Template */
		ob_start();
		include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/mobile_check/lib/mobile.php";
		$mobilecsstemplate = ob_get_contents();
		ob_end_clean();

		/* Remove comments array */
		$regex = array(
		"`^([\t\s]+)`ism"=>'',
		"`^\/\*(.+?)\*\/`ism"=>"",
		"`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
		"`([\n\A;\s]+)//(.+?)[\n\r]`ism"=>"$1\n",
		"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
		);

		/* Remove comments from CSS Template */
		$mobilecsstemplate = preg_replace(array_keys($regex),$regex,$mobilecsstemplate);

		/* Get public mobile css */
		$mobilecsspath = '/inc/css/';
		$mobilecssfile = 'mobile.css';
		$mobilecssfilepath = $_SERVER{'DOCUMENT_ROOT'}.$mobilecsspath.$mobilecssfile;

		/* Try updating mobile css */
		if (file_exists($mobilecssfilepath)) {
			chmod($mobilecssfilepath, 0777);
			if(is_writable($mobilecssfilepath)){
				$csssave = fopen($mobilecssfilepath,'rb');
				$csscontents = fread($csssave, filesize($mobilecssfilepath));
				/* Check to make sure no changes have been made directly to mobile.css since last save. */
				if(DEBUG != true){
					if($csscontents != $cachedcss && Plugin::getSetting('clientname', 'clientdetails') == 'Blue Horizons Client'){
						//Flash::set('error', 'Warning. Cannot save changes because mobile.css has been changed manually.');
						//redirect(get_url('plugin/mobile_check/settings'));
					}
				}
				if($csssave == ''){
					Flash::set('error', $mobilecssfilepath.' ... cannot be read.');
					redirect(get_url('plugin/mobile_check/settings'));
				}
				if($mobilecsstemplate != ''){
					$mobilecss = $mobilecsstemplate;
				} else {
					Flash::set('error', $mobilecssfilepath.' ... cannot be updated.');
					redirect(get_url('plugin/mobile_check/settings'));
				}
				if($mobilecsstemplate != '' && $csscontents != $mobilecsstemplate){
					$csssave = fopen($mobilecssfilepath,'w+');
					// Update mobile.css if not empty and contains no php error notices.
					if($mobilecss != '' && !stristr($mobilecss, '<b>Notice</b>:') && !stristr($mobilecss, ' on line <b>')){
						if(DEBUG == true){
							$newcss = $mobilecss;
						} else {
							$newcss = compressspaces($mobilecss);							
						}
						fwrite($csssave,$newcss);
					} else {
						Flash::set('error', 'Errors in css template.');
						redirect(get_url('plugin/mobile_check/settings'));
					}
					chmod($mobilecssfilepath, 0644);
				}
				fclose($csssave);
			} else {
				Flash::set('error', $mobilecssfilepath.' ... is not writable.');
			}
		} else {
			Flash::set('error', $mobilecssfilepath.' ... does not exist.');
			//redirect(get_url('plugin/mobile_check/settings'));
		}

		ob_start();
		include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/mobile_check/lib/toggle.js";
		$toggletemplate = ob_get_contents();
		ob_end_clean();

		$toggletemplate = preg_replace(array_keys($regex),$regex,$toggletemplate);
		$togglepath = '/inc/js/';
		$togglefile = 'toggle.js';
		$togglefilepath = $_SERVER{'DOCUMENT_ROOT'}.$togglepath.$togglefile;
		if (file_exists($togglefilepath)) {
			chmod($togglefilepath, 0777);
			if(is_writable($togglefilepath)){
				$togglesave = fopen($togglefilepath,'rb');
				$togglecontents = fread($togglesave, filesize($togglefilepath));
				if($togglesave == ''){
					Flash::set('error', $togglefilepath.' ... cannot be read.');
						redirect(get_url('plugin/mobile_check/settings'));
				}
				if($toggletemplate != ''){
					$toggle = $toggletemplate;
				} else {
					Flash::set('error', $togglefilepath.' ... cannot be updated.');
						redirect(get_url('plugin/mobile_check/settings'));
				}
				if($toggletemplate != '' && $togglecontents != $toggletemplate){
					$togglesave = fopen($togglefilepath,'w+');
					if($toggle != '' && !stristr($toggle, '<b>Notice</b>:') && !stristr($toggle, ' on line <b>')){
						$newtoggle = compressspaces($toggle);
						fwrite($togglesave,$newtoggle);
					} else {
						Flash::set('error', 'Errors in toggle template.');
						redirect(get_url('plugin/mobile_check/settings'));
					}
					chmod($togglefilepath, 0644);
				}
				fclose($togglesave);
			} else {
				Flash::set('error', $togglefilepath.' ... is not writable.');
			}
		} else {
			Flash::set('error', $togglefilepath.' ... does not exist.');
		}

		ob_start();
		include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/mobile_check/lib/nav.css";
		$navtemplate = ob_get_contents();
		ob_end_clean();

		$navtemplate = preg_replace(array_keys($regex),$regex,$navtemplate);
		$navpath = '/inc/css/';
		$navfile = 'nav.css';
		$navfilepath = $_SERVER{'DOCUMENT_ROOT'}.$navpath.$navfile;
		if (file_exists($navfilepath)) {
			chmod($navfilepath, 0777);
			if(is_writable($navfilepath)){
				$navsave = fopen($navfilepath,'rb');
				$navcontents = fread($navsave, filesize($navfilepath));
				if($navsave == ''){
					Flash::set('error', $navfilepath.' ... cannot be read.');
						redirect(get_url('plugin/mobile_check/settings'));
				}
				if($navtemplate != ''){
					$nav = $navtemplate;
				} else {
					Flash::set('error', $navfilepath.' ... cannot be updated.');
						redirect(get_url('plugin/mobile_check/settings'));
				}
				if($navtemplate != '' && $navcontents != $navtemplate){
					$navsave = fopen($navfilepath,'w+');
					if($nav != '' && !stristr($nav, '<b>Notice</b>:') && !stristr($nav, ' on line <b>')){
						$newnav = compressspaces($nav);
						fwrite($navsave,$newnav);
					} else {
						Flash::set('error', 'Errors in cms template.');
						redirect(get_url('plugin/mobile_check/settings'));
					}
					chmod($navfilepath, 0644);
				}
				fclose($navsave);
			} else {
				Flash::set('error', $navfilepath.' ... is not writable.');
			}
		} else {
			Flash::set('error', $navfilepath.' ... does not exist.');
		}
		
		$settings = array(	'version' => $version,
				  			'enable' => $enable,
				  			'copyright' => $copyright,
							'screen_width' => $screen_width,
							'tablet_width' => $tablet_width,
							'website_width' => $website_width,
							'logo' => $logo, 
							'logo_url' => $logo_url,
							'desktop_text' => $desktop_text,
							'topnav' => $topnav,
							'theme' => $theme,
							'color_body_bg' => $color_body_bg,
							'color_body_border' => $color_body_border,
							'color_main_link' => $color_main_link,
							'color_main_text' => $color_main_text,
							'color_footer_link' => $color_footer_link,
							'color_footer_text' => $color_footer_text,
							'color_button_bg' => $color_button_bg,
							'color_button_border' => $color_button_border,
							'color_button_opacity' => $color_button_opacity,
							'color_button_link' => $color_button_link,
							'logo_maxwidth' => $logo_maxwidth,
							'viewport' => $viewport,

							'color_content_bg' => $color_content_bg,
							'color_content_h1' => $color_content_h1,
							'color_content_text' => $color_content_text,
							'color_content_link' => $color_content_link,
							'content_font' => $content_font,

							'content_font_h1' => $content_font_h1,
							'content_font_h2' => $content_font_h2,
							'content_font_intro' => $content_font_intro,

							'cachedcss' => $newcss,
							'topnavhome' => $topnavhome,
							'background_url' => $background_url,
							'homecontent' => $homecontent,
							'color_head_bg' => $color_head_bg,
							'navpos' => $navpos,
							'homelogo' => $homelogo,
							'pagelogo' => $pagelogo,
							'background_align' => $background_align,
							'searchbox' => $searchbox,
							'logo_pos' => $logo_pos,
							'sidebar' => $sidebar,
							'customcss' => $customcss,
							'header_banner_home' => $header_banner_home,
							'header_banner' => $header_banner);


			/* Copy nav js required files (overwrite if exists, should images be updates) */
			if($navpos == 'header'){
				$hamburger = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/hamburger-inverted.gif';
				$hamburger_retina = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/hamburger-inverted-retina.gif';

			} else {
				$hamburger = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/hamburger.gif';
				$hamburger_retina = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/mobile_check/lib/hamburger-retina.gif';
			}
			$new_hamburger = $_SERVER{'DOCUMENT_ROOT'}.'/inc/img/hamburger.gif';
			$new_hamburger_retina = $_SERVER{'DOCUMENT_ROOT'}.'/inc/img/hamburger-retina.gif';
			if (!copy($hamburger, $new_hamburger)) {
				Flash::set('error', 'Failed to copy hamburger.gif');
			}
			if (!copy($hamburger_retina, $new_hamburger_retina)) {
				Flash::set('error', 'Failed to copy hamburger-retina.gif');
			}


			return $settings;
		
}
}


if(!function_exists('mobileHomeNav')){
function mobileHomeNav($parent){

	$topnav = Plugin::getSetting('topnav', 'mobile_check');
	$topnavhome = Plugin::getSetting('topnavhome', 'mobile_check');
	$background_url = Plugin::getSetting('background_url', 'mobile_check');

	/* Build page object, set page to home page id, 1 */
	$page = Page::findById(1);
	$uri = $_SERVER['REQUEST_URI'];
	/* Filter out virtual pages (such as success pages) */
	if(stristr($uri,'/success'.URL_SUFFIX)){
		$uri = str_replace('/success', '', $uri);
	}
	$find = str_replace(array(URL_SUFFIX,'mobile/','search/'),array('','',''),$uri);
	$parent = $page->find($find);

	if(is_object($parent)){

		if($parent && $parent->url == ''){
			$parent->includeSnippet('mobilemenu');
		}
	
		if($parent->url != '' && $topnav == 'menu'){
			//echo '<div role="navigation" id="nav"><ul>';
			//ob_start();
			$parent->includeSnippet('mobilemenu');
			//$menu = ob_get_contents();
	  		//ob_end_clean();
	  		//echo strip_tags($menu,'<li><a>');
			//echo '</ul></div>';
	
		}
	
	}

}
}


if(!function_exists('mobileHead')){
function mobileHead(){
	
	$topnav = Plugin::getSetting('topnav', 'mobile_check');
	$topnavhome = Plugin::getSetting('topnavhome', 'mobile_check');
	$background_url = Plugin::getSetting('background_url', 'mobile_check');

	/* Build page object, set page to home page id, 1 */
	$page = Page::findById(1);
	$uri = $_SERVER['REQUEST_URI'];
	/* Filter out virtual pages (such as success pages) */
	if(stristr($uri,'/success'.URL_SUFFIX)){
		$uri = str_replace('/success', '', $uri);
	}
	$find = str_replace(array(URL_SUFFIX,'mobile/','search/'),array('','',''),$uri);
	$parent = $page->find($find);


	// Check if page is unavailable/503
	//if($DATABASE_UNAVAILABLE == true) $parent = $page->find('template');


	//echo '<script>alert("'.$parent->url.'");</script>';
	

	if(is_object($parent)){
		if($parent->url == '' && $topnavhome != 'disabled'){
			?>
			<script>document.write("<link rel='stylesheet' href='/inc/css/nav.css' type='text/css'>");</script>
			<script src='/inc/js/nav.js'></script>
			<?php
		}
		
		if($parent->url != '' && $topnav == 'menu'){ ?>
			<script>document.write("<link rel='stylesheet' href='/inc/css/nav.css' type='text/css'>");</script>
			<script src='/inc/js/nav.js'></script>
			<?php
		}
	}
}
}


if(!function_exists('mobileFoot')){
function mobileFoot(){

	$topnav = Plugin::getSetting('topnav', 'mobile_check');
	$topnavhome = Plugin::getSetting('topnavhome', 'mobile_check');
	$background_url = Plugin::getSetting('background_url', 'mobile_check');

	/* Build page object, set page to home page id, 1 */
	$page = Page::findById(1);
	$uri = $_SERVER['REQUEST_URI'];
	/* Filter out virtual pages (such as success pages) */
	if(stristr($uri,'/success'.URL_SUFFIX)){
		$uri = str_replace('/success', '', $uri);
	}
	$find = str_replace(array(URL_SUFFIX,'mobile/','search/'),array('','',''),$uri);
	$parent = $page->find($find);
	
	if(is_object($parent)){

		if($parent->url == '' && $topnavhome != 'disabled'){ ?>
			<script src="/inc/js/toggle.js"></script>
			<?php
		}
	
		if($parent->url != '' && $topnav == 'menu'){ ?>
			<script src="/inc/js/toggle.js"></script>
			<?php
		}
		
	}

}
}



if(!function_exists('getmobilecontent')){
function getmobilecontent($parent,$scripts=false){
	$homecontent = Plugin::getSetting('homecontent', 'mobile_check');
	if($parent->slug != '' || ($parent->slug == '' && $homecontent != 'disabled')){
		mobilecontent($parent,true);
	}
}
}



if(!function_exists('mobilesidebar')){
function mobilesidebar($parent){
	if(Plugin::getSetting('sidebar', 'mobile_check') != 'false' && (strlen($parent->content('sidebar')) > 0 && $parent->slug != '' && $parent->slug != 'news')){ ?>
	<div id="sidebar">
	<?php echo $parent->content('sidebar', true); ?>
	</div>
	<?php }
}
}