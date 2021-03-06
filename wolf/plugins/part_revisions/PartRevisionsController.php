<?php
/* Security measure */
if (!defined('IN_CMS')) {
	exit();
}
/**
 * Part Revisions Plugin for Wolf CMS
 * Provides Page Part revisions history management.
 * 
 * @package Plugins
 * @subpackage part_revisions
 *
 * @author Marek Murawski <http://marekmurawski.pl>
 * @copyright Marek Murawski, 2012
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */

class PartRevisionsController extends PluginController {
	
	const VIEW_FOLDER = "../../plugins/part_revisions/views/";

	public function __construct() {
		AuthUser::load();
		if (!(AuthUser::isLoggedIn())) {
		redirect(get_url('login'));
		}

		//if (!AuthUser::hasPermission('admin_view')) {
		if (!AuthUser::hasPermission('administrator')) {
		redirect(URL_PUBLIC);
		}

		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/part_revisions/views/sidebar'));
	}

	public function revert($id) {
		$revertedPart = PartRevision::findOneFrom('PartRevision', 'id='.$id); // todo: make prepared statement
		$partToReplace = PagePart::findOneFrom('PagePart', 'name=? AND page_id=?', array($revertedPart->name, $revertedPart->page_id));
	
		if ($partToReplace) { // if part to replace exists make a copy of it as a new Revision
					$partRevision = new PartRevision;
					$partRevision->content		= $partToReplace->content;
					$partRevision->content_html	= $partToReplace->content_html;
					$partRevision->filter_id	= $partToReplace->filter_id;
					$partRevision->name		= $partToReplace->name;
					$partRevision->page_id		= $partToReplace->page_id;
					$partRevision->save();
					Flash::set('success', __('Reverted revision of part - :part', array(':part'=>$partToReplace->name)));
				}

		if ($partToReplace==false) {$partToReplace = new PagePart;} //create PagePart if it doesn't exist
		// reverting to selected revision
		$partToReplace->content = $revertedPart->content;
		$partToReplace->content_html = $revertedPart->content_html;
		$partToReplace->filter_id = $revertedPart->filter_id;
		$partToReplace->name = $revertedPart->name;
		$partToReplace->page_id = $revertedPart->page_id;
		$partToReplace->save();
		Flash::set('success', __('Restored part - :part', array(':part'=>$partToReplace->name)));
		redirect(get_url('page/edit/'.$partToReplace->page_id));
		
	}
	
	public function purgebypage($id) {
		PartRevision::deleteByPageId($id);
		Flash::set('success',__('All page part revisions for page id :id deleted!', array(':id'=>$id)));
		redirect(get_url('page/edit/'.$id));
	}

	public function purgeall() {
		PartRevision::deleteWhere('PartRevision', '1=1');
		Flash::set('success',__('All page part revisions in ALL pages deleted!'));
		redirect(get_url('plugin/part_revisions/documentation'));
	}

	public function deleteolder($id, $page_id=0) { // @todo: IN AJAX $page_id will be obsolete
		$part = Record::findByIdFrom('PartRevision', $id);
		$time = $part->updated_on;
		$name = $part->name;
		//echo $time . '<br><br>';
		
		if (Record::deleteWhere('PartRevision', 'updated_on < ? AND name = ?', array ($time, $name))) {
			Flash::set('success',__('All page part revisions of :name older than :date were deleted!', array(':name'=>$name, ':time'=>$time)));
		}
		// go back to page editing @todo: make it AJAX
		($page_id!=0) ? redirect(get_url('page/edit/'.$page_id)) : redirect(get_url('plugin/part_revisions/recent'));
	}	
	
	public function preview($id) {
		$part = PartRevision::findOneFrom('PartRevision','id=?', array((int)$id));
		header('Content-type: text/html; charset=UTF-8');
		echo nl2br(htmlentities($part->content,ENT_COMPAT,'UTF-8'));
	}

	public function diff($id) {
		AutoLoader::addFile('SimpleDiff',PLUGINS_ROOT.'/part_revisions/lib/SimpleDiff.php');
		AutoLoader::load('SimpleDiff');
		$old = Record::findOneFrom('PartRevision','id=?', array($id));

		$new = PagePart::findOneFrom('PagePart', 'page_id=? AND name=?', array($old->page_id,$old->name));
		if ($new) { //the part exists in page
			
			$old = nl2br(htmlentities($old->content,ENT_COMPAT,'UTF-8'));

			$old = str_replace('<br />','<br/>',$old);
			$new = nl2br(htmlentities($new->content,ENT_COMPAT,'UTF-8'));

			$new = str_replace('<br />','<br/>',$new);
			header('Content-type: text/html; charset=UTF-8');
			echo SimpleDiff::htmlDiff($old,$new);
		} else echo __("The part ':part' doesn't currently exist in this page. Nothing to compare.", array(":part" => $old->name));
	}
	
	public function getlist() {
		echo new View('../../plugins/part_revisions/views/editpage/parts_list', array(
			'page_id'		   => $_POST['page_id'],
			'part_name_to_show' => $_POST['name'],
		));
	}	
	
	public function delete($id,$page_id=0) { // @todo: IN AJAX $page_id will be obsolete
		PartRevision::deleteById($id);
		Flash::set('success',__('Deleted part revision [id - :id]!', array(':id'=>$id)));
		($page_id!=0) ? redirect(get_url('page/edit/'.$page_id)) : redirect(get_url('plugin/part_revisions/recent'));
	}
	
	public function documentation() {
		// Check for localized documentation or fallback to the default english and display notice
		$lang = ( $user = AuthUser::getRecord() ) ? strtolower($user->language) : 'en';

		if (file_exists(PLUGINS_ROOT . DS . 'part_revisions'.DS.'views'.DS.'documentation'.DS. $lang . '.php')) {
			$this->display('part_revisions'.DS.'views'.DS.'documentation'.DS.$lang);
			} else
			$this->display('part_revisions'.DS.'views'.DS.'documentation'.DS.'en');
	}
	
	function index() {
		redirect(get_url('plugin/part_revisions/recent'));
	}	

	function recent($page_number = 1) {
		$this->display('part_revisions/views/recent', array(
				'page_number' => $page_number
			));
	}
	
	public static function Callback_view_page_edit_tab_links($page) {
					echo '<li class="tab"><a href="#'.PR_CSS_ID.'_tabcontents">'. __('Part revisions') . '</a></li>';
	}
		
	public static function Callback_view_page_edit_tabs(& $page) {
					echo new View(self::VIEW_FOLDER.'editpage/tabcontents', array(
							'page_id' => $page->id,
					)); 
	}	

	public static function Callback_view_page_edit_popup($page) {
					echo new View(self::VIEW_FOLDER.'editpage/popup_part_preview', array(
							'page_id' => $page->id,
					)); 
	}	
}