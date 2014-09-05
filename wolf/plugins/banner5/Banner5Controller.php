<?php
class Banner5Controller extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/banner5/views/sidebar'));
	}
	public function index(){
		$this->display('banner5/views/settings');
	}
	function settings(){
		$settings = Plugin::getAllSettings('banner5');
			if (!$settings) {
				Flash::set('error', 'Banner 5 - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('banner5/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'banner5';
		$bannerid = $_POST['bannerid'];
		$bannerwidth = $_POST['bannerwidth'];
		$bannerheight = $_POST['bannerheight'];
		$bannerradius = $_POST['bannerradius'];
		//$bannercode = $_POST['bannercode'];
		$bannerimages = $_POST['bannerimages'];
		//$bannerinclude = $_POST['bannerinclude'];
		//$bannerexclude = $_POST['bannerexclude'];
		//$imagesarray = $_POST['imagesarray'];
		$imagesarray = explode(',', rtrim($_POST['imagesarray'], ','));
		//$descriptionsarray = $_POST['descriptionsarray'];

		$descriptionsarray = '';
		for ($i = 0; $i < sizeof($imagesarray); $i++) {
			$title = $_POST['title'.$i];
			//array_push($title_array, $title);
			$descriptionsarray .= $title.'|';
		}

		$pref_controls = $_POST['pref_controls'];
		$pref_random = $_POST['pref_random'];
		$pref_preload = $_POST['pref_preload'];
		$pref_transition = $_POST['pref_transition'];
		$pref_burns = $_POST['pref_burns'];
		$pref_burntime = $_POST['pref_burntime'];
		$pref_time = $_POST['pref_time'];
		$pref_pause = $_POST['pref_pause'];
		$pref_delay = $_POST['pref_delay'];
		
		if(is_dir($_SERVER{'DOCUMENT_ROOT'}.$_POST['bannerimages'])){

			$settings = array('bannerid' => $bannerid,
							  'bannerwidth' => $bannerwidth,
							  'bannerheight' => $bannerheight,
							  'bannerradius' => $bannerradius,
							  'bannerimages' => $bannerimages,
							  'imagesarray' => $imagesarray,
							  'descriptionsarray' => $descriptionsarray,
							  'pref_controls' => $pref_controls,
							  'pref_random' => $pref_random,
							  'pref_preload' => $pref_preload,
							  'pref_transition' => $pref_transition,
							  'pref_burns' => $pref_burns,
							  'pref_burntime' => $pref_burntime,
							  'pref_time' => $pref_time,
							  'pref_pause' => $pref_pause,
							  'pref_delay' => $pref_delay
				);
	
			if (Plugin::setAllSettings($settings, 'banner5')){
	
				$servpath = dirname(__FILE__);
				$jspath = '/inc/js/';
				$jsfile = 'banner5.js';
				$bannerxml	= '/banner5.xml';
				$jsfilepath = $_SERVER{'DOCUMENT_ROOT'}.$jspath.$jsfile;
				$compress = FALSE;
	
				$pageslug = $this->slug;
	
				if($pageslug == null){
					$pageslug = 'home';
				}
				//if($bannerinclude == null && $bannerexclude != null){
				//	$bannerinclude = 'all';
				//}
		
				//if(stristr($bannerinclude,$pageslug) || $bannerinclude == 'all'){
				
						/*
						return '
						<script type="text/javascript">
						<!--// <![CDATA[
						var so = new SWFObject("/inc/img/banner5.swf", "flashbanner", "'.$bannerwidth.'", "'.$bannerheight.'", "7", "#ffffff");
						so.addParam("AllowScriptAccess", "always");
						so.addParam("wmode", "transparent");
						so.addVariable("showLogo", "false");
						so.addVariable("showVersionInfo", "false");
						so.addVariable("dataFile", "'.$bannerxml.'");
						so.write("'.$bannerid.'");
						// -->
						</script>
						';
						*/
	
						$flash = 'var fb = new SWFObject("/inc/img/bannerInstall.swf", "flashbanner", "'.$bannerwidth.'", "'.$bannerheight.'", "7", "#ffffff");';
						$flash .= 'fb.addParam("AllowScriptAccess", "always");';
						$flash .= 'fb.addParam("wmode", "transparent");';
						$flash .= 'fb.addVariable("loadDelay", "'.($pref_delay + $pref_time).'");';
						$flash .= 'fb.addVariable("showLogo", "false");';
						$flash .= 'fb.addVariable("showVersionInfo", "false");';
						$flash .= 'fb.addVariable("dataFile", "'.$bannerxml.'");';
						if($bannerradius > 0){ $flash .= 'fb.addVariable("borderRadius", "'.$bannerradius.'");'; }
						$flash .= 'fb.write("'.$bannerid.'");';
	
				//}
	
				$js = $flash;
	
				if (file_exists($jsfilepath)) {
					// echo "The file $jsfilepath exists";
					chmod($jsfilepath, 0777);
					if(is_writable($jsfilepath)){
						if($compress == TRUE){
							require 'lib/class.JavaScriptPacker.php';
							$packer = new JavaScriptPacker($js, 'Normal', true, false);
							$packed = $packer->pack();
							Flash::set('success', 'Banner 5 - '.__('settings have been saved.'));
						} else {
							$packed = $js;
							Flash::set('success', 'Banner 5 - '.__('settings have been saved.'));
						}
						if($packed != file_get_contents($jsfilepath) && $packed != ''){
							$jssave = fopen($jsfilepath,'w') or die("can't open file " . $jsfilepath);
							/* Force cache */
							fwrite($jssave, $packed);
							chmod($jsfilepath, 0644);
							/* Display message if in backend */
							Flash::set('success', 'Banner 5 - '.__('banner5 js has successfully updated.'));
						} else {
							//Flash::set('error', 'Banner 5 - '.__('banner5 js does not need updating.'));
						}
					} else {
						chmod($jsfilepath, 0644);
						/* Display message if in backend */
						Flash::set('error', 'Banner 5 - '.__('banner5 js is not writable.'));
					}
				} else {
					// echo "The required file $jsfilepath does not exist.";
					Flash::set('error', 'Banner 5 - '.__($jsfilepath.' not found.'));
				}
				redirect(get_url('plugin/banner5/settings'));
	
			} else {
				Flash::set('error', 'Banner 5 - '.__('plugin settings not saved!'));
				redirect(get_url('plugin/banner5/settings'));
			}
			
		} else {
			Flash::set('error', 'Banner 5 - '.__('the image path does not exist.'));
			redirect(get_url('plugin/banner5/settings'));
		}

	}
}