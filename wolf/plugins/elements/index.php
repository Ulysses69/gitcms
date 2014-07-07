<?php
Plugin::setInfos(array(
    'id'          => 'elements',
    'title'       => 'Elements',
    'description' => 'Elements and attributes',
    'version'     => '1.0.0')
);

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	Plugin::addController('elements', __('Elements'), 'administrator', false);
}

Observer::observe('page_found', 'jselements');
Observer::observe('page_found', 'runelements');

// echo jselements();

function jselements($page = null){

	if(is_object($page)){
		//$page = $this;
		$scrollanchor = FALSE; $scrollspeed = 1000;
		$compress = FALSE;
		$iefocus = FALSE;
		$jshead = ''; $jsbody = ''; $headelements = ''; $bodyelements = ''; $jsdate = ''; $scroll = '';
	
		// $pagelist = Plugin::getSetting('pagelist', 'elements');
		$createElement = 'ce';
		$createAttribute = 'ca';
	
		$jsheadpath = '/inc/js/';
		$jsheadfile = 'jhead.js';
		$jsheadfilepath = $_SERVER{'DOCUMENT_ROOT'}.$jsheadpath.$jsheadfile;
	
		$jsbodypath = '/inc/js/';
		$jsbodyfile = 'jbody.js';
		$jsbodyfilepath = $_SERVER{'DOCUMENT_ROOT'}.$jsbodypath.$jsbodyfile;
	
		if(stristr($page->content,'class="popup')){
			$headelements .= "if(Shadowbox){\n";
			$headelements .= "document.write('<link rel=\"stylesheet\" href=\"/inc/css/shadowbox.css\" />');\n";
			$headelements .= "Shadowbox.init();\n";
			$headelements .= "};";
		}
	
		$jshead = $headelements.$scroll;
		if (file_exists($jsheadfilepath)) {
			// echo "The file $jsbodyfilepath exists";
			chmod($jsheadfilepath, 0777);
			if(is_writable($jsheadfilepath)){
				if($compress == TRUE){
					require_once 'lib/class.JavaScriptPacker.php';
					$packer = new JavaScriptPacker($jshead, 'Normal', true, false);
					$packed = $packer->pack();
				} else {
					$packed = $jshead;
				}
				if($packed != file_get_contents($jsheadfilepath) && $jshead != ''){
					$jssave = fopen($jsheadfilepath,'w') or die("can't open file " . $jsheadfilepath);
					/* Force cache */
					fwrite($jssave, $packed);
					chmod($jsheadfilepath, 0644);
					/* Display message if in backend */
					//Flash::set('success', 'Elements - '.__('head js has successfully updated.'));
					$flashresult = 'have successfully updated.';
					Flash::set('success', 'Elements - '.__('settings '.$flashresult));
				}
			} else {
				chmod($jsheadfilepath, 0644);
				/* Display message if in backend */
				$flashresult = 'are not writable.';
				Flash::set('error', 'Elements - '.__('settings '.$flashresult));
			}
		} else {
			// echo "The required file $jsbodyfilepath does not exist.";
		}
	
		// $imgpath = '/inc/img/';
		// $imgsrc = 'link.gif';
	
	
		//if($iefocus == TRUE){ $bodyelements .= "(function($){$.pseudoFocus=function(){var focusIsSupported=(function(){var ud='t'+ +new Date(),anchor=$('<a id=\"'+ud+'\" href=\"#\"/>').css({top:'-999px',position:'absolute'}).appendTo('body'),style=$('<style>#'+ud+'{font-size:10px;}#'+ud+':focus{font-size:1px !important;}</style>').appendTo('head'),supported=anchor.focus().css('fontSize')!=='10px';anchor.add(style).remove();return supported})();if(focusIsSupported){return}var stylesToAdd=[],pseudoRegex=/:(unknown|focus)/,className='focus';$(document.styleSheets).each(function(i,sheet){var cssRules=sheet.cssRules||sheet.rules;$.each(cssRules,function(i,rule){$.each(rule.selectorText.split(','),function(i,selector){var hasPseudoFocus=pseudoRegex.test(selector);if(hasPseudoFocus){var styles=rule.cssText?rule.cssText.match(/\{(.+)\}/)[1]:rule.style.cssText,newSelector=selector.replace(pseudoRegex,'.'+className);selector=selector.replace(pseudoRegex,'');stylesToAdd[stylesToAdd.length]=newSelector+'{'+styles+'}';$(selector).each(function(){var isAcceptable='a,input,textarea,button';$($(this).is(isAcceptable)?this:$(this).parents(isAcceptable)[0]).bind('focus.pseudoFocus',function(){$(this).addClass(className)}).bind('blur.pseudoFocus',function(){$(this).removeClass(className)});if($(this).is('a')){$(this).bind('click.pseudoFocus',function(){$(this).blur()})}})}})})});stylesToAdd&&$('head').append('<style>'+stylesToAdd.join('')+'</style>')}})(jQuery);\n"; }
	
		$bodyelements .= "function ".$createElement."(parentid,targetid){\n var p=document.getElementById(parentid).getElementsByTagName(targetid);\n";
		// $jsbody .= "for(i=0;i<p.length;i++){var c=document.createElement('img');c.src='".$imgpath.$imgsrc."';c.alt=p[i].innerHTML;p[i].insertBefore(c,p[i].firstChild);}};";
		$bodyelements .= "for(i=0;i<p.length;i++){\n var c=document.createElement('span');\n p[i].insertBefore(c,p[i].firstChild);\n };\n };\n";
		$bodyelements .= "document.write('<link rel=\"stylesheet\" href=\"/inc/css/styles.css\" />');\n";
		$bodyelements .= "function ".$createAttribute."(parentid,targetid,attr){\n var p=document.getElementById(parentid);\n";
		$bodyelements .= "if(p){\n var t=document.createAttribute(targetid);\n t.value=attr;\n p.setAttributeNode(t);\n };\n };\n";
	
		$bodyelements .= "window.onload=function(){\n";
	/* Create elements (parent id, child tag) */
		$bodyelements .= $createElement."('navigation','a');\n";
		//if(defined('NAVIGATION')) $bodyelements .= $createElement."('navigation','a');\n";
		$bodyelements .= $createElement."('sidemenu','a');\n";
		$bodyelements .= $createElement."('home-go','a');\n";
		$bodyelements .= $createElement."('content','h1');\n";
	/* Add landmark roles (element id, attribute, value) */
		$bodyelements .= $createAttribute."('main','role','main');\n";
		$bodyelements .= $createAttribute."('test','role','navigation');\n";
		$bodyelements .= $createAttribute."('navigation','role','navigation');\n";
		$bodyelements .= $createAttribute."('sidemenu','role','navigation');\n";
		$bodyelements .= $createAttribute."('crumbs','role','navigation');\n";
		$bodyelements .= $createAttribute."('links','role','navigation');\n";
		$bodyelements .= $createAttribute."('legal','role','navigation');\n";
		$bodyelements .= $createAttribute."('searchbox','role','search');\n";
		$bodyelements .= $createAttribute."('features','role','complementary');\n";
		$bodyelements .= $createAttribute."('footer','role','contentinfo');\n";
		if($iefocus == TRUE){ $bodyelements .= "$.pseudoFocus();\n"; }
		$bodyelements .= "};";
	
	/* Add scrolling to internal links */
		if($scrollanchor == TRUE){
			$scroll .= "$(function(){\n";
			$scroll .= "$('a[href*=#]').click(function(){\n";
			$scroll .= "if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')\n";
			$scroll .= "&& location.hostname == this.hostname){\n";
			$scroll .= "var \$target = $(this.hash);\n";
			$scroll .= "var \$targethash = this.hash;\n";
			$scroll .= "\$target = \$target.length && \$target || $('[name=' + this.hash.slice(1) +']');\n";
			$scroll .= "if (\$target.length){\n";
			$scroll .= "var targetOffset = \$target.offset().top;\n";
			$scroll .= "$('html,body').animate({scrollTop: targetOffset}, ".$scrollspeed.");\n";
			$scroll .= "\$targethash.focus();\n";
			$scroll .= "return false;\n";
			$scroll .= "}\n";
			$scroll .= "}\n";
			$scroll .= "});\n";
			$scroll .= "});\n";
		} else {
			$scroll = '';
		}
	
		$jsbody = $bodyelements.$scroll;
		//$jsbody = $bodyelements.$headscripts;
		if (file_exists($jsbodyfilepath)) {
			// echo "The file $jsbodyfilepath exists";
			chmod($jsbodyfilepath, 0777);
			if(is_writable($jsbodyfilepath)){
				if($compress == TRUE){
					require_once 'lib/class.JavaScriptPacker.php';
					$packer = new JavaScriptPacker($jsbody, 'Normal', true, false);
					$packed = $packer->pack();
				} else {
					$packed = $jsbody;
				}
				if($packed != file_get_contents($jsbodyfilepath) && $jsbody != ''){
					$jssave = fopen($jsbodyfilepath,'w') or die("can't open file " . $jsbodyfilepath);
					/* Force cache */
					fwrite($jssave, $packed);
					chmod($jsbodyfilepath, 0644);
					/* Display message if in backend */
					$flashresult = 'have successfully updated.';
					Flash::set('success', 'Elements - '.__('settings '.$flashresult));
				} else {
					$flashresult = 'do not require updating.';
				}
			} else {
				chmod($jsbodyfilepath, 0644);
				/* Display message if in backend */
				$flashresult = 'are not writable.';
				Flash::set('error', 'Elements - '.__('settings '.$flashresult));
			}
		} else {
			// echo "The required file $jsbodyfilepath does not exist.";
		}
	
		//$jsdate = '?recipe=vol'.time($jsbodyfilepath);
	
		if($scrollanchor == TRUE){ echo "<script type='text/javascript' src='".$jsbodypath."jquery.js'></script>\n"; }
		if($scrollanchor == TRUE){ echo "<script type='text/javascript' src='".$jsbodypath."jquery.scrollTo.js'></script>\n"; }
		//echo "<script type='text/javascript' src='/inc/js/swfobject.js'></script>\n";
		//echo '<script type="text/javascript" src="'.$jsbodypath.$jsbodyfile.$jsdate.'"></script>'."\n";
	
		define('ELEMENTSresult','<p>Page elements '.$flashresult.'</p>');
	}
}

function runelements($page = null){
	/*
	if(stristr($page->content(),'class="popup')){
		ob_start();
		$page->includeSnippet('registerfunctions'); // Include custom functions snippet
		$page->_executeLayout();
		$page = ob_get_contents();
		ob_end_clean();
		$page = str_replace('class="popup', 'rel="shadowbox', $page);
		echo $page;
		exit();
	}
	*/
}