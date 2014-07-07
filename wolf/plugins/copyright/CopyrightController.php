<?php
class CopyrightController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/copyright/views/sidebar'));
	}
    public function index() {
        //$this->documentation();
        //$this->display('copyright/views/settings', $settings);
        $this->display('copyright/views/settings');
    }
	public function settings(){
		$settings = Plugin::getAllSettings('copyright');
	        if (!$settings) {
	            Flash::set('error', 'Copyright - '.__('unable to retrieve plugin settings.'));
	            return;
	        }
	        $this->display('copyright/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'copyright';
		$linkcustom = $_POST['linkcustom'];
		$livedate = $_POST['livedate'];
		$vatnumber = $_POST['vatnumber'];
		$companyregistration = $_POST['companyregistration'];
		$countryregistration = $_POST['countryregistration'];
		$icoregistrant = $_POST['icoregistrant'];
		$icoaddress = $_POST['icoaddress'];
		$iconumber = $_POST['iconumber'];
		$gdcnumber = $_POST['gdcnumber'];
		$gdcurl = $_POST['gdcurl'];
		$cqcname = $_POST['cqcname'];
		$cqcnumber = $_POST['cqcnumber'];
		$cqcurl = $_POST['cqcurl'];
		if($_POST['linkback'] != '') {
			$linkback = str_replace("'",'"',$_POST['linkback']); 
		} else { 
			$linkback = $_POST['linkback'];
		}
		$settings = array(	'linkback' => $linkback,
				  			'linkcustom' => $linkcustom,
				  			'livedate' => $livedate,
				  			'vatnumber' => $vatnumber,
				  			'companyregistration' => $companyregistration,
				  			'countryregistration' => $countryregistration,
				  			'icoregistrant' => $icoregistrant,
				  			'icoaddress' => $icoaddress,
				  			'iconumber' => $iconumber,
				  			'gdcnumber' => $gdcnumber,
				  			'gdcurl' => $gdcurl,
				  			'cqcname' => $cqcname,
				  			'cqcnumber' => $cqcnumber,
				  			'cqcurl' => $cqcurl);
		if (Plugin::setAllSettings($settings, 'copyright')) {
			Flash::set('success', 'Copyright - '.__('plugin settings saved.'));
			redirect(get_url('plugin/copyright/settings'));
		} else {
			Flash::set('error', 'Copyright - '.__('plugin settings not saved!').$linkback);
			redirect(get_url('plugin/copyright/settings'));
		}

	}
}