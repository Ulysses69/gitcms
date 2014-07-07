<?php
class RelatedPages extends Record {
	const TABLE_NAME = 'page_related_pages';

	public $id;
	public $page_id;
	public $related_page_id;

	public static function GetRelations($page_id){
		$related = array();

		$results = Record::findAllFrom(__CLASS__, 'page_id = ?', array($page_id));

		foreach($results as $result){
			// Should not need to do this, as observer cleans up relations for deleted pages.
			// Test and confirm.
			$resultpage = Page::findById($result->related_page_id);

			if (!empty($resultpage)){
				$related[$resultpage->id] = 1;
			}
		}

		return $related;
	}

	public static function AddRelation($page_id, $related_page_id){
		return Record::insert(__CLASS__, array('page_id' => $page_id,'related_page_id' => $related_page_id));
	}

	public static function DeleteRelation($page_id, $related_page_id){
		return Record::deleteWhere(__CLASS__, 'page_id = ? AND related_page_id = ?', array($page_id, $related_page_id));
	}

	public static function DeleteAllByPage($page_id){
		Record::deleteWhere(__CLASS__, 'page_id = ?', array($page_id));
	}

	public static function GetRelatedPages($page_id, $page_self){
		$related = array();
		$tmp_position = array();

		$results = Record::findAllFrom(__CLASS__, 'page_id = ?', array($page_id));

		foreach($results as $result){
			$resultpage = Page::findById($result->related_page_id);

			/* Manually insert the URL, and page parts.  Appears to be a bug in the framework (issue 178). */
			$resultpage->url = RelatedPages::GetUrl($result->related_page_id);
			$resultpage->part = get_parts($result->related_page_id);
			
			$thispage = Page::findById($page_id);
			$thisposition = $thispage->position;

			//if (!empty($resultpage) && $resultpage->status_id == Page::STATUS_PUBLISHED){
			if (!empty($resultpage) && ($resultpage->status_id == Page::STATUS_PUBLISHED || $resultpage->status_id == Page::STATUS_HIDDEN)){
				array_push($related, $resultpage);
			}

			$tmp_position[] = $thisposition;

		}

		/* Include current page */
		if($page_self == true){
			//if($thisposition == $resultpage->position){
				$resultself = Page::findById($page_id);
				array_push($related, $resultself);
				$tmp_position[] = $resultself->position;
			//}
		}
		
		/* Force sorting */
		array_multisort($related, SORT_DESC, $tmp_position);
		//$related = $tmp_position;
		//array_multisort($tmp_position, SORT_DESC, $related);
		$related = array_reverse($related);

		return $related;
	}

	/* Temporary function until they fix the core framework */
	public static function GetUrl($page_id){
		$slugs = array();

		while ($page_id != 1){
			$page = Page::findById($page_id);
			array_push($slugs, $page->slug);
			$page_id = $page->parent_id;
		}

		return implode(array_reverse($slugs), '/');
	}
}
?>
