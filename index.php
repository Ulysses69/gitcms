<?php




























//  Constants  ---------------------------------------------------------------
define('IN_CMS', true); // define('WP_USE_THEMES', false); require_once('./blog/wp-blog-header.php'); // DEFINE Wordpress include

define('CMS_ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
define('CORE_ROOT', CMS_ROOT.DS.'wolf');
define('PLUGINS_ROOT', CORE_ROOT.DS.'plugins');
define('APP_PATH', CORE_ROOT.DS.'app');
define('REGISTER_FUNCTIONS', '../.RegisterFunctions');
require_once(CORE_ROOT.DS.'utils.php');

$config_file = CMS_ROOT.DS.'config.php';
require_once($config_file);


if ( ! defined('DEBUG')) { header('Location: install/'); exit(); }

$url = URL_PUBLIC;

// Figure out what the public URI is based on URL_PUBLIC.
// @todo improve
$changedurl = str_replace('//','|',URL_PUBLIC);
$lastslash = strpos($changedurl, '/');
if (false === $lastslash) {
    define('URI_PUBLIC', '/');
}
else {
    define('URI_PUBLIC', substr($changedurl, $lastslash));
}

// Determine URI for backend check
if (USE_MOD_REWRITE && isset($_GET['THISPAGE'])) {
    $admin_check = $_GET['THISPAGE'];
}
else {
    $admin_check = urldecode($_SERVER['QUERY_STRING']);
}

// Are we in frontend or backend?
if (startsWith($admin_check, ADMIN_DIR) || startsWith($admin_check, '/'.ADMIN_DIR) || isset($_GET['WOLFAJAX'])) {
    define('CMS_BACKEND', true);
    if (defined('USE_HTTPS') && USE_HTTPS) {
        $url = str_replace('http://', 'https://', $url);
    }
    define('BASE_URL', $url . (endsWith($url, '/') ? '': '/') . (USE_MOD_REWRITE ? '': '?/') . ADMIN_DIR . (endsWith(ADMIN_DIR, '/') ? '': '/'));
    define('BASE_URI', URI_PUBLIC . (endsWith($url, '/') ? '': '/') . (USE_MOD_REWRITE ? '': '?/') . ADMIN_DIR . (endsWith(ADMIN_DIR, '/') ? '': '/'));
}
else {
    define('BASE_URL', URL_PUBLIC . (endsWith(URL_PUBLIC, '/') ? '': '/') . (USE_MOD_REWRITE ? '': '?'));
    define('BASE_URI', URI_PUBLIC . (endsWith(URI_PUBLIC, '/') ? '': '/') . (USE_MOD_REWRITE ? '': '?'));
}

define('PLUGINS_URI', URI_PUBLIC.'wolf/plugins/');
if (!defined('THEMES_ROOT')) { define('THEMES_ROOT', CMS_ROOT.'/public/themes'); }
if (!defined('THEMES_URI')) { define('THEMES_URI', URI_PUBLIC.'public/themes/'); }

// Figure out which mode the admin theme should use
if(stristr($_SERVER['SERVER_NAME'],'bluehorizons')){
	define('CMS_THEME_MODE', 'Blue Horizons Client');
} else {
	define('CMS_THEME_MODE', 'Default');
}


// Security checks -----------------------------------------------------------
if (DEBUG == false && isWritable($config_file)) {

    if (substr(PHP_OS, 0, 3) != 'WIN') {
        echo '<html><head><title>Server work in progress</title></head><body>';
        echo '<h1>This website is currently being serviced</h1>';
        echo '<p><strong>Status:</strong> it has been temporarily disabled.</p>';
        echo '<p><strong>Reason:</strong> the administrator needs to complete service work.</p>';
        echo '</body></html>';
        exit();
    }
}

//  Init  --------------------------------------------------------------------

//if (!defined('BASE_URL')) define('BASE_URL', URL_PUBLIC . (endsWith(URL_PUBLIC, '/') ? '': '/') . (USE_MOD_REWRITE ? '': '?'));
//if (!defined('BASE_URI')) define('BASE_URI', URI_PUBLIC . (endsWith(URI_PUBLIC, '/') ? '': '/') . (USE_MOD_REWRITE ? '': '?'));

require CORE_ROOT.'/Framework.php';

try {
    $__CMS_CONN__ = @new PDO(DB_DSN, DB_USER, DB_PASS);
}
catch (PDOException $error) {
	
	// DATABASE ERROR

	$h1 = '<h1>Page unavailable</h1>';
	$message = '<p>The content for this page is temporarily unavailable, due to a database connection error. </p><p>Please try again in a few minutes.</p>';
	
	// Check if cached index page exists (use for template)
	//if(file_exists('cache/template'.URL_SUFFIX)){
	if(!stristr($_SERVER['REQUEST_URI'],'mobile/') && file_exists('cache/template'.URL_SUFFIX) || stristr($_SERVER['REQUEST_URI'],'mobile/') && file_exists('cache/mobile/template'.URL_SUFFIX)){

		$doc = new DOMDocument();
		libxml_use_internal_errors(true);

		// Use sitemap page, else use home page
		$page = 'index';

		// TO DO: Check mobile/print/download
		if(stristr($_SERVER['REQUEST_URI'],'mobile/') && file_exists('cache/mobile/template'.URL_SUFFIX)){
			$template = 'mobile/template';
		} else {
			$template = 'template';
		}


		$doc->loadHTMLFile('cache/'.$template.URL_SUFFIX);

		//if($page != 'sitemap') {

			// Find container of content
			$container = $doc->getElementsByTagName('h1')->item(0)->parentNode;
			$containerChildren = $container->childNodes;

			//echo 'Mobile';
			//exit;
			
			// Remove existing content
			while ($containerChildren->length > 0) {
				$container->removeChild($containerChildren->item(0));
			}

			// Update title (typically used for temporary technical notices)
			// Let Google Analytics filter this page with help of title: page http://blog.vkistudios.com/index.cfm/2009/4/24/Tracking-Error-Pages-and-Broken-Links-in-Google-Analytics
			$new_title_tag = $doc->getElementsByTagName("title");
			$new_title_tag->item(0)->nodeValue = 'Error 503: Temporarily Unavailable';
	
			// Create new h1
			$new_h1_tag = $doc->createElement("h1");
			$new_h1_tag->nodeValue = strip_tags($h1);
			
			// Create new paragraph
			$new_p_tag = $doc->createElement("p");
			$new_p_tag->nodeValue = strip_tags($message);

			// Add new content
			$container->appendChild($new_h1_tag);
			$container->appendChild($new_p_tag);

		//}


		// Ensure headers are set
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status: 503 Service Temporarily Unavailable');
		header('Retry-After: 300');//300 seconds

		echo $doc->saveHTML();
		libxml_clear_errors();



	} else {

		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status: 503 Service Temporarily Unavailable');
		header('Retry-After: 300');//300 seconds
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml">';
		echo '<head>';
		echo '<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />';
		echo '<link rel="stylesheet" href="/inc/css/print.css" type="text/css" media="screen, print" />';
		echo '<style type="text/css">';
		echo '#top { padding: 1em 2.5em; }';
		echo '</style>';
		echo '</head>';
		echo '<body>';
		echo '<div id="top">';
		echo '<div id="content">';
		echo $h1;
		echo $message;

		//echo $_SERVER['SERVER_NAME']."\n";
		//echo $_SERVER['REQUEST_URI']."\n";

		echo '</div>';
		
		if(file_exists(dirname(__FILE__).'/inc/img/logo.png')) echo '<br/><img src="/inc/img/logo.png" alt="" style="width:150px;height:auto;max-width:100%" />';

		echo '</div>';
		echo '</body>';
		echo '</html>';
		
		$unwanted = array("www.", "http://", "https://", "/");
		if(!isset($name)) $name = '/';
		if(!isset($email)) $email = '';
		if(!isset($nameOut)) $nameOut = '';
		if(!isset($emailOut)) $emailOut = '';
		//include('./wolf/plugins/form_core/lib/formSettings.php');
		//
		//if(!isset($name)) $name = '';
		$head_from = "cms@".str_replace($unwanted,'',URL_ABSOLUTE);
		$headers = "Return-Path: ".$head_from."\r\n";
		$headers .= "Reply-To: \"".$name."\" <".$email.">\r\n";
		$headers .= "From: ".$email."\r\n";
		$headers .= "To: \"".$nameOut."\" <".$emailOut.">\r\n";
		exit;

		//mail("steven@bluehorizonsmedia.co.uk", $_SERVER['HTTP_HOST'], 'Database Connection Error: '.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], "From: CMS Alert <".$head_from.">");
		//die('DB Connection failed: '.$error->getMessage());

	}

}

if(isset($__CMS_CONN__)){

	$driver = $__CMS_CONN__->getAttribute(PDO::ATTR_DRIVER_NAME);
	
	if ($driver === 'mysql') {
	    $__CMS_CONN__->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	}
	
	if ($driver === 'sqlite') {
	    // Adding date_format function to SQLite 3 'mysql date_format function'
	    if (! function_exists('mysql_date_format_function')) {
	        function mysql_function_date_format($date, $format) {
	            return strftime($format, strtotime($date));
	        }
	    }
	    $__CMS_CONN__->sqliteCreateFunction('date_format', 'mysql_function_date_format', 2);
	}

	// DEFINED ONLY FOR BACKWARDS SUPPORT - to be taken out before 0.9.0
	$__FROG_CONN__ = $__CMS_CONN__;
	
	Record::connection($__CMS_CONN__);
	Record::getConnection()->exec("set names 'utf8'");
	
	Setting::init(); Flash::init();
	
	use_helper('I18n','Globals');
	I18n::setLocale(Setting::get('language'));
	
	// Only add the cron web bug when necessary
	if (defined('USE_POORMANSCRON') && USE_POORMANSCRON && defined('POORMANSCRON_INTERVAL')) {
	    Observer::observe('page_before_execute_layout', 'run_cron');
	
	    function run_cron() {
	        $cron = Cron::findByIdFrom('Cron', '1');
	        $now = time();
	        $last = $cron->getLastRunTime();
	
	        if ($now - $last > POORMANSCRON_INTERVAL) {
	            echo $cron->generateWebBug();
	        }
	    }
	}

// run everything!
require APP_PATH.'/main.php';

}


