<?php

Plugin::setInfos(array(
	'id'					=> 'searchbox',
	'title'					=> 'Search Box',
	'description'			=> 'Provides site search.',
	'version'				=> '1.2.0',
	'author'				=> 'Steven Henderson',
	'require_frog_version'	=> '0.9.4'
));

//Behavior::add('page_not_found', '');
//Observer::observe('page_requested', 'searchbox_catch_searchquery');
//Observer::observe('page_not_found', 'searchbox_log_match');
//Observer::observe('page_requested', 'searchbox_log_match');

AutoLoader::addFolder(dirname(__FILE__) . '/models');
//Plugin::addController('searchbox', 'SiteSearch');
//Plugin::addJavascript('searchbox', 'js/jquery.scrollTo-min.js');


function searchbox($heading='<legend>Search</legend>',$button='search',$icon='text',$label='Search this site'){

	if(isset($_GET['mobile'])){ $GET_mobile = htmlspecialchars($_GET['mobile']); } else { $GET_mobile = ''; }
	$mobile_string_var = '?mobile=n'; $mobile_set = $GET_mobile; $mobile_string = '';
	if($mobile_set == 'n'){ $mobile_string = $mobile_string_var; }

	$buildsearch = '';
	$searchanchor = ''; //#content
	if(stristr($_SERVER['REQUEST_URI'], 'contrast/')){
		$searchpage = '/contrast/search'.URL_SUFFIX.$mobile_string.$searchanchor;
	} else {
		$searchpage = '/search'.URL_SUFFIX.$searchanchor;
	}
	$buildsearch .= '<form id="searchbox" action="'.$searchpage.$mobile_string.'" method="post">';
	$buildsearch .= '<fieldset>';
	$buildsearch .= $heading;
	$buildsearch .= '<label for="thissearch" id="search">'.$label.'</label> ';
	$buildsearch .= '<input id="thissearch" type="search" name="search" value="'.$mysearch = str_replace(URL_SUFFIX,'',pagesearch()).'" />';
	if($icon != 'text'){
		$type = "image";
		$src = ' src="/includes/images/submit.gif" alt="'.$button.'"';
	} else {
		$type = "submit";
		$src = "";
	}
	$buildsearch .= '<input type="'.$type.'"'.$src.' name="searchsubmit" value="'.$button.'" class="submit" />';
	$buildsearch .= '</fieldset>';
	$buildsearch .= "</form>\n";
	if(!defined('SEARCHSTATUS')) define('SEARCHSTATUS','true');
	echo $buildsearch;
}

function searchstart($parent){
	$badStrings = array(
	"content-type:",
	"mime-version:",
	"content-transfer-encoding:",
	"multipart/mixed",
	"charset=",
	"bcc:",
	"cc:",
	"href=",
	"http:",
	"script>",
	"?php",
	"url=",
	"link=");
	$malicious = false;
	if (isset($_POST['search'])){
		foreach($_POST as $k => $v){
			foreach($badStrings as $v1){
				if(strpos(strtolower($v), $v1) !== false || strlen($v) > 1000){
					$malicious = true;
				}
			}
		}
		$searchcriteria = htmlentities($_POST['search'], ENT_QUOTES, 'UTF-8');
		if($searchcriteria != NULL && strlen($searchcriteria) < 30 && $searchcriteria != '' && $malicious != true){
			echo sitesearch($parent);
		}else{
			echo '<p id="listing">Please input a search term or keyword.</p>';
		}
	} else if (isset($_GET['search'])){
		foreach($_GET as $k => $v){
			foreach($badStrings as $v2){
				if(strpos(strtolower($v), $v2) !== false || strlen($v) > 1000){
					$malicious = true;
				}
			}
		}
		$searchcriteria = htmlentities($_GET['search'], ENT_QUOTES, 'UTF-8');
		if(isset($_SESSION['searchpass'])){ $searchpass = $_SESSION['searchpass']; } else { $searchpass = ''; }
		if($searchcriteria != NULL && strlen($searchcriteria) < 30 && $searchpass != 'unset' && $malicious != true){
			echo sitesearch($parent);
		}else{
			echo '<p>Please input a search term or keyword.</p>';
		}
	} else {
		header('HTTP/1.0 403 Forbidden');
		$host = $_SERVER['HTTP_HOST'];
		header("Location: http://$host");
		exit;
	}
}
function sitesearch($parent){

	if(isset($_GET['mobile'])){ $GET_mobile = htmlspecialchars($_GET['mobile']); } else { $GET_mobile = ''; }
	$mobile_string_var = '?mobile=n'; $mobile_set = $GET_mobile; $mobile_string = '';
	if($mobile_set == 'n'){ $mobile_string = $mobile_string_var; }

	global $listing;
	global $checked;
	global $showdesc;
	global $mysearch;
	global $searchanchor;
	$redirect = '';	
	$showdesc = false;
	$homechecked = false;
	$listing = array();
	$ranking = array();
	$checked = array();
	$mysearch = pagesearch();
	$mysearch = str_replace(URL_SUFFIX,'',$mysearch);
	$searchanchor = "#results";
	if(!function_exists('is_in_array')){
		function is_in_array($str, $array) {
			return preg_grep('/^' . preg_quote($str, '/') . '$/i', $array);
		}
	}
	// Clean content from searchbox
	if(!function_exists('clean_content')){
		function clean_content($string){
				$dom = new DOMDocument();
				@$dom->loadHTML($string);
				$dom->preserveWhiteSpace = false;
				$elements = $dom->getElementsByTagName('form');
				while($span = $elements->item(0)) {	   
				   $span->parentNode->removeChild($span);
				}
				$string = $dom->saveHTML();
				return $string;
		}
	}
	if(!function_exists('snippet_sitesearch')){
		function snippet_sitesearch($parent,$mobile_string){
			global $listing;
			global $ranking;
			global $checked;
			global $showdesc;
			global $mysearch;
			$matchcount = 0;
			$counter = 0;
			$out = '';
			if($parent->slug == "" && !in_array($parent->slug,$checked)) {
				$mylink = $parent->link();
				$mycrumb = $parent->breadcrumb;
				$mycontent = $parent->content();

				// Clean content from searchbox
				$mycontent = clean_content($mycontent);

				if(stristr($mycontent,$mysearch) || stristr($parent->title(),$mysearch) || stristr($parent->breadcrumb(),$mysearch) || is_in_array($mysearch,$parent->tags())){
					$matchcount += substr_count(strtoupper($mycontent),strtoupper($mysearch));
					if(substr_count(strtoupper($parent->title()),strtoupper($mysearch)) > 0){ $searchrank = $matchcount + substr_count(strtoupper($parent->title()),strtoupper($mysearch)) * 10; } else { $searchrank = $matchcount; }
					$matchcount += substr_count(strtoupper($parent->title()),strtoupper($mysearch));
					$matchcount += substr_count(strtoupper($parent->breadcrumb()),strtoupper($mysearch));
					if(is_in_array($mysearch,$parent->tags())){$searchrank += 1;}
					if($parent->description != '' && $showdesc == true){$childdesc = '<p>'.$parent->description.'</p>';}else{$childdesc='';}
					if($parent->content('redirect') != null){ $parentlink = strip_tags($parent->content('redirect')); } else { $parentlink = '/'.$parent->url; }

					/*
					if(stristr($_SERVER['REQUEST_URI'], 'mobile/')){
						if(!stristr($parentlink,'/mobile/')){
							$parentlink = '/mobile'.$parentlink;
						}
					}
					*/

					$result = '<li><a href="'.$parentlink.'">'.$mycrumb.'</a>'.$childdesc.'</li>'."\r";
					$listing[] = array('link' => $result, 'rank'=>$searchrank);
					$ranking[$counter] = $searchrank;
					$checked[$result] = 'Home';
					$out .= $result;
				}
			}
			$childs = $parent->children(null,array(),true);
			if (count($childs) > 0){
				foreach ($childs as $child) {
					//if((function_exists('robotredirect') && robotredirect($child,'return') == '') || (!function_exists('robotredirect') && $child->content('redirect') == null)){
					if((function_exists('robotredirect') && robotredirect($child,'return') == '') || (function_exists('robotredirect') && robotredirect($child,'return') != '') || (!function_exists('robotredirect') && $child->content('redirect') == null)){

						//	echo 'Find: '.findrobotredirect($child,'slug');
						//}
						
						$matchcount = 0; $mychild = ''; $out = ''; $result = '';
						// Exclude pages like archives and newsletter success pages
						if(!in_array($parent->slug,$checked) && !isExcludedPage($child->url) && !stristr($child->behavior_id,'archive_') && !stristr($child->url,'newsletters/')){
							$myparent = snippet_sitesearch($child,$mobile_string);
							$mylink = $child->link();
						 	$url_segments = explode('/', $child->url);
							$url_seg_count = count($url_segments);
							$mytags = implode(' ',$child->tags());
							/* Determine whether to show page path */
							if($url_seg_count > 1){
								//$mycrumb = ucfirst(str_replace('-',' ',$child->parent->breadcrumb)).' / '.$child->breadcrumb;
								$mycrumb = $child->breadcrumb;
							} else {
								$mycrumb = $child->breadcrumb;
							}
							if(extension($child->url) == ''){$ext = URL_SUFFIX;} else {$ext = '';$mycrumb = str_replace(URL_SUFFIX,'',$mycrumb);}
						
							$mycontent = $mychild.$child->content();
							// Clean content from searchbox
							$mycontent = clean_content($mycontent);

							if(stristr($mycontent,$mysearch) || stristr($mychild.$child->title(),$mysearch) || stristr($mychild.$child->breadcrumb(),$mysearch) || stristr($mytags,$mysearch)){
								$counter++;
								$title_n = substr_count(strtoupper($mychild.$child->title()),strtoupper($mysearch));
								$description_n = substr_count(strtoupper($mychild.$child->description()),strtoupper($mysearch));
								$content_n = substr_count(strtoupper($mycontent),strtoupper($mysearch));
								$breadcrumb_n = substr_count(strtoupper($mychild.$child->breadcrumb()),strtoupper($mysearch));
								$tags_n = substr_count(strtoupper($mytags),strtoupper($mysearch));
								$matchcount += $content_n;
								$matchcount += $breadcrumb_n;
								$matchcount += $tags_n;
								if(substr_count(strtoupper($mychild.$child->title()),strtoupper($mysearch)) > 0){
									$searchrank = $matchcount + ((substr_count(strtoupper($mychild.$child->title()),strtoupper($mysearch)) * 10) * $description_n);
								} else {
									$searchrank = $matchcount;
								}
								if(stristr($mytags,$mysearch)){$searchrank += 1;}
								if($searchrank > 0){
									//if(is_in_array($mysearch,$child->tags())){$searchrank += 1;}
									if($child->description != '' && $showdesc == true){$childdesc = '<p>'.$child->description.'</p>';}else{$childdesc='';}
									/* Test */
									//$childdesc = ' ('.$child->url().URL_SUFFIX.')';
									if((function_exists('robotredirect') && robotredirect($child,'return') != '') || (!function_exists('robotredirect') && $child->content('redirect') != null)){
									//if($child->content('redirect') != null){ 
										if(function_exists('robotredirect') && robotredirect($child,'return') != ''){
											$redirect = robotredirect($child,'return');
											/* Test */
											//$childdesc = ' ('.$redirect.')';
										} else {
											$redirect = $child->content('redirect');
										}
										$childlink = strip_tags($redirect); } else { $childlink = '/'.$child->url.URL_SUFFIX; }

	
									if(function_exists('removearticledate')){
										$childlink = removearticledate($childlink);
									} else {
										$pattern = '/(\d+)\/(\d+)\/(\d+)\//';
										$childlink = preg_replace($pattern,'',$childlink);
									}


									/*
									if(stristr($_SERVER['REQUEST_URI'], 'mobile/')){
										if(!stristr($childlink,'/mobile/')){
											$childlink = '/mobile'.$childlink;
										}
									}
									*/


									$result = '<li><a href="'.$childlink.$mobile_string.'">'.$mycrumb.'</a> '.$childdesc.'</li>'."\r";
									if(!is_in_array($result,$checked)){
										$listing[] = array('link' => $result, 'rank'=>$searchrank);
										$ranking[$counter] = $searchrank;
										$checked[] = $result;
									}
								}
								if(!is_in_array($result,$checked)) $out .= $result;
							}
							if(!is_in_array($result,$checked)) $out .= snippet_sitesearch($child,$mobile_string);
						}
						
					}

				}
			}
		}
	}
	$searchdata = snippet_sitesearch($parent->find('/'),$mobile_string);
	$occurances = sizeof($listing);
	if($occurances != NULL){
		if(stristr($_SERVER['REQUEST_URI'], 'search'.URL_SUFFIX)){
			$_SESSION['searchpass'] = 'set';
			$mysearch = str_replace(' ','-',$mysearch);
			if(stristr($_SERVER['REQUEST_URI'], 'contrast/')){
				header("location: /contrast/search/".$mysearch.$mobile_string.$searchanchor);
			} else if(stristr($_SERVER['REQUEST_URI'], 'mobile/')){
				header("location: /mobile/search/".$mysearch.$mobile_string.$searchanchor);
			} else if(stristr($_SERVER['REQUEST_URI'], 'standard/')){
				header("location: /standard/search/".$mysearch.$mobile_string.$searchanchor);
			} else {
				header("location: /search/".$mysearch.$mobile_string.$searchanchor);
			}
		} else {
		}
		if($occurances > 1){$results = $occurances.' '.' results were';}else{$results = 'The following result was';}
		echo '<p>'.$results.' found for <strong>'.$mysearch.'</strong></p>'."\r";
		echo '<ol id="listing">'."\r";
		
		if(!function_exists('array_sort_bycolumn')) {
			function array_sort_bycolumn(&$array,$column,$dir = 'asc') {
				foreach($array as $a) $sortcol[$a[$column]][] = $a;
				ksort($sortcol);
				foreach($sortcol as $col) {
					foreach($col as $row) $newarr[] = $row;
				}
				
				if($dir=='desc') $array = array_reverse($newarr);
				else $array = $newarr;
			}
		}

		array_sort_bycolumn($listing,'rank','desc');
		
		//foreach($array as $a) $sortcol[$a[$column]][] = $a;

		foreach($listing as $key=>$val) {
			echo $val['link'];
		}
		echo '</ol>'."\r";
		
		//print_r($checked);
	} else {
		if(stristr($_SERVER['REQUEST_URI'], 'search'.URL_SUFFIX)){
			$_SESSION['searchpass'] = 'set';
			$mysearch = str_replace(' ','-',$mysearch);
			if(stristr($_SERVER['REQUEST_URI'], 'contrast/')){
				header("location: /contrast/search/".$mysearch.$mobile_string.$searchanchor);
			} else if(stristr($_SERVER['REQUEST_URI'], 'mobile/')){
				header("location: /mobile/search/".$mysearch.$mobile_string.$searchanchor);
			}  else if(stristr($_SERVER['REQUEST_URI'], 'standard/')){
				header("location: /standard/search/".$mysearch.$mobile_string.$searchanchor);
			} else {
				header("location: /search/".$mysearch.$mobile_string.$searchanchor);
			}
		} else {
		}
		/* Check downloads.php has not been accessed directly. */
		if($mysearch == 'not specified'){
			echo '<p>You did not specify a valid page or document to download.</p>';
		} else {
			echo '<p>Your search for <strong>'.$mysearch.'</strong> has no matching results.</p>';
		}
	}
	if(!defined('SEARCHBOX')) define('SEARCHBOX',''); if(SEARCHBOX == 'true'){
		if($occurances == 0){
			echo '<p id="search-again">Search again or try using the <a href="/sitemap.html">sitemap</a>.</p>';
		}
	} else {
		echo '<p id="search-again">For further help try using the <a href="/sitemap.html">sitemap</a>.</p>';
	}
}




// searchquery urls already set up
function searchbox_catch_searchquery(){
	$searchquery = Record::findAllFrom('SiteSearchQueries', 'url = \''.$_SERVER['REQUEST_URI'].'\'');
	if(sizeof($searchquery) > 0) {
		Record::update('SiteSearchQueries', array('hits' => ($searchquery[0]->hits + 1)), 'id = '.$searchquery[0]->id);

		header ('HTTP/1.1 301 Moved Permanently', true);
		header ('Location: '.$searchquery[0]->destination);
		exit();
	}

}


// watch and log Match errors
function searchbox_log_match(){
	$searchquery = Record::findAllFrom('SiteSearchMatches', 'url = \''.$_SERVER['REQUEST_URI'].'\'');
	if(sizeof($searchquery) > 0) {
		Record::update('SiteSearchMatches', array('hits' => ($searchquery[0]->hits + 1)), 'id = '.$searchquery[0]->id);
	} else {
		Record::insert('SiteSearchMatches', array('url' => $_SERVER['REQUEST_URI']));
	}
}


/* Search */
if(!function_exists('setsearch')){
	function setsearch($heading='<legend>Search</legend>',$button='search',$icon='text',$label='Search this site'){
		if(function_exists('searchbox')){
			$showsearch = true;
			// Allow mobile plugin settings to control search visibility
			if(Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('searchbox', 'mobile_check') == 'false'){ $showsearch = false; }
			if($showsearch == true){
				//if(){
					echo '<div role="search">'."\n";
					searchbox($heading,$button,$icon,$label);
					echo '</div>'."\n";
					setglobal('SEARCHBOX','true');
				//}
			}
		}
	}
}