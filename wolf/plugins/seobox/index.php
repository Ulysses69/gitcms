<?php

if (!defined('SEOBOX_VERSION')) { define('SEOBOX_VERSION', '3.7.0'); }
if (!defined('SEOBOX_ROOT')) { define('SEOBOX_ROOT', URI_PUBLIC.'wolf/plugins/seobox'); }
Plugin::setInfos(array(
	'id'					=> 'seobox',
	'title'					=> 'SEO Box',
	'description'			=> 'SEO tools.',
	'version'				=> SEOBOX_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));
if(!defined('CLIENTDETAILS_ROOT')){
	define('CLIENTDETAILS_ROOT', URI_PUBLIC.'wolf/plugins/seobox');
}

//if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
if (false !== strpos($_SERVER['PHP_SELF'], ADMIN_DIR)) {
	if(!AuthUser::hasPermission('client')) Plugin::addController('seobox', 'SEO', 'administrator', true);
}

//Observer::notify('page_found', 'check_robots');

if(!function_exists('sitemaplink')){
function sitemaplink($parent,$echo=true) {
	$sitemaplink = Plugin::getSetting('sitemaplink', 'seobox');
	if(pagetitle($parent,false) != '' && $sitemaplink != ''){
		$newtitle = '';
		if($sitemaplink == 'title'){
			$newtitle = $parent->title();
		}
		if($sitemaplink == 'breadcrumb'){
			$newtitle = $parent->breadcrumb();
		}
		if($sitemaplink == 'description'){
			$newtitle = $parent->description();
		}
		$newtitle = str_replace('[client]',clientname(),$newtitle);
		$newtitle = str_replace('[clientname]',clientname(),$newtitle);
		$newtitle = str_replace('[copyright]',displayCopyright('text'),$newtitle);
		$newtitle = str_replace('[telephone]',clienttelephone($parent),$newtitle);
		$newtitle = str_replace('[address]',clientaddress($parent),$newtitle);
		$newtitle = str_replace('[location]',clientlocation($parent),$newtitle);
		$newtitle = str_replace('[email]',clientemail($parent),$newtitle);
		if($echo == true){
			//echo 'title="'.ereg_replace("/\n\r|\r\n|\n|\r/", '', $newtitle).'"';
			echo ' title="'.str_replace("/\n\r|\r\n|\n|\r/", '', $newtitle).'"';
		} else {
			//return  'title="'.ereg_replace("/\n\r|\r\n|\n|\r/", '', $newtitle).'"';
			return  ' title="'.str_replace("/\n\r|\r\n|\n|\r/", '', $newtitle).'"';
		 }
	}
}
}

if(!function_exists('dateDiff')){
function dateDiff($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}
}

if(!function_exists('pageisnew')){
function pageisnew($page){
	$newenabled = Plugin::getSetting('noticestatus', 'seobox');
	$livedate = Plugin::getSetting('livedate', 'copyright');

	if($newenabled == true && $livedate != ''){

		$countdays = Plugin::getSetting('noticedays', 'seobox');
		$livecheck = Plugin::getSetting('noticelivecheck', 'seobox');

		//$countdays = '30';
		//$newenabled = true;
		//$livecheck = false;
		$updatefrom = 'updated_on'; /* created_on/published_on/updated_on */
		$createdfrom = 'created_on'; /* created_on/published_on/updated_on */

		$days = '';
		$liveddays = 0;
		$diff = 0;
		$updateddiff = 0;
		$creadteddiff = 0;
		$livedate = Plugin::getSetting('livedate', 'copyright');

		$created = substr($page->created_on,0,10);
		$updated = substr($page->updated_on,0,10);


		$startdate = date('Y-m-d');
		//$updatedays = dateDiff($updated,$startdate);
		//$createddays = dateDiff($created,$startdate);
		//if($livedate != '') $liveddays = dateDiff($livedate,$startdate);
		$livedays = dateDiff($livedate,$startdate);
		//if(dateDiff($updated,$livedate) > 0) $updateddiff = dateDiff($updated,$livedate);
		//if(dateDiff($created,$livedate) > 0) $creadteddiff = dateDiff($created,$livedate);

		if(strtotime($created) < strtotime($livedate)){
			//$updated = $livedate;
		}

		$updateddiff = dateDiff($updated,$startdate);
		$creadteddiff = dateDiff($created,$startdate);

		if(strtotime($page->updated_on) < strtotime($livedate)){
			$updateddiff = dateDiff($livedate,$startdate);
		}

		//if($diff < $countdays) $liveddays = $diff;

		//if($livedate != ''){
			//if(strtotime($updated) > strtotime($livedate) && $creadteddiff <= $livedays){
			if(strtotime($page->created_on) > strtotime($livedate)){
				$days = $creadteddiff;
				if($days <= $countdays){
					if($days == 0) {
						$days = ' today';
					} else if($days == 1) {
						$days = ' yesterday';
					} else if($days < 7) {
						$days = $days . ' days ago';
					} else if($days == 7) {
						$days = ' a week ago';
					} else if($days < (7*6)) {
						$days = ' ' . ceil($days/7) . ' weeks ago';
					} else if($days < 365) {
						$days = ' ' . ceil($days/(365/12)) . ' months ago';
					} else {
						$years = round($days/365);
						$days = ' ' . $years . ' year' . ($years != 1 ? 's' : '') . ' ago';
					}
					return ' title="added'.$days.'"><em> </em';
				}
			} else if(strtotime($page->created_on) < strtotime($livedate)) {
				if(strtotime($page->updated_on) > strtotime($livedate)){
					$days = $updateddiff;
					if($days <= $countdays){
						if($days == 0) {
							$days = ' today';
						} else if($days == 1) {
							$days = ' yesterday';
						} else if($days < 7) {
							$days = $days . ' days ago';
						} else if($days == 7) {
							$days = ' a week ago';
						} else if($days < (7*6)) {
							$days = ' ' . ceil($days/7) . ' weeks ago';
						} else if($days < 365) {
							$days = ' ' . ceil($days/(365/12)) . ' months ago';
						} else {
							$years = round($days/365);
							$days = ' ' . $years . ' year' . ($years != 1 ? 's' : '') . ' ago';
						}
						return ' title="updated'.$days.'"><em> </em';
					}
				}
			} else {
				return '><em>('.$updateddiff.') </em';
			}
		//}

		//return '><em>(Live: '.$livedate.' Live Days: '.$liveddays.' Created: '.$created.' Updated: '.$updated.' Days Since Live: '.$updated.' ) </em';
		/*
			if($creadteddiff < $countdays){
				return ' title="new"><em>('.$creadteddiff.') </em';
			} else if($updateddiff < $countdays){
				return ' title="update"><em>('.$updateddiff.') </em';
			} else {
				return '><em>('.$livedays.') </em';
			}
		*/


		/*
		//return $days.' days for '.substr($page->$fromdate,0,10).' on '.date('Y-m-d');
		if(($livecheck == true && $liveddays > $countdays) || $livecheck == false){
			if($createddays < $countdays){
				return ' title="new"';
			} else if($updatedays < $countdays){
				return ' title="update"';
			}
		}
		*/



	}
}
}

/* Advanced Sitemap - under development */
if(!function_exists('sitemap')){
function sitemap($parent,$limits=false,$exclude=array(),$ulid='sitemap'){

	$sitemaplink = Plugin::getSetting('sitemaplink', 'seobox');
	$sitemaptitle = Plugin::getSetting('sitemaptitle', 'seobox');
	$sitemapdescription = Plugin::getSetting('sitemapdescription', 'seobox');
	$sitemapheadings = Plugin::getSetting('sitemapheadings', 'seobox');
	$sitemaparchives = Plugin::getSetting('sitemaparchives', 'seobox');

	global $startul;
	global $checkstart;
	$checkstart = FALSE;
	//if(NAVIGATION != 'true' && !stristr($_SERVER['REQUEST_URI'],'/mobile/')){

	//if(NAVIGATION != 'true' && MOBILEMODE == TRUE){
	//	setglobal('NAVIGATION','true');
	//} else {
		if($ulid != ''){
			$ulid = 'sitemap';
		}
	//}

	if(!function_exists('snippet_sitemap')){
	function snippet_sitemap($startparent,$parent,$ulid,$passcount=0,$level=0,$limits,$exclude){

		if(isset($_GET['mobile'])){ $GET_mobile = htmlspecialchars($_GET['mobile']); } else { $GET_mobile = ''; }
		$mobile_string_var = '?mobile=n'; $mobile_set = $GET_mobile; $mobile_string = ''; $selected = '';
		if($mobile_set == 'n'){ $mobile_string = $mobile_string_var; }

		$sitemaplink = Plugin::getSetting('sitemaplink', 'seobox');
		$sitemaptitle = Plugin::getSetting('sitemaptitle', 'seobox');
		$sitemapdescription = Plugin::getSetting('sitemapdescription', 'seobox');
		$sitemapheadings = Plugin::getSetting('sitemapheadings', 'seobox');
		$sitemaparchives = Plugin::getSetting('sitemaparchives', 'seobox');

		if($passcount == 0){ $startul = ' id="'.$ulid.'"'; } else { $startul = ''; }
			$out = '';
			$childs = $parent->children();
			$datedpages = isDatedPage();

			if (count($childs) > 0){
				$out = '<ul'.$startul.'>';
				if($passcount == 0){
					$passcount = 1;
					if(!in_array('home',$exclude)){
						if($_SERVER['REQUEST_URI'] == '/' && $ulid != 'sitemap'){
							$selected = ' class="selected"';
						}
						$out .= '<li id="home-'.$ulid.'"'.$selected.'><a href="/'.$mobile_string.'">Home</a></li>';
					}
				}
				foreach ($childs as $child){

					if($child->parent->behavior_id != 'archive' || $sitemaparchives == 'yes'){
					//if($child->slug == 'copyright' && $startparent->layout_id == 10){
						# Do nothing
					//} else {

						//if(stristr($_SERVER['REQUEST_URI'],$child->slug) && $ulid != 'sitemap'){
						if(($_SERVER['REQUEST_URI'] == '/'.$child->slug.URL_SUFFIX || stristr($_SERVER['REQUEST_URI'],$child->url) || $_SERVER['REQUEST_URI'] == '/'.$child->url.URL_SUFFIX) && $ulid != 'sitemap'){
							$selected = ' class="selected"';
						} else {
							$selected = '';
						}

						$level = substr_count($child->url, '/') + 1;
						if($level < $limits || $limits == false){
							$match = '';
							if($child->getLoginNeeded() == Page::LOGIN_REQUIRED) continue;
								  foreach($exclude as $key => $search_needle){
								   if(stristr($child->link(), $search_needle) != FALSE){
									 $match = 'found';
								   }
								}
							if($sitemaptitle == 'title' && $parent->find('/')->layout_id != 10) {
								//$childtitle = $child->title() . ' - ' . $sitemaptitle  . ' - ' . $parent->find('/')->layout_id;
								$childtitle = $child->title();
								$sitemaplinktitle = '';
							} else {
								$childtitle = $child->breadcrumb();
								$thischild = $parent->find($child->url);
								//$sitemaplinktitle = ' '.sitemaplink($child,false);
								$sitemaplinktitle = ' '.sitemaplink($thischild,false);
							}
						 	$description = '';
							//if($child->content('redirect') != null){


							if((function_exists('robotredirect') && robotredirect($child,'return') == '') || (!function_exists('robotredirect') && $child->content('redirect') == null)){
								
								if((function_exists('robotredirect') && robotredirect($child,'return') != '') || (!function_exists('robotredirect') && $child->content('redirect') != null)){
									if(function_exists('robotredirect') && robotredirect($child,'return') != ''){
										$redirect = robotredirect($child,'return');
									} else {
										$redirect = $child->content('redirect');
									}


									$href = strip_tags($redirect);
									$pageExtension = extension($child->url);
									if($pageExtension == '') $href = $href.URL_SUFFIX;


									if($sitemapheadings == true) {
										$childlink = '<h2><a href="'.$href.'">'.$childtitle.'</a></h2>';
									} else {
										$childlink = '<a href="'.$href.$mobile_string.'">'.$childtitle.'</a>';
									}
									if($sitemapdescription == true){
										$description = '<p>'.$child->find($redirect)->description().'</p>';
										if($description != ''){
											$childlink .= $description;
										}
									}

								} else {

									// Maximize copyright link for sitemap entry
									if($child->slug() == 'copyright' && $ulid == 'sitemap'){
										if($sitemaptitle == 'title' && (Plugin::isEnabled('copyright') == true && Plugin::getSetting('linkback', 'copyright') != '')){
											//$childtitle = ucfirst(displayCopyright());
										} else {
											if($child->slug() == 'copyright' && $parent->find('/')->layout_id != 10){
												$childtitle = '[copyright]';
											}
										}
									}

									$href = '/'.$child->url;
									$pageExtension = extension($child->url);
									if($pageExtension == '') $href = $href.URL_SUFFIX;


									/* Check if title attribute is empty or is new/updated */
									//$sitemaplinktitle = 'title="updated"';
									$thischild = $parent->find($child->url);
									//$sitemaplinktitle = pageisnew($child);

									if(Plugin::isEnabled('funky_cache') != true){
										//if($parent->funky_cache_enabled == 1){
											$sitemaplinktitle = pageisnew($thischild);
										//}
									}

									if($sitemaplinktitle != '' && $sitemaplinktitle != ' title=""'){
										//$childlink = $child->link($childtitle,$sitemaplinktitle);
										//$childlink = '<a href="'.$href.'"'.$sitemaplinktitle.'>'.$childtitle.'</a>';
										
										/*
										$livecheck = Plugin::getSetting('noticelivecheck', 'seobox');
										$updatefrom = 'updated_on';
										$createdfrom = 'created_on';
										$liveddays = 0;
										$livedate = Plugin::getSetting('livedate', 'copyright');
										$startdate = date('Y-m-d');
										$updatedate = substr($child->$updatefrom,0,10);
										$updatedays = dateDiff($updatedate,$startdate);
										$createddate = substr($child->$createdfrom,0,10);
										$createddays = dateDiff($createddate,$startdate);
										if($livedate != '') $liveddays = dateDiff($livedate,$startdate);
										if(($livecheck == true && $liveddays > $countdays) || $livecheck == false){
											if($createddays < $countdays){
												$title = 'New ';
											} else if($updatedays < $countdays){
												$title = 'Update ';
											}
										}
										*/

										//$childlink = '<a href="'.$href.'"'.$sitemaplinktitle.'>'.$childtitle.' ('.$title.$parent->find($child->url)->updated_on.')</a>';
										$childlink = '<a href="'.$href.$mobile_string.'"'.$sitemaplinktitle.'>'.$childtitle.'</a>';
									} else {
										//$childlink = $child->link($childtitle);
										$childlink = '<a href="'.$href.$mobile_string.'">'.$childtitle.'</a>';
									}


									if($sitemapheadings == true) {
										$childlink = '<h2>'.$childlink.'</h2>';
									} else {
										$childlink = $childlink;
									}
									if($sitemapdescription == true){
										$description = '<p>'.$child->description().'</p>';
									}
									$childlink .= $description;


								}
								
								if(function_exists('removearticledate')){
									$childlink = removearticledate($childlink);
								} else {
									$pattern = '/(\d+)\/(\d+)\/(\d+)\//';
									$childlink = preg_replace($pattern,'',$childlink);
								}

								if($match != 'found') $out .= '<li id="'.$child->slug().'-'.$ulid.'"'.$selected.'>'.$childlink.snippet_sitemap($startparent,$child,$ulid,$passcount,$level,$limits,$exclude).'</li>';


							} else {
								
								//echo '[build:'.$child->slug.']';

						  	   	if(function_exists('robotredirect') && robotredirect($child,'return') != ''){
									$redirect = robotredirect($child,'return');
								} else {
									$redirect = $child->content('redirect');
								}


								if(!function_exists('endsWith')){
									function endsWith($FullStr, $needle){
										$StrLen = strlen($needle);
										$FullStrEnd = substr($FullStr, strlen($FullStr) - $StrLen);
										return $FullStrEnd == $needle;
									}
								}

								$href = strip_tags($redirect);
								$pageExtension = extension($child->url);


								if($parent->layout_id != '10'){
									if($pageExtension == '' && endsWith($href,'/') == false) $href = $href.URL_SUFFIX;
								}
									

								if($sitemapheadings == true) {
									$childlink = '<h2><a href="'.$href.$mobile_string.'">'.$childtitle.'</a></h2>';
								} else {
									$childlink = '<a href="'.$href.$mobile_string.'">'.$childtitle.'</a>';
								}
								if($sitemapdescription == true){
									$description = '<p>'.$child->find($redirect)->description().'</p>';
									if($description != ''){
										$childlink .= $description;
									}
								}
								if(function_exists('removearticledate')){
									$childlink = removearticledate($childlink);
								} else {
									$pattern = '/(\d+)\/(\d+)\/(\d+)\//';
									$childlink = preg_replace($pattern,'',$childlink);
								}

								if($match != 'found') $out .= '<li id="'.$child->slug().'-'.$ulid.'"'.$selected.'>'.$childlink.snippet_sitemap($startparent,$child,$ulid,$passcount,$level,$limits,$exclude).'</li>';

							}

						}

					}

				}
				$out.= '</ul>';

				$out = str_replace('[client]',clientname(),$out);
				$out = str_replace('[clientname]',clientname(),$out);
				if(Plugin::isEnabled('copyright') != true) $out = str_replace('[copyright]','Copyright',$out);
				$out = str_replace('[telephone]',clienttelephone($parent),$out);
				$out = str_replace('[address]',clientaddress($parent),$out);
				$out = str_replace('[location]',clientlocation($parent),$out);
				$out = str_replace('[email]',clientemail($parent),$out);

			}


		/* Check proposal child link */
		if($parent->layout_id == '10'){
			//echo $out;
			//exit;
			$out = str_replace('href="', 'href="/', $out);
			$out = str_replace('href="//', 'href="/', $out);
			$out = str_replace('href="/http', 'href="http', $out);
		}


		$out = str_replace(URL_SUFFIX.URL_SUFFIX, URL_SUFFIX, $out);
		return str_replace('<ul></ul>','',$out);
	}
	}

	echo snippet_sitemap($parent,$parent->find('/'),$ulid,0,0,$limits,$exclude);
	echo setglobal('SITEMAP','true');
}
}


if(!function_exists('clientdetails_location')){
function clientdetails_location() {
	return Plugin::getSetting('clientlocation', 'seobox');
}
}

if(!function_exists('clientdetails_analytics')){
function clientdetails_analytics() {
	return Plugin::getSetting('clientanalytics', 'seobox');
}
}

if(!function_exists('clientdetails_analyticspolicy')){
function clientdetails_analyticspolicy() {
	if(Plugin::getSetting('clientanalyticspolicy', 'seobox') != '' && Plugin::getSetting('clientanalytics', 'seobox') != '' && (Plugin::getSetting('clientanalyticsstatus', 'seobox') != 'off' && Plugin::getSetting('clientanalyticsstatus', 'seobox') != '')){
		//if(Plugin::getSetting('clientanalytics', 'seobox') != 'UA-XXXXX-X' && Plugin::getSetting('clientanalytics', 'seobox') != ''){
			return Plugin::getSetting('clientanalyticspolicy', 'seobox');
		//}
	} else {
		return null;
	}
}
}

if(!function_exists('googleAnalytics')){
function googleAnalytics($parent){
	$gacode = Plugin::getSetting('clientanalytics', 'seobox');
	$noscript = Plugin::getSetting('clientanalyticsnoscript', 'seobox');
	if($gacode == ''){
		ob_start();
		$parent->includeSnippet('analytics');
		$gacode = ob_get_clean();
	}
	$url = '';
	$referer = '';
	//if(MOBILEMODE == TRUE){
		$gacode = str_replace('UA-','MO-',$gacode);
	//}
	$url .= "/track/ga.php?";
	$url .= "utmac=" . $gacode;
	$url .= "&utmn=" . rand(0, 0x7fffffff);
	if(Plugin::isEnabled('funky_cache') != true){
		if(isset($_SERVER['HTTP_REFERER'])){ $referer = $_SERVER["HTTP_REFERER"]; }
	}

	//if($noscript == 'on'){
		$utmp = '/nojavascript' . $_SERVER['REQUEST_URI']; // track js activity
		$url .= "&utmp=".$utmp;
	//}

	$query = $_SERVER["QUERY_STRING"];
	$path = $_SERVER["REQUEST_URI"];
	//if (empty($referer)) {
	if ($referer == '') {
		$referer = "-";
	}
	$url .= "&utmr=" . urlencode($referer);
	if (!empty($path)) {
		$url .= "&utmp=" . urlencode($path);
	}
	$url .= "&guid=ON";
	return str_replace("&", "&amp;", $url);
}
}

if(!function_exists('setanalytics')){
function setanalytics($parent){
	
	if(!function_exists('curPageName')){
		function curPageName(){
			 //return substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'],"/")+1);
			 return substr(strtok($_SERVER['REQUEST_URI'],'?'),strrpos(strtok($_SERVER['REQUEST_URI'],'?'),"/")+1);
		}
	}
	$checkPage = curPageName();
	//echo $checkPage;

	//  NOT WORKING: Ignore direct success pages won't work with post check, as success page is redirect not post
	//if($checkPage != 'success'.URL_SUFFIX || ($checkPage == 'success'.URL_SUFFIX && isset($_POST['submit']))){


		/* Determine script type (remove for HTML5) */
		if($parent->layout_id == '17' || ($parent->parent && $parent->parent->layout_id == '17')){
			$script_type = '';
		} else {
			$script_type = ' type="text/javascript"';
		}

		$seo = Plugin::getSetting('clientanalyticsstatus', 'seobox');
		//AuthUser::load();
		//if(!AuthUser::isLoggedIn()){

		if($seo == true){
			
			/* NEW Universal Analytics Support */
			$analyticsVersion = Plugin::getSetting('clientanalyticsversion', 'seobox');
			
			//echo 'Test';
			//exit;
			
			$br = "";
			if(DEBUG == true){
				$br = "\n";
			}
			
			$gacode = Plugin::getSetting('clientanalytics', 'seobox');
			$clientanalyticslinks = Plugin::getSetting('clientanalyticslinks', 'seobox');
			$subdomain = Plugin::getSetting('clientanalyticssubdomain', 'seobox');
			$noscript = Plugin::getSetting('clientanalyticsnoscript', 'seobox');
	
			if((isset($_GET['media']) && $_GET['media'] == 'mobile') || mobiledevice() == TRUE){
				$media = 'Mobile | ';
			} else if(isset($_GET['media']) && $_GET['media'] == 'print'){
				$media = 'Print | ';
			} else if(isset($_GET['media']) && $_GET['media'] == 'pdf'){
				$media = 'PDF | ';
			} else {
				$media = '';
			}
	
			if($gacode != '' && clientdetails_analyticspolicy() != ''){
				$analytics = '';
	
	
	
				/* Get 404 pageviews and referring page, passed from page_not_found plugin */
				$trackPageviewParams = '';
				if(isset($_GET['404'])){
					$page404 = str_replace('/search','',$_SERVER["REQUEST_URI"]);
					$page404 = str_replace('?404=Error','',$page404);
					//if($analyticsVersion == 'universal'){
					//	$trackPageviewParams = ", '404', 'Visit', '404 Error Page - Visit - Page'";
					//} else {
						/* Track 404 pageviews in Google Analytics: Create a new custom report with the following (http://www.thepiepers.net/blog/bryan-pieper/2011/06/google-analytics-track-404-pages/):
						Filter: Include Page [regex=^/404.html]
						Metrics:
							Pageviews
							Bounce Rate
							Avg Time on Page
							Avg Time on Site
						Segments: Page
						*/
						if($_GET['404'] != '' && $_GET['404'] != 'Error'){
							$page404 = str_replace('?404=','?referrer=',$page404);
						} else {
							$page404 = str_replace('?404=','',$page404);
						}
						$trackPageviewParams = ", '/404".$page404."'";
					//}
				}


				/*
				Event Actions should be UNIQUE across CATEGORIES, else they will be tracked as the same event
				http://www.optimizesmart.com/event-tracking-guide-google-analytics-simplified-version/
				*/
	

				//$analytics .= '<script type="text/javascript">document.getElementById(\'tracknumber\').onclick=function(){pageTracker._trackPageview('."'/track/telephone".URL_SUFFIX."'".');}</script>';
				//$analytics .= '<script type="text/javascript">var pageTracker=_gat._getTracker("'.$gacode.'");pageTracker._trackPageview();</script>';
				if(stristr($gacode,'<script')){
	
					if($subdomain == 'yes' && !stristr($gacode, '_setDomainName')){
						$gacode = str_replace("_gaq.push(['_trackPageview']);", "_gaq.push(['_setDomainName','".$_SERVER["SERVER_NAME"]."']);_gaq.push(['_trackPageview']);", $gacode);
					}
					$analytics .= $gacode;
	
				} else {

					$analytics .= '<script'.$script_type.'>'.$br;
					if($analyticsVersion == 'universal'){
					/* Universal Analytics */
						$analytics .= "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;".$br;
						$analytics .= 'i[r]=i[r]||function(){'.$br;
						$analytics .= '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'.$br;
						$analytics .= 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;'.$br;
						$analytics .= "m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');".$br;
						$analytics .= "ga('create', '".$gacode."');".$br;
						$analytics .= "ga('send', 'pageview'".$trackPageviewParams.");".$br;
					} else {
					/* Classic Analytics (default) */
						$analytics .= 'var _gaq = _gaq || [];'.$br;
						$analytics .= '_gaq.push([\'_setAccount\', \''.$gacode.'\']);'.$br;
		
						if($subdomain == 'yes'){
						$analytics .= '_gaq.push([\'_setDomainName\', \''.$_SERVER["SERVER_NAME"].'\']);'.$br;
						}
		
						$analytics .= '_gaq.push([\'_trackPageview\''.$trackPageviewParams.']);'.$br;
						$analytics .= '(function(){'.$br;
						$analytics .= 'var ga = document.createElement(\'script\');'.$br;
						$analytics .= 'ga.type = \'text/javascript\';'.$br;
						$analytics .= 'ga.async = true;'.$br;
						$analytics .= 'ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';'.$br;
						$analytics .= 'var s = document.getElementsByTagName(\'script\')[0];'.$br;
						$analytics .= 's.parentNode.insertBefore(ga, s);'.$br;
						$analytics .= '})();'.$br;
					}
					$analytics .= '</script>'.$br;
	
					//echo $analytics;
	
	
					/* Track links */
					if($clientanalyticslinks == 'on'){
	
						/* Category (Required. The name you supply for the group of objects you want to track. Recommend using something like "Login") */
						$trackCategory = "'Links'";
		
						/* Action (Required. Used to define the type of user interaction. Recommend using something like "Account Login" or "Download 2003 Whitepaper") */
						$trackAction = "'Clicked'";
						
						/* Label (Optional. Recommend using something to further describe the user interaction (e.g. "Clicked").) */
						$trackLabel = "'Phone Call'";

						/* Value (Optional. If you'd like to assign a numeric value to your user interaction, enter that value here) */
						$trackValue = "";
						
						/* Non-Interaction (Optional. Select "true" if you want to consider it a bounce when a visitor views one page, submits a contact form and leaves without viewing any other pages.) */
						$trackInteraction = "false";
		
						// $trackEvent = "pageTracker._trackPageview(\'/track/telephone'.URL_SUFFIX.'\');";
						//$trackEvent = "_gaq.push(['_trackEvent', $trackCategory, $trackAction, $trackLabel, $trackValue, $trackInteraction]);";
						if($analyticsVersion == 'universal'){
							$trackPhone = "ga('send', 'event', $trackCategory, $trackAction, 'Mobile Call');";
							$trackEmail = "ga('send', 'event', $trackCategory, $trackAction, 'Mobile Email');";
						} else {
							$trackPhone = "_gaq.push(['_trackEvent', $trackCategory, $trackAction, 'Mobile Call']);";
							$trackEmail = "_gaq.push(['_trackEvent', $trackCategory, $trackAction, 'Mobile Email']);";
						}
		
						// 1. Open up the Google Analytics profile you wish to set up the goal in.
						// 2. Click the gear icon in the upper right corner of the Google Analytics interface.
						// 3. Click the Goals tab (in the sub-navigation just below where your Profile is listed)
						// 4. Choose the Goal Set you wish to add the event to.
						// 5. Name your goal and select the Event radio button.
						// 6. Populate the following goal details using consistent naming conventions:
		
						// Category = kind of link
						// Action = name of link
						// Label = page or location of the link

						// Category | that matches | Contact
						// Action | that matches | Phone Call
						// Label | that matches | Clicked

						// Category | that matches interactive widgets and links | Banners
						// Action | that matches the page for the link | Sales Page
						// Label | that matches where on the page banner was clicked | Right Sidebar
		
						// Category | that matches | RSS
						// Action | that matches | Click RSS
						// Label | that matches | All Pages - Sidebar Widget - RSS - Text Link
						// Value | that matches |
						
						// Category | that matches | 404
						// Action | that matches | Visit 404
						// Label | that matches | 404 Error Page - Visit - Page
						// Value | that matches |
		
						// Category | that matches | Searched
						// Action | that matches | Submitted Search
						// Label | that matches | All Pages - Header Right - Search - Form
						// Value | that matches |
		
						// Category | that matches | Form Errors
						// Action | that matches | Email Not Provided

						// Category | that matches | Search Results
						// Action | that matches | No Search Results
						// Label | that matches | [Search phrase here]
						// Value | that matches | 1
						// Non-Interactive | that matches | true
		
						// Category | that matches | Forms
						// Action | that matches | Print
						// Label | that matches | Print view
		
						// Category | that matches | Forms
						// Action | that matches | Subscribe
						// Label | that matches | Sidebar
		
						// Category | that matches | Videos
						// Action | that matches | Play
						// Label | that matches | File
		
						// Category | that matches | Videos
						// Action | that matches | Video Views
						// Label | that matches | Video #1
		
						// Category | that matches | Podcasts
						// Action | that matches | Download
						// Label | that matches | Issue 1 Overview
		
						// Category | that matches | Downloads
						// Action | that matches | Podcast
						// Label | that matches | Issue 1 Overview
		
						// Category | that matches | Call to Actions
						// Action | that matches | Click
						// Label | that matches | Button 1
		
						// Category | that matches | Call to Action
						// Action | that matches | Contact > Telephone
						// Label | that matches | Call 01242 500500
		
						// Category | that matches | Ads
						// Action | that matches | Free Ad
						// Label | that matches | Company Fullpage Banner
		
						// Category | that matches | Call to Action
						// Action | that matches | Signup
						// Label | that matches | Free Trial in Sidebar
		
						// Category | that matches | Social Media
						// Action | that matches | Facebook
						// Label | that matches | Follow in Footer
		
						// Category | that matches | PDFs
						// Action | that matches | Downloaded
						// Label | that matches | Tutorial
		
						// Category | that matches | PDFs
						// Action | that matches | Viewed online
						// Label | that matches | 2013 Whitepaper
						// Show me visitors who viewed PDFs and which ones
		
						// Category | that matches | Donwloads
						// Action | that matches | Viewed PDF in header
						// Label | that matches | 2013 Whitepaper
		
						// Category | that matches | Banners
						// Action | that matches | Clicks
						// Label | that matches | Banner #1
		
						// Category | that matches | Errors
						// Action | that matches | Contact Form
						// Label | that matches | Name
		
						// Category | that matches | Logins
						// Action | that matches | Steven
						// Label | that matches | Monday 17:30
		
						// Category | that matches | External Link
						// Action | that matches | Click
						// Label | that matches | External Website #1
		
						// Category | that matches | Links
						// Action | that matches | Clicked Email
						// Label | that matches | johm@smith.com
		
						// Category | that matches | Guides
						// Action | that matches | Download
						// Label | that matches | Guide #1
		
						// Category | that matches | Maps
						// Action | that detects requests for | Driving Directions
						// Label | the location the user wants directions to | Moon
		
						// Category | that defines which form is flagging errors | Registration Errors
						// Action | that matches field | Email Address
						// Label | that describes validation rule and value that broke it | Valid Email|yahoo.com
		
						// Category | that matches | Outgoing Links
						// Action | that matches | Advert #1
						// Label | that matches | Blog Sidebar


						// Category | that matches | Consumption
						// Action | that matches | Article Load
						// Label | that matches | [URL here]
						// Value | that measures amount of page scrolled | 1-100
						// Non-Interactivity | that matches | true

						//   How to Use This Custom Event: Definitely read Cutroni's post to implement this Everest-sized event. Actually, this tracking will consist of multiple custom events. First, you'll load the event shown above when the page first loads, using the page's URL as the label and using "100" as the value. Make sure non-interaction is set to true.
						//   Next, you'll set up another custom event when the user first scrolls on the page. Tweak the first custom event you created by changing the value to "75" and by removing the non-interaction value. Create a third event that fires when the user reaches the bottom of the article, being sure to change the value to "50." Finally, create a fourth event that fires when a user reaches the bottom of the page ? this event should have a value of "25."
						//   Once you've set up all of these events on your blog, you'll be able to export the values from all of the events and create an index of your most popular articles. Higher numbers mean less content consumption while lower average numbers indicate your most engaging content.


						// Category | that matches | Estimation Calculator
						// Action | that matches | Calculate
						// Label | that matches | [ZIP]|[BUDGET]|[OPTION]
						// Value | that matches | [credits here]
						// Non-Interactivity | that matches | true

						//   How to Use This Custom Event: This event is probably the most abstract, so let's use a real life Google Analytics higher education case study.
						//   Rasmussen College implemented a tuition estimator on its site and wanted to know how a user's intended program of study, geography and number of transferable credits influenced their interest in the price of a program.
						//   They piped several user-entered values from the calculator into the label field (i.e., ZIP code, degree level and academic program) and the transferable credits into the value field by firing an event when users hit the calculate button.
						//   This level of insight into price sensitivity wouldn't be possible without the use of custom events.



						// 7. If you've added a Value in step 1, leave the "Use the actual Event Value" radio button selected.
						// 8. Click "Save" and you're ready to go!
		
						/*
						if(MOBILEMODE == TRUE){
							echo '<script type="text/javascript">function addLoadEvent(func){var oldonload = window.onload;if (typeof window.onload != \'function\'){window.onload=func;} else {window.onload=function(){if(oldonload){oldonload();};func();};};};addLoadEvent(function(){';
							echo 'var p=document.getElementById(\'tracknumber\');if(p){';
							echo 'document.getElementById(\'tracknumber\').onclick=function(){'.$trackPhone.'}';
							echo '}';
							echo 'var p=document.getElementById(\'trackemail\');if(p){';
							echo 'document.getElementById(\'trackemail\').onclick=function(){'.$trackEmail.'}';
							echo '}';
							echo '})</script>';
						}
						*/


		
						$script = '';
						/* Under development. Need to check if link tracking works */
						/* http://dicabrio.com/javascript/unobtrusive-google-analytics.php */
						/* Google Analytics -> Content Optimization -> Content Performance -> Content Drilldown */
						//if(MOBILEMODE == TRUE){
							$script .= '<script'.$script_type.'>'."\n";






							/* TESTING */
							/* Add screen size functions to jscrpts if required by seobox analytics (tends to use doc size, not device size) */
							/*
							$script .= "var docsize = getwinsize(); var orientation = '';";
							$script .= "if(docsize.y > docsize.x){ orientation = ' (portrait)'; };";
							$script .= "var stats = docsize.x + ' x ' + docsize.y + orientation;";
							$script .= "document.write(stats);";


							if(DEBUG == true){
								//if(function_exists('analyticsPush')){
									//$script .= analyticsPush(false, '_trackEvent', 'Screen Stats', 'Pixels Scrolled', f(n), 1, !0);
									$script .= "alert('_trackEvent, Screen Stats, Pixel Depth, ' + screenstats + ', 1, !0');";
								//}
							} else {
								if(function_exists('analyticsPush')){
									//$script .= analyticsPush(false, '_trackEvent', 'Screen Stats', 'Pixels Scrolled', f(n), 1, !0);
									//$script .= analyticsPush(false, '_trackEvent', 'Screen Stats', 'Pixel Depth', 'screenstats', 1, !0);
								}
							}
							*/








							$script .= 'function addLoadEvent(func){'."\n";
								$script .= 'var oldonload = window.onload;'."\n";
								$script .= 'if (typeof window.onload != \'function\'){'."\n";
								$script .= 'window.onload=func;'."\n";
								$script .= '} else {'."\n";
								$script .= 'window.onload=function(){if(oldonload){oldonload();};func();};};'."\n";
							$script .= '};'."\n";
							$script .= 'addLoadEvent(function(){'."\n";
		
								$script .= "window.stop = '';"."\n";
		
								//$script .= "window.onload = setLinkBehaviours;";
								//$script .= "function setLinkBehaviours(){";
								$script .= "var Links = document.getElementsByTagName('A');"."\n";
			
								$script .= "for(var i = 0; i < Links.length; i++){"."\n";
								$script .= "if(Links[i].innerHTML != ''){"."\n";
								//$script .= "alert(Links[i]);";
								//$script .= "Links[i].onmouseover = findDivId";
								//$script .= "Links[i].onkeydown = findDivId;"."\n";
								$script .= "Links[i].onclick = findDivId;"."\n";
								//$script .= "Links[i].onkeydown  = confirmObject;";
								//$script .= "Links[i].onclick = confirmObject;";
								$script .= "}"."\n";
								$script .= "}"."\n";
		
								//$script .= "function confirmObject(e){"."\n";
									//$script .= "var keycode;";
									//$script .= "if (window.event){ keycode = window.event.keyCode;";
									//$script .= "} else if (e){ keycode = e.which;";
									//$script .= "};";
		
									//$script .= "var e = e || window.event;"."\n";
									//$script .= "var typ = e.type;"."\n";
									//$script .= "var obj = this || document.activeElement;"."\n";
									//$script .= "alert('Confirmed: ' + document.activeElement.tagName);";
									//$script .= "findDivId;"."\n";
								//$script .= "};"."\n";
		
								$script .= "function findDivId(e){"."\n";
									//$script .= "var evt = e || window.event;"."\n";
									//$script .= "var keycode = evt.which || evt.keyCode;"."\n";
									//$script .= "alert('Type: ' + evt.type);"."\n";
		
									//$script .= "alert('Stop: ' + window.stop);"."\n";
		
									/* Work out if key was pressed on page */
									//$script .= "alert('Keycode: ' + keycode);"."\n";
		
									//$script .= "var typ = evt.type;"."\n";
									$script .= "var obj = this || document.activeElement;"."\n";
		
								//$script .= "function findDivId(e,typ,obj,keycode) {";
									//$script .= "if((typ == 'click' && window.stop != 'stop') || (typ == 'keydown' && keycode == 13)){"."\n";
		
										//$script .= "alert(typ);";
										//$script .= "alert(obj.href);";
		
										$script .= "var idx = ['legal','nav','navigation','main','date-go','options'];"."\n";
										$script .= "var tagx = ['LI','UL','A'];"."\n";
										//$script .= "var srcElement = '';";
										$script .= "var targ = e.target || srcElement;"."\n";
										$script .= "var thisRef = obj.href;"."\n";
										$script .= "var thisExt = obj.href.split('.').pop();"."\n";
										$script .= "var dad = targ.id;"."\n";
		
										$script .= "if(thisRef == undefined || thisRef == ''){ thisRef = obj; }"."\n";
		
										$script .= "while((targ = targ.parentNode) && targ.tagName != 'BODY' && idx.indexOf(targ.id) == -1);"."\n";
										$script .= "var cat = 'Links';"."\n";
										$script .= "var dad = targ;"."\n";
										$script .= "var thisDad = dad.id;"."\n";
		
										$script .= "if(dad){"."\n";
					
										$script .= "String.prototype.capitalize = function(){"."\n";
										$script .= "return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );"."\n";
										$script .= "};"."\n";
					
										$script .= "thisDad = thisDad.toLowerCase().capitalize();"."\n";
		
										$script .= "if(dad.id == 'date-go' || dad.id == 'legal'){thisDad = 'Footer'}; if(dad.id == 'options'){thisDad = 'Page Options'};"."\n";
										$script .= "if(obj.parentNode.className == 'followup'){thisDad = 'Follow Up';};"."\n";
					
										$script .= "if(obj.title != ''){thisRef = obj.title;};"."\n";
					
										/* Shadowbox requires images to use absolute paths */
										//$script .= "	var domain = window.location.protocol + \"//\" + window.location.host;";
										//$script .= "	thisRef = thisRef.replace(domain, '');";
					
										//$script .= "		if(this.data-event != '' && this.data-event != null && this.data-event != undefined){";
										//$script .= "_trackPageview(this.data-event);";
										//$script .= "_gaq.push(['_trackEvent', this.data-event, $trackAction]);";
										//$script .= "		} else if(this.title != '' && this.title != null && this.title != undefined){";
										//$script .= "_trackPageview(this.title);";
										//$script .= "_gaq.push(['_trackEvent', this.title, $trackAction]);";
										//$script .= "		} else {";
										//$script .= "_trackPageview(this.href);";
										//$script .= "_gaq.push(['_trackEvent', this.href, $trackAction]);";
										//$script .= "		};";
		
										//$script .= "		alert('TAG = ' + dad.tagName + ' ID = ' + dad.id + ' HREF = ' + thisRef);";
		
										//$script .= "		_trackPageview(this.data-event);";
										//$script .= "		_gaq.push(['_trackEvent', this.data-event, $trackAction]);";
				
										//$script .= "		_gaq.push(['_trackEvent', 'Links', '".$media."' + dad.tagName]);";
										//$script .= "		_gaq.push(['_trackEvent', 'Downloads', 'PDF', 'file.pdf');";
										//$script .= "		_gaq.push(['_trackEvent', 'Videos', 'play', 'video.file');";
										//$script .= "		_gaq.push(['_trackEvent', 'Forms', 'fieldfocus', 'submit');";
		
		
										//$script .= "typ = '';"."\n";
										/* Track links, determine what parent was clicked, what the link was, set a value, and then set non-interaction to true to unaffect bounce rate. */
										if(DEBUG == true){
											$script .= "	if(obj.text){ thisText = obj.text; } else { t = obj.href; thisText = t.substring(t.lastIndexOf('/')+1); }"."\n";
											//$script .= "	if(this.type == 'keypress'){ inputmethod = 'keyboard'; } else { inputmethod = 'mouse'; }"."\n";
											//$script .= "	alert('CAT: ' + cat + \"\\n\" + 'Text: ' + thisText + \"\\n\" + 'PARENT ID: ' + thisDad + \"\\n\" + 'CLASS: ' + this.className + \"\\n\" + 'URI: ' + thisRef + \"\\n\" + 'Path: ' + document.location.pathname + \"\\n\" + 'Ext: ' + thisExt);"."\n";
		
											//$script .= "	alert('Category: '  + \"\\t\" + cat + \"\\n\" + 'Action:		' + thisText + \"\\n\" + 'Label: ' + \"\\t\\t\" + thisDad);"."\n";
											//$script .= analyticsPush(false,'_trackEvent',cat,thisText,thisDad,'0','true');
											if(function_exists('analyticsPush')){
												$script .= analyticsPush(false, '_trackEvent', 'cat', 'thisDad', 'thisRef', '0', 'true');
											}
										} else {
											//$script .= "	_gaq.push(['_trackEvent', cat, thisDad, thisRef, 0, true]);"."\n";
											if(function_exists('analyticsPush')){
												$script .= analyticsPush(false, '_trackEvent', 'cat', 'thisDad', 'thisRef', '0', 'true');
											}
										}
										
										//$script .= "if(typ == 'keydown'){"."\n";
										//$script .= "window.stop = 'stop'; alert('stop');"."\n";
										//$script .= "if(keycode == 13) return false;";
										//$script .= "}"."\n";
		
		
									//$script .= "};"."\n";
		
								$script .= "};"."\n";
			
								//echo "	return false;";
								$script .= "};"."\n";

								//$script .= "assignClickEvent();";
							$script .= '})'."\n";
							$script .= '</script>'."\n";
		
							if(DEBUG != true){
								$script = strtr($script, array("\t" => "", "\n" => "", "\r" => ""));
							}
	
							echo $script;
		
					}
	
				}
				
				$gc = googleAnalytics($parent);
				/* Track pages on mobile, without requiring client-side javascript */
				if((!stristr($gc, 'UA-XXXXX-X') && !stristr($gc, 'MO-XXXXX-X')) || DEBUG == true){
					if($noscript == 'on'){
						$analytics .= '<noscript>';
						$analytics .= '<img src="'.$gc.'" class="tracker" alt="" />';
						$analytics .= '</noscript>';
					}
					$analytics .= $br;
				}



				
				/* Use Scroll Depth jQuery plugin here, after Google Analytics is loaded */
				$scrolldepthstatus = false;
				if($scrolldepthstatus == true){
					/* Setup public scrolldepth js */
					$scrolljspath = '/inc/js/';
					$scrolljsfile = 'scrolldepth.js';
					$scrolljsfilepath = $_SERVER{'DOCUMENT_ROOT'}.$scrolljspath.$scrolljsfile;
	
					/* Check for public scrolldepth js */
					if (!file_exists($scrolljsfilepath)) {
						ob_start();
						include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/seobox/lib/jquery.scrolldepth.min.js";
						$scrolljstemplate = ob_get_contents();
						ob_end_clean();

						$jssave = @fopen($scrolljsfilepath,'w+');
						fwrite($jssave,$scrolljstemplate);
						fclose($jssave);
					}
	
					$setupscroll = '<script src="'.$scrolljspath.$scrolljsfile.'"></script>'."\n";
					$setupscroll .= '<script>
					$(function() {
					  $.scrollDepth();
					});
					</script>';

					if(DEBUG != true){
						function compressspaces($data){
							return preg_replace("/\s+/", " ", $data);
						}
						$setupscroll = compressspaces($setupscroll);
					}
					$analytics .= $setupscroll;

				}







				echo $analytics;

				//if(!defined('COOKIES_IN_USE')){ define('COOKIES_IN_USE', true); }
	
			}
		//}
		}
		
	//}
}
}

if(!function_exists('analyticsPush')){
function analyticsPush($script=true,$track='_trackEvent',$category='',$action='',$label='',$value='0',$noninteraction='false'){

	$seo = Plugin::getSetting('clientanalyticsstatus', 'seobox');
	$clientanalyticslinks = Plugin::getSetting('clientanalyticslinks', 'seobox');

	/* NEW Universal Analytics Support */
	$analyticsVersion = Plugin::getSetting('clientanalyticsversion', 'seobox');

	if($seo != 'off' && $seo != '' && $clientanalyticslinks == 'on'){

		/* Check if tracking type is valid and that a category and action have been set */
		if(($track == '_trackEvent' || $track == 'event' || $track == '_trackPageview') && $category != '' && $action != ''){

			
			/* If page object not returned, set page to home page id, 1 */
			if(!isset($parent)){
				$parent = Page::findById(1);
			}


			/* Determine script type (remove for HTML5) */
			if($parent->layout_id == '17' || $parent->parent->layout_id == '17'){
				$script_type = '';
			} else {
				$script_type = " type='text/javascript'";
			}


			/* Determine if script tags are needed */
			$opentag = ""; $closetag = "";
			if($script == true){
				$opentag .= "<script".$script_type.">";
				$opentag .= "document.onreadystatechange = function(){";
				$opentag .= "if(document.readyState == 'loaded' || document.readyState == 'complete'){";
				
				$closetag .= "}";
				$closetag .= "}";
				$closetag .= "</script>";
			}
			
			/* Convert trackEvent if using universal analytics */
			if($analyticsVersion == 'universal'){
				if($track == '_trackEvent'){
					$track = 'event';
				}
			}

			/* Push or debug */
			if(DEBUG == true){
				//return $opentag."alert('".$action."');".$closetag;
				return $opentag."alert('Pathname: ' + \"\\t\" + window.location.pathname + \"\\n\" + 'Event: '  + \"\\t\\t\" + '".$track."' + \"\\n\" + 'Category: '  + \"\\t\" + ".$category." + \"\\n\" + 'Action:		' + ".$action." + \"\\n\" + 'Label: ' + \"\\t\\t\" + ".$label." + \"\\n\" + 'Value: ' + \"\\t\\t\" + ".$value." + \"\\n\" + 'No Bounce: ' + \"\\t\" + ".$noninteraction.");".$closetag."\n";
			} else {
				if($analyticsVersion == 'universal'){
					if($noninteraction == 'true'){
						$noninteraction = '';
					} else {
						$noninteraction = ", {'nonInteraction': 1}";
					}
					return $opentag.$setinteraction."ga('send', ".$track.", ".$category.", ".$action.", ".$label.", ".$value.$noninteraction.");".$closetag."\n";
				} else {
					return $opentag."_gaq.push(['".$track."', ".$category.", ".$action.", ".$label.", ".$value.", ".$noninteraction."]);".$closetag."\n";
				}
			}
	
		}

	}

}
}

// Determin if bots are allowed in robots (disallow when in test site mode)
if($_SERVER['REQUEST_URI'] == '/robots.txt'){
	$bots = Plugin::getSetting('bots', 'seobox');
	if($bots == 'disallow'){ header("Content-Type:text/plain"); ?>
User-agent: *
Disallow: /
	<?php exit; }
}