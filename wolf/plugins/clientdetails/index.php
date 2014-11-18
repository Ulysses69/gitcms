<?php

if (!defined('CLIENTDETAILS_VERSION')) {	define('CLIENTDETAILS_VERSION', '2.5.0'); }
if (!defined('CLIENTDETAILS_ID')) {			define('CLIENTDETAILS_ID', 'clientdetails'); }
if (!defined('CLIENTDETAILS_TITLE')) {		define('CLIENTDETAILS_TITLE', 'Clientdetails'); }
if (!defined('CLIENTDETAILS_DESC')) {		define('CLIENTDETAILS_DESC', 'Manage client details'); }
if (!defined('CLIENTDETAILS_ROOT')) {		define('CLIENTDETAILS_ROOT', URI_PUBLIC.'wolf/plugins/'.CLIENTDETAILS_ID); }

Plugin::setInfos(array(
	'id'					=> CLIENTDETAILS_ID,
	'title'					=> CLIENTDETAILS_TITLE,
	'description'			=> CLIENTDETAILS_DESC,
	'version'				=> CLIENTDETAILS_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));

/* Check if this plugin is enabled */
if(Plugin::isEnabled(CLIENTDETAILS_ID)){

	if(!defined('CLIENTDETAILS_ROOT')){
		define('CLIENTDETAILS_ROOT', URI_PUBLIC.'wolf/plugins/clientdetails');
	}
	
	if(!AuthUser::hasPermission('client') && Plugin::isEnabled('dashboard') == true) {
		Plugin::addController('clientdetails', 'Client', 'administrator', false);
	} else {
		Plugin::addController('clientdetails', 'Details', 'administrator', true);
	}
	
	/*
	if($page->slug == 'clientdetails'){
	Observer::observe('view_backend_list_plugin', 'client_mobile');
	
	function client_mobile($page) { ?>
	<p>Client mobile details</p>
	<?php }
	}
	*/



	if(!function_exists('clientdetails_name')){
		function clientdetails_name() {
			return Plugin::getSetting('clientname', 'clientdetails');
		}
	}
	if(!function_exists('clientdetails_slogan')){
		function clientdetails_slogan() {
			return Plugin::getSetting('clientslogan', 'clientdetails');
		}
	}
	if(!function_exists('clientdetails_town')){
		function clientdetails_town() {
			return Plugin::getSetting('clientaddress_town', 'clientdetails');
		}
	}
	if(!function_exists('clientdetails_county')){
		function clientdetails_county() {
			return Plugin::getSetting('clientaddress_county', 'clientdetails');
		}
	}
	if(!function_exists('clientdetails_postcode')){
		function clientdetails_postcode() {
			return Plugin::getSetting('clientaddress_postcode', 'clientdetails');
		}
	}
	if(!function_exists('clientdetails_address')){
		function clientdetails_address($flat=true,$justaddress=false) {
			$schema = Plugin::getSetting('schema', 'clientdetails');
		
			$clientaddress = ''; //$spacer = "";
		
			$clientname = Plugin::getSetting('clientname', 'clientdetails');
			$clientaddress_building = Plugin::getSetting('clientaddress_building', 'clientdetails');
			$clientaddress_thoroughfare = Plugin::getSetting('clientaddress_thoroughfare', 'clientdetails');
			$clientaddress_street = Plugin::getSetting('clientaddress_street', 'clientdetails');
			$clientaddress_locality = Plugin::getSetting('clientaddress_locality', 'clientdetails');
			$clientaddress_town = Plugin::getSetting('clientaddress_town', 'clientdetails');
			$clientaddress_county = Plugin::getSetting('clientaddress_county', 'clientdetails');
			$clientaddress_postcode = Plugin::getSetting('clientaddress_postcode', 'clientdetails');
		
			$clientphone = Plugin::getSetting('clientphone', 'clientdetails');
			$clientemail = Plugin::getSetting('clientemail', 'clientdetails');
		
			if($flat == false && $justaddress == false){
		
				if(stristr($_SERVER['REQUEST_URI'], '/privacy')){
					$htag = 'h3';
				} else {
					$htag = 'h2';
				}
				
				$theaddress = '';
				$theactions = '';
		
				$clientaddress .= '<div itemscope itemtype="http://schema.org/'.$schema.'" class="schema itemaddress">'."\n";
		
				//$clientaddress .= "<address>\n";
		
				//$clientdetails_schema .= '<span itemprop="description"></span>';
				//$theaddress .= '<'.$htag.' class="header address">Address</'.$htag.">\n";
		
				$clientaddress .= '<address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">'."\n";
		
		
		

				/* PDF Format */
				if(stristr($_SERVER['REQUEST_URI'], '/pdf/')){
					$theaddress .= '<h2>Address</h2>'."\n";
					$theaddress .= '<p>'.$clientname." <br/>\n";
					$steetAddress = '';
					if($clientaddress_building != '') $steetAddress .= $clientaddress_building." <br/>\n";
					if($clientaddress_thoroughfare != '') $steetAddress .= $clientaddress_thoroughfare." <br/>\n";
					$theaddress .= $steetAddress.$clientaddress_street." <br/>\n";
					if($clientaddress_locality != '') $theaddress .= $clientaddress_locality." <br/>\n";
					$theaddress .= $clientaddress_town." <br/>\n";
					$theaddress .= $clientaddress_county." <br/>\n";
					$theaddress .= $clientaddress_postcode." <br/>\n";
					$theaddress .= "</p>\n";
				} else {
					$theaddress .= "\n".'<div class="group">'."\n";
					$theaddress .= '<p class="address"><span class="h2">Address</span> '."\n";
					$theaddress .= '<span itemprop="name" class="itemname">'.$clientname." </span>\n";
					$steetAddress = '';
					if($clientaddress_building != '') $steetAddress .= '<span>'.$clientaddress_building." </span>\n";
					if($clientaddress_thoroughfare != '') $steetAddress .= '<span>'.$clientaddress_thoroughfare." </span>\n";
					$theaddress .= '<span itemprop="streetAddress">'.$steetAddress.$clientaddress_street." </span>\n";
					if($clientaddress_locality != '') $theaddress .= '<span>'.$clientaddress_locality." </span>\n";
					//if($clientaddress_locality == '' && $clientaddress_town != '') $clientaddress .= '<span itemprop="addressRegion">'.$clientaddress_town." </span>\n";
					$theaddress .= '<span itemprop="addressLocality">'.$clientaddress_town." </span>\n";
					$theaddress .= '<span itemprop="addressRegion">'.$clientaddress_county." </span>\n";
					$theaddress .= '<span itemprop="postalCode">'.$clientaddress_postcode." </span>\n";
					//$theaddress .= "</address>\n";
					$theaddress .= "</p>\n";
					$theaddress .= "</div>\n";
				}
		
		
		
		
				//if(defined('MOBILEMODE') && 'MOBILEMODE' == TRUE){
				if(defined('MOBILEMODE') && MOBILEMODE == TRUE){
					$actionOpen = '<div class="action">';
					$actionClose = '</div>';
					$action2Open = '<div class="action even">';
					$action2Close = '</div>';
				} else {
					$actionOpen = '';
					$actionClose = '';
				}
		
		
		
				/* PDF Format */
				if(stristr($_SERVER['REQUEST_URI'], '/pdf/')){
		
					if($clientphone != '' || $clientemail != ''){
						if($clientphone != ''){
							$theactions .= "<h2>Telephone</h2>\n<p>".$clientphone."</p>\n";
						}
						if($clientemail != ''){
							$theactions .= "<h2>Email</h2>\n<p>".$clientemail."</p>\n";
						}
					}
				
				} else {
		
					if($clientphone != '' || $clientemail != ''){
						$theactions .= "\n".'<div class="group">'."\n";
						if($clientphone != ''){
							$theactions .= '<p class="phone"><span class="h2">Telephone</span> <span itemprop="telephone" class="itemtelephone">'.$clientphone.' </span></p>';
						}
						if($clientemail != ''){
							$theactions .= '<p class="email"><span class="h2">Email</span> <span itemprop="email" class="itememail">'.$clientemail.' </span></p>';
						}
						$theactions .= "\n</div>\n";
					}
		
				}
		
		
		
		
				//if(defined('MOBILEMODE') && 'MOBILEMODE' == TRUE){
				if(defined('MOBILEMODE') && MOBILEMODE == TRUE){
					$theactions = str_replace('Telephone','Call',$theactions);
					$theactions = str_replace($clientphone,telephone('','','true','',false),$theactions);
					$theactions = str_replace($clientemail,'<span id="trackemail"><a href="mailto:'.$clientemail.'">'.$clientemail.'</a></span>',$theactions);
					$clientaddress .= $theactions;
		
					$clientaddress .= '<div class="column">'."\n";
					//$clientaddress .= "<$htag>Address</$htag>\n";
					$clientaddress .= $theaddress;
					$clientaddress .= "</div>\n";
		
					//if(!stristr($_SERVER['REQUEST_URI'], '/privacy')){
					//	$clientaddress .= '<div class="column even">'."\n";
						//$clientaddress .= "<h2>Open hours</h2>\n";
					//	$clientaddress .= clientdetails_businesshours();
					//	$clientaddress .= "</div>\n";
					//}
		
				} else {
					$clientaddress .= $theaddress;
					$clientaddress .= $theactions;
				}
		
				$clientaddress .= "</address>\n";
				//$clientaddress .= "\n</div>\n";
		
		
				//if(defined('MOBILEMODE') && 'MOBILEMODE' == TRUE){
				if(defined('MOBILEMODE') && MOBILEMODE == TRUE){
					if(!stristr($_SERVER['REQUEST_URI'], '/privacy')){
						$clientaddress .= '<div class="column even">'."\n";
						//$clientaddress .= "<h2>Open hours</h2>\n";
						$clientaddress .= clientdetails_businesshours();
						$clientaddress .= "</div>\n";
					}
				}
		
				$clientaddress .= "</div>\n";
		
			} else {
				if($justaddress == true){
					$clientaddress = $clientname."<br />".$clientaddress_building."<br />".$clientaddress_street."<br />".$clientaddress_town."<br />".$clientaddress_county."<br />".$clientaddress_postcode;
					$clientaddress = str_replace("<br /><br />","<br />",$clientaddress);
					$clientaddress = trim(str_replace('  ',' ',$clientaddress));
				} else {
					$clientaddress = $clientname.' '.$clientaddress_building.' '.$clientaddress_street.' '.$clientaddress_town.' '.$clientaddress_county.' '.$clientaddress_postcode;
					$clientaddress = trim(str_replace('  ',' ',$clientaddress));
				}
			}
			return $clientaddress;
		}
	}

	if(!function_exists('clientdetails_schema')){
		function clientdetails_schema() {
			$clientdetails_schema = '';
			$clientname = Plugin::getSetting('clientname', 'clientdetails');
			$clientphone = Plugin::getSetting('clientphone', 'clientdetails');
			$clientemail = Plugin::getSetting('clientemail', 'clientdetails');
			$clientaddress_street = Plugin::getSetting('clientaddress_street', 'clientdetails');
			$clientaddress_town = Plugin::getSetting('clientaddress_town', 'clientdetails');
			$clientaddress_locality = Plugin::getSetting('clientaddress_locality', 'clientdetails');
			$clientaddress_postcode = Plugin::getSetting('clientaddress_postcode', 'clientdetails');
			$schema = Plugin::getSetting('schema', 'clientdetails');
			$clientdetails_schema .= '<div itemscope itemtype="http://schema.org/'.$schema.'" class="schema hours">';
			$clientdetails_schema .= '<span itemprop="name" class="itemname">'.$clientname." </span>\n";
			//$clientdetails_schema .= '<span itemprop="description"></span>';
			$clientdetails_schema .= '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="itemaddress">';
			$clientdetails_schema .= '<span itemprop="streetAddress">'.$clientaddress_street." </span>\n";
			if($clientaddress_locality != '') $clientdetails_schema .= '<span itemprop="addressLocality">'.$clientaddress_locality." </span>\n";
			if($clientaddress_locality == '' && $clientaddress_town != '') $clientdetails_schema .= '<span itemprop="addressRegion">'.$clientaddress_town." </span>\n";
			$clientdetails_schema .= '<span itemprop="postalCode">'.$clientaddress_postcode." </span>\n";
			$clientdetails_schema .= '</div>';
			//$clientdetails_schema .= '<span itemprop="telephone">'.$clientphone.' </span>';
			if($clientphone != '') $clientdetails_schema .= '<span itemprop="telephone" class="itemtelephone">'.$clientphone.' </span>';
			if($clientemail != '') $clientdetails_schema .= '<span itemprop="email" class="itememail">'.$clientemail.' </span>';
		
			$clientdetails_schema .= '</div>';
			return $clientdetails_schema;
		
		}
	}
	
	if(!function_exists('clientdetails_telephone')){
		function clientdetails_telephone() {
			return Plugin::getSetting('clientphone', 'clientdetails');
		}
	}

	if(!function_exists('clientdetails_email')){
		function clientdetails_email() {
			return Plugin::getSetting('clientemail', 'clientdetails');
		}
	}

	if(!function_exists('clientdetails_businesshours')){
		function clientdetails_businesshours($parent='') {
			$mondayopen = Plugin::getSetting('mondayopen', 'clientdetails');
			$mondayclose = Plugin::getSetting('mondayclose', 'clientdetails');
			$tuesdayopen = Plugin::getSetting('tuesdayopen', 'clientdetails');
			$tuesdayclose = Plugin::getSetting('tuesdayclose', 'clientdetails');
			$wednesdayopen = Plugin::getSetting('wednesdayopen', 'clientdetails');
			$wednesdayclose = Plugin::getSetting('wednesdayclose', 'clientdetails');
			$thursdayopen = Plugin::getSetting('thursdayopen', 'clientdetails');
			$thursdayclose = Plugin::getSetting('thursdayclose', 'clientdetails');
			$fridayopen = Plugin::getSetting('fridayopen', 'clientdetails');
			$fridayclose = Plugin::getSetting('fridayclose', 'clientdetails');
			$saturdayopen = Plugin::getSetting('saturdayopen', 'clientdetails');
			$saturdayclose = Plugin::getSetting('saturdayclose', 'clientdetails');
			$sundayopen = Plugin::getSetting('sundayopen', 'clientdetails');
			$sundayclose = Plugin::getSetting('sundayclose', 'clientdetails');
			
			$mondayappt = Plugin::getSetting('mondayappt', 'clientdetails');
			$tuesdayappt = Plugin::getSetting('tuesdayappt', 'clientdetails');
			$wednesdayappt = Plugin::getSetting('wednesdayappt', 'clientdetails');
			$thursdayappt = Plugin::getSetting('thursdayappt', 'clientdetails');
			$fridayappt = Plugin::getSetting('fridayappt', 'clientdetails');
			$saturdayappt = Plugin::getSetting('saturdayappt', 'clientdetails');
			$sundayappt = Plugin::getSetting('sundayappt', 'clientdetails');
		
			$showcurrentday = Plugin::getSetting('showcurrentday', 'clientdetails');
			
			$hournotation = Plugin::getSetting('hournotation', 'clientdetails');
			$mergelunch = Plugin::getSetting('mergelunch', 'clientdetails');
			$daytag = Plugin::getSetting('daytag', 'clientdetails');
			
			$schema = Plugin::getSetting('schema', 'clientdetails');
		
			//if($mondayappt != '' || $tuesdayappt != '' || $wednesdayappt != '' || $thursdayappt != '' || $fridayappt != '' || $saturdayappt != '' || $sundayappt != '') $appointmentrequired = true; $appointmentlink = '<sup><a href="#appt" title="See footnote">1</a></sup>';
		
		
			
			/* Don't check date if page is cached */
			if($parent != ''){
				//if($parent->funky_cache_enabled != 1 && $showcurrentday != 'false'){
				if((Plugin::isEnabled('funky_cache') != true || Plugin::isEnabled('funky_cache') == true && $parent->funky_cache_enabled != 1) && $showcurrentday != 'false'){
					$mondaytoday = (date("l") == 'Monday') ? ' class="today"' : '';
					$tuesdaytoday = (date("l") == 'Tuesday') ? ' class="today"' : '';
					$wednesdaytoday = (date("l") == 'Wednesday') ? ' class="today"' : '';
					$thursdaytoday = (date("l") == 'Thursday') ? ' class="today"' : '';
					$fridaytoday = (date("l") == 'Friday') ? ' class="today"' : '';
					$saturdaytoday = (date("l") == 'Saturday') ? ' class="today"' : '';
					$sundaytoday = (date("l") == 'Sunday') ? ' class="today"' : '';
				}
			}
		
		
			$openhours = '<ul class="open">'."\n";
			if($mergelunch == 'mergelunch'){
		
				/* Display lunch hours between open hours */
				/* Still working on */
				$mondaylunchstart = Plugin::getSetting('mondaylunchstart', 'clientdetails');
				$mondaylunchend = Plugin::getSetting('mondaylunchend', 'clientdetails');
				$tuesdaylunchstart = Plugin::getSetting('tuesdaylunchstart', 'clientdetails');
				$tuesdaylunchend = Plugin::getSetting('tuesdaylunchend', 'clientdetails');
				$wednesdaylunchstart = Plugin::getSetting('wednesdaylunchstart', 'clientdetails');
				$wednesdaylunchend = Plugin::getSetting('wednesdaylunchend', 'clientdetails');
				$thursdaylunchstart = Plugin::getSetting('thursdaylunchstart', 'clientdetails');
				$thursdaylunchend = Plugin::getSetting('thursdaylunchend', 'clientdetails');
				$fridaylunchstart = Plugin::getSetting('fridaylunchstart', 'clientdetails');
				$fridaylunchend = Plugin::getSetting('fridaylunchend', 'clientdetails');
				$saturdaylunchstart = Plugin::getSetting('saturdaylunchstart', 'clientdetails');
				$saturdaylunchend = Plugin::getSetting('saturdaylunchend', 'clientdetails');
				$sundaylunchstart = Plugin::getSetting('sundaylunchstart', 'clientdetails');
				$sundaylunchend = Plugin::getSetting('sundaylunchend', 'clientdetails');
				
				if($mondaylunchstart != '' && $mondaylunchend != ''){
					if($hournotation == '12'){
					$mondaylunchstart = date("g:i a", strtotime($mondaylunchstart)); $mondaylunchend = date("g:i a", strtotime($mondaylunchend)); }
					$mondaylunch = $mondaylunchstart .' <em>and</em> '. $mondaylunchend .' <span>to</span> ';
				}
				if($tuesdaylunchstart != '' && $tuesdaylunchend != ''){
					if($hournotation == '12'){
					$tuesdaylunchstart = date("g:i a", strtotime($tuesdaylunchstart)); $tuesdaylunchend = date("g:i a", strtotime($tuesdaylunchend)); }
					$tuesdaylunch = $tuesdaylunchstart .' <em>and</em> '. $tuesdaylunchend .' <span>to</span> ';
				}
				if($wednesdaylunchstart != '' && $wednesdaylunchend != ''){
					if($hournotation == '12'){
					$wednesdaylunchstart = date("g:i a", strtotime($wednesdaylunchstart)); $wednesdaylunchend = date("g:i a", strtotime($wednesdaylunchend)); }
					$wednesdaylunch = $wednesdaylunchstart .' <em>and</em> '. $wednesdaylunchend .' <span>to</span> ';
				}
				if($thursdaylunchstart != '' && $thursdaylunchend != ''){
					if($hournotation == '12'){
					$thursdaylunchstart = date("g:i a", strtotime($thursdaylunchstart)); $thursdaylunchend = date("g:i a", strtotime($thursdaylunchend)); }
					$thursdaylunch = $thursdaylunchstart .' <em>and</em> '. $thursdaylunchend .' <span>to</span> ';
				}
				if($fridaylunchstart != '' && $fridaylunchend != ''){
					if($hournotation == '12'){
					$fridaylunchstart = date("g:i a", strtotime($fridaylunchstart)); $fridaylunchend = date("g:i a", strtotime($fridaylunchend)); }
					$fridaylunch = $fridaylunchstart .' <em>and</em> '. $fridaylunchend .' <span>to</span> ';
				}
				if($saturdaylunchstart != '' && $saturdaylunchend != ''){
					if($hournotation == '12'){
					$saturdaylunchstart = date("g:i a", strtotime($saturdaylunchstart)); $saturdaylunchend = date("g:i a", strtotime($saturdaylunchend)); }
					$saturdaylunch = $saturdaylunchstart .' <em>and</em> '. $saturdaylunchend .' <span>to</span> ';
				}
				if($sundaylunchstart != '' && $sundaylunchend != ''){
					if($hournotation == '12'){
					$sundaylunchstart = date("g:i a", strtotime($sundaylunchstart)); $sundaylunchend = date("g:i a", strtotime($sundaylunchend)); }
					$sundaylunch = $sundaylunchstart .' <em>and</em> '. $sundaylunchend .' <span>to</span> ';
				}
		
			} else {
		
				$mondaylunch = '';
				$tuesdaylunch = '';
				$wednesdaylunch = '';
				$thursdaylunch = '';
				$fridaylunch = '';
				$saturdaylunch = '';
				$sundaylunch = '';
		
			}
		
		
		
			if(!isset($mondaytoday)) $mondaytoday = '';
			if(!isset($tuesdaytoday)) $tuesdaytoday = '';
			if(!isset($wednesdaytoday)) $wednesdaytoday = '';
			if(!isset($thursdaytoday)) $thursdaytoday = '';
			if(!isset($fridaytoday)) $fridaytoday = '';
			if(!isset($saturdaytoday)) $saturdaytoday = '';
			if(!isset($sundaytoday)) $sundaytoday = '';
			
			if(!isset($mondaylunch)) $mondaylunch = '';
			if(!isset($tuesdaylunch)) $tuesdaylunch = '';
			if(!isset($wednesdaylunch)) $wednesdaylunch = '';
			if(!isset($thursdaylunch)) $thursdaylunch = '';
			if(!isset($fridaylunch)) $fridaylunch = '';
			if(!isset($saturdaylunch)) $saturdaylunch = '';
			if(!isset($sundaylunch)) $sundaylunch = '';
			
			
			/* Check if day tag has been set */
			if(!isset($daytag)){
				$daytag = 'h3';
				$daytagopen = '<'.$daytag.'>';
				$daytagclose = '</'.$daytag.'>';
			} else {
				if($daytag == ''){
					$daytagopen = '';
					$daytagclose = '';
				} else {
					$daytagopen = '<'.$daytag.'>';
					$daytagclose = '</'.$daytag.'>';
				}
			}


			/* Get am and pm times */
			$moAM = date("g:i a", strtotime($mondayopen)); $moPM = date("g:i a", strtotime($mondayclose));
			$tuAM = date("g:i a", strtotime($tuesdayopen)); $tuPM = date("g:i a", strtotime($tuesdayclose));
			$weAM = date("g:i a", strtotime($wednesdayopen)); $wePM = date("g:i a", strtotime($wednesdayclose));
			$thAM = date("g:i a", strtotime($thursdayopen)); $thPM = date("g:i a", strtotime($thursdayclose));
			$frAM = date("g:i a", strtotime($fridayopen)); $frPM = date("g:i a", strtotime($fridayclose));
			$saAM = date("g:i a", strtotime($saturdayopen)); $saPM = date("g:i a", strtotime($saturdayclose));
			$suAM = date("g:i a", strtotime($sundayopen)); $suPM = date("g:i a", strtotime($sundayclose));

		
			if($hournotation == '24'){
	
				if(!isset($mondaytoday)){ $mondaytoday = ''; }
					if($mondayappt == 'yes'){
						$openhours .= "<li".$mondaytoday.">".$daytagopen."Monday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($mondayopen) == 'closed' || strtolower($mondayclose) == 'closed') {$openhours .= "<li".$mondaytoday.">".$daytagopen."Monday".$daytagclose." Closed</li>\n";
						} else if($mondayopen != '' && $mondayopen != '') {
						$title = 'Mo '.$mondayopen.'-'.$mondayclose;
						$openhours .= "<li".$mondaytoday.' itemprop="openingHours" id="Mo" title="Mo '.$mondayopen.'-'.$mondayclose.'"'.">".$daytagopen."Monday".$daytagclose." ".$mondayopen.' <span>to</span> '.$mondaylunch.$mondayclose."</li>\n"; } else { }
					}
				if(!isset($tuesdaytoday)){ $tuesdaytoday = ''; }
					if($tuesdayappt == 'yes'){
						$openhours .= "<li".$tuesdaytoday.">".$daytagopen."Tuesday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($tuesdayopen) == 'closed' || strtolower($tuesdayclose) == 'closed') {$openhours .= "<li".$tuesdaytoday.">".$daytagopen."Tuesday".$daytagclose." Closed</li>\n";
						} else if($tuesdayopen != '' && $tuesdayopen != '') {
						$title = 'Tu '.$tuesdayopen.'-'.$tuesdayclose;
						$openhours .= "<li".$tuesdaytoday.' itemprop="openingHours" id="Tu" title="Tu '.$tuesdayopen.'-'.$tuesdayclose.'"'.">".$daytagopen."Tuesday".$daytagclose." ".$tuesdayopen.' <span>to</span> '.$tuesdaylunch.$tuesdayclose."</li>\n"; } else { }
					}
				if(!isset($wednesdaytoday)){ $wednesdaytoday = ''; }
					if($wednesdayappt == 'yes'){
						$openhours .= "<li".$wednesdaytoday.">".$daytagopen."Wednesday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($wednesdayopen) == 'closed' || strtolower($wednesdayclose) == 'closed') {$openhours .= "<li".$wednesdaytoday.">".$daytagopen."Wednesday".$daytagclose." Closed</li>\n";
						} else if($wednesdayopen != '' && $wednesdayopen != '') {
						$title = 'We '.$wednesdayopen.'-'.$wednesdayclose;
						$openhours .= "<li".$wednesdaytoday.' itemprop="openingHours" id="We" title="We '.$wednesdayopen.'-'.$wednesdayclose.'"'.">".$daytagopen."Wednesday".$daytagclose." ".$wednesdayopen.' <span>to</span> '.$wednesdaylunch.$wednesdayclose."</li>\n"; } else { }
					}
				if(!isset($thursdaytoday)){ $thursdaytoday = ''; }
					if($thursdayappt == 'yes'){
						$openhours .= "<li".$thursdaytoday.">".$daytagopen."Thursday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($thursdayopen) == 'closed' || strtolower($thursdayclose) == 'closed') {$openhours .= "<li".$thursdaytoday.">".$daytagopen."Thursday".$daytagclose." Closed</li>\n";
						} else if($thursdayopen != '' && $thursdayopen != '') {
						$title = 'Th '.$thursdayopen.'-'.$thursdayclose;
						$openhours .= "<li".$thursdaytoday.' itemprop="openingHours" id="Th" title="Th '.$thursdayopen.'-'.$thursdayclose.'"'.">".$daytagopen."Thursday".$daytagclose." ".$thursdayopen.' <span>to</span> '.$thursdaylunch.$thursdayclose."</li>\n";  } else { }
					}
				if(!isset($fridaytoday)){ $fridaytoday = ''; }
					if($fridayappt == 'yes'){
						$openhours .= "<li".$fridaytoday.">".$daytagopen."Friday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($fridayopen) == 'closed' || strtolower($fridayclose) == 'closed') {$openhours .= "<li".$fridaytoday.">".$daytagopen."Friday".$daytagclose." Closed</li>\n";
						} else if($fridayopen != '' && $fridayopen != '') {
						$title = 'Fr '.$fridayopen.'-'.$fridayclose;
						$openhours .= "<li".$fridaytoday.' itemprop="openingHours" id="Fr" title="Fr '.$fridayopen.'-'.$fridayclose.'"'.">".$daytagopen."Friday".$daytagclose." ".$fridayopen.' <span>to</span> '.$fridaylunch.$fridayclose."</li>\n"; } else { }
					}
				if(!isset($saturdaytoday)){ $saturdaytoday = ''; }
					if($saturdayappt == 'yes'){
						$openhours .= "<li".$saturdaytoday.">".$daytagopen."Saturday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($saturdayopen) == 'closed' || strtolower($saturdayclose) == 'closed') {$openhours .= "<li".$saturdaytoday.">".$daytagopen."Saturday".$daytagclose." Closed</li>\n";
						} else if($saturdayopen != '' && $saturdayclose != '') {
						$title = 'Sa '.$saturdayopen.'-'.$saturdayclose;
						$openhours .= "<li".$saturdaytoday.' itemprop="openingHours" id="Sa" title="Sa '.$saturdayopen.'-'.$saturdayclose.'"'.">".$daytagopen."Saturday".$daytagclose." ".$saturdayopen.' <span>to</span> '.$saturdaylunch.$saturdayclose."</li>\n";  } else { }
					}
				if(!isset($sundaytoday)){ $sundaytoday = ''; }
					if($sundayappt == 'yes'){
						$openhours .= "<li".$sundaytoday.">".$daytagopen."Sunday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($sundayopen) == 'closed' || strtolower($sundayclose) == 'closed') {$openhours .= "<li".$sundaytoday.">".$daytagopen."Sunday".$daytagclose." Closed</li>\n";
						} else if($sundayopen != '' && $sundayclose != '') {
						$title = 'Su '.$sundayopen.'-'.$sundayclose;
						$openhours .= "<li".$sundaytoday.' itemprop="openingHours" id="Su" title="Su '.$sundayopen.'-'.$sundayclose.'"'.">".$daytagopen."Sunday".$daytagclose." ".$sundayopen.' <span>to</span> '.$sundaylunch.$sundayclose."</li>\n"; } else { }
					}
			} else {
	
				if(!isset($mondaytoday) || $mondayappt == 'yes'){ $mondaytoday = ''; }
					if($mondayappt == 'yes'){
						$openhours .= "<li".$mondaytoday.">".$daytagopen."Monday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($mondayopen) == 'closed' || strtolower($mondayclose) == 'closed') {$openhours .= "<li".$mondaytoday.">".$daytagopen."Monday".$daytagclose." Closed</li>\n";
						} else if($mondayopen != '' && $mondayopen != '') {
						$title = 'Mo '.$mondayopen.'-'.$mondayclose;
						$openhours .= "<li".$mondaytoday.' itemprop="openingHours" id="Mo" title="'.$title.'"'.">".$daytagopen."Monday".$daytagclose." ".date("g:i a", strtotime($mondayopen)).' <span>to</span> '.$mondaylunch.date("g:i a", strtotime($mondayclose))."</li>\n"; } else { }
					}
				if(!isset($tuesdaytoday) || $tuesdayappt == 'yes'){ $tuesdaytoday = ''; }
					if($tuesdayappt == 'yes'){
						$openhours .= "<li".$tuesdaytoday.">".$daytagopen."Tuesday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($tuesdayopen) == 'closed' || strtolower($tuesdayclose) == 'closed') {$openhours .= "<li".$tuesdaytoday.">".$daytagopen."Tuesday".$daytagclose." Closed</li>\n";
						} else if($tuesdayopen != '' && $tuesdayopen != '') {
						$title = 'Tu '.$tuesdayopen.'-'.$tuesdayclose;
						$openhours .= "<li".$tuesdaytoday.' itemprop="openingHours" id="Tu" title="'.$title.'"'.">".$daytagopen."Tuesday".$daytagclose." ".date("g:i a", strtotime($tuesdayopen)).' <span>to</span> '.$tuesdaylunch.date("g:i a", strtotime($tuesdayclose))."</li>\n"; } else { }
					}
				if(!isset($wednesdaytoday) || $wednesdayappt == 'yes'){ $wednesdaytoday = ''; }
					if($wednesdayappt == 'yes'){
						$openhours .= "<li".$wednesdaytoday.">".$daytagopen."Wednesday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($wednesdayopen) == 'closed' || strtolower($wednesdayclose) == 'closed') {$openhours .= "<li".$wednesdaytoday.">".$daytagopen."Wednesday".$daytagclose." Closed</li>\n";
						} else if($wednesdayopen != '' && $wednesdayopen != '') {
						$title = 'We '.$wednesdayopen.'-'.$wednesdayclose;
						$openhours .= "<li".$wednesdaytoday.' itemprop="openingHours" id="We" title="'.$title.'"'.">".$daytagopen."Wednesday".$daytagclose." ".date("g:i a", strtotime($wednesdayopen)).' <span>to</span> '.$wednesdaylunch.date("g:i a", strtotime($wednesdayclose))."</li>\n"; } else { }
					}
				if(!isset($thursdaytoday) || $thursdayappt == 'yes'){ $thursdaytoday = ''; }
					if($thursdayappt == 'yes'){
						$openhours .= "<li".$thursdaytoday.">".$daytagopen."Thursday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($thursdayopen) == 'closed' || strtolower($thursdayclose) == 'closed') {$openhours .= "<li".$thursdaytoday.">".$daytagopen."Thursday".$daytagclose." Closed</li>\n";
						} else if($thursdayopen != '' && $thursdayopen != '') {
						$title = 'Th '.$thursdayopen.'-'.$thursdayclose;
						$openhours .= "<li".$thursdaytoday.' itemprop="openingHours" id="Th" title="'.$title.'"'.">".$daytagopen."Thursday".$daytagclose." ".date("g:i a", strtotime($thursdayopen)).' <span>to</span> '.$thursdaylunch.date("g:i a", strtotime($thursdayclose))."</li>\n";  } else { }
					}
				if(!isset($fridaytoday) || $fridayappt == 'yes'){ $fridaytoday = ''; }
					if($fridayappt == 'yes'){
						$openhours .= "<li".$fridaytoday.">".$daytagopen."Friday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($fridayopen) == 'closed' || strtolower($fridayclose) == 'closed') {$openhours .= "<li".$fridaytoday.">".$daytagopen."Friday".$daytagclose." Closed</li>\n";
						} else if($fridayopen != '' && $fridayopen != '') {
						$title = 'Fr '.$fridayopen.'-'.$fridayclose;
						$openhours .= "<li".$fridaytoday.' itemprop="openingHours" id="Fr" title="'.$title.'"'.">".$daytagopen."Friday".$daytagclose." ".date("g:i a", strtotime($fridayopen)).' <span>to</span> '.$fridaylunch.date("g:i a", strtotime($fridayclose))."</li>\n"; } else { }
					}
				if(!isset($saturdaytoday) || $saturdayappt == 'yes'){ $saturdaytoday = ''; }
					if($saturdayappt == 'yes'){
						$openhours .= "<li".$saturdaytoday.">".$daytagopen."Saturday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($saturdayopen) == 'closed' || strtolower($saturdayclose) == 'closed') {$openhours .= "<li".$saturdaytoday.">".$daytagopen."Saturday".$daytagclose." Closed</li>\n";
						} else if($saturdayopen != '' && $saturdayclose != '') {
						$title = 'Sa '.$saturdayopen.'-'.$saturdayclose;
						$openhours .= "<li".$saturdaytoday.' itemprop="openingHours" id="Sa" title="'.$title.'"'.">".$daytagopen."Saturday".$daytagclose." ".date("g:i a", strtotime($saturdayopen)).' <span>to</span> '.$saturdaylunch.date("g:i a", strtotime($saturdayclose))."</li>\n";  } else { }
					}
				if(!isset($sundaytoday) || $sundayappt == 'yes'){ $sundaytoday = ''; }
					if($sundayappt == 'yes'){
						$openhours .= "<li".$sundaytoday.">".$daytagopen."Sunday".$daytagclose." by appointment</li>\n";
					} else {
						if(strtolower($sundayopen) == 'closed' || strtolower($sundayclose) == 'closed') {$openhours .= "<li".$sundaytoday.">".$daytagopen."Sunday".$daytagclose." Closed</li>\n";
						} else if($sundayopen != '' && $sundayclose != '') {
						$title = 'Su '.$sundayopen.'-'.$sundayclose;
						$openhours .= "<li".$sundaytoday.' itemprop="openingHours" id="Su" title="'.$title.'"'.">".$daytagopen."Sunday".$daytagclose." ".date("g:i a", strtotime($sundayopen)).' <span>to</span> '.$sundaylunch.date("g:i a", strtotime($sundayclose))."</li>\n"; } else { }
					}
			}
		
			$openhours = str_replace('12:00 pm', '12:00 noon', $openhours);
			$openhours = str_replace('12:00 am', '12:00 midnight', $openhours);

		
			$openhours = str_replace('am', '<small>am</small>', $openhours);
			$openhours = str_replace('pm', '<small>pm</small>', $openhours);
			$openhours = str_replace('noon', '<small>noon</small>', $openhours);
			$openhours = str_replace('midnight', '<small>midnight</small>', $openhours);


			/* Create data-hours attributes for javascript insertion */
			$openhours = str_replace('id="Mo"', 'data-hours="'.$moAM.' - '.$moPM.'"', $openhours);
			$openhours = str_replace('id="Tu"', 'data-hours="'.$tuAM.' - '.$tuPM.'"', $openhours);
			$openhours = str_replace('id="We"', 'data-hours="'.$weAM.' - '.$wePM.'"', $openhours);
			$openhours = str_replace('id="Th"', 'data-hours="'.$thAM.' - '.$thPM.'"', $openhours);
			$openhours = str_replace('id="Fr"', 'data-hours="'.$frAM.' - '.$frPM.'"', $openhours);
			$openhours = str_replace('id="Sa"', 'data-hours="'.$saAM.' - '.$saPM.'"', $openhours);
			$openhours = str_replace('id="Su"', 'data-hours="'.$suAM.' - '.$suPM.'"', $openhours);
			$openhours = str_replace(' am', 'am', $openhours);
			$openhours = str_replace(' pm', 'pm', $openhours);
		
		
			/* Keep hours with main hours list, rather than below the list.  */
			/* Check for days that require appointments - Not working if hours set yet */
			/*
			if($mondayappt == 'yes'){
				$openhours .= "<li".$mondaytoday.">".$daytagopen."Monday".$daytagclose." by appointment</li>\n";
			}
			if($tuesdayappt == 'yes'){
				$openhours .= "<li".$tuesdaytoday.">".$daytagopen."Tuesday".$daytagclose." by appointment</li>\n";
			}
			if($wednesdayappt == 'yes'){
				$openhours .= "<li".$wednesdaytoday.">".$daytagopen."Wednesday".$daytagclose." by appointment</li>\n";
			}
			if($thursdayappt == 'yes'){
				$openhours .= "<li".$thursdaytoday.">".$daytagopen."Thursday".$daytagclose." by appointment</li>\n";
			}
			if($fridayappt == 'yes'){
				$openhours .= "<li".$fridaytoday.">".$daytagopen."Friday".$daytagclose." by appointment</li>\n";
			}
			if($saturdayappt == 'yes'){
				$openhours .= "<li".$saturdaytoday.">".$daytagopen."Saturday".$daytagclose." by appointment</li>\n";
			}
			if($sundayappt == 'yes'){
				$openhours .= "<li".$sundaytoday.">".$daytagopen."Sunday".$daytagclose." by appointment</li>\n";
			}
			*/
		
		
		
			$openhours .= '</ul>';
		
		
		
			$hourlist = '';
			$display = '';
			if(1 === preg_match('~[0-9]~', $openhours)){
				$hourlist .= '<div itemscope itemtype="http://schema.org/'.$schema.'" id="businessHours" class="schema">';
				$hourlist .= "<h2>Open hours</h2>\n".$openhours."\n";
				$hourlist .= '</div>';
			}
			//if(1 === preg_match('~[0-9]~', $closedhours)) $hourlist .= "<h2>Closed for lunch</h2>\n".$closedhours."\n";
			if(1 === preg_match('~[0-9]~', $openhours)){
				$display = '';
				//$display = '<div id="hours">'."\n";
				$display .= $hourlist;
			
		
				//$mypage = unserialize(THISPAGE);
				//$display .= $parent->funky_cache_enabled;
			
			
				//if($appointmentrequired == true) {
				//	$display .= '<ul class="footnote">';
				//	$display .= '<li id="appt">Appointment required. <a href="#hours">Return to hours</a></li>';
				//	$display .= '</ul>'."\n";
				//}
				//$display .= '</div>'."\n";
			}
			//if(defined('MOBILEMODE') && 'MOBILEMODE' == TRUE){
			if(defined('MOBILEMODE') && MOBILEMODE == TRUE){
				$display = str_replace('Monday','Mon',$display);
				$display = str_replace('Tuesday','Tue',$display);
				$display = str_replace('Wednesday','Wed',$display);
				$display = str_replace('Thursday','Thu',$display);
				$display = str_replace('Friday','Fri',$display);
				$display = str_replace('Saturday','Sat',$display);
				$display = str_replace('Sunday','Sun',$display);
		
				$display = str_replace(' am','am',$display);
				$display = str_replace(' pm','pm',$display);
			}
			return $display;
		}
	}

	if(!function_exists('clientdetails_lunchhours')){
		function clientdetails_lunchhours($parent='') {
			//$lunchstart = Plugin::getSetting('lunchstart', 'clientdetails');
			//$lunchend = Plugin::getSetting('lunchend', 'clientdetails');
			//if($lunchstart != '' && $lunchend != ''){
			//	$lunch = '<p class="lunch">Closed for lunch '.$lunchstart.' to '.$lunchend.'</p>';
			//	return $lunch;
			//}
		
			$mondaylunchstart = Plugin::getSetting('mondaylunchstart', 'clientdetails');
			$mondaylunchend = Plugin::getSetting('mondaylunchend', 'clientdetails');
			$tuesdaylunchstart = Plugin::getSetting('tuesdaylunchstart', 'clientdetails');
			$tuesdaylunchend = Plugin::getSetting('tuesdaylunchend', 'clientdetails');
			$wednesdaylunchstart = Plugin::getSetting('wednesdaylunchstart', 'clientdetails');
			$wednesdaylunchend = Plugin::getSetting('wednesdaylunchend', 'clientdetails');
			$thursdaylunchstart = Plugin::getSetting('thursdaylunchstart', 'clientdetails');
			$thursdaylunchend = Plugin::getSetting('thursdaylunchend', 'clientdetails');
			$fridaylunchstart = Plugin::getSetting('fridaylunchstart', 'clientdetails');
			$fridaylunchend = Plugin::getSetting('fridaylunchend', 'clientdetails');
			$saturdaylunchstart = Plugin::getSetting('saturdaylunchstart', 'clientdetails');
			$saturdaylunchend = Plugin::getSetting('saturdaylunchend', 'clientdetails');
			$sundaylunchstart = Plugin::getSetting('sundaylunchstart', 'clientdetails');
			$sundaylunchend = Plugin::getSetting('sundaylunchend', 'clientdetails');
		
			$showcurrentday = Plugin::getSetting('showcurrentday', 'clientdetails');
		
			$hournotation = Plugin::getSetting('hournotation', 'clientdetails');
			$mergelunch = Plugin::getSetting('mergelunch', 'clientdetails');
			$daytag = Plugin::getSetting('daytag', 'clientdetails');
		
			/* Don't check date if page is cached */
			if($parent->funky_cache_enabled != 1 && $showcurrentday != 'false'){
				$mondaytoday = (date("l") == 'Monday') ? ' class="today"' : '';
				$tuesdaytoday = (date("l") == 'Tuesday') ? ' class="today"' : '';
				$wednesdaytoday = (date("l") == 'Wednesday') ? ' class="today"' : '';
				$thursdaytoday = (date("l") == 'Thursday') ? ' class="today"' : '';
				$fridaytoday = (date("l") == 'Friday') ? ' class="today"' : '';
				$saturdaytoday = (date("l") == 'Saturday') ? ' class="today"' : '';
				$sundaytoday = (date("l") == 'Sunday') ? ' class="today"' : '';
			}

		
			/* Check if day tag has been set */
			if(!isset($daytag)){
				$daytag = 'h3';
				$daytagopen = '<'.$daytag.'>';
				$daytagclose = '</'.$daytag.'>';
			} else {
				if($daytag == ''){
					$daytagopen = '';
					$daytagclose = '';
				} else {
					$daytagopen = '<'.$daytag.'>';
					$daytagclose = '</'.$daytag.'>';
				}
			}
		
		
			$hours = '<ul class="closed">';
		
			if($hournotation == '24'){
		
				if(!isset($mondaytoday)) $mondaytoday = ''; if($mondaylunchstart != '' && $mondaylunchstart != '') $hours .= "<li".$mondaytoday.">".$daytagopen."Monday".$daytagclose." ".$mondaylunchstart." <span>to</span> ".$mondaylunchend."</li>";
				if(!isset($tuesdaytoday)) $tuesdaytoday = ''; if($tuesdaylunchstart != '' && $tuesdaylunchstart != '') $hours .= "<li".$tuesdaytoday.">".$daytagopen."Tuesday".$daytagclose." ".$tuesdaylunchstart." <span>to</span> ".$tuesdaylunchend."</li>";
				if(!isset($wednesdaytoday)) $wednesdaytoday = ''; if($wednesdaylunchstart != '' && $wednesdaylunchstart != '') $hours .= "<li".$wednesdaytoday.">".$daytagopen."Wednesday".$daytagclose." ".$wednesdaylunchstart." <span>to</span> ".$wednesdaylunchend."</li>";
				if(!isset($thursdaytoday)) $thursdaytoday = ''; if($thursdaylunchstart != '' && $thursdaylunchstart != '') $hours .= "<li".$thursdaytoday.">".$daytagopen."Thursday".$daytagclose." ".$thursdaylunchstart." <span>to</span> ".$thursdaylunchend."</li>";
				if(!isset($fridaytoday)) $fridaytoday = ''; if($fridaylunchstart != '' && $fridaylunchstart != '') $hours .= "<li".$fridaytoday.">".$daytagopen."Friday".$daytagclose." ".$fridaylunchstart." <span>to</span> ".$fridaylunchend."</li>";
				if(!isset($saturdaytoday)) $saturdaytoday = ''; if($saturdaylunchstart != '' && $saturdaylunchstart != '') $hours .= "<li".$saturdaytoday.">".$daytagopen."Saturday".$daytagclose." ".$saturdaylunchstart." <span>to</span> ".$saturdaylunchend."</li>";
				if(!isset($sundaytoday)) $sundaytoday = ''; if($sundaylunchstart != '' && $sundaylunchstart != '') $hours .= "<li".$sundaytoday.">".$daytagopen."Sunday".$daytagclose." ".$sundaylunchstart." <span>to</span> ".$sundaylunchend."</li>";
		
			} else {
				
				if(!isset($mondaytoday)) $mondaytoday = ''; if($mondaylunchstart != '' && $mondaylunchstart != '') $hours .= "<li".$mondaytoday.">".$daytagopen."Monday".$daytagclose." ".date("g:i a", strtotime($mondaylunchstart))." <span>to</span> ".date("g:i a", strtotime($mondaylunchend))."</li>";
				if(!isset($tuesdaytoday)) $tuesdaytoday = ''; if($tuesdaylunchstart != '' && $tuesdaylunchstart != '') $hours .= "<li".$tuesdaytoday.">".$daytagopen."Tuesday".$daytagclose." ".date("g:i a", strtotime($tuesdaylunchstart))." <span>to</span> ".date("g:i a", strtotime($tuesdaylunchend))."</li>";
				if(!isset($wednesdaytoday)) $wednesdaytoday = ''; if($wednesdaylunchstart != '' && $wednesdaylunchstart != '') $hours .= "<li".$wednesdaytoday.">".$daytagopen."Wednesday".$daytagclose." ".date("g:i a", strtotime($wednesdaylunchstart))." <span>to</span> ".date("g:i a", strtotime($wednesdaylunchend))."</li>";
				if(!isset($thursdaytoday)) $thursdaytoday = ''; if($thursdaylunchstart != '' && $thursdaylunchstart != '') $hours .= "<li".$thursdaytoday.">".$daytagopen."Thursday".$daytagclose." ".date("g:i a", strtotime($thursdaylunchstart))." <span>to</span> ".date("g:i a", strtotime($thursdaylunchend))."</li>";
				if(!isset($fridaytoday)) $fridaytoday = ''; if($fridaylunchstart != '' && $fridaylunchstart != '') $hours .= "<li".$fridaytoday.">".$daytagopen."Friday".$daytagclose." ".date("g:i a", strtotime($fridaylunchstart))." <span>to</span> ".date("g:i a", strtotime($fridaylunchend))."</li>";
				if(!isset($saturdaytoday)) $saturdaytoday = ''; if($saturdaylunchstart != '' && $saturdaylunchstart != '') $hours .= "<li".$saturdaytoday.">".$daytagopen."Saturday".$daytagclose." ".date("g:i a", strtotime($saturdaylunchstart))." <span>to</span> ".date("g:i a", strtotime($saturdaylunchend))."</li>";
				if(!isset($sundaytoday)) $sundaytoday = ''; if($sundaylunchstart != '' && $sundaylunchstart != '') $hours .= "<li".$sundaytoday.">".$daytagopen."Sunday".$daytagclose." ".date("g:i a", strtotime($sundaylunchstart))." <span>to</span> ".date("g:i a", strtotime($sundaylunchend))."</li>";
		
			}
		
			$hours = str_replace('12:00 pm', '12:00 noon', $hours);
			$hours = str_replace('12:00 am', '12:00 midnight', $hours);
		
			$hours = str_replace('am', '<small>am</small>', $hours);
			$hours = str_replace('pm', '<small>pm</small>', $hours);
			$hours = str_replace('noon', '<small>noon</small>', $hours);
			$hours = str_replace('midnight', '<small>midnight</small>', $hours);
		
			$hours .= '</ul>';
		
		
			$hourlist = '';
			if(1 === preg_match('~[0-9]~', $hours)) $hourlist .= "<h2>Closed for lunch</h2>\n".$hours."\n";
			if(1 === preg_match('~[0-9]~', $hours)){
				$hours = '';
				//$hours = '<div id="lunch">'."\n";
				$hours .= $hourlist;
				//$hours .= '</div>'."\n";
			}
		
			if(1 === preg_match('~[0-9]~', $hours)){
				if(MOBILEMODE == TRUE){
					$hours = str_replace('>Monday<','>Mon<',$hours);
					$hours = str_replace('>Tuesday<','>Tue<',$hours);
					$hours = str_replace('>Wednesday<','>Wed<',$hours);
					$hours = str_replace('>Thursday<','>Thu<',$hours);
					$hours = str_replace('>Friday<','>Fri<',$hours);
					$hours = str_replace('>Saturday<','>Sat<',$hours);
					$hours = str_replace('>Sunday<','>Sun<',$hours);
				}
				return $hours;
			} else {
				//return '<p>Open hours to go here.</p>';
			}
		
			//return $clientlocation;
		}
	}


}