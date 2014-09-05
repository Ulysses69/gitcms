<?php

/**
 * Simple Email library
 *
 * Frog CMS/Wolf CMS function that provide multilevel menu
 *
 * LICENSE: see license.txt and exception.txt for the full license texts.
 *
 * @package	wolf/helpers
 * @author	 Maslakov Alexander <jmas.ukraine@gmail.com>
 * @copyright  2008-2010 Maslakov Alexander
 * @license	http://www.wolfcms.org/about/wolf-cms-licensing.html
 */


/*
* @function menu		Frog CMS/Wolf CMS function that provide multilevel menu
* @param $page		Object of Page class
* @param $css_class	CSS class name of first <UL>
* @param $stop_level	Depth level
* @param $except_tags	Pages with this tags should be excepted from menu
* @param $subout	Parametr used in recursion
*/
function menu( $page, $css_class = 'menu', $stop_level = 0, $except_tags = array(), $subout = '' )
{
	// Check input parameters
	if( !is_object($page) && get_class($page) != 'Page' )
	{
		throw new Exception('First parameter $page should be object of class Page!');
	}
	
	if( empty($css_class) )
	{
		$css_class = 'menu';
	}
	
	// $except_tags should be an array
	if( !is_array($except_tags) )
	{
		throw new Exception('Parameter $except_tags should be an array!');
	}

	// If page has parent page
	$out = '';
	
	if( $page->level() > $stop_level )
	{
		$out .= '<ul class="level-'. $page->level() .'">';
		
		foreach( $page->parent->children() as $item )
		{
			// If page has tag that presented in $except_tags array - we except this page from menu
			if( empty($except_tags) || (!empty($except_tags) && array_diff( $except_tags, $item->tags() ) == $except_tags) )
			{
				// If this item is current page we should add css class "current" to it
				if( $item->url() == $page->url() )
				{
					// If current item has sub pages we should show them
					if( $subout == '' && $page->childrenCount() > 0 )
					{
						$out .= '<li class="item-level-'. $page->level() .' item-opened item-current">';
						
						$out .= '<span class="current">' . $page->title() . '</span>'
							 .'<ul class="level-'. ($page->level()+1) .'">';
						
						foreach( $page->children() as $children )
						{
							// If page has tag that presented in $except_tags array - we except this page from menu
							if( empty($except_tags) || (!empty($except_tags) && array_diff( $except_tags, $item->tags() ) == $except_tags) )
							{
								$out .= '<li class="item-level-'. $children->level() .'">' . $children->link() . '</li>';
							}
						}
						
						$out .= '</ul>';
					}
					else // Page do not have any sub page, but we should make it "current"
					{
						$out .= '<li class="item-level-'. $page->level() .' item-opened">';
						
						$out .= ( $page->childrenCount() > 0 ? $page->link( null, ' class="opened"')  : '<span class="current">' . $page->title() . '</span>' ) . $subout;
					} // end if
				}
				else // Do not current page. Only make link
				{
					$out .= '<li class="item-level-'. $page->level() .'">';
					
					$out .= $item->link();
				} // end if
				
				$out .= '</li>';
			} // end if
		} // end foreach
		
		$out .= '</ul>';
	}
	else if( $page->level() == $stop_level )
	{
		if( $subout == '' )
		{
			$subout = '<ul class="level-'. ($page->level()+1) .'">';
						
			foreach( $page->children() as $children )
			{
				// If page has tag that presented in $except_tags array - we except this page from menu
				if( empty($except_tags) || (!empty($except_tags) && array_diff( $except_tags, $item->tags() ) == $except_tags) )
				{
					$subout .= '<li class="item-level-'. $children->level() .'">' . $children->link() . '</li>';
				}
			} // end foreach
			
			$subout .= '</ul>';
		} // end if
	} // end if
	
	if( $page->parent && $page->level() > $stop_level )
	{
		// Recursive menu building
		menu( $page->parent, $css_class, $stop_level, $except_tags, $out );
	}
	else // Output first <UL> that contain sub menu lists
	{
		echo '<ul class="'. $css_class .'">' . $subout . '</ul>';
	} // end if
} // end function