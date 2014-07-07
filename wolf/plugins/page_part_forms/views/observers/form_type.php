<?php
foreach($page_part_forms as $form) {
	$pageid = $form->id;
}


/* This is a new (unsaved) page */
$req = $_SERVER['REQUEST_URI'];
if(stristr($req,'page/add/')){

	/* Get parent id */
	$matches = array();
	if (preg_match('#(\d+)$#', $req, $matches)) {
	    $parentid = $matches[1];
	}

	$form_sql = "SELECT * FROM ".TABLE_PREFIX."page_metadata";
	$form_q = Record::getConnection()->query($form_sql);
	$form_f = $form_q->fetchAll(PDO::FETCH_OBJ);
	foreach ($form_f as $form) {

		/* Force page part form if parent has set page part form for children */
		if($parentid == $form->page_id){
			//echo '<h2>value: '.$form->value.'</h2>';
			//echo '<h2>form id: '.$form->id.'</h2>';
			//echo '<h2>selected: '.$selected.'</h2>';
			$selected = $form->value;
		}
	}

}



/* Profiles are always shown - needs fixing */
if(!isset($pageid)){ ?>
<p>Please save this page before setting profiles.</p>
<?php } else { ?>

<div class="page-metadata-row">
  <label for="<?php echo $css_id_prefix; ?>selection"><?php echo __('Page'); ?></label>
  <div class="page-metadata-column">
    <input type="hidden" name="page_metadata[<?php echo $plugin_id; ?>][name]" value="<?php echo $plugin_id; ?>" />
    <input type="hidden" name="page_metadata[<?php echo $plugin_id; ?>][visible]" value="0" />
    <select id="<?php echo $css_id_prefix; ?>selection" name="page_metadata[<?php echo $plugin_id; ?>][value]" class="page-metadata-value" title="Set profile for this page">
      <option value="">&#8212; <?php echo __('none'); ?> &#8212;</option>
    <?php foreach($page_part_forms as $form) {
      echo '<option value="'.$form->id.'"'.($form->id == $selected ? ' selected="selected"' : '').'>'.$form->name.'</option>';
      
      // Allow plugins and CMS to know if page has form parts enabled
	  //if($form->id == $selected && $form->id != ''){
	  //	define('PAGE_PART_FORM','enabled');
      //}

    } ?>
    </select>
  </div>
</div>

<?php
/* Add new */
?>
<div class="page-metadata-row">
  <label for="<?php echo $css_id_prefix; ?>selection"><?php echo __('Children'); ?></label>
  <div class="page-metadata-column">
    <input type="hidden" name="page_metadata[<?php echo $plugin_id; ?>_children][name]" value="<?php echo $plugin_id; ?>_children" />
    <input type="hidden" name="page_metadata[<?php echo $plugin_id; ?>_children][visible]" value="0" />
    <select id="<?php echo $css_id_prefix; ?>selection" name="page_metadata[<?php echo $plugin_id; ?>_children][value]" class="page-metadata-value" title="Set profile for child pages">
      <option value="">&#8212; <?php echo __('none'); ?> &#8212;</option>
    <?php foreach($page_part_forms as $form) {
      echo '<option value="'.$form->id.'"'.($form->id == $children_selected ? ' selected="selected"' : '').'>'.$form->name.'</option>';

      // Allow plugins and CMS to know if page has form parts enabled
	  if($form->id == $selected && $form->id != ''){
	  	define('PAGE_PART_FORM','enabled');
      }

    } ?>
    </select>
  </div>
</div>

<?php } ?>