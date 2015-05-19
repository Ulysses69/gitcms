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
		Record::deleteWhere(__CLASS__, 'page_id = ? OR related_page_id = ?', array($page_id, $page_id));
	}

	public static function GetRelatedPages($page_id){
		$related = array();

		$results = Record::findAllFrom(__CLASS__, 'page_id = ?', array($page_id));

		foreach($results as $result){
			$resultpage = Page::findById($result->related_page_id);

			if (!empty($resultpage) && $resultpage->status_id == Page::STATUS_PUBLISHED){
				array_push($related, $resultpage);
			}
		}

		return $related;
	}
}
?>
