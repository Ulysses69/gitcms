<?php

if (!defined('JSCRIPTS_VERSION')) { define('JSCRIPTS_VERSION', '3.6.8'); }
Plugin::setInfos(array(
	'id'		  => 'jscripts',
	'title'	   => 'jScripts',
	'description' => 'Provides organisation of external javascript and css files',
	'version'	 => JSCRIPTS_VERSION)
);

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	Plugin::addController('jscripts', __('jScripts'), 'administrator', false);
}

$embedding = Plugin::getSetting('embedding', 'jscripts');
if($embedding == 'auto'){
	Observer::observe('page_found', 'jscripts');
}

Observer::observe('page_edit_after_save', 'save_jscripts');
Observer::observe('layout_after_edit', 'save_jscripts');
Observer::observe('snippet_after_edit', 'save_jscripts');


/* Call jscripts whenever page, snippet or layout is saved */
if(!function_exists('save_jscripts')){
function save_jscripts($page){
	// Call jscripts (page, javascript to add, place before or after jscripts template content)
	writeJScripts($page);
}
}

if(!function_exists('buildscripts')){
function buildscripts($page, $insertref, $checkup = false){
	
	$scripts = '';
	//$scripts .= "<!-- BUILDSCRIPTS is running in ".$insertref." on ". $page->slug ." page -->\n";
	//$scripts .= "<!-- BUILDSCRIPTS DUMP \n insertref: " . $insertref . " \n SETHEADSCRIPTS: " . SETHEADSCRIPTS . " \n page->setheadscripts: " . $page->setheadscripts . " \n SETBODYSCRIPTS: " . SETBODYSCRIPTS . " \n page->setbodyscripts: " . $page->setbodyscripts . " -->\n";
	//if($checkup == true) $scripts .= "<!-- BUILDSCRIPTS is in checkup mode -->\n";
	//if(($page->funky_cache_enabled && ($insertref == 'head' && $page->setheadscripts != 'called') || ($insertref == 'body' && $page->setbodyscripts != 'called')) || ($insertref == 'head' && (!defined('SETHEADSCRIPTS') || SETHEADSCRIPTS != 'yes' || (isset($page->setheadscripts) && $page->setheadscripts != 'called'))) || ($insertref == 'body' && (!defined('SETBODYSCRIPTS') || SETBODYSCRIPTS != 'yes' || (isset($page->setbodyscripts) && $page->setbodyscripts != 'called')))){
	if(isset($page->setheadscripts)){ $setheadscripts = $page->setheadscripts; } else { $setheadscripts = ''; }
	if(isset($page->setbodyscripts)){ $setbodyscripts = $page->setbodyscripts; } else { $setbodyscripts = ''; }
	if(($insertref == 'head' && $setheadscripts != 'called') || ($insertref == 'body' && $setbodyscripts != 'called')){

		//echo '<!-- buildscripts running: pagetitle = '.$page->title.' and insertref = '.$insertref." -->\n";

		$rows = Plugin::getSetting('rows', 'jscripts');
		
		for($r=0;$r<$rows;$r++){
			${'script'.$r} = Plugin::getSetting('script'.$r, 'jscripts');
			${'include'.$r} = Plugin::getSetting('include'.$r, 'jscripts');
			${'exclude'.$r} = Plugin::getSetting('exclude'.$r, 'jscripts');
			${'insert'.$r} = Plugin::getSetting('insert'.$r, 'jscripts');
		}
	
		for($r=0;$r<$rows;$r++){
	
			$thisscript = '';
			$pagelevel = '';
			$defer = '';
			$script = ${'script'.$r};
			$include = ${'include'.$r};
			$exclude = ${'exclude'.$r};
			$insert = ${'insert'.$r};
			$pageslug = $page->slug;
			$pageid = $page->id;
	
	
			if($pageslug == null || $pageslug == ''){
				$pageslug = 'home';
			}
			if($include == null && $exclude != null){
				$include = 'all';
			}
			if(function_exists('pagelevel')){
				if(stristr($include,pagelevel($page))){
					$pagelevel = TRUE;
				}
			}

			/* Determine script type (remove for HTML5) */
			if($page->layout_id == '17' || (is_object($page->parent) && $page->parent->layout_id == '17')){
				$script_type = '';
			} else {
				$script_type = ' type="text/javascript"';
			}

			if(stristr($include,$pageslug) || stristr($include,$pageid) || $pagelevel == TRUE || $include == 'all'){
	
				//echo $pageslug;
	
				if($include == 'all'){
					if(!stristr($exclude,$pageslug) && !stristr($exclude,$pageid)){
						$thisscript .= $script;
					}
				} else {
					$thisscript .= $script;
				}
	
				// Embed script in head or body
				if($insertref == $insert){

					//echo '<!-- buildscripts: insertref = '.$insertref.' and insert = '.$insert." -->\n";
					
					$cachedscript = $thisscript; if(function_exists('cachescript')){ $cachedscript = cachescript($thisscript); }
	
					if(stristr($thisscript,'.js')){
						$scripts .= '<script'.$script_type.' src="'.$cachedscript.'"'.$defer.'></script>'."\n";
						// Serve jQuery by CDN or default to local
						if(stristr($scripts,'ajax.googleapis.com/ajax/libs/jquery')){
							$jq = '<script'.$script_type.'>';
							$jq .= 'if(typeof jQuery == \'undefined\'){';
							$jq .= 'document.write(unescape("%3Cscript src=\'/inc/js/jquery.js\' type=\'text/javascript\'%3E%3C/script%3E"));';
							$jq .= '}';
							$jq .= '</script>'."\n";
							if(!stristr($scripts,$jq)) $scripts .= $jq;
						}
						
						//echo '<!-- buildscripts: scripts = '.$scripts." -->\n";
	
					} else if(stristr($thisscript,'.css')){
						$scripts .= '<link type="text/css" href="'.$cachedscript.'" rel="stylesheet" media="screen" />'."\n";
						//echo '<!-- buildscripts: scripts = '.$scripts." -->\n";
	
					} else {
						$scripts .= $thisscript."\n";
					}
				}

			}
	
		}

		if($insertref == 'head' && $checkup != true){ setglobal('SETHEADSCRIPTS','yes'); $page->setheadscripts = 'called'; }
		if($insertref == 'body' && $checkup != true){ setglobal('SETBODYSCRIPTS','yes'); $page->setbodyscripts = 'called'; }

	}
	
	//if($insertref == 'head' && $checkup != true){ setglobal('SETHEADSCRIPTS','yes'); $page->setheadscripts = 'called'; }
	//if($insertref == 'body' && $checkup != true){ setglobal('SETBODYSCRIPTS','yes'); $page->setbodyscripts = 'called'; }
	//echo '<!-- buildscripts output: '.$scripts." -->\n";
	
	$content_font = Plugin::getSetting('content_font', 'mobile_check');
	//echo '<!-- ' . $content_font . ' -->';

	// Run once, first time, in header
	if(!defined('GOOGLEFONTS')){
		if($content_font != ''){
			$tempscripts = $scripts;
			$fontscript = '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$content_font.'">'."\n";

			// After first time, define so that we don't duplicate
			define("GOOGLEFONTS", "true");
			
			if($checkup == true){
				echo $fontscript;
			} else {
				$scripts = $fontscript.$tempscripts;
			}

			//echo '<!-- checkup: ' . $checkup . ' -->';
			//echo '<!-- GOOGLEFONTS -->';
		}
	}


	return $scripts;

}
}


if(!function_exists('jscripts')){
function jscripts($page = null, $insertref = '', $checkup = false){

	//$compress	= FALSE;
	//$jspath	= '/inc/js/';
	//$jsfile	= 'jscripts.js';
	//$defer	= ' defer="defer"';
	$defer		= '';

	$pageslug 	= $page->slug;
	$scripts	= '';
	$embedding	= Plugin::getSetting('embedding', 'jscripts');
	$version = Plugin::getSetting('version', 'jscripts');

	//$scripts .= '<!-- jscripts in '.$insertref." -->\n";


	// Check if jscripts placement (head/body) has been specified
	if($insertref != ''){
		//$scripts .= "<!-- call buildscripts for " . $page->slug . " -->\n";
		$scripts .= buildscripts($page,$insertref,$checkup);
	}
	
	//$scripts .= "<!-- jscripts values: scripts: " . $scripts . " and embedding: " . $embedding . " -->\n";
	if($scripts != '' || $embedding == 'auto'){
		//$scripts .= "<!-- check jscripts embedding -->\n";
		if($embedding == 'auto'){

			$page->includeSnippet('registerfunctions'); // Include custom functions snippet
			ob_start();
			$page->_executeLayout();
			$cachedpage = ob_get_contents();
			ob_end_clean();
			$headscripts = buildscripts($page,'head');
			$bodyscripts = buildscripts($page,'body');
			$newpage = str_replace('</head>', $headscripts."\n".'</head>', $cachedpage);
			$newpage = str_replace('</body>', $bodyscripts."\n".'</body>', $newpage);
			echo $newpage;
			exit();

		} else {
			//echo buildscripts($page,$insertref);
			echo $scripts;
		}
	} else {
		//$scripts .= "<!-- jscripts embedding not checked -->\n";
		//echo '<!-- jscript: pageslug = '.$pageslug.' and pagetitle = '.$pagetitle.' and scripts = '.$scripts.' and embedding = '.$embedding.' and insertref = '.$insertref." -->\n";
	}

}
}


if(!function_exists('writeJScripts')){
function writeJScripts($page='', $pushed_javascript='', $position='after'){
	if($page){ $pageid = $page->id; } else { $pageid = 0; }
	$thispage = Page::findById($pageid);

	if(!defined('REGISTER_FUNCTIONS')){
		include('../../.RegisterFunctions');
	}

	$jscriptstemplate = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/jscripts/lib/scripts.php';
	$jscriptsfile = $_SERVER{'DOCUMENT_ROOT'}.'/inc/js/scripts.js';

	// Get content from jscripts template
	$defaultdata = file_get_contents($jscriptstemplate);
	$defaultfile = file_get_contents($jscriptsfile);

	/* Get shadowbox/gallery value - NEED TO MAKE SURE MATCHES ARE ACTIVE AND NOT COMMENTED-OUT */
	$shadowbox_used = 0;
	//$shadowbox_sql = "SELECT * FROM ".TABLE_PREFIX."page_part WHERE (content LIKE '%setThumbs%' AND content NOT LIKE '%//%setThumbs%') OR content LIKE '%shadowbox%' OR content LIKE '%\"popup\"%'";
	$shadowbox_sql = "SELECT * FROM ".TABLE_PREFIX."page_part WHERE content LIKE '%setThumbs%' OR content LIKE '%shadowbox%' OR content LIKE '%\"popup\"%'";
	$shadowbox_q = Record::getConnection()->query($shadowbox_sql);
	$shadowbox_f = $shadowbox_q->fetchAll(PDO::FETCH_OBJ);
	foreach ($shadowbox_f as $shadowbox) {
		// Build up number of matches (not including duplicates per part matched)
		$shadowbox_used++;
	}
	





	/* Simple Banner JS */
	if(function_exists('simplebannerJS')){
		$pushed_javascript .= simplebannerJS($thispage);
	}









	// Check pages for gallery or shadowbox references
	if($shadowbox_used > 0){

		// If shadowbox exists (and not already in scripts.js) write javascript to scripts.js
		if(!stristr($defaultdata, 'Shadowbox.init(') && !stristr($defaultdata, 'Shadowbox.setup(')){
			ob_start(); ?>

			if(typeof(Shadowbox) !== 'undefined'){
				Shadowbox.init({
				overlayOpacity: 0.8
				}, setupScripts);
			};
			function setupScripts(){
				Shadowbox.setup('a.gallery-group', {
					gallery: 'Gallery',
					continuous: true,
					counterType: 'skip'
				});
			};

			<?php
			$shadowbox_script = ob_get_contents(); ob_end_clean();
			$pushed_javascript .= $shadowbox_script;
		}

	}





	/* Get testimonials value */
	$testimonials_used = 0;
	//$testimonials_sql = "SELECT * FROM ".TABLE_PREFIX."page_part WHERE content LIKE '%testimonials(''fade%' AND content NOT LIKE '%//%testimonials(''fade%'";
	$testimonials_sql = "SELECT * FROM ".TABLE_PREFIX."page_part WHERE content LIKE '%testimonials(''fade%'";
	$testimonials_q = Record::getConnection()->query($testimonials_sql);
	$testimonials_f = $testimonials_q->fetchAll(PDO::FETCH_OBJ);
	foreach ($testimonials_f as $testimonials) {
		$testimonials_used++;
	}
	if($testimonials_used == 0){
		//$testimonials_sql = "SELECT * FROM ".TABLE_PREFIX."snippet WHERE content LIKE '%testimonials(''fade%' AND content NOT LIKE '%//%testimonials(''fade%'";
		$testimonials_sql = "SELECT * FROM ".TABLE_PREFIX."snippet WHERE content LIKE '%testimonials(''fade%'";
		$testimonials_q = Record::getConnection()->query($testimonials_sql);
		$testimonials_f = $testimonials_q->fetchAll(PDO::FETCH_OBJ);
		foreach ($testimonials_f as $testimonials) {
			$testimonials_used++;
		}
	}
	if($testimonials_used == 0){
		//$testimonials_sql = "SELECT * FROM ".TABLE_PREFIX."layout WHERE content LIKE '%testimonials(''fade%' AND content NOT LIKE '%//%testimonials(''fade%'";
		$testimonials_sql = "SELECT * FROM ".TABLE_PREFIX."layout WHERE content LIKE '%testimonials(''fade%'";
		$testimonials_q = Record::getConnection()->query($testimonials_sql);
		$testimonials_f = $testimonials_q->fetchAll(PDO::FETCH_OBJ);
		foreach ($testimonials_f as $testimonials) {
			$testimonials_used++;
		}
	}
	
	if($testimonials_used > 0){
		/*
		<style type="text/css">
		#testimonials {
			opacity: 1.0;
			-moz-opacity: 1.0;
			-khtml-opacity: 1.0;
			filter: alpha(opacity=100);
		}
		</style>
		*/


		if(Plugin::getSetting('marqueeparent', 'jscripts')){ $marqueeparent = Plugin::getSetting('marqueeparent', 'jscripts'); } else { $marqueeparent = ''; }
		if(Plugin::getSetting('marqueecontent', 'jscripts')){ $marqueecontent = Plugin::getSetting('marqueecontent', 'jscripts'); } else { $marqueecontent = ''; }
		if(Plugin::getSetting('marqueedisplaynum', 'jscripts')){ $marqueedisplaynum = Plugin::getSetting('marqueedisplaynum', 'jscripts'); } else { $marqueedisplaynum = ''; }
		if(Plugin::getSetting('marqueeorder', 'jscripts')){ $marqueeorder = Plugin::getSetting('marqueeorder', 'jscripts'); } else { $marqueeorder = ''; }
		if(Plugin::getSetting('marqueesort', 'jscripts')){ $marqueesort = Plugin::getSetting('marqueesort', 'jscripts'); } else { $marqueesort = ''; }
		if(Plugin::getSetting('marqueeduration', 'jscripts')){ $marqueeduration = Plugin::getSetting('marqueeduration', 'jscripts'); } else { $marqueeduration = ''; }
		if(Plugin::getSetting('marqueetransition', 'jscripts')){ $marqueetransition = Plugin::getSetting('marqueetransition', 'jscripts'); } else { $marqueetransition = ''; }

		/* Ensure marquee settings are available and set */
		if($marqueeparent != ''){

			$marquee_data = array();
			/* Get id of target slug - Can't use this->target from plugin */
			$pageid_sql = "SELECT * FROM ".TABLE_PREFIX."page WHERE slug='".$marqueeparent."'";
			$pageid_q = Record::getConnection()->query($pageid_sql);
			$pageid_f = $pageid_q->fetchAll(PDO::FETCH_OBJ);
			$pageID = '';
			foreach ($pageid_f as $marqpage){
				$pageID = $marqpage->id;
			}
			/* Get children */
			$childid_sql = "SELECT * FROM ".TABLE_PREFIX."page WHERE parent_id='".$pageID."'";
			$childid_q = Record::getConnection()->query($childid_sql);
			$childid_f = $childid_q->fetchAll(PDO::FETCH_OBJ);
			$childID = '';
			foreach ($childid_f as $marqchild){
				$childID = $marqchild->id;
			}
			/* Prepare order */
			if($marqueesort == 'ascend') $marqueesort = 'ASC';
			if($marqueesort == 'descend') $marqueesort = 'DESC';
			/* Get children */
			$childid_sql = "SELECT * FROM ".TABLE_PREFIX."page WHERE parent_id='".$pageID."' ORDER BY ".$marqueeorder." ".$marqueesort;
			$childid_q = Record::getConnection()->query($childid_sql);
			$childid_f = $childid_q->fetchAll(PDO::FETCH_OBJ);
			$childID = '';
			foreach ($childid_f as $marqchild){
				$childID = $marqchild->id;
				$childBehavior = $marqchild->behavior_id;
				$childTitle = $marqchild->title;
				
				$status = $marqchild->status_id;
				/* Ensure page is not draft */
				if($status != 1){

					//$published_time = strtotime(trim(str_replace(array("T","Z")," ",$marqchild->$marqueeorder)));
					//$updated = date('F j Y', $published_time);
					//$updated = date('j M', $published_time);
					//$updated = $marqchild->$marqueeorder;
					$marqdate = $marqueeorder;
					$updated =  date("j M", strtotime($marqchild->$marqdate));
	
					//$updated = $marqchild->created_on;
					/* Check pages aren't themselves, archive page types */
					if($childBehavior == ''){
	
						/* Get content for children */
						if($marqueecontent == 'title' || $marqueecontent == 'breadcrumb' || $marqueecontent == 'description'){
							$contentid_sql = "SELECT * FROM ".TABLE_PREFIX."page WHERE id='".$childID."'";
						} else {
							if($marqueecontent == 'excerpt'){
								$contentid_sql = "SELECT * FROM ".TABLE_PREFIX."page_part WHERE page_id='".$childID."' AND name='excerpt'";
							} else {
								$contentid_sql = "SELECT * FROM ".TABLE_PREFIX."page_part WHERE page_id='".$childID."' AND name='body'";
							}
						}
	
						$contentid_q = Record::getConnection()->query($contentid_sql);
						$contentid_f = $contentid_q->fetchAll(PDO::FETCH_OBJ);
						$contentID = '';
						foreach ($contentid_f as $contents){
	
							$status = $marqchild->status_id;
							/* Ensure page is not draft */
							if($status != 1){
	
								if($marqueecontent == 'title'){
									$content = $contents->title;
								} else if($marqueecontent == 'breadcrumb'){
									$content = $contents->breadcrumb;
								} else if($marqueecontent == 'description'){
									$content = $contents->description;
								} else if($marqueecontent == 'excerpt'){
									$content = $contents->content_html;
								} else {
									$content = $contents->content_html;
								}
		
								/* Remove h1 tags */
								$content = preg_replace('/<h1[^>]*>([\s\S]*?)<\/h1[^>]*>/', '', $content);
		
								if(!stristr($content,'</p>')) $content = '<p>'.$content.'</p>';
								$content = str_replace('<p',"<p data-date='".$updated."'",$content);

								/* Remove blockquote tags */
								$content = str_replace('<blockquote>', '', $content);
								$content = str_replace('</blockquote>', '', $content);
								$content = trim($content);
								$marquee_data[] = str_replace('"',"",$content);
							
							}
							
						}
	
					}
					
				}
			}
			$marquee = '"'.implode('", "', $marquee_data).'"';
			//echo $marquee;
		}

		ob_start();


			?>
	
			var marquee = new Array(<?php echo $marquee; ?>);
	
			<?php
			//var marquee = new Array(
			//"<h3>Slice1</h3><p>This slideshow will use a fade effect to fade out and in between holders.</p><p>This Example is a part of the Article.</p>",
			//"<h3>Slice2</h3><p>This slideshow will use a fade effect to fade out and in between holders.</p>",
			//"<h3>Slice3</h3><p>This Example is a part of the Article.</p>",
			//"<h3>Slice4</h3><p>This Example is part of the Article too.</p>"
			//);
			?>
	
			var groupnum = <?php echo $marqueedisplaynum; ?>;
			var groupreset = 0;
			var html = "";
			var mystyle = '';
			for (var i=0;i<marquee.length;i++){
				if(groupreset == 0){ html += "<div class='group'" + mystyle + ">"; }
				groupreset++;
				html += "<blockquote id='slice" + i + "'>";
				html += marquee[i];
				html += "</blockquote>";
				if(groupreset == groupnum){ html += "</div>"; groupreset = 0; }
			}
			document.getElementById("testimonials").innerHTML = html;
	
			var holder = document.getElementById("testimonials");
			var element = 'div'; /* .class or data- or tag */
			if(element.substring(0, 1) == "."){
				divs = holder.getElementsByClassName(element.slice(1));
			} else {
				divs = holder.getElementsByTagName(element);
			};
			var total = divs.length;
			var duration = <?php echo $marqueetransition; ?>; /* fade duration in millisecond */
			var hidetime = duration / 10; /* time to stay hidden (between fadeout and fadein) */
			var showtime = <?php echo $marqueeduration; ?>; /* time to stay visible */
			
			var running = 0; /* Used to check if fade is running */
			var iEcount = 0; /* Element Counter */
	
			document.getElementsByClassName = function(cl) {
				var retnode = [];
				var myclass = new RegExp('\\b'+cl+'\\b');
				var elem = this.getElementsByTagName('*');
				for (var i = 0; i < elem.length; i++) {
					var classes = elem[i].className;
					if (myclass.test(classes)){
						retnode.push(elem[i]);
					}
				}
				return retnode;
			};



		<?php
		/* TO DO: Need to stop fade animation if marquee array length isn't greater than groupnum (otherwise each loop fade is identical) */
		/* At present, javascript fade is disabled as needed, but html should now be submitted */
		if(count($marquee_data) > $marqueedisplaynum){
		?>


			function SetOpa(Opa) {
				holder.style.opacity = Opa;
				holder.style.MozOpacity = Opa;
				holder.style.KhtmlOpacity = Opa;
				holder.style.filter = 'alpha(opacity=' + (Opa * 100) + ');';
			};
			
			function StartFade() {
				if (running != 1) {
				running = 1;
				var i;
				for ( i = 0; i < total; i++ ) {
					if(i == 0){
						divs[i].style.display = "block";
					} else {
						divs[i].style.display = "none";
					}
				}
				setTimeout("fadeOut()", showtime);
				}
			};
			
			function fadeOut() {
				for (i = 0; i <= 1; i += 0.01) {
					setTimeout("SetOpa(" + (1 - i) +")", i * duration);
				}
				setTimeout("FadeIn()", (duration + hidetime));
			};
			
			function FadeIn() {
				for (i = 0; i <= 1; i += 0.01) {
					setTimeout("SetOpa(" + i +")", i * duration);
				}
				if (iEcount == total - 1) {
					iEcount = 0;
					for (i = 0; i < total; i++ ) {
						if(i == iEcount){
							divs[iEcount].style.display = "block";
						} else {
							divs[i].style.display = "none";
						}
					}
				 } else {
					for (i = 0; i < total; i++ ) {
						if(i == 0){
							divs[iEcount + 1].style.display = "block";
						} else {
							divs[iEcount].style.display = "none";
						}
					}
					iEcount = iEcount+1;
				}
				setTimeout("fadeOut()", (duration + showtime));
			};
			StartFade();

	
		<?php
		}
		?>





		<?php 
		$testimonials_script = ob_get_contents(); ob_end_clean();
		$pushed_javascript .= $testimonials_script;

	}




	// Work with template if contents available
	if($defaultdata){



		/* Add screen size functions to jscrpts if required by seobox analytics (tends to use doc size, not device size) */
		/*
		if(Plugin::getSetting('clientanalyticsscreenstats', 'seobox') == 'on'){
		$defaultdata .= "var getwinsize = function(){
			var f='';
			// get window size
			if (typeof(window.innerWidth) == 'number'){
				f='x:window.innerWidth,y:window.innerHeight';
			} else if (document.documentElement && document.documentElement.clientWidth){
				f='x:document.documentElement.clientWidth,y:document.documentElement.clientHeight';
			} else if (document.body && document.body.clientWidth) {
				f='x:document.body.clientWidth,y:document.body.clientHeight';
			} else if (document.width){
				f='x:document.width,y:document.height';
			}
			// get scroll distance
			if (typeof(document.scrollTop) == 'number'){
				f+=',yy:document.scrollTop,xx:document.scrollLeft';
			} else if (typeof(document.body.scrollTop) == 'number'){
				f+=',yy:document.body.scrollTop,xx:document.body.scrollLeft';
			} else if (typeof(document.documentElement.scrollTopt) == 'number'){
				f+=',yy:document.documentElement.scrollTop,xx:document.documentElement.scrollLeft';
			} else if (typeof(window.pageYOffset) == 'number'){
				f+=',yy:window.pageYOffset,xx:window.pageXOffset';
			} else {
				f+=',yy=0,xx=0';
			}
			getwinsize = Function('return{'+f+'}');
			return (getwinsize());
		};";
		}
		*/


		if(DEBUG == false){
			// Remove comments from jscripts Template
			if(function_exists('removecomments')) $defaultdata = removecomments($defaultdata);
	
			// Remove unwanted whitespace from jscripts Template
			if(function_exists('compress')) $defaultdata = compress($defaultdata);
		}

		// Allow jscripts file to be editable
		chmod($jscriptsfile, 0777);
	
		// Check jscripts file is editable.
		if(is_writable($jscriptsfile) && $defaultdata != ''){

			// Open jscripts file for writing (w) and check permissions.
			//$jscriptsopen = fopen($jscriptsfile,'r');

			//if($jscriptsopen && fileperms($jscriptsfile) >= 0644){
				
				//fclose($jscriptsopen);
				
				// Make any additional amends to content (pushed via plugins etc)
				if($pushed_javascript != ''){
					

					//$pushed_javascript = " alert('Saved by ".$page->slug." page in admin');";

					if(DEBUG == false){
						// Remove comments from jscripts Template
						$pushed_javascript = removecomments($pushed_javascript);
	
						// Remove unwanted whitespace from jscripts Template
						$pushed_javascript = compress($pushed_javascript);
					}

					if($position == 'before'){

						// Write pushed javascript to beginning of scripts.js file
						$defaultdata = $pushed_javascript.$defaultdata;

					} else {

						// Write pushed javascript to end of scripts.js file
						$defaultdata = $defaultdata.$pushed_javascript;

					}
					
					// Wrap script in 
					$prefix = "/* Check if browser is DOM and HTML5 Savvy */ \n";
					$prefix .= "if ('querySelectorAll' in document && 'addEventListener' in window) { ";
					// Close wrapper handler for simple banner support
					if(!stristr($defaultdata,'bannerHolder')){ $suffix = "} "; }
					
					$defaultdata = $prefix.$defaultdata.$suffix;

					//echo $defaultdata."\n\n";
					//echo $defaultfile."\n\n";
					//exit;

				}

				// Write reminder to not edit js file directly (as it could be over-written).
				//if(stristr($jscripts,'/* CMS-Generated Update')){
				if(stristr($defaultfile,'/* CMS-Generated Update')){
					$jscripts = preg_replace("/\/\* CMS-Generated Update(.*?)\*\//", '', $defaultdata);
				}
				$jscripts = "/* CMS-Generated Update ".date("F j, Y, g:i a")." */\n\n".$defaultdata;


				//echo $jscripts."\n\n";
				//exit;

			//}


			//echo preg_replace("/\/\* CMS-Generated Update(.*?)\*\//", '', $jscripts)."\n\n\n";
			//echo preg_replace("/\/\* CMS-Generated Update(.*?)\*\//", '', $defaultfile);
			
			//exit;

			// Finally, update jscripts file if not empty and differs to existing file.
			if($jscripts != '' && (preg_replace("/\/\* CMS-Generated Update(.*?)\*\//", '', $jscripts) != preg_replace("/\/\* CMS-Generated Update(.*?)\*\//", '', $defaultfile))){

				//echo 'Testimonials found on save: '.$marquee;
				//exit;

				$defaultfile = $jscripts;
				file_put_contents($jscriptsfile, $defaultfile);
				//$f = file_put_contents($jscriptsfile, $defaultfile);
				//fwrite($jscriptsopen, $jscripts);
			}


			/*
			if($f){
			  print 1;
			} else {
			  print 0;
			}
			*/


			//fclose($jscriptsfile);


	
		}

		// Protect jscripts file from being editable
		chmod($jscriptsfile, 0644);
		
	}
	

	//exit;
}
}