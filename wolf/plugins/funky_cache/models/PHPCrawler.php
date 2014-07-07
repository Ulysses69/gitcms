<?php

if (!defined('IN_CMS')) { exit(); }


require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawler.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerUtils.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/UrlCache/PHPCrawlerURLCacheBase.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/UrlCache/PHPCrawlerMemoryURLCache.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/UrlCache/PHPCrawlerSQLiteURLCache.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerHTTPRequest.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerLinkFinder.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerDNSCache.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerCookieDescriptor.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerResponseHeader.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/CookieCache/PHPCrawlerCookieCacheBase.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/CookieCache/PHPCrawlerMemoryCookieCache.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/CookieCache/PHPCrawlerSQLiteCookieCache.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerURLFilter.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerRobotsTxtParser.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerProcessReport.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerUserSendDataCache.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerURLDescriptor.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerDocumentInfo.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerBenchmark.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerUrlPartsDescriptor.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/PHPCrawlerStatus.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/Enums/PHPCrawlerAbortReasons.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/Enums/PHPCrawlerRequestErrors.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/Enums/PHPCrawlerUrlCacheTypes.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/Enums/PHPCrawlerMultiProcessModes.class.php');


require_once('./wolf/plugins/funky_cache/lib/crawl/libs/ProcessCommunication/PHPCrawlerProcessCommunication.class.php');
require_once('./wolf/plugins/funky_cache/lib/crawl/libs/ProcessCommunication/PHPCrawlerDocumentInfoQueue.class.php');




if(!class_exists('MyCrawler')){
	// Extend the class and override the handleDocumentInfo()-method
	class MyCrawler extends PHPCrawler 
	{
	  function handleDocumentInfo($DocInfo) 
	  {
	    // Just detect linebreak for output ("\n" in CLI-mode, otherwise "<br>").
	    if (PHP_SAPI == "cli") $lb = "\n";
	    else $lb = "<br />";
	
	    // Print the URL and the HTTP-status-Code
	    echo "Page requested: ".$DocInfo->url." (".$DocInfo->http_status_code.")".$lb;
	    
	    // Print the refering URL
	    echo "Referer-page: ".$DocInfo->referer_url.$lb;
	    
	    // Print if the content of the document was be recieved or not
	    if ($DocInfo->received == true)
	      echo "Content received: ".$DocInfo->bytes_received." bytes".$lb;
	    else
	      echo "Content not received".$lb; 
	    
	    // Now you should do something with the content of the actual
	    // received page or file ($DocInfo->source), we skip it in this example 
	    
	    echo $lb;
	    
	    flush();
	  } 
	}
	
	// Now, create a instance of your class, define the behaviour
	// of the crawler (see class-reference for more options and details)
	// and start the crawling-process. 
	
	$crawler = new MyCrawler();
	
	// URL to crawl
	//$crawler->setURL("www.php.net");
	$crawler->setURL($_SERVER['HTTP_HOST']);
	
	// Only receive content of files with content-type "text/html"
	$crawler->addContentTypeReceiveRule("#text/html#");
	
	// Ignore links to pictures, dont even request pictures
	$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");

	// Store and send cookie-data like a browser does
	$crawler->enableCookieHandling(true);
	
	// Set the traffic-limit to 1 MB (in bytes,
	// for testing we dont want to "suck" the whole site)
	$crawler->setTrafficLimit(1000 * 1024);
	
	// Thats enough, now here we go
	$crawler->go();
	
	// At the end, after the process is finished, we print a short
	// report (see method getProcessReport() for more information)
	$report = $crawler->getProcessReport();
	
	if (PHP_SAPI == "cli") $lb = "\n";
	else $lb = "<br />";
	    
	echo "Summary:".$lb;
	echo "Links followed: ".$report->links_followed.$lb;
	echo "Documents received: ".$report->files_received.$lb;
	echo "Bytes received: ".$report->bytes_received." bytes".$lb;
	echo "Process runtime: ".$report->process_runtime." sec".$lb;
}
			


?>