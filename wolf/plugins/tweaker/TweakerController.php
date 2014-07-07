<?php
class TweakerController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/tweaker/views/sidebar'));
	}
	public function index(){
		$this->generate();
	}
	public function generate(){
		$this->display('tweaker/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('tweaker');
	        if (!$settings) {
	            Flash::set('error', 'Tweaker - '.__('unable to retrieve plugin settings.'));
	            return;
	        }
	        $this->display('tweaker/views/settings', $settings);
	}
	public function save_settings(){
		$wof = 'wolf';
		$tablename = TABLE_PREFIX.'tweaker';
		$urlpublic = $_POST['urlpublic'];
		$autometa = $_POST['autometa'];
		$plugindescriptions = $_POST['plugindescriptions'];

		$admincss = '../'.ADMIN_DIR.'/stylesheets/admin.css';
		$wofjs = '../'.ADMIN_DIR.'/javascripts/wolf.js';
		$backendlayout = '../'.$wof.'/app/layouts/backend.php';

		if(file_exists($admincss)){
			chmod($admincss, 0777);
			if(is_writable($admincss)){
				$cssdata = '';
				$csstempdata = file_get_contents($admincss);
				$hidecss = "\rtd.plugin p {display: none;}\r";
				if($plugindescriptions == 'true'){
					$cssdata = str_replace($hidecss, '', $csstempdata);
				} else {
					$cssdata = $csstempdata.$hidecss;
				}
				if($cssdata != ''){
					$csssave = fopen($admincss,'w') or die("can't open file " . $admincss);
					/* Force cache */
					fwrite($csssave, $cssdata);
					chmod($admincss, 0644);
					Flash::set('success', 'Tweaker - '.__('Admin css has successfully updated.'));
				}
			} else {
				chmod($admincss, 0644);
				Flash::set('error', 'Tweaker - '.__('Admin css is not writable.'));
			}

		} else {
			Flash::set('error', 'Tweaker - '.__('Admin css cannot be found at '.$admincss));
		}

		if(file_exists($wofjs)){
			chmod($wofjs, 0777);
			if(is_writable($wofjs)){
				$data = '';
				$tempdata = file_get_contents($wofjs);
				$renameslug = "if (oldTitle.toSlug() == slug.value) slug.value = title.value.toSlug();";
				$renamecrumb = "if (oldTitle == breadcrumb.value) breadcrumb.value = title.value;";
				$lockslug = "if (oldTitle.toSlug() == slug.value && autometa.value != 'false') slug.value = title.value.toSlug();";
				$lockcrumb = "if (oldTitle == breadcrumb.value && autometa.value != 'false') breadcrumb.value = title.value;";
				if($autometa == 'true'){
					/* Disable auto-name */
					$parse = str_replace($lockslug, $renameslug, $tempdata);$data = str_replace($lockcrumb, $renamecrumb, $parse);
				} else {
					/* Enable auto-name */
					$parse = str_replace($renameslug, $lockslug, $tempdata);$data = str_replace($renamecrumb, $lockcrumb, $parse);
				}
				if($data != ""){
					$save = fopen($wofjs,'w') or die("can't open file " . $wofjs);
					fwrite($save, $data);
					chmod($wofjs, 0644);
					Flash::set('success', 'Tweaker - '.__('Auto-generate meta successful.'));
				}

				if(file_exists($backendlayout)){
					chmod($backendlayout, 0777);
					if(is_writable($backendlayout)){
						$layouttempdata = file_get_contents($backendlayout);
						$staticwof = 'frog.js';
						$dynamicwof = 'frog.js?cache=js';
						/* Force wolf js cache here, since we're checking the backend anyway */
						if(file_exists($wofjs)){
							if($autometa == 'false'){
								if(stristr("cache=js", $layouttempdata) === FALSE){
									$layouttempdata = str_replace($staticwof, $dynamicwof, $layouttempdata);
								}
							} else {
								$layouttempdata = str_replace($dynamicwof, $staticwof, $layouttempdata);
							}
						}
						/* Force admin css cache here, since we're checking the backend anyway */
						if(file_exists($admincss)){
							if($plugindescriptions == 'false'){
								if(stristr("cache=css", $layouttempdata) === FALSE){
									$layouttempdata = str_replace("admin.css", "admin.css?cache=css", $layouttempdata);
								}
							} else {
								$layouttempdata = str_replace("admin.css?cache=css", "admin.css", $layouttempdata);
							}
						}
						if($layouttempdata != ''){
							$layoutsave = fopen($backendlayout,'w') or die("can't open file");
							$layouttempdata = str_replace("?cache=css?cache=css", "?cache=css", $layouttempdata);
							$layouttempdata = str_replace("?cache=js?cache=js", "?cache=js", $layouttempdata);
							fwrite($layoutsave, $layouttempdata);
							chmod($backendlayout, 0644);
							Flash::set('success', 'Tweaker - '.__('Backend layout has successfully updated.'));
						}
					} else {
						chmod($backendlayout, 0644);
						Flash::set('error', 'Tweaker - '.__('Backend layout is not writable.'));
					}
				} else {
					Flash::set('error', 'Tweaker - '.__('Backend layout cannot be found at '.$backendlayout));
				}
			} else {
				Flash::set('error', 'Tweaker - '.__('The '.$wof.'.js file is not writable.'));
			}
		} else {
			Flash::set('error', 'Tweaker - '.__('The '.$wof.'.js file cannot be found at '.$wof));
		}



	        if (empty($urlpublic)) {
			$urlpublic = '/';
	        } else {
	        	$settings = array('urlpublic' => $urlpublic,
	            			'autometa' => $autometa,
	            			'plugindescriptions' => $plugindescriptions
	                );
			    
			if (Plugin::setAllSettings($settings, 'tweaker'))
				Flash::set('success', 'Tweaker - '.__('plugin settings saved.'));
			else
				Flash::set('error', 'Tweaker - '.__('plugin settings not saved!'));
				redirect(get_url('plugin/tweaker/settings'));
		}

	}
}