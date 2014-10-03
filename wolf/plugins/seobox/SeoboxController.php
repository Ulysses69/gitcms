<?php
class SeoboxController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/seobox/views/sidebar'));
	}
	public function index(){
		$this->generate();
	}
	public function generate(){
		$this->display('seobox/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('seobox');
			if (!$settings) {
				Flash::set('error', 'SEO Box - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('seobox/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'seobox';
		$sitemaplink = $_POST['sitemaplink'];
		$sitemaptitle = $_POST['sitemaptitle'];
		$sitemapdescription = $_POST['sitemapdescription'];
		$sitemapheadings = $_POST['sitemapheadings'];
		$sitemaparchives = $_POST['sitemaparchives'];
		$clientlocation = $_POST['clientlocation'];
		$clientanalyticssubdomain = $_POST['clientanalyticssubdomain'];
		$clientanalyticsstatus = $_POST['clientanalyticsstatus'];
		$clientanalyticslinks = $_POST['clientanalyticslinks'];
		$clientanalyticspolicy = $_POST['clientanalyticspolicy'];
		$clientanalyticsnoscript = $_POST['clientanalyticsnoscript'];
		$noticestatus = $_POST['noticestatus'];
		$noticedays = $_POST['noticedays'];
		$noticelivecheck = $_POST['noticelivecheck'];
		$bots = $_POST['bots']; if($bots == '') $bots = 'disallow';
		$clientanalyticsscreenstats = $_POST['clientanalyticsscreenstats'];  
		
        $clientanalytics = $_POST['clientanalytics'];
		if(stristr($clientanalytics, 'analytics.js')){
            // Universal tracking code detected
            $clientanalyticsversion = 'universal';
        } else {
            // Default to saved analytics version
            $clientanalyticsversion = $_POST['clientanalyticsversion'];
        }
        
		$settings = array('sitemaplink' => $sitemaplink,
				  		  'sitemaptitle' => $sitemaptitle,
						  'sitemapdescription' => $sitemapdescription,
						  'sitemapheadings' => $sitemapheadings,
						  'sitemaparchives' => $sitemaparchives,
						  'clientlocation' => $clientlocation,
						  'clientanalytics' => $clientanalytics,
						  'clientanalyticssubdomain' => $clientanalyticssubdomain,
						  'clientanalyticsstatus' => $clientanalyticsstatus,
						  'clientanalyticslinks' => $clientanalyticslinks,
						  'clientanalyticspolicy' => $clientanalyticspolicy,
						  'clientanalyticsnoscript' => $clientanalyticsnoscript,
						  'noticestatus' => $noticestatus,
						  'noticedays' => $noticedays,
						  'noticelivecheck' => $noticelivecheck,
						  'bots' => $bots,
						  'clientanalyticsscreenstats' => $clientanalyticsscreenstats,
						  'clientanalyticsversion' => $clientanalyticsversion);

		if (Plugin::setAllSettings($settings, 'seobox')) {

			// Call jscripts, in case screen stats analytics are required
			writeJScripts($this);

			Flash::set('success', 'SEO Box - '.__('plugin settings saved.'));
			redirect(get_url('plugin/seobox'));
		} else {
			Flash::set('error', 'SEO Box - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/seobox/settings'));
		}

	}
}