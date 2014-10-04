<?php


//$FlagMagicQuotes = "php_flag magic_quotes_gpc off\n";


/* Define all variables */
$FlagMagicQuotes = '';
$AddTypes = '';
$AddDefaultCharset = '';
$Options = '';
$DirectoryIndex = '';
$Env = '';
$RewriteRules = '';

// Domain without www (supports subdomains - domain name must be explicitly set)
#preg_match("/[^\.\/]+\.[^\.\/]+$/", $_SERVER['HTTP_HOST'], $domain_name);
#$SubdomainCond = '#RewriteCond %{HTTP_HOST} !^([^.]+\.)'.str_replace('.', '\.', $domain_name[0]).'$ [NC]'."\n";
#$SubdomainCond .= '#RewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L]'."\n";

// Domain without www (breaks subdomains)
#$SubdomainCond = 'RewriteCond %{HTTP_HOST} !^www\. [NC]'."\n";
#$SubdomainCond .= 'RewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L]'."\n";

$SubdomainCond = 'RewriteCond %{HTTPS} !=on'."\n";
$SubdomainCond .= 'RewriteCond %{HTTP_HOST} !^(www|([^.]+)\.([a-z]{2,4})$) [NC]'."\n";
$SubdomainCond .= 'RewriteRule .? http://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]'."\n";

$AdminAccess = '';
$RedirectHome = '';
$adminDir = ADMIN_DIR;
$RewriteRuleCache = 'no'; /* yes or no */
$caseSensitive = 'yes'; /* yes or no  - DOES NOT WORK YET */
$htmlasphp = 'no'; /* yes or no */


$AddTypes = "AddType text/x-component .htc\n";
$AddTypes .= "AddType video/ogg .ogm\n";
$AddTypes .= "AddType video/ogg .ogv\n";
$AddTypes .= "AddType video/ogg .ogg\n";
$AddTypes .= "AddType video/webm .webm\n";
$AddTypes .= "AddType video/mp4 .mp4\n";
$AddTypes .= "AddType video/x-m4v .m4v\n";
$AddTypes .= "AddType audio/webm .weba\n";


/* Should html be parsed by php */
if($htmlasphp == 'yes'){ ?>
AddHandler application/x-httpd-php5 .php .html
<?php }


$AddDefaultCharset = "AddDefaultCharset UTF-8\n";


/* Disable directory index browsing and multi-content negotiations, allow non-physical links */
$Options = "Options -Indexes +FollowSymLinks\n";


/* Default index pages */

/* If funky cache enabled, then check if mobile check enabled */
//if(Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('enable', 'mobile_check') == true){
$DirectoryIndex = "DirectoryIndex cache/index.html index.html index.php\n";
//} else {
//$DirectoryIndex = "DirectoryIndex index.html index.php\n";
//}



/* Environment variables */
//$Env = "#SetEnvIf Host dev.domain.com debug_mode\n":
//$Env .= "#<IfDefine debug_mode>\n":
//$Env .= "#php_flag display_errors Off\n":
//$Env .= "#</IfDefine>\n":


/* Handle Redirects */

// Disable caching of RewriteRule if required.
// Docs: http://mark.koli.ch/set-cache-control-and-expires-headers-on-a-redirect-with-mod-rewrite
if($RewriteRuleCache == 'no'){ $RewriteRuleCache = ',E=nocache:1'; } else { $RewriteRuleCache = ''; }

//$RewriteRules = "RewriteRule ^services.php$ /services.html? [L,R=301".$RewriteRuleCache."]\n";
//$RewriteRules .= "RewriteRule ^oldpage.html /newfolder/newpage.html [L,R=301".$RewriteRuleCache."]\n";
//$RewriteRules .= "redirect 301 /new /special.html?utm_source=new&utm_medium=redirects&utm_campaign=301\n";


/* Handle home redirect */
//$RewriteRules .= "#RewriteCond %{REQUEST_URI} ^/+$\n";
//$RewriteRules .= "#RewriteRule ^/*$ about.html [R=301,L".$RewriteRuleCache."]\n";
/* Redirect 'listings' folder, but not it's sub folders */
//$RewriteRules = "RewriteRule ^/?listings/?$ / [L,R=301".$RewriteRuleCache."]\n";


/* Handle domain change (retains/assumes all page structures have moved across to new domain */
//RewriteRule ^(.*)$ http://www.newdomain.co.uk/$1 [R=301,L]

$RewriteRules = '';
$RedirectHome = '';

if(Plugin::isEnabled('redirector') == true){

	$redirects_sql = "SELECT * FROM ".TABLE_PREFIX."redirector_redirects ORDER BY destination, url";
	$redirects_q = Record::getConnection()->query($redirects_sql);
	$redirects_f = $redirects_q->fetchAll(PDO::FETCH_OBJ);
	foreach ($redirects_f as $redirects) {
	 	$url = stripslashes($redirects->url);
	  	$destination = stripslashes($redirects->destination);
  	
	  	$url = trim( preg_replace( '/\s+/', ' ', $url ));
	  	$destination = trim( preg_replace( '/\s+/', ' ', $destination ));
	  	
	  	//$destination = str_replace(' ', '%20', $destination);

	  	$status = $redirects->status;
	  	if($status == '301'){
			$thisCache = $RewriteRuleCache;
		} else {
			$thisCache = '';
		}
	  	if($caseSensitive == 'no'){
			$thisCase = ',NC';
		} else {
			$thisCase = '';
		}
		
		

	  	if($url == '/'){
			$RedirectHome .= "RewriteCond %{REQUEST_URI} ^/+$\n";
			$RedirectHome .= "RewriteRule ^/*$ ".'"'.$destination.'"'." [L,R=".$status.$thisCache.$thisCase."]\n";
		} else {
	  	 	if($url[strlen($url)-1] == '/' && $destination[strlen($destination)-1] == '/'){
				//$RewriteRules .= "RewriteRule ^".$url."(.*)$ ".$destination."$1 [L,R=".$status.$thisCache.",NC]\n";
				$RewriteRules .= "RewriteRule ^".$url."(.*)$ ".$destination."$1 [L,R=".$status.$thisCache.$thisCase."]\n";
			} else if(stristr($destination,'?')){
				$RewriteRules .= 'redirect 301 '.$url.' '.'"'.$destination.'"'."\n";
			} else if (stristr($url, '?')){

				//$url = $url."$"; $destination = $destination."?";
				//$RewriteRules .= "RewriteRule ^".ltrim($url,'/').' '.$destination." [L,R=".$status."]\n";

				$url = str_replace("?","$\nRewriteCond %{QUERY_STRING} ^",$url)."$";
				$RewriteRules .= "RewriteCond %{REQUEST_URI} ^".$url."\n";
				$RewriteRules .= "RewriteRule ^(.*)$ ".$destination."? [L,R=".$status.$thisCache.$thisCase."]\n";

			} else {
				$RewriteRules .= "RewriteRule ^".ltrim($url,'/').' '.'"'.$destination.'"'." [L,R=".$status.$thisCache.$thisCase."]\n";
			}
		}
	}
	
	/* Remove invalid characters and strings from RewriteRules */
	$RewriteRules = str_replace("‎", "", $RewriteRules);
	//$RewriteRules = utf8_decode($RewriteRules);

	/*
	$data['current_redirects'] = Record::findAllFrom('RedirectorRedirects', 'true ORDER BY destination, url');
	$RewriteRules = '';
	if(sizeof($data) > 0){
		foreach ($data as $redirect){
			if(stristr($redirect[0]->destination,'?')){
				$RewriteRules .= 'redirect 301 '.$redirect[0]->url.' '.$redirect[0]->destination."\n";
			} else {
				$RewriteRules .= 'RewriteRule ^'.ltrim($redirect[0]->url,'/').' '.$redirect[0]->destination." [L,R=".$redirect[0]->status."]\n";
			}
		}
	}
	*/
}


/* Handle Subdomains */
//$SubdomainCond = "RewriteCond %{HTTP_HOST} !([^.]+\.[^.]+)$ [NC]\n";
//$SubdomainCond .= "RewriteCond %{REQUEST_URI} (.+)\n";


/* Handle wordpress access */
//$AdminAccess = "#RewriteCond %{REMOTE_HOST} !^localhost\n";
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^\.local\n";
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^127\.0\.0\.1\n";
/* Work IP */
$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^82\.152\.147\.125\n";
/* Home IP */
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^77\.99\.231\.221\n";
/* My iPhone IP */
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^213\.205\.231\.157\n";
$AdminAccess .= "#RewriteRule ^blog/wp-admin/(.*)$ /notfound.html? [R,L]\n";


/* Handle admin access */
//$AdminAccess = "#RewriteCond %{REMOTE_HOST} !^localhost\n";
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^\.local\n";
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^127\.0\.0\.1\n";
/* Work IP */
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^82\.152\.147\.125\n";
/* Home IP */
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^77\.99\.231\.221\n";
/* My iPhone IP */
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^213\.205\.231\.157\n";
//$AdminAccess .= "#RewriteRule ^".$adminDir."/(.*)$ /notfound.html? [R,L]\n";



// Restrict access to enabled whitelist IPs, when IPs have been granted authorized access.
$maintenance = Plugin::getAllSettings('maintenance');
//if(Plugin::isEnabled('maintenance') == true && $maintenance['maintenanceAuthorizedAccess'] == 'on'){
if(Plugin::isEnabled('maintenance') == true){
    $allowed_ips = 0;
	$allowed = MaintenanceAccessControl::getAllowed();
    foreach($allowed as $allow) {
		if($allow->enabled == 'yes'){
            $allowed_ips++;
            $AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^".str_replace('.', '\.', $allow->ip)."\n";
        }
	}
	if($allowed_ips > 0){
        $AdminAccess .= "#RewriteRule ^".$adminDir."/(.*)$ /notfound.html? [R,L]\n";
    }
}



/* Private access (whitelist exception needs setting) */
#RewriteCond %{REMOTE_HOST} !^82\.152\.147\.125
#RewriteRule ^(.*)$ http://www.google.co.uk/$1 [R=302,L]


/* Handle cache access */
//$AdminAccess = "#RewriteCond %{REMOTE_HOST} !^localhost\n";
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^\.local\n";
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^127\.0\.0\.1\n";
/* Work IP */
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^82\.152\.147\.125\n";
/* Home IP */
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^77\.99\.231\.221\n";
/* My iPhone IP */
//$AdminAccess .= "#RewriteCond %{REMOTE_HOST} !^213\.205\.231\.157\n";
//$AdminAccess .= "#RewriteRule ^cache/(.*)$ /notfound.html? [R,L]\n";


/* Under construction (whitelist exception needs setting) */
#RewriteCond %{REMOTE_HOST} !^82\.152\.147\.125
#RewriteCond %{REQUEST_URI} !(\.(gif|jpg|png|css)$|^/under-construction/$)
#RewriteRule ^(.*)$ /under-construction/? [R=302,L]


?>
#
# Setting Frog requirements
#
<?php echo $FlagMagicQuotes; ?>
<?php echo $AddTypes; ?>
<?php echo $AddDefaultCharset; ?>
<?php echo $Options; ?>
<?php echo $DirectoryIndex; ?>
<?php echo $Env; ?>

<?php
/* Headers */
if($RewriteRuleCache != ''){
?>
<IfModule mod_headers.c>
Header always set Cache-Control "no-store, no-cache, must-revalidate" env=nocache
Header always set Expires "Thu, 01 Jan 1970 00:00:00 GMT" env=nocache
</IfModule>
<?php } ?>


<?php
/* GZip Compression | Disabled by default */
$gzip = false;
if($gzip == true){ ?>
<IfModule mod_deflate.c>
AddOutputFilterByType DEFLATE text/html text/plain text/xml application/xml application/xhtml+xml text/css text/javascript application/javascript application/x-javascript
</IfModule>
<?php } ?>


<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
<?php //echo $SubdomainCond; ?>
<?php echo $RewriteRules; ?>
RewriteCond %{HTTP_HOST} !.local$ [NC]
#RewriteCond %{HTTP_HOST} !.poppymedia.co.uk$ [NC]
#RewriteCond %{HTTP_HOST} !.bluehorizonsmedia.co.uk$ [NC]
<?php echo $SubdomainCond; ?>
#RewriteCond %{HTTP_HOST} !^www\. [NC]
#RewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L]
RewriteRule ^install/index.html$ install/index.php?rewrite=1 [L,QSA]
RewriteRule ^install/index.php$ install/index.php?rewrite=1 [L,QSA]
RewriteRule ^install/$ install/index.php?rewrite=1 [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^<?php echo $adminDir; ?>(.*)$ <?php echo $adminDir; ?>/index.php?$1 [L,QSA]


<?php
/* Check if funky cache is enabled */
//if(Plugin::isEnabled('funky_cache') == true){
?>


<?php
/* If funky cache enabled, then check if mobile check enabled */
//if(Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('enable', 'mobile_check') == true){
?>

RewriteCond %{REQUEST_METHOD} ^GET$
RewriteCond %{DOCUMENT_ROOT}/cache/mobile/index.html -f
RewriteRule ^mobile/$ %{DOCUMENT_ROOT}/cache/mobile/index.html [L,QSA]
<?php //} ?>

RewriteCond %{REQUEST_METHOD} ^GET$
RewriteCond %{DOCUMENT_ROOT}/cache/index.html -f
RewriteRule ^$ %{DOCUMENT_ROOT}/cache/index.html [L,QSA]

RewriteCond %{REQUEST_METHOD} ^GET$
RewriteCond %{DOCUMENT_ROOT}/cache%{REQUEST_URI} -f
RewriteCond %{THE_REQUEST} !success.html
RewriteRule (.*) %{DOCUMENT_ROOT}/cache%{REQUEST_URI} [L,QSA]
#RewriteRule ^%{REQUEST_URI} /cache/$1 [L,QSA]
<?php //} ?>



RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^portfolio/category/(.*)$ portfolio.html?sort=$1 [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^articles/category/(.*)$ articles.html?sort=$1 [L,QSA]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^download/(.*)$ /downloads.php?THISPAGE=download.html&media=pdf&filename=$1 [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^private/(.*)$ /private.html?THISPAGE=private.html&userfile=$1 [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^mobile/search/(.*)$ mobile.html?THISPAGE=search.html&media=mobile&search=$1 [L,QSA]
#RewriteCond %{REQUEST_FILENAME} !-f
#RewriteCond %{REQUEST_FILENAME} !-d
#RewriteCond %{REQUEST_FILENAME} !-l
#RewriteRule ^mobile/(.*)/process.html$ mobile.html?THISPAGE=$1&media=mobile&return=process [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^mobile/(.*)/success.html$ mobile.html?THISPAGE=$1&media=mobile&return=success [L,QSA]
#RewriteCond %{REQUEST_FILENAME} !-f
#RewriteCond %{REQUEST_FILENAME} !-d
#RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^standard/search/(.*)$ standard.html?THISPAGE=search.html&media=standard&search=$1 [L,QSA]
#RewriteCond %{REQUEST_FILENAME} !-f
#RewriteCond %{REQUEST_FILENAME} !-d
#RewriteCond %{REQUEST_FILENAME} !-l
#RewriteRule ^standard/(.*)/process.html$ standard.html?THISPAGE=$1&media=standard&return=process [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^standard/(.*)/success.html$ standard.html?THISPAGE=$1&media=standard&return=success [L,QSA]
#RewriteCond %{REQUEST_FILENAME} !-f
#RewriteCond %{REQUEST_FILENAME} !-d
#RewriteCond %{REQUEST_FILENAME} !-l
#RewriteRule ^(.*)/process.html$ contact.html?THISPAGE=$1&return=process [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.*)/success.html$ contact.html?THISPAGE=$1&return=success [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^search/(.*)$ index.php?THISPAGE=search.html&search=$1 [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^proposal.html$ index.php?THISPAGE=$1&media=proposal [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^contrast/search/(.*)$ contrast.html?THISPAGE=search.html&search=$1&media=contrast [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^print/search/(.*)$ print.html?THISPAGE=search.html&search=$1&media=print [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^mobile/(.*)$ mobile.html?THISPAGE=$1&media=mobile [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^standard/(.*)$ standard.html?THISPAGE=$1&media=standard [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^print/(.*)$ print.html?THISPAGE=$1&media=print [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^pdf/(.*)$ pdf.html?THISPAGE=$1&media=pdf [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^proposal/(.*)$ proposal.html?THISPAGE=$1&media=proposal [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^flash/(.*)$ flash.html?THISPAGE=$1&media=flash [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^contrast/(.*)$ contrast.html?THISPAGE=$1&media=contrast [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.*)$ index.php?THISPAGE=$1 [L,QSA]
<?php echo $AdminAccess; ?>
<?php echo $RedirectHome; ?>


Redirect 301 /assets/ /public/images/assets/
Redirect 301 /plugins.xml /public/projects/development/software/frog/plugins.xml
Redirect 301 /googlemap.zip /public/projects/development/software/frog/plugins/googlemap.zip
Redirect 301 /savemysql.zip /public/projects/development/software/frog/plugins/savemysql.zip


</IfModule>