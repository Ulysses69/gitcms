<?php

/*
 * Redirector - Wolf CMS URL redirection plugin
 *
 * Copyright (c) 2010 Design Spike
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://themes.designspike.ca/redirector/help/
 *
 */

class RedirectorController extends PluginController {
	function __construct() {
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
 
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/redirector/views/sidebar'));
	}
 
	function index() {
		// load redirects and logged 404 errors
		$data['current_redirects'] = Record::findAllFrom('RedirectorRedirects', 'true ORDER BY destination, url, status');
		$data['current_404s'] = Record::findAllFrom('Redirector404s', 'true ORDER BY hits DESC');
		
		$this->display('redirector/views/index', $data);
	}

	function save() {

		/***
		$data['current_redirects'] = Record::findAllFrom('RedirectorRedirects', 'true ORDER BY destination, url');
		if(sizeof($data) > 0){
			foreach ($data as $redirect){
				if(stristr($redirect[0]->destination,'?')){
					echo 'redirect 301 '.$redirect[0]->url.' '.$redirect[0]->destination."\n";
				} else {
					echo 'RewriteRule ^'.ltrim($redirect[0]->url,'/').' '.$redirect[0]->destination." [L,R=301]\n";
				}
			}
		}
		exit;
		***/

		if(isset($_POST['redirect'])){ $data = $_POST['redirect']; } else { $data = ''; }
		//$data = $_POST['redirect'];

		if (empty($data['url'])){
			Flash::set('error', __('You have to specify a url.'));
			redirect(get_url('plugin/redirector/'));
		}

		if (empty($data['destination'])){
			Flash::set('error', __('You have to specify a destination url.'));
			redirect(get_url('plugin/redirector/'));
		}

		$dataURL = $data['url'];
		$dataDestination = $data['destination'];

		$dataURL = addslashes($dataURL);
		$dataDestination = addslashes($dataDestination);
		
		if(function_exists('slugify','none')){
			$dataURL = slugify($dataURL);
			$dataDestination = slugify($dataDestination);
		}


		// Ensure destination URL is not identical to redirect (page and page.html are deemed identical however)
		if (stristr($dataURL, ' ') || stristr($dataDestination, ' ')){
			Flash::set('error', __('URLs cannot contain spaces.'));
			redirect(get_url('plugin/redirector/'));
		}


		if(isset($data['status'])){ $dataStatus = $data['status']; } else { $dataStatus = 301; }
		//if($dataStatus == '') $dataStatus = 301;

		function addScheme($url){
			if($url != strip_tags($url) || stristr($url,"javascript:")) {
				$url = 'invalid';
			}
			if($parts = parse_url($url)) {
			   if(!isset($parts["host"])) {
				   $url = $_SERVER["SERVER_NAME"].'/'.$url;
			   }
			   if(!isset($parts["scheme"])) {
				   $url = "http://$url";
			   }
			   //$url = str_replace("///", "//", $url);
			   //$url = str_replace("//", "/", $url);
			   //$url = str_replace(":/", "://", $url);
			}
			
			//if(FILTER_VALIDATE_URL){
			//$url = rtrim($url, "?");
				//if(filter_var($url, FILTER_VALIDATE_URL) !== false && $url != 'invalid'){
				if($url != 'invalid'){
					return "valid";
				} else {
					//return 'valid';
					return $url." invalid";
				}
			//}
		}

		if(FILTER_VALIDATE_URL){
			if(addScheme($dataURL) != 'valid' || addScheme($dataDestination) != 'valid'){
				Flash::set('error', __('Invalid URL ('.addScheme($dataURL).' and '.addScheme($dataDestination).'). Verify all characters.'));
				redirect(get_url('plugin/redirector/'));
			}
		}

		function removeDomain($url){
			$parts = explode("/",$url);
			array_shift($parts);array_shift($parts);array_shift($parts);
			$newurl = implode("/",$parts);
			return $newurl;
		}
		if(stristr($dataURL,'http://')) $dataURL = '/'.removeDomain($dataURL);
		if(stristr($dataDestination,'http://')) $dataDestination = '/'.removeDomain($dataDestination);
		$data = array("url" => $dataURL, "destination" => $dataDestination, "status" => $dataStatus);
		//print_r($data);
		//echo $dataURL;
		//echo $dataDestination;
		//exit;

		// Ensure destination URL is not identical to redirect (page and page.html are deemed identical however)
		if ($dataDestination == $dataURL){
			Flash::set('error', __('Pages cannot redirect to itself.'));
			redirect(get_url('plugin/redirector/'));
		}

		if ($existing_redirect = Record::findOneFrom('RedirectorRedirects', 'url = \''.($dataURL.'\''))) {
			Record::update('RedirectorRedirects', array('url' => $dataURL, 'destination' => $dataDestination), 'url = \''.($dataURL.'\''), 'status = \''.($dataStatus.'\''));
		} else {
			$entry = new RedirectorRedirects($data);

			if ( ! $entry->save()){
				Flash::set('error', __('There was a problem adding your redirect. Possible outdated database schema'));
			} else {
				if ($error = Record::findOneFrom('Redirector404s', 'url = \''.($dataURL.'\''))){
					$error->delete();
				}

				Flash::set('success', __('Redirect has been added!'));
			}
		}

		if(Plugin::isEnabled('_htaccess') == true){
			
			/* TO DO: Provide www redirect option */

			$htaccessfile = $_SERVER{'DOCUMENT_ROOT'}.'/.htaccess';
			ob_start();
			include($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/lib/htaccess.php');
			$htaccesstemplate = ob_get_contents();
			ob_end_clean();

			//$htaccess = file_get_contents($htaccesstemplate);
			$htaccess = $htaccesstemplate;
			$htaccess = preg_replace("/(\s\s){1,}/","\n",trim($htaccess));
			
			$htaccessbackupfile = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/backups/.htaccess.bak';
			$htaccessbackup = file_get_contents($htaccessbackupfile);
			$htaccessbackup = preg_replace("/(\s\s){1,}/","\n",trim($htaccessbackup));

			saveServerConfig($htaccess,$htaccessbackup,$htaccessfile,$htaccessbackupfile);
		}

		redirect(get_url('plugin/redirector/'));
	}

	function remove($id) {
		// find the user to delete
		if ($redirect = Record::findByIdFrom('RedirectorRedirects', $id)){
			if ($redirect->delete()){
				Flash::set('success', __('Redirect has been deleted!'));
			}
			else
				Flash::set('error', __('There was a problem deleting this redirect!'));
		}
		else Flash::set('error', __('Redirect not found!'));
		
		if(Plugin::isEnabled('_htaccess') == true){

			$htaccessfile = $_SERVER{'DOCUMENT_ROOT'}.'/.htaccess';
			ob_start();
			include($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/lib/htaccess.php');
			$htaccesstemplate = ob_get_contents();
			ob_end_clean();

			//$htaccess = file_get_contents($htaccesstemplate);
			$htaccess = $htaccesstemplate;
			$htaccess = preg_replace("/(\s\s){1,}/","\n",trim($htaccess));

			$htaccessbackupfile = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/backups/.htaccess.bak';
			$htaccessbackup = file_get_contents($htaccessbackupfile);
			$htaccessbackup = preg_replace("/(\s\s){1,}/","\n",trim($htaccessbackup));

			saveServerConfig($htaccess,$htaccessbackup,$htaccessfile,$htaccessbackupfile);
		}
		
		redirect(get_url('plugin/redirector/'));		
	}

	function remove_404($id) {
		// find the user to delete
		if ($error = Record::findByIdFrom('Redirector404s', $id)){
			if ($error->delete()){
				Flash::set('success', __('404 Error has been deleted!'));
			}
			else
				Flash::set('error', __('There was a problem deleting this 404 error!'));
		}
		else Flash::set('error', __('404 Error not found!'));
		
		redirect(get_url('plugin/redirector/'));		
	}

}
