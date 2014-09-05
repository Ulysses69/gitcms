<?php

Plugin::setInfos(array(
	'id'						=> 'banner5',
	'title'						=> 'Banner 5',
	'description'				=> 'Lets you add a HTML5 banner to pages.',
	'version'					=> '0.5.0',
	'license'					=> 'GPLv3',
	'require_wolf_version'		=> '0.5.5'
));

Behavior::add('Banner', '');

/* Ensure Elements plugin is enabled */
//if(Plugin::isEnabled('elements') == true){

	if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
		Plugin::addController('banner5', 'Banner');
	}

	//Observer::observe('page_found', 'banner5');
	require 'lib/files.php';


	function banner5($page) {

		$servpath 			= dirname(__FILE__);
		$bannerid			= Plugin::getSetting('bannerid', 'banner5');
		$bannerwidth		= Plugin::getSetting('bannerwidth', 'banner5');
		$bannerheight		= Plugin::getSetting('bannerheight', 'banner5');
		$bannerradius		= Plugin::getSetting('bannerradius', 'banner5');
		$bannercode			= Plugin::getSetting('bannercode', 'banner5');
		$bannerimages		= Plugin::getSetting('bannerimages', 'banner5');
		$bannerinclude		= Plugin::getSetting('bannerinclude', 'banner5');
		$bannerexclude		= Plugin::getSetting('bannerexclude', 'banner5');
		$imagesarray		= Plugin::getSetting('imagesarray', 'banner5');
		$descriptionsarray	= Plugin::getSetting('descriptionsarray', 'banner5');
		$pref_controls		= Plugin::getSetting('pref_controls', 'banner5');
		$pref_random		= Plugin::getSetting('pref_random', 'banner5');
		$pref_preload		= Plugin::getSetting('pref_preload', 'banner5');
		$pref_transition	= Plugin::getSetting('pref_transition', 'banner5');
		$pref_burns			= Plugin::getSetting('pref_burns', 'banner5');
		$pref_burntime		= Plugin::getSetting('pref_burntime', 'banner5');
		$pref_time			= Plugin::getSetting('pref_time', 'banner5');
		$pref_pause			= Plugin::getSetting('pref_pause', 'banner5');
		$pref_delay			= Plugin::getSetting('pref_delay', 'banner5');
		
		//echo $servpath."\n";
		//echo $bannerimages."\n";
	
		if (stristr($servpath, '/')){
			$strike = '/';
			$bannerpath = $bannerimages;
			$servpath = str_replace('/wolf/plugins/banner5','',$servpath);
		} else {
			$strike = '\\';
			$bannerpath = str_replace('/','\\',$bannerimages);
			$servpath = str_replace('\wolf\plugins\banner5','',$servpath);
		}
	
		if($pref_controls == 'false'){ $pref_controls							= 'showControls="'.$pref_controls.'" ';} else { $pref_controls = ''; }
		if($pref_random == 'true'){ $pref_random								= 'randomizeImages="'.$pref_random.'" ';} else { $pref_random = ''; }
		if($pref_preload >= '0' && $pref_preload <= '1000'){ $pref_preload		= 'preloadImages="'.$pref_preload.'" ';} else { $pref_preload = ''; }
		if($pref_transition != 'noTransition'){ $pref_transition				= 'imageTransition="'.$pref_transition.'" ';} else { $pref_transition = ''; }
		if($pref_burns != 'none'){ $pref_burns									= 'kenBurnsMode="'.$pref_burns.'" ';} else { $pref_burns = ''; }
		if($pref_burntime >= '0' && $pref_burntime <= '1000'){ $pref_burntime	= 'kenBurnsTime="'.$pref_burntime.'" ';} else { $pref_burntime = ''; }
		if($pref_time >= '0' && $pref_time <= '1000'){ $pref_time				= 'imageTransitionTime="'.$pref_time.'" ';} else { $pref_time = ''; }
		if($pref_pause >= '0.5'){ $pref_pause									= 'imagePause="'.$pref_pause.'" ';} else { $pref_pause = ''; }
		$pref_loadicon															= 'showLoadingIcon="false" '; // "true", "false"
	
		$bann = '<?xml version="1.0" encoding="UTF-8" ?>';
		$bann .= "<slideshow>";
		$bann .= "<preferences ";
		$bann .= $pref_loadicon.$pref_controls.$pref_random.$pref_preload.$pref_transition.$pref_burns.$pref_burntime.$pref_time.$pref_pause;
		$bann .= "/>";
		$bann .= banner5files($servpath.$bannerpath, $bannerimages, 'xml');
		$bann .= "<slideshow>";

		return $bann;
	}


 function banner5js($page=null){
		$bannerid		= Plugin::getSetting('bannerid', 'banner5');
		$bannerwidth	= Plugin::getSetting('bannerwidth', 'banner5');
		$bannerheight	= Plugin::getSetting('bannerheight', 'banner5');
		$bannerradius	= Plugin::getSetting('bannerradius', 'banner5');
		$bannerinclude	= Plugin::getSetting('bannerinclude', 'banner5');
		$bannerexclude	= Plugin::getSetting('bannerexclude', 'banner5');

		$pageslug = $page->slug;
		if($pageslug == null){
			$pageslug = 'home';
		}
		if($bannerinclude == null && $bannerexclude != null){
			$bannerinclude = 'all';
		}

		if(stristr($bannerinclude,$pageslug) || $bannerinclude == 'all'){
				$bannerxml	= '/banner5.xml';
		
				/*
				return '
				<script type="text/javascript">
				<!--// <![CDATA[
				var so = new SWFObject("/inc/img/banner5.swf", "flashbanner", "'.$bannerwidth.'", "'.$bannerheight.'", "7", "#ffffff");
				so.addParam("AllowScriptAccess", "always");
				so.addParam("wmode", "transparent");
				so.addVariable("showLogo", "false");
				so.addVariable("showVersionInfo", "false");
				so.addVariable("dataFile", "'.$bannerxml.'");
				so.write("'.$bannerid.'");
				// -->
				</script>
				';
				*/
		
				$flash = 'if(document.getElementById("'.$bannerid.'")){';
				$flash .= 'var fb = new SWFObject("/inc/img/bannerInstall.swf", "flashbanner", "'.$bannerwidth.'", "'.$bannerheight.'", "7", "#ffffff");';
				$flash .= 'fb.addParam("AllowScriptAccess", "always");';
				$flash .= 'fb.addParam("wmode", "transparent");';
				$flash .= 'fb.addVariable("loadDelay", "'.($pref_delay + $pref_time).'");';
				$flash .= 'fb.addVariable("showLogo", "false");';
				$flash .= 'fb.addVariable("showVersionInfo", "false");';
				$flash .= 'fb.addVariable("dataFile", "'.$bannerxml.'");';
				if($bannerradius > 0){ $flash .= 'fb.addVariable("borderRadius", "'.$bannerradius.'");'; }
				$flash .= 'fb.write("'.$bannerid.'");';
				$flash .= '};';
			
				return $flash;
				
		}
	
	}

//}