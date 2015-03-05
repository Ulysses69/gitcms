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
		if(isset($_POST['sitemaplink'])) { $sitemaplink = $_POST['sitemaplink']; } else { $sitemaplink = ''; }
		if(isset($_POST['sitemaptitle'])) { $sitemaptitle = $_POST['sitemaptitle']; } else { $sitemaptitle = ''; }
		if(isset($_POST['sitemapdescription'])) { $sitemapdescription = $_POST['sitemapdescription']; } else { $sitemapdescription = ''; }
		if(isset($_POST['sitemapheadings'])) { $sitemapheadings = $_POST['sitemapheadings']; } else { $sitemapheadings = ''; }
		if(isset($_POST['sitemaparchives'])) { $sitemaparchives = $_POST['sitemaparchives']; } else { $sitemaparchives = ''; }
		if(isset($_POST['clientlocation'])) { $clientlocation = $_POST['clientlocation']; } else { $clientlocation = ''; }
		if(isset($_POST['clientanalyticssubdomain'])) { $clientanalyticssubdomain = $_POST['clientanalyticssubdomain']; } else { $clientanalyticssubdomain = ''; }
		if(isset($_POST['clientanalyticsstatus'])) { $clientanalyticsstatus = $_POST['clientanalyticsstatus']; } else { $clientanalyticsstatus = ''; }
		if(isset($_POST['clientanalyticslinks'])) { $clientanalyticslinks = $_POST['clientanalyticslinks']; } else { $clientanalyticslinks = ''; }
		if(isset($_POST['clientanalyticspolicy'])) { $clientanalyticspolicy = $_POST['clientanalyticspolicy']; } else { $clientanalyticspolicy = ''; }
		if(isset($_POST['clientanalyticsnoscript'])) { $clientanalyticsnoscript = $_POST['clientanalyticsnoscript']; } else { $clientanalyticsnoscript = ''; }
		if(isset($_POST['noticestatus'])) { $noticestatus = $_POST['noticestatus']; } else { $noticestatus = ''; }
		if(isset($_POST['noticedays'])) { $noticedays = $_POST['noticedays']; } else { $noticedays = ''; }
		if(isset($_POST['noticelivecheck'])) { $noticelivecheck = $_POST['noticelivecheck']; } else { $noticelivecheck = ''; }
		if(isset($_POST['bots'])) { $bots = $_POST['bots']; } else { $bots = ''; } if($bots == '') $bots = 'disallow';
		if(isset($_POST['clientanalyticsscreenstats'])) { $clientanalyticsscreenstats = $_POST['clientanalyticsscreenstats'];  } else { $clientanalyticsscreenstats = ''; }
		if(isset($_POST['hometabindex'])) { $hometabindex = $_POST['hometabindex']; } else { $hometabindex = ''; }
		
        if(isset($_POST['clientanalytics'])) { $clientanalytics = $_POST['clientanalytics']; } else { $clientanalytics = ''; }
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
						  'clientanalyticsversion' => $clientanalyticsversion,
						  'hometabindex' => $hometabindex);

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