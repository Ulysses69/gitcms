<?php

if (!defined('COPYRIGHT_VERSION')) { define('COPYRIGHT_VERSION', '1.3.3'); }
if (!defined('COPYRIGHT_ROOT')) { define('COPYRIGHT_ROOT', URI_PUBLIC.'wolf/plugins/copyright'); }
Plugin::setInfos(array(
	'id'					=> 'copyright',
	'title'					=> 'Legal',
	'description'			=> 'Set company copyright/backlink.',
	'version'				=> COPYRIGHT_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));

if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	Plugin::addController('copyright', 'Legal', 'administrator', false);
}

if(!function_exists('displayCopyright')){
function displayCopyright($format='',$location=''){
	$done = '';
	$linkcustom = Plugin::getSetting('linkcustom', 'copyright');
	$livedate = Plugin::getSetting('livedate', 'copyright');
	if($linkcustom == ''){
		if($location == 'footer'){
			if(((isset($_GET['media']) && $_GET['media'] == 'mobile') || mobiledevice() == TRUE) && (Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('copyright', 'mobile_check') == true)){
				$copyright = 'Copyright &copy; Blue Horizons ';
			} else {
				$copyright = '&copy; ';
			}
		} else {
			$linkback = Plugin::getSetting('linkback', 'copyright');
			$linkback = preg_match_all("/(<a.*>)(\w.*)(<\/a>)/isxmU", $linkback, $matches);
			foreach($matches as $match){
				if($done != true){
					$done = true;
					if(!isset($match[0])) $match[0] = '';
					if(stristr($match[0],'dental')){
						$copyright = str_replace('Dental Marketing','dental marketing agency',$match[0]);
					} else {
						$copyright = str_replace('Marketing Agency','marketing agency',$match[0]);
					}
				}
			}
		}
	} else {
		$copyright = $linkcustom;
	}
	if($format == 'text'){
		$copyright = strip_tags($copyright);
		return $copyright;
	} else {
		echo $copyright;
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


if(!function_exists('displayUpdated')){
function displayUpdated($parent,$output='echo'){
	
	/* Get parent */
	if(!$parent){
		$parent = Page::findByUri(str_replace(URL_SUFFIX,'',$_SERVER['REQUEST_URI']));
	}

	$data = '';
	if(!stristr($_SERVER['REQUEST_URI'],'/search/')){
		$livedate = Plugin::getSetting('livedate', 'copyright');
		$Day = $parent->date('%d', 'updated');
		if(!isset($Month)) $Month = 0; if(!isset($Year)) $Year = 0;
		$TheDay = date("j", mktime(0, 0, 0, $Month, $Day, $Year)).date("S", mktime(0, 0, 0, $Month, $Day, $Year));
		$parentDate = $parent->date('%d of %B %Y', 'updated');
		
		/* Use live date */
		if($livedate != ''){
			if(strtotime($parent->updated_on) < strtotime($livedate)){
			//if($parent->date('%Y-%m-%d') < $livedate){
				$newDate = new DateTime($livedate);
				$data .= $newDate->format('jS \of F Y');
			} else {
			//} else if(strtotime($livedate) > strtotime($parent->date('%d of %B %Y', 'updated'))){
				$thedate = $parent->date('%d of %B %Y', 'updated');
				$Day = $parent->date('%d', 'updated');
				$TheDay = date("j", mktime(0, 0, 0, $Month, $Day, $Year)).date("S", mktime(0, 0, 0, $Month, $Day, $Year));
				$parentDate = $parent->date('%Y-%m-%d', 'updated');
				$newDate = new DateTime($parentDate);
				$data .= $newDate->format('jS \of F Y');
			}
		} else {
			$data .= str_replace($Day.' of', $TheDay.' of', $parentDate);
		}
	} else {
		$data .= date('Y');
	}
	
	if($output == 'echo'){
		echo $data;
	} else {
		return $data;
	}
}
}

if(!function_exists('copyrightDate')){
function copyrightDate($path=''){
	if($path == ''){
		$path = Page::findByUri(str_replace(URL_SUFFIX,'',$_SERVER['REQUEST_URI']));
	}

	if(!stristr($_SERVER['REQUEST_URI'],'/search/')){
		$copydate = '';
		$livedate = Plugin::getSetting('livedate', 'copyright');
		/* Use live date */
		if($livedate != ''){
			//$newdate = new DateTime($livedate);
			//$newdate->format('Y');
			//$createdDate = $livedate;
			//$createdDate = $newdate;
			$createdDate = date('Y', strtotime($livedate));
		} else {
			$createdDate = $path->date('%Y', 'created');
		}
		if($createdDate != date('Y')){
			$copydate .= $createdDate.'-'.date('Y');
		} else {
			$copydate = $createdDate;
		}
		//$copydate .= date('Y');
		return $copydate;
	} else {
		return date('Y');
	}
}
}

if(!function_exists('icoRegistered')){
function icoRegistered(){
	$registrant = Plugin::getSetting('icoregistrant', 'copyright');
	if(isset($registrant) && $registrant != ''){
		return true;
	} else {
		return false;
	}
}
}
if(!function_exists('cqcRegistered')){
function cqcRegistered(){
	$cqcnumber = Plugin::getSetting('cqcnumber', 'copyright');
	$cqcurl = Plugin::getSetting('cqcurl', 'copyright');
	if((isset($cqcnumber) && $cqcnumber != '') || (isset($cqcurl) && $cqcurl != '')){
		return true;
	} else {
		return false;
	}
}
}
if(!function_exists('gdcRegistered')){
function gdcRegistered(){
	/* Get gdc value */
	$gdc_sql = "SELECT * FROM ".TABLE_PREFIX."page_part WHERE name='gdc'";
	$gdc_q = Record::getConnection()->query($gdc_sql);
	$gdc_f = $gdc_q->fetchAll(PDO::FETCH_OBJ);
	foreach ($gdc_f as $gdc) {
			if($gdc->content != '' || $gdc->content_html != ''){
			 	return true;
			}
	}
	return false;
}
}


if(!function_exists('dataRegistration')){
function dataRegistration(){
	$number = Plugin::getSetting('iconumber', 'copyright');
	if($number != ''){
		return $number;
	} else {
		return 'presently unavailable';
	}
}
}
if(!function_exists('dataRegistrarAddress')){
function dataRegistrarAddress($flatten=false){
	$address = Plugin::getSetting('icoaddress', 'copyright');
	if($address != ''){
		if($flatten==true) $address = nl2br($address);
		return $address;
	} else {
		return 'not presently registered';
	}
}
}
if(!function_exists('dataController')){
function dataController(){
	$controller = Plugin::getSetting('icoregistrant', 'copyright');
	if($controller != ''){
		return $controller;
	} else {
		return 'not presently registered';
	}
}
}




if(!function_exists('gdcNumber')){
function gdcNumber(){
	$number = Plugin::getSetting('gdcnumber', 'copyright');
	if($number != ''){
		return $number;
	} else {
		return 'presently unavailable';
	}
}
}
if(!function_exists('gdcUrl')){
function gdcUrl(){
	$url = Plugin::getSetting('gdcurl', 'copyright');
	if($url != ''){
		return $url;
	}
}
}



if(!function_exists('cqcUrl')){
function cqcUrl(){
	$url = Plugin::getSetting('cqcurl', 'copyright');
	$cqcnumber = Plugin::getSetting('cqcnumber', 'copyright');
	$name = Plugin::getSetting('cqcname', 'copyright');
	if($cqcnumber != ''){
		$testurl = 'http://www.cqc.org.uk/location/'.$cqcnumber;
		$array = get_headers($testurl);
		$string = $array[0];
		if($url == ''){
			if(strpos($string,"200")) {
			    $url = $testurl;
			} else {
			    if($name != ''){
					$url = 'http://www.cqc.org.uk/search/site/'.urlencode($name);
				} else {
					$url = '';
				}
			}
		}
	}
	if($url != '' ){
		return $url;
	} else {
		$param = '';
		if(Plugin::getSetting('schema', 'clientdetails') != ''){
			$param = Plugin::getSetting('schema', 'clientdetails');
		}
		return 'http://www.cqc.org.uk/search-criteria/'.$param;
	}
}
}

if(!function_exists('cqcName')){
function cqcName(){
	$name = Plugin::getSetting('cqcname', 'copyright');
	if($name != ''){
		return $name;
	}
}
}