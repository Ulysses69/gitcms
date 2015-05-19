<?php
AutoLoader::addFolder(dirname(__FILE__) . '/models');

class RelatedPagesController extends PluginController {
	const PLUGIN_ID = "related_pages";
	const VIEW_FOLDER = "related_pages/views/";
	const PLUGIN_REL_VIEW_FOLDER = "../../plugins/related_pages/views/";
	const CSS_ID_PREFIX = "Related-pages-";
	const CSS_CLASS_PREFIX = "related-pages-";

	// Singleton instance for observers
	private static $Instance;

	public static function Get_instance() {
	if (!self::$Instance) {
	  $class = __CLASS__;
	  self::$Instance = new $class();
	}

		return self::$Instance;
	}

	public function __construct() {
		AuthUser::load();
		if (!(AuthUser::isLoggedIn())) {
			redirect(get_url('login'));
		}

		$this->setLayout('backend');
	}

	public function __call($name, $args) {
		redirect(get_url(''));
	}

	private function get_default_view_vars() {
		$vars = array();

		$vars['plugin_id'] = self::PLUGIN_ID;
		$vars['css_id_prefix'] = self::CSS_ID_PREFIX;
		$vars['css_class_prefix'] = self::CSS_CLASS_PREFIX;
		$vars['plugin_url'] = get_url('plugin/'.self::PLUGIN_ID.'/');

		return $vars;
	}

	public function render($view, $vars=array()) {
		$vars = array_merge($this->get_default_view_vars(), $vars);
		return parent::render(self::VIEW_FOLDER.$view, $vars);
	}

	public function create_view($view, $vars=array()) {
		$vars = array_merge($this->get_default_view_vars(), $vars);

		return new View(self::PLUGIN_REL_VIEW_FOLDER.$view, $vars);
	}

	public static function Callback_view_page_edit_tabs($page) {
		$related = array();

		if (isset($page->id) && !empty($page->id)) {
			$related = RelatedPages::GetRelations($page->id);
		}

		self::Get_instance()->create_view('related', array(
			'pageid' => $page->id,
			'related' => $related,
			'sitetree' => self::Get_instance()->children($page->id, 1, 0, false)
		))->display();
	}

	public static function children($page_id, $parent_id, $level, $output = true) {
        $expanded_node = isset($_COOKIE['expanded_node']) ? explode(',', $_COOKIE['expanded_node']): array();

		$related = RelatedPages::GetRelations($page_id);

		$children = Page::childrenOf($parent_id);

		foreach ($children as $index => $child) {
			$children[$index]->has_children = Page::hasChildren($child->id);
			$children[$index]->is_expanded = in_array($child->id, $expanded_node);
			$children[$index]->is_related = array_key_exists($child->id, $related);

			if ($children[$index]->is_expanded)
				$children[$index]->children_rows = self::Get_instance()->children($child->id, $level+1);
		}

		$content = self::Get_instance()->create_view('node', array(
			'pageid' => $page_id,
			'children' => $children,
			'level' => $level + 1
		));

		if ($output) echo $content;

		return $content;
	}

	public static function set_relation($action, $page_id, $related_page_id) {
		if ($action == 'add') {
			echo RelatedPages::AddRelation($page_id, $related_page_id);
		} elseif ($action == 'delete') {
			echo RelatedPages::DeleteRelation($page_id, $related_page_id);
		}
	}

	public static function Callback_page_delete($page) {
		RelatedPages::DeleteAllByPage($page->id);
	}

    public static function documentation() {
        self::Get_instance()->display('documentation', array(
        ))->display();
    }
}
?>
