<?php
$plugin_id = "related_pages";
$controller_name = 'RelatedPagesController';

AutoLoader::addFolder(dirname(__FILE__) . '/models');

Plugin::setInfos(array(
	'id'		  => $plugin_id,
	'title'	   => __('Related Pages'),
	'description' => __('Add related pages to a page.'),
	'version'	 => '0.0.2b',
	'license'	 => 'DoWhatYouLike',
	'author'	  => 'Andy Rowland',
	'website'	 => 'http://www.andrewrowland.com/article/display/wolf-cms-related-pages-plugin',
	'update_url'  => 'http://www.andrewrowland.com/wolfcms/plugins.xml',
	'require_frog_version' => '0.6.0'
));

Plugin::addController($plugin_id, __('Related Pages'), null, false);

Observer::observe('view_page_edit_tabs', $controller_name.'::Callback_view_page_edit_tabs');

Observer::observe('page_delete', $controller_name.'::Callback_page_delete');

function get_relations($page_id, $page_self=false){
	return RelatedPages::GetRelatedPages($page_id, $page_self);
}

?>
