<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008,2009 Martijn van der Kleijn <martijn.niji@gmail.com>
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
 * @package wolf
 * @subpackage models
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, Martijn van der Kleijn, 2008
 */

/**
 * class Page
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @since Wolf version 0.1
 */
class Page extends Record {
	const TABLE_NAME = 'page';

	const STATUS_DRAFT = 1;
	const STATUS_PREVIEW = 10;
	const STATUS_PUBLISHED = 100;
	const STATUS_HIDDEN = 101;

	const LOGIN_NOT_REQUIRED = 0;
	const LOGIN_REQUIRED = 1;
	const LOGIN_INHERIT = 2;

	public $id;
	public $title = '';
	public $slug = '';
	public $breadcrumb;
	public $keywords = '';
	public $description = '';
	public $content;
	public $parent_id;
	public $layout_id;
	public $behavior_id;
	public $status_id;
	public $comment_status;
	public $created_on;
	public $published_on;
	public $valid_until;
	public $updated_on;
	public $created_by_id;
	public $updated_by_id;
	public $position;
	public $is_protected;
	public $needs_login;
	public $author;
	public $author_id;
	public $updater;
	public $updater_id;
	// non db fields
	public $parent = false;
	public $level = false;
	public $tags = false;
	public $url = '';
	private $uri = false;




	public function __construct($object=null, $parent=null) {
		if ($parent !== null) {
			$this->parent = $parent;
		}

		if ($object !== null) {
			foreach ($object as $key => $value) {
				$this->$key = $value;
			}
		}

		if ($this->parent) {
			$this->setUrl();
		}
	}

	public function id() {
		return $this->id;
	}
	public function author() {
		return $this->author;
	}
	public function authorId() {
		return $this->author_id;
	}
	public function title() {
		return $this->title;
	}
	public function description() {
		return $this->description;
	}
	public function keywords() {
		return $this->keywords;
	}

	public function parentId() {
		return $this->parent_id;
	}

	public function url($suffix=false) {
		if ($suffix === false) {
			return BASE_URL.$this->uri();
		}
		else {
			return BASE_URL.$this->uri().($this->uri() != '' ? URL_SUFFIX : '');
		}
	}

	/**
	 * Allows user to get the url of a page by page ID.
	 *
	 * This function will always produce a correct and current url to the page
	 * despite it possibly having moved from its original position in the page
	 * hierarchy.
	 *
	 * Usage: <?php echo Page::urlById(3); ?>
	 *
	 * @param   int	 $id The id of the page to link to.
	 * @return  mixed	   Full url of page or error message.
	 */
	public static function urlById($id) {
		if (!is_numeric($id) || !is_int($id) || $id <= 0) {
			return '[urlById: id NAN or id <= 0]';
		}

		$page = self::findById($id);

		if (!$page)
			return '[urlById: no page with that id]';

		return $page->url();
	}

	public function slug() {
		return $this->slug;
	}
	public function breadcrumb() {
		return $this->breadcrumb;
	}
	public function updater() {
		return $this->updater;
	}
	public function updaterId() {
		return $this->updater_id;
	}

	public function breadcrumbs($separator='&gt;',$tag='span') {
		$out = '';
		$url = '';
		$path = '';
		$paths = explode('/', '/'.$this->slug);
		$nb_path = count($paths);

		if ($this->parent() !== false)
			$out .= $this->parent->_inversedBreadcrumbs($separator,$tag);

		//return $out . '<span class="breadcrumb-current">'.$this->breadcrumb().'</span>';
		if(!defined('BREADCRUMBS')) define('BREADCRUMBS','true');

		$opentag = ''; $closetag = '';
		if($tag != ''){ $opentag = '<'.$tag.' class="selected">'; $closetag = '</'.$tag.'> '; }
		return $out . $opentag.$this->breadcrumb($separator,$tag).$closetag;

	}

	/**
	 * 
	 * @todo Finish _inversedBreadcrumbs PHPDoc
	 *
	 * @param type $separator
	 * @return string 
	 */
	private function _inversedBreadcrumbs($separator,$tag) {
		$opentag = ''; $closetag = ''; $ext = '';
		if($tag != '') { $opentag = '<'.$tag.' class="breadcrumb-separator">'; $closetag = '</'.$tag.'>'; }
		if(URL_SUFFIX != ''){
			$urlext = pathinfo($this->url(), PATHINFO_EXTENSION);
			if($this->slug != '' && $urlext == ''){ $ext = URL_SUFFIX; } else { $ext = ''; }
		}
		$out = '<a href="'.$this->url().$ext.'" title="'.$this->breadcrumb($separator,$tag).'">'.$this->breadcrumb.'</a>'.$opentag.$separator.$closetag;

		if ($this->parent() !== false)
			return $this->parent()->_inversedBreadcrumbs($separator,$tag).$out;

		return $out;
	}

	/**
	 * Returns the subjective "previous" Page.
	 *
	 * @return mixed	Returns either a Page object or false.
	 */
	public function previous() {
		if ($this->parent() !== false) {
			return $this->parent()->children(array(
				'limit' => 1,
				'where' => 'page.position < '.$this->position.' AND page.id < '.$this->id,
				'order' => 'page.position DESC'
			));
		}

		return false;
	}


	/**
	 * Returns the subjective "next" Page.
	 *
	 * @return mixed	Returns either a Page object or false.
	 */
	public function next() {
		if ($this->parent() !== false) {
			return $this->parent()->children(array(
				'limit' => 1,
				'where' => 'page.position > '.$this->position.' AND page.id > '.$this->id,
				'order' => 'page.position ASC'
			));
		}

		return false;
	}

	public function childrenCount($args=null, $value=array(), $include_hidden=false) {
		global $__CMS_CONN__;

		// Collect attributes...
		$where   = isset($args['where']) ? $args['where']: '';
		$order   = isset($args['order']) ? $args['order']: 'position, id';
		$limit   = isset($args['limit']) ? $args['limit']: 0;
		$offset  = 0;

		// Prepare query parts
		$where_string = trim($where) == '' ? '' : "AND ".$where;
		$limit_string = $limit > 0 ? "LIMIT $offset, $limit" : '';

		// Prepare SQL
		$sql = 'SELECT COUNT(*) AS nb_rows FROM '.TABLE_PREFIX.'page '
				. 'WHERE parent_id = '.$this->id.' AND (status_id='.Page::STATUS_PUBLISHED.($include_hidden ? ' OR status_id='.Page::STATUS_HIDDEN: '').') '
				. "$where_string ORDER BY $order $limit_string";

		$stmt = $__CMS_CONN__->prepare($sql);
		$stmt->execute($value);

		return (int) $stmt->fetchColumn();
	}

	/**
	 * Returns the Page object's parent.
	 * 
	 * The option $level parameter allows the user to specify the level on
	 * which the found Page object should be.
	 *
	 * @param   int	 $level  Optional level parameter
	 * @return  Page	The object's parent.
	 */
	public function parent($level=null) {

		// check to see if it's already been retrieved, if not get the parent!
		if ($this->parent === false && $this->parent_id != 0) {
			$this->parent = self::findById($this->parentId());
		}

		if ($level === null)
			return $this->parent;

		if ($level > $this->level)
			return false;
		else if ($this->level == $level)
			return $this;
		else
			return $this->parent($level);
	}

	public function executionTime() {
		return execution_time();
	}

	public function includeSnippet($name) {
		$snippet = Snippet::findByName($name);

		$eval = '?'.'>'.$snippet->content_html;
		if (false !== $snippet) {
			eval($eval);
			return true;
		}

		return false;
	}


	private function _loadTags() {
		global $__CMS_CONN__;
		$this->tags = array();

		$sql = "SELECT tag.id AS id, tag.name AS tag FROM ".TABLE_PREFIX."page_tag AS page_tag, ".TABLE_PREFIX."tag AS tag ".
				"WHERE page_tag.page_id={$this->id} AND page_tag.tag_id = tag.id";

		if ( ! $stmt = $__CMS_CONN__->prepare($sql))
			return;

		$stmt->execute();

		// Run!
		while ($object = $stmt->fetchObject())
			$this->tags[$object->id] = $object->tag;
	}

	public function tags() {
		if ( ! $this->tags)
			$this->_loadTags();

		return $this->tags;
	}

	/**
	 * Return a numerical representation of this page's place in the page hierarchy.
	 *
	 * This uses the page url as returned by the url() method to check the level.
	 * It might not always be what you'd expect.
	 *
	 * @return int The page's level.
	 */
	public function level() {
		if ($this->level === false) {
			$uri = $this->uri();
			$this->level = empty($uri) ? 0 : substr_count($uri, '/') + 1;
		}

		return $this->level;
	}


	/**
	 * Return formatted date for page. Defaults to 'created on' date.
	 *
	 * This function works through PHP's strftime() function. Please see
	 * http://php.net/strftime for more details on formatting options.
	 *
	 * Example usage:
	 *  '%a, %e %b %Y'		-> Wed, 20 Dec 2006 <- (default)
	 *  '%A, %e %B %Y'		-> Wednesday, 20 December 2006
	 *  '%B %e, %Y, %H:%M %p' -> December 20, 2006, 08:30 pm
	 *
	 * @param string	Format string.
	 * @param which_one The date field to be used.
	 * @return string   Formatted date.
	 */
	public function date($format='%a, %e %b %Y', $which_one='created') {
		if ($which_one == 'update' || $which_one == 'updated')
			return strftime($format, strtotime($this->updated_on));
		else if ($which_one == 'publish' || $which_one == 'published')
			return strftime($format, strtotime($this->published_on));
		else
			return strftime($format, strtotime($this->created_on));
	}


	/**
	 * Return content of the page or a specific part of the page.
	 *
	 * @param string $part	  Part to retrieve content for. Defaults to 'body'.
	 * @param bool   $inherit   Check parents for part content if true.
	 * @return string		   Actual contents of the part.
	 */
	public function content($part='body', $inherit=false) {
		// if part exist we generate the content en execute it!

		if (isset($this->part->$part)) {
			ob_start();
			eval('?'.'>'.$this->part->$part->content_html);
			$out = ob_get_contents();
			ob_end_clean();
			return $out;
		}
		else if ($inherit && $this->parent() !== false) {
			return $this->parent()->content($part, true);
		}

	}

	/**
	 * Check if a part exists and it has content
	 *
	 * If inherit is set to true, it checks for the part
	 * in this page's parents.
	 *
	 * @param string $part	  Part name.
	 * @param bool   $inherit   Check parents for part if true.
	 * @return bool			 Returns true if part was found or false if nothing was found
	 */
	public function hasContent($part, $inherit=false) {
		if (isset($this->part->$part)) {
			$trim = trim($this->part->$part->content_html);
			if (!empty($trim)) {
				return true;
			}

			return false;
		}
		else if ($inherit && $this->parent() !== false) {
			return $this->parent()->hasContent($part, true);
		}
		return false;
	}


	/**
	 * Check if a part exists.
	 *
	 * If inherit is set to true, it checks for the part
	 * in this page's parents.
	 *
	 * @param string $part	  Part name.
	 * @param bool   $inherit   Check parents for part if true.
	 * @return bool			 Returns true if part was found or false if nothing was found
	 */
	public function partExists($part, $inherit=false) {
		if (isset($this->part->$part)) {
			return true;
		}
		else if ($inherit && $this->parent() !== false) {
			return $this->parent()->partExists($part, true);
		}
		return false;
	}

	protected function setUrl() {
		$this->url = trim($this->parent->url .'/'. $this->slug, '/');
	}

	/**
	 * Return an HTML anchor element for this page.
	 *
	 * @param string $label	 A custom label. Defaults to page title.
	 * @param array $options	Array containing attributes to add.
	 * @return string		   The actual anchor element.
	 */
	public function link($label=null, $options='') {
		if ($label == null)
			$label = $this->title();

		return sprintf('<a href="%s" %s>%s</a>', $this->url(), $options, $label
		);
	}


	/**
	 * Allow user to link to a page by ID.
	 *
	 * This function will always produce a correct and current link to the page
	 * despite it possibly having moved from its original position in the page
	 * hierarchy.
	 *
	 * Usage: <?php echo Page::linkById(3); ?>
	 *
	 * @param int $id The id of the page to link to.
	 * @param string $label The label or title of the link.
	 * @param string $options Any other HTML options you want to use.
	 * @return string XHTML compliant link code or error message.
	 */
	public static function linkById($id, $label=null, $options='') {
		if (!is_numeric($id) || !is_int($id) || $id <= 0) {
			return '[linkById: id NAN or id <= 0]';
		}

		$page = self::findById($id);

		if ($label == null) {
			$label = $page->title();
		}

		return sprintf('<a href="%s" %s>%s</a>', $page->url(), $options, $label
		);
	}

	/**
	 * Return an array of this page's children.
	 * 
	 * Note: returns a single Page object if only one child exists.
	 *
	 * @param array $args			   Array of key=>value pairs.
	 * @param array $value
	 * @param boolean $include_hidden   True if children with hidden status should be included.
	 * @return mixed					False, array of Page objects or single Page object.
	 */
	public function children($args=null, $value=array(), $include_hidden=false) {
		global $__CMS_CONN__;

		$page_class = 'Page';

		// Collect attributes...
		$where   = isset($args['where']) ? $args['where']: '';
		$order   = isset($args['order']) ? $args['order']: 'page.position, page.id';
		$offset  = isset($args['offset']) ? $args['offset']: 0;
		$limit   = isset($args['limit']) ? $args['limit']: 0;

		// auto offset generated with the page param
		if ($offset == 0 && isset($_GET['page']))
			$offset = ((int)$_GET['page'] - 1) * $limit;

		// Prepare query parts
		$where_string = trim($where) == '' ? '' : "AND ".$where;
		$limit_string = $limit > 0 ? "LIMIT $limit" : '';
		$offset_string = $offset > 0 ? "OFFSET $offset" : '';

		// Prepare SQL
		$sql = 'SELECT page.*, author.name AS author, author.id AS author_id, updater.name AS updater, updater.id AS updater_id '
				. 'FROM '.TABLE_PREFIX.'page AS page '
				. 'LEFT JOIN '.TABLE_PREFIX.'user AS author ON author.id = page.created_by_id '
				. 'LEFT JOIN '.TABLE_PREFIX.'user AS updater ON updater.id = page.updated_by_id '
				. 'WHERE parent_id = '.$this->id.' AND (status_id='.Page::STATUS_PUBLISHED.($include_hidden ? ' OR status_id='.Page::STATUS_HIDDEN: '').') '
				. "$where_string ORDER BY $order $limit_string";

		$pages = array();

		// hack to be able to redefine the page class with behavior
		if (!empty($this->behavior_id)) {
			// will return Page by default (if not found!)
			$page_class = Behavior::loadPageHack($this->behavior_id);
		}

		// Run!
		if ($stmt = $__CMS_CONN__->prepare($sql)) {
			$stmt->execute($value);

			while ($object = $stmt->fetchObject()) {
				$page = new $page_class($object, $this);

				// assignParts
				$page->part = self::get_parts($page->id);
				$pages[] = $page;
			}
		}

		if ($limit == 1)
			return isset($pages[0]) ? $pages[0] : false;

		return $pages;
	}


	/**
	 * Finds the "login needed" status for the page.
	 *
	 * @return int Integer corresponding to one of the LOGIN_* constants.
	 */
	public function getLoginNeeded() {
		if ($this->needs_login == Page::LOGIN_INHERIT && $this->parent)
			return $this->parent->getLoginNeeded();
		else
			return $this->needs_login;
	}

	public function _executeLayout() {
		global $__CMS_CONN__;

		$sql = 'SELECT content_type, content FROM '.TABLE_PREFIX.'layout WHERE id = ?';

		$stmt = $__CMS_CONN__->prepare($sql);
		$stmt->execute(array($this->_getLayoutId()));

		if ($layout = $stmt->fetchObject()) {
			// if content-type not set, we set html as default
			if ($layout->content_type == '')
				$layout->content_type = 'text/html';

			// set content-type and charset of the page
			header('Content-Type: '.$layout->content_type.'; charset=UTF-8');

			Observer::notify('page_before_execute_layout');

			// execute the layout code
			eval('?>'.$layout->content);
		}
	}

	/**
	 * find the layoutId of the page where the layout is set
	 */
	private function _getLayoutId() {
		if ($this->layout_id)
			return $this->layout_id;
		else if ($this->parent)
			return $this->parent->_getLayoutId();
		else
			exit ('You need to set a layout!');
	}


	/* -------- */


	public function beforeInsert() {
		$this->created_on = date('Y-m-d H:i:s');
		$this->created_by_id = AuthUser::getId();

		$this->updated_on = $this->created_on;
		$this->updated_by_id = $this->created_by_id;

		if ($this->status_id == Page::STATUS_PUBLISHED)
			$this->published_on = date('Y-m-d H:i:s');

		// Prevent certain stuff from entering the INSERT statement
		unset($this->parent);
		unset($this->url);
		unset($this->level);
		unset($this->tags);

		return true;
	}

	public function beforeUpdate() {
		$this->created_on = $this->created_on . ' ' . $this->created_on_time;
		unset($this->created_on_time);

		if ( ! empty($this->published_on)) {
			$this->published_on = $this->published_on . ' ' . $this->published_on_time;
			unset($this->published_on_time);
		} else if ($this->status_id == Page::STATUS_PUBLISHED) {
			$this->published_on = date('Y-m-d H:i:s');
		}

		$this->updated_by_id = AuthUser::getId();
		$this->updated_on = date('Y-m-d H:i:s');

		unset($this->url);
		unset($this->level);
		unset($this->tags);
		unset($this->parent);


		return true;
	}

	public function beforeDelete() {
		$ret = false;

		$ret = self::deleteChildrenOf($this->id);
		$ret = PagePart::deleteByPageId($this->id);
		$ret = PageTag::deleteByPageId($this->id);

		return $ret;
	}

	/**
	 * Returns the uri for this node.
	 * 
	 * Note: The uri does not start nor end with a '/'.
	 *
	 * @return string   The node's full uri.
	 */
	public function uri() {
		if ($this->uri === false) {
			if ($this->parent() !== false)
				$this->uri = trim($this->parent()->uri().'/'.$this->slug, '/');
			else
				$this->uri = trim($this->slug, '/');
		}

		return $this->uri;
	}

	/**
	 * @todo improve
	 *
	 * @return <type>
	 */
	public function getUri() {
		/*
		$result = null;

		$parent = $this->findById($this->parent_id);
		if ($parent != null && $parent->slug != '') {
			$result = $parent->getUri().'/'.$this->slug;
		} else {
			$result = $this->slug;
		}

		return $result;
		*/
		return $this->uri();
	}

	public function getTags() {
		$tablename_page_tag = self::tableNameFromClassName('PageTag');
		$tablename_tag = self::tableNameFromClassName('Tag');

		$sql = "SELECT tag.id AS id, tag.name AS tag FROM $tablename_page_tag AS page_tag, $tablename_tag AS tag ".
				"WHERE page_tag.page_id={$this->id} AND page_tag.tag_id = tag.id";

		if ( ! $stmt = self::$__CONN__->prepare($sql))
			return array();

		$stmt->execute();

		// Run!
		$tags = array();
		while ($object = $stmt->fetchObject())
			$tags[$object->id] = $object->tag;

		return $tags;
	}

	public function setTags($tags) {
		if (is_string($tags))
			$tags = explode(',', $tags);

		$tags = array_map('trim', $tags);

		$current_tags = $this->getTags();

		// no tag before! no tag now! ... nothing to do!
		if (count($tags) == 0 && count($current_tags) == 0)
			return;

		// delete all tags
		if (count($tags) == 0) {
			$tablename = self::tableNameFromClassName('Tag');

			// update count (-1) of those tags
			foreach ($current_tags as $tag)
				self::$__CONN__->exec("UPDATE $tablename SET count = count - 1 WHERE name = '$tag'");

			return Record::deleteWhere('PageTag', 'page_id=?', array($this->id));
		} else {
			$old_tags = array_diff($current_tags, $tags);
			$new_tags = array_diff($tags, $current_tags);

			// insert all tags in the tag table and then populate the page_tag table
			foreach ($new_tags as $index => $tag_name) {
				if ( ! empty($tag_name)) {
					// try to get it from tag list, if not we add it to the list
					if ( ! $tag = Record::findOneFrom('Tag', 'name=?', array($tag_name)))
						$tag = new Tag(array('name' => trim($tag_name)));

					$tag->count++;
					$tag->save();

					// create the relation between the page and the tag
					$tag = new PageTag(array('page_id' => $this->id, 'tag_id' => $tag->id));
					$tag->save();
				}
			}

			// remove all old tag
			foreach ($old_tags as $index => $tag_name) {
				// get the id of the tag
				$tag = Record::findOneFrom('Tag', 'name=?', array($tag_name));
				Record::deleteWhere('PageTag', 'page_id=? AND tag_id=?', array($this->id, $tag->id));
				$tag->count--;
				$tag->save();
			}
		}
	}

	/**
	 * @deprecated
	 * @see setTags()
	 */
	public function saveTags($tags) {
		return $this->setTags($tags);
	}

	public static function find_page_by_uri($uri) {
		return Page::findByUri($uri);
	}

	public static function findByUri($uri, $all = false) {
		/* Check if this page/targetted page has children - required amend to teamitems() */
		if(function_exists('explode_uri')){
			global $__CMS_CONN__;
	
			$uri = trim($uri, '/');
	
			$has_behavior = false;
	
			// adding the home root
			$urls = array_merge(array(''), explode_uri($uri));
			$url = '';
	
			$page = new stdClass;
			$page->id = 0;
	
			$parent = false;
	
			foreach ($urls as $page_slug) {
				$url = ltrim($url.'/'.$page_slug, '/');
	
				$page = self::findBySlug($page_slug, $parent, $all);
				if ($page instanceof Page) {
					// check for behavior
					if ($page->behavior_id != '' && stristr($page->behavior_id,'archive')) {
						// add a instance of the behavior with the name of the behavior
						$params = explode_uri(substr($uri, strlen($url)));
						$page->{$page->behavior_id} = Behavior::load($page->behavior_id, $page, $params);
	
						return $page;
					}
				 }
				else {
					break;
				}
	
				$parent = $page;
			} // foreach
			return $page;

		}

	}


	/**
	 * find a page by the slug and parent id
	 *
	 * @param string $slug		page slug to search for
	 * @param object $parent 	parent object
	 * @param bool $all			flag for returning all status types
	 * @return mixed			page object or false
	 */
	public static function findBySlug($slug, &$parent, $all = false) {
		$parent_id = $parent ? $parent->id : 0;

		if (empty($slug)) {
			$slug = NULL;
			$slug_sql = "slug = ''";
		}
		else {
			$slug_sql = "slug = '".$slug."'";
		}

		if ($all) {
			//$where = 'COALESCE(slug, \'\') = COALESCE('.$slug.', \'\') AND parent_id = '.$parent_id.' AND (status_id='.self::STATUS_PREVIEW.' OR status_id='.self::STATUS_PUBLISHED.' OR status_id='.self::STATUS_HIDDEN.')';
			$where = $slug_sql.' AND parent_id = '.$parent_id.' AND (status_id='.self::STATUS_PREVIEW.' OR status_id='.self::STATUS_PUBLISHED.' OR status_id='.self::STATUS_HIDDEN.')';
		}
		else {
			//$where = 'COALESCE(slug, \'\') = COALESCE('.$slug.', \'\') AND parent_id = '.$parent_id.' AND (status_id='.self::STATUS_PUBLISHED.' OR status_id='.self::STATUS_HIDDEN.')';
			$where = $slug_sql.' AND parent_id = '.$parent_id.' AND (status_id='.self::STATUS_PUBLISHED.' OR status_id='.self::STATUS_HIDDEN.')';
		}

		$page = self::find(array('where' => $where,
					'limit' => 1));

		return $page;
	}
	


	/**
	 * Finds a Page record based on supplied arguments.
	 * 
	 * Usage:
	 *	  $page = Page::find('/the/uri/to/your/page');
	 *	  $page = Page::find(array('where' => 'created_by_id=12'));
	 * 
	 * Argument array can contain:
	 *	  - where
	 *	  - order
	 *	  - offset
	 *	  - limit
	 * 
	 * Return values can be:
	 *	  - A single Page object
	 *	  - An array of Page objects which can be empty
	 *	  - False
	 *
	 * @param mixed $args   Uri string or array of arguments.
	 * @return mixed		Page or array of Pages, otherwise false.
	 */
	public static function find($args = null) {
		if (!is_array($args)) {
			// Assumes find was called with a uri
			return Page::findByUri($args);
		}

		$page_class = 'Page';

		// Collect attributes...
		$where = isset($args['where']) ? trim($args['where']) : '';
		$order_by = isset($args['order']) ? trim($args['order']) : '';
		$offset = isset($args['offset']) ? (int) $args['offset'] : 0;
		$limit = isset($args['limit']) ? (int) $args['limit'] : 0;

		// Prepare query parts
		$where_string = empty($where) ? '' : "WHERE $where";
		$order_by_string = empty($order_by) ? '' : "ORDER BY $order_by";
		$limit_string = $limit > 0 ? "LIMIT $limit" : '';
		$offset_string = $offset > 0 ? "OFFSET $offset" : '';

		$tablename = self::tableNameFromClassName('Page');
		$tablename_user = self::tableNameFromClassName('User');

		// Prepare SQL
		$sql = "SELECT page.*, creator.name AS created_by_name, updater.name AS updated_by_name FROM $tablename AS page".
				" LEFT JOIN $tablename_user AS creator ON page.created_by_id = creator.id".
				" LEFT JOIN $tablename_user AS updater ON page.updated_by_id = updater.id".
				" $where_string $order_by_string $limit_string $offset_string";

		$stmt = self::$__CONN__->prepare($sql);
		if (!$stmt->execute()) {
			return false;
		}

		// Run!
		$objects = array();
		while ($page = $stmt->fetchObject('Page')) {
			$parent = $page->parent();
			if (!empty($parent->behavior_id)) {
				// will return Page by default (if not found!)
				$page_class = Behavior::loadPageHack($parent->behavior_id);
			}

			// create the object page
			$page = new $page_class($page, $parent);
			$page->part = self::get_parts($page->id);
			$objects[] = $page;
		}

		// if we're loading just one result return it
		if ($limit == 1) {
			if (isset($objects['0']) && is_object($objects['0'])) {
				return $objects['0'];
			}
		}
		else {
			// or return them all
			return $objects;
		}

		return false;
	}

	public static function findAll($args = null) {
		return self::find($args);
	}

	public static function findById($id) {
		return self::find(array(
				'where' => 'page.id='.(int)$id,
				'limit' => 1
		));
	}

	public static function childrenOf($id) {
		return self::find(array('where' => 'parent_id='.$id, 'order' => 'position, page.created_on DESC'));
	}

	public static function hasChildren($id) {
		return (boolean) self::countFrom('Page', 'parent_id = '.(int)$id);
	}

	public static function deleteChildrenOf($id) {
		$id = (int)$id;

		if (self::hasChildren($id)) {
			$children = self::childrenOf($id);
			if (is_array($children)) {
				foreach ($children as $child) {
					if (!$child->delete()) {
						return false;
					}
				}
			} elseif ($children instanceof Page) { // because Page::childrenOf return directly an object when there is only 1 child...
				if (!$children->delete()) {
					return false;
				}
			}
		}

		return true;
	}

	public static function cloneTree($page, $parent_id) {
		/* This will hold new id of root of cloned tree. */
		static $new_root_id = false;

		/* Clone passed in page. */
		$clone = Record::findByIdFrom('Page', $page->id);
		$clone->parent_id = (int)$parent_id;
		$clone->id = null;
		$clone->title .= " (copy)";
		$clone->slug .= "-copy";
		$clone->save();

		/* Also clone the page parts. */
		$page_part = PagePart::findByPageId($page->id);
		if (count($page_part)) {
			foreach ($page_part as $part) {
				$part->page_id = $clone->id;
				$part->id = null;
				$part->save();
			}
		}

		/* Also clone the page tags. */
		$page_tags = $page->getTags();
		if (count($page_tags)) {
			foreach ($page_tags as $tag_id => $tag_name) {
				// create the relation between the page and the tag
				$tag = new PageTag(array('page_id' => $clone->id, 'tag_id' => $tag_id));
				$tag->save();
			}
		}
		
		/* This gets set only once even when called recursively. */
		if (!$new_root_id) {
			$new_root_id = $clone->id;
		}

		/* Clone and update childrens parent_id to clones new id. */
		if (Page::hasChildren($page->id)) {
			foreach (Page::childrenOf($page->id) as $child) {
				Page::cloneTree($child, $clone->id);
			}
		}

		return $new_root_id;
	}


	public static function get_parts($page_id) {
		global $__CMS_CONN__;

		$objPart = new stdClass;

		$sql = 'SELECT name, content_html FROM '.TABLE_PREFIX.'page_part WHERE page_id=?';

		if ($stmt = $__CMS_CONN__->prepare($sql)) {
			$stmt->execute(array($page_id));

			while ($part = $stmt->fetchObject())
				$objPart->{$part->name} = $part;
		}

		return $objPart;
	}

} // end Page class
