<?php

/*
 * Funky Cache - Frog CMS caching plugin
 *
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/funky_cache
 *
 */




class FunkyCachePage extends Record 
{
	const TABLE_NAME = 'funky_cache_page';
	
	public  $url;
	public  $created_on;
	public  $page_id;
	public  $page;

	public function getColumns()
	{
		return array('page_id', 'url', 'created_on');
	}
	
	public function publicUrl() {
		$folder = Setting::get('funky_cache_folder') . '/';
		$folder = preg_replace('#//*#', '/', $folder);
		$folder = preg_replace('#^/#', '', $folder);
		return str_replace($folder, '', $this->url);
	}
		
	public function beforeSave()
	{
		$this->created_on = date('Y-m-d H:i:s');
 		$this->page_id= $this->page->id;
		/* If directories do not exist create them. */
		$parts = explode('/', $this->path());
		//<< sartas
		if(strtoupper(substr(php_uname(),0,3)) == "WIN") {
			array_shift($parts);
		}
		//>>
		$file = array_pop($parts);
		
		//print_r ($parts);

		/* If deep link create directories when needed. */
		$dir = '';
		//echo 'Home: ' . getenv('HOME');
		foreach($parts as $part) {
			//echo "\n Dir: " . $dir;

			//if(!is_dir($dir .= "/$part")){
				//mkdir($dir);
			//}
			
			$dir .= "/$part";
			if($dir != '/'){
				if(!is_dir($dir)){
					mkdir($dir);
				}
			}

		}
		/* Fix case when articles.html is created before articles/ */
		/* TODO This still creates on extra directory in the end.  */
		//<< removed sartas
		/*if (('archive' == $this->page->behavior_id) || ($this->page instanceof PageArchive)) {
			$dir .= $this->path();
			if(!is_dir($dir)) {
				mkdir($dir);
			}
		}*/
		//>>

		if(DEBUG == true){ $cache_info = "\n\n<!-- Dynamic Page Served in ". execution_time() .' seconds, memory used ' . memory_usage() . ' -->	'; }
		return file_put_contents($this->path(), $this->content().$cache_info, LOCK_EX);
	}

	public function beforeDelete()
	{
		return @unlink($this->path());
	}

	public function path() {
		return $_SERVER['DOCUMENT_ROOT'] . $this->url;
	}
	
	public function content() {

		//echo 'Funky Cache';
		//exit;

		if(Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('enable', 'mobile_check') == true && stristr($_SERVER['REQUEST_URI'],URL_PUBLIC.'mobile/')) $this->page->layout_id = 7;

		ob_start();
		$this->page->_executeLayout();
		$output = ob_get_contents();

		// Run layout switch changes
		if(function_exists('layoutMetaTest')){
			//$output = layoutMetaTest($this->page,$output);
		}
		if(function_exists('layoutFormCss')){
			$output = layoutFormCss($this->page,$output);
		}
		if(function_exists('layoutScreenCss')){
			$output = layoutScreenCss($this->page,$output);
		}


		// TO FIX: DATE IS NOT PASSED TO FIRST PAGE CACHED
		// Date this page was cached (not date page content was updated by CMS)
		//header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$output = str_replace('</title>', '</title>'."\n".'<meta http-equiv="last-modified" content="'.gmdate( 'D, d M Y H:i:s' ) . ' GMT" />', $output);


		//$output = 'Cache Test';
		echo $output;
		//exit;

		ob_end_clean();


		if(Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('enable', 'mobile_check') == true && stristr($_SERVER['REQUEST_URI'],URL_PUBLIC.'mobile/')) $output = strtr($output, array("\t" => "", "\n" => "", "\r" => "", 'href="'.URL_PUBLIC => 'href="'.URL_PUBLIC.'mobile/', 'action="'.URL_PUBLIC.'search.html' => 'action="'.URL_PUBLIC.'mobile/search.html'));
		return $output;
	}
	
}

