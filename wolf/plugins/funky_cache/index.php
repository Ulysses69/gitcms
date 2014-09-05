<?php

/*
 * Funky Cache - Wolf CMS caching plugin
 *
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/funky_cache
 *
 * ported to Wolf CMS by sartas (http://sartas.ru)
 *
 */

/**
 * Root location where Comment plugin lives.
 */
define('FUNKY_CACHE_ROOT', URI_PUBLIC.'wolf/plugins/funky_cache');

Plugin::setInfos(array(
	'id'		  => 'funky_cache',
	'title'	   => __('Funky Cache'), 
	'description' => __('Enables funky caching which makes your site ultra fast.'), 
	'version'	 => '0.3.5.2', 
	'license'	 => 'MIT',
	'author'	  => 'Mika Tuupola',
	'require_wolf_version' => '0.6.0',
	'update_url'  => 'http://www.appelsiini.net/download/frog-plugins.xml',
	'website'	 => 'http://www.appelsiini.net/'
));

	AutoLoader::addFile('FunkyCachePage', CORE_ROOT.'/plugins/funky_cache/models/FunkyCachePage.php');

/* Stuff for backend. */
if (defined('CMS_BACKEND'))  {

	AutoLoader::addFile('DateDifference', CORE_ROOT.'/plugins/funky_cache/lib/DateDifference.php');
	
	Plugin::addController('funky_cache', 'Cache', 'administrator,developer', false);

	#Observer::observe('page_edit_after_save',   'funky_cache_delete_one');
	Observer::observe('page_edit_after_save',   'funky_cache_delete_all');
	Observer::observe('page_add_after_save',	'funky_cache_delete_all');
	Observer::observe('page_delete',			'funky_cache_delete_all');
	Observer::observe('view_page_edit_plugins', 'funky_cache_show_select');


	Observer::observe('comment_after_add',   'funky_cache_delete_comment');
	Observer::observe('comment_after_edit',   'funky_cache_delete_comment');
	Observer::observe('comment_after_delete',   'funky_cache_delete_comment');
	Observer::observe('comment_after_approve',   'funky_cache_delete_comment');
	Observer::observe('comment_after_unapprove',   'funky_cache_delete_comment');

	
	/* These currently only work in MIT fork of Wolf. */
	Observer::observe('layout_after_edit',	  'funky_cache_delete_all');
	Observer::observe('snippet_after_edit',	 'funky_cache_delete_all');



	function funky_cache_delete_comment($comment) {
		if ($cache = Record::findOneFrom('FunkyCachePage', 'page_id=?', array($comment->page_id))) {
			$cache->delete();
		}
	}


	
	/* TODO Fix this to work with configurable cache folder. */
	function funky_cache_delete_one($page) {
		$data['url'] = '/' . $page->getUri() . URL_SUFFIX;
		if ($cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($data['url']))) {
			$cache->delete();
		}
	}

	function funky_cache_delete_all() {
		$cache = Record::findAllFrom('FunkyCachePage');
		foreach ($cache as $page) {
			$page->delete();
		}
	}
	
	function funky_cache_show_select($page) {
		$enabled = isset($page->funky_cache_enabled) ? 
						 $page->funky_cache_enabled  : funky_cache_by_default();
		print '
		  <div class="boxpart">
		  <p id="pagecache"><label for="page_funky_cache_enabled">'.__('Cache').'</label>
			<select id="page_funky_cache_enabled" name="page[funky_cache_enabled]">
			  <option value="0"'.($enabled == 0 ? ' selected="selected"': '').'>'.__('No').'</option>
			  <option value="1"'.($enabled == 1 ? ' selected="selected"': '').'>'.__('Yes').'</option>
			 </select>
		  </p>
		  </div>';
	}
		
} else {
/* Stuff for frontend. */  

	global $__CMS_CONN__;
	Record::connection($__CMS_CONN__);
	
	Observer::observe('page_found', 'funky_cache_create');
	// Observer::observe('page_requested', 'funky_cache_debug');

	//  function funky_cache_debug($page) {
	//print "-" . $_SERVER['QUERY_STRING'] . "-";
	//  }

	function funky_cache_create($page,$mobile=false) {

		if ($page->funky_cache_enabled) {

			funky_cache_suffix();

			// Include custom functions snippet
			$page->includeSnippet('registerfunctions');

			// UNDER CONSTRUCTION - Mobile Cache Support
			$mobdir = ''; if(Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('enable', 'mobile_check') == true && stristr($_SERVER['REQUEST_URI'],URL_PUBLIC.'mobile/')) $mobdir = 'mobile/';
			//echo 'Test page: '.$page->url; exit;

			// Cache template page
			// TO DO: Create empty template from search results page (perhaps with shortcode to use str_replace rather than DOMDocument manipulation)
			$template_page = $page->find('template');


			#$data['url'] = "/" . $_SERVER['QUERY_STRING'];
			$data['url'] = "/" . CURRENT_URI . URL_SUFFIX;
			

			/* Frontpage should become index.html */
			if ('/' . URL_SUFFIX == $data['url']) {
				$data['url'] = '/index' . funky_cache_suffix(); 
			/* If Wolf suffix is not used, use suffix from cache settings */
			/* For example /articles becomes /articles.html */
			} elseif (!strlen(URL_SUFFIX)) {
				$data['url'] .= funky_cache_suffix();
			}



			//echo 'CURRENT_URI: ' . CURRENT_URI . " <br/>Data['url']: " . $data['url'];
			//exit;



			$data['url'] = funky_cache_folder() . $mobdir . $data['url'];
			$data['url'] = preg_replace('#//#', '/', $data['url']);
			$data['page'] = $page;

			if(!$cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($data['url']))) {


	
				if($template_page){
	
					// Get about page layout
					#$about_layout = $page->findById(3)->layout_id;
					#$template_layout = $page->find('template')->layout_id;
					#if($template_layout == 0){
					#	$template_page->layout_id = $about_layout; // Force layout change
					#}
	
					//ob_start();
					//$template_page->_executeLayout();
					//$template_page = ob_get_contents();
					//ob_end_clean();
	
					//echo $template;
					//exit;
					$template_data['url'] = funky_cache_folder() . $mobdir . 'template' . URL_SUFFIX;
					$template_data['page'] = $template_page;
					//if (!$template_cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($template_data['url']))) {
						$template_cache = new FunkyCachePage($template_data);
					//}
					//if(!stristr($find,'</html>')) exit;
					$template_cache->page = $template_page;
					$template_cache->save();
				}


				$cache = new FunkyCachePage($data);

				$cache->page = $page;
	
	
	
				// TO DO: Check if page has errors, before caching (don't want cached error pages)
				/*
				$page->_executeLayout();
				$find = ob_get_contents();
				ob_end_clean();
				if(!stristr($find,'</html>')) exit;
				*/
	
	
	
				// Cache this page last (so that it displays after template has been cached)
				$cache->save();
				
				// Force cached page to be displayed (layout_switch changes are applied after page renders, so will not be displayed otherwise)
				//echo $_SERVER["DOCUMENT_ROOT"].$data['url'];
				//exit;
				readfile($_SERVER["DOCUMENT_ROOT"].$data['url']);
				exit;

			}




		}
	}
}

function funky_cache_suffix() {
	return Setting::get('funky_cache_suffix');
}

function funky_cache_by_default() {
	return Setting::get('funky_cache_by_default');
}

function funky_cache_folder() {
	$folder = '/' . Setting::get('funky_cache_folder') . '/';
	$folder = preg_replace('#//*#', '/', $folder);
	return $folder;
}

function funky_cache_folder_is_root() {
	return '/' == funky_cache_folder();
}