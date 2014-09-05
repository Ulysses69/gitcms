<?php
Plugin::setInfos(array(
	'id'		  => 'pagepeel_plus',
	'title'	   => 'Pagepeel plus',
	'description' => 'Advertising banner based on Page peel plugin',
	'version'	 => '1.0.0',
	'website'	 => 'http://www.bluehorizonsmarketing.co.uk')
);

if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	Plugin::addController('pagepeel_plus', __('Peel'), 'administrator', true);
}

Observer::observe('page_found', 'pagepeelstart');

function pagepeelplus($page = null){
	$pagelink = Plugin::getSetting('pagelink', 'pagepeel_plus');
	$pagelist = Plugin::getSetting('pagelist', 'pagepeel_plus');
	$ppp = '';
	$ppp = "<script type=\"text/javascript\" src=\"".URL_PUBLIC."inc/js/AC_OETags.js\"></script>\n";
	$ppp .= "<script language='Javascript'>\n";
	$ppp .= "var pagearSmallImg = '".URL_PUBLIC."public/images/pagepeel/small.jpg';\n";
	$ppp .= "var pagearBigImg = '".URL_PUBLIC."public/images/pagepeel/large.jpg'; \n";
	$ppp .= "var jumpTo = '".$pagelink."'\n";
	//$ppp .= "var pagearSmallSwf = '".URL_PUBLIC."inc/img/pagepeel/small.swf';\n";
	//$ppp .= "var pagearBigSwf = '".URL_PUBLIC."inc/img/pagepeel/large.swf';\n";
	$ppp .= "</script>\n";
	$ppp .= "<script type=\"text/javascript\" src=\"".URL_PUBLIC."inc/js/pageear.js\"></script>";
	return $ppp;
}

function pagepeelstart($page) {
	if($page->id == 1){
		$pageslug = 'home';
	} else {
		$pageslug = $page->slug;
	}
	$pagelist = Plugin::getSetting('pagelist', 'pagepeel_plus');
	if(stristr($pagelist,$pageslug) || stristr($pagelist,'all')){
		ob_start();
		$page->includeSnippet('registerfunctions'); // Include custom functions snippet
		$page->_executeLayout();
		$page = ob_get_contents();
		ob_end_clean();
		$newpage = str_replace('</body>', '<script type="text/javascript">writeObjects();</script>'."\n".'</body>', $page);
		$newpage = str_replace('</head>', pagepeelplus($page)."\n".'</head>', $newpage);
		echo $newpage;
		exit();
	}
}