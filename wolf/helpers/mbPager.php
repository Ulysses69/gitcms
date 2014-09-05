<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */
/**
 * mbpaging.php
 * 
 * helper class for handling pagination
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		wolf/helpers/mbpaging.php
 * @date		10/04/2010
 * 
 */

class mbPager
{
	/**
	 * page
	 *
	 * the current page
	*/
	public $page;
	
	/**
	 * limit
	 *
	 * the number of items per page
	*/	
	public $limit;
	
	/**
	 * totalrows
	 *
	 * the number of rows in total
	*/
	public $totalrows;
	
	/**
	 * numofpages
	 *
	 * contains the result from (totalrows / limit)
	*/
	public $numofpages;
	
	/**
	 * append
	 *
	 * the text to append to the page number
	*/
	public $append;

	/**
	 * prepend
	 *
	 * the text to prepend to the page number
	*/
	public $prepend;
		
	/**
	 * pagination
	 *
	 * contains the final array of links that are added to the tpl
	*/
	public $pagination = array();
	
	/**
	 * itemTpl
	 *
	 * tpl for the number 
	*/
	public $itemTpl;	
	
	/**
	 * contructor
	 *
	 * setup the options
	*/		
	public function __construct($array)
	{
		if(count($array) > 0)
		{
			foreach($array as $k => $v)
			{
				$this->{$k} = $v;
			}
		}

		if(!empty($this->totalrows) && !empty($this->limit))
		{
			$this->numofpages = $this->totalrows / $this->limit;
		}	
	}
	
	/**
	 * generate
	 *
	 * Generates the pagination links
	*/
	public function generate()
	{
		if($this->numofpages > 1)
		{			
			// generate page numbers
			$this->genPageNums();
			
			// generate the prev / next links if required
			$this->genPrevLink();
			$this->genNextLink();
			$this->genFirstLink();
			$this->genLastLink();	
		
			return $this->pagination;
		}
		return false;
	}
	
	/** 
	 * genPrevLink
	 *
	 * Generates the "previous" link
	*/
	public function genPrevLink()
	{
		$this->pagination['prevLink'] = "";	
		if($this->page > 1)
		{
			$page = $this->page-1;
			$item = $this->itemTpl;
			$item = str_replace(array('{pageclass}','{pagelink}', '{pagetext}'),
								array('page page_prev',$this->prepend.$page.$this->append, '&lt;'),
								$item);
			$this->pagination['prevLink'] = $item;
		}
	}
	
	/** 
	 * genFirstLink
	 *
	 * Generates the "First" link
	*/
	public function genFirstLink()
	{
		$this->pagination['firstLink'] = "";
		if($this->page >= 10)
		{
			$page = 1;			
			$item = $this->itemTpl;
			$item = str_replace(array('{pageclass}','{pagelink}', '{pagetext}'),
								array('page page_first',$this->prepend.$page.$this->append, '&lt;&lt;'),
								$item);							
			$this->pagination['firstLink'] = $item;				
		}
	}
		
	/** 
	 * genNextLink
	 *
	 * Generates the "next" link
	*/
	public function genNextLink()
	{
		$this->pagination['nextLink'] = "";	
		if($this->page < $this->numofpages)
		{
			$page = $this->page+1;				
			$item = $this->itemTpl;
			$item = str_replace(array('{pageclass}','{pagelink}', '{pagetext}'),
								array('page page_next',$this->prepend.$page.$this->append, '&gt;'),
								$item);							
			$this->pagination['nextLink'] = $item;
		}
	}
	
	/** 
	 * genLastLink
	 *
	 * Generates the "Last" link
	*/
	public function genLastLink()
	{
		$this->pagination['lastLink'] = "";
		if($this->page <= ($this->numofpages - 10))
		{
			$page = $this->numofpages;
			$item = $this->itemTpl;
			$item = str_replace(array('{pageclass}','{pagelink}', '{pagetext}'),
								array('page page_last',$this->prepend.$page.$this->append, '&gt;&gt;'),
								$item);						
			$this->pagination['lastLink'] = $item;	
		}
	}
			
	/**
	 * genPageNums
	 *
	 * generates the page numbers and then fitlers if we need to.
	*/
	public function genPageNums()
	{
		$pageLinks = array();	
	
		for($i=1; $i<=$this->numofpages; $i++)
		{
			$page = $i;
			$item = $this->itemTpl;			
			if($this->page == $i)
			{
				$styleclass = 'page_current';
			} else
			{
				$styleclass = 'page';
			}
			$item = str_replace(array('{pageclass}','{pagelink}', '{pagetext}'),
								array($styleclass, $this->prepend.$page.$this->append, $i),
								$item);	
			$pageLinks[$i] = $item;
		}	
	
		if(($this->totalrows % $this->limit) != 0)
		{
			$this->numofpages++;
			$page = $i;
			$item = $this->itemTpl;			
			if($this->page == $i)
			{
				$styleclass = 'page_current';
			} else
			{
				$styleclass = 'page';
			}
			$item = str_replace(array('{pageclass}','{pagelink}', '{pagetext}'),
								array($styleclass, $this->prepend.$page.$this->append, $i),
								$item);					
			$pageLinks[$i] = $item;
		}
		ksort($pageLinks);
		$this->pagination['nums'] = $pageLinks;
	}
}	
