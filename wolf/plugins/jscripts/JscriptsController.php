<?php
//if (!defined('IN_CMS')) { exit(); }
class JscriptsController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/jscripts/views/sidebar'));
	}
	public function index() {
			$this->documentation();
	}
	public function documentation() {
		$settings = Plugin::getAllSettings('jscripts');
			if (!$settings) {
				Flash::set('error', 'jScripts - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('jscripts/views/settings', $settings);
	}
	public function settings(){
		$settings = Plugin::getAllSettings('jscripts');
			if (!$settings) {
				Flash::set('error', 'jScripts - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('jscripts/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'jscripts';
		$embedding = $_POST['embedding'];
		$rows = $_POST['rows'];
		$marqueeparent = $_POST['marqueeparent'];
		$marqueecontent = $_POST['marqueecontent'];
		$marqueedisplaynum = $_POST['marqueedisplaynum'];
		$marqueeorder = $_POST['marqueeorder'];
		$marqueesort = $_POST['marqueesort'];
		$marqueeduration = $_POST['marqueeduration'];
		$marqueetransition = $_POST['marqueetransition'];
		$emptyrows = 0;
		for($r=0;$r<$rows+1;$r++){
			${'script'.$r} = $_POST['script'.$r];
			${'include'.$r} = $_POST['include'.$r];
			${'exclude'.$r} = $_POST['exclude'.$r];
			${'insert'.$r} = $_POST['insert'.$r];
			if(${'script'.$r} == null){
				$emptyrows++;
			}
		}
		$settings = array('embedding' => $embedding);
		if($emptyrows != 0){
			$rows = $rows + 1;
		}
		$settings['rows'] = $rows;
		for($r=0;$r<$rows;$r++){
			//if(${'script'.$r} != null){
				$settings['script'.$r] = ${'script'.$r};
				$settings['include'.$r] = ${'include'.$r};
				$settings['exclude'.$r] = ${'exclude'.$r};
				$settings['insert'.$r] = ${'insert'.$r};
			//}
		}

		$settings['marqueeparent'] = $marqueeparent;
		$settings['marqueecontent'] = $marqueecontent;
		$settings['marqueedisplaynum'] = $marqueedisplaynum;
		$settings['marqueeorder'] = $marqueeorder;
		$settings['marqueesort'] = $marqueesort;
		$settings['marqueeduration'] = $marqueeduration;
		$settings['marqueetransition'] = $marqueetransition;	

		/* Write jscript file */
		/* TO DO: js file does not updated first time */
		writeJScripts($this);
		//save_jscripts();		

		if (Plugin::setAllSettings($settings, 'jscripts')){
			
			if(function_exists('funky_cache_delete_all')){
				funky_cache_delete_all();
			}

			Flash::set('success', 'jScripts - '.__('plugin settings saved.'));
			redirect(get_url('plugin/jscripts/settings'));

		} else {
			Flash::set('error', 'jScripts - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/jscripts/settings'));
		}

		//header('refresh:0; url=/admin/plugin/jscripts/settings');
		//$this->display('jscripts/views/settings', $settings);

	}

}