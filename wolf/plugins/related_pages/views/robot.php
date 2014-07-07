<div id="<?php echo $css_id_prefix;?>container" title="<?php echo __('Robot'); ?>">
<style type="text/css">
#<?php echo $css_id_prefix;?>container {
	padding: 10px 10px 0 10px;
	border: solid 1px #C7C7C7;
	background: #EEEEEE;
}

#<?php echo $css_id_prefix;?>container p {
	margin: 10px 20px;
}

#<?php echo $css_id_prefix;?>container ul ul {
	margin-left: 10px;
}

#<?php echo $css_id_prefix;?>container li li {
	margin-top: 4px;
	padding-left: 14px;
}

#<?php echo $css_id_prefix;?>container .status {
	font-size: 10px;
	color: #999;
}

#<?php echo $css_id_prefix;?>container .expander {
	position: absolute;
	margin-left: -20px;
	margin-top: -1px;
	cursor: pointer;
}
</style>
<?php if (empty($pageid)){ ?>
<p>Please save this page before creating relations.</p>
<?php } else { ?>
	<ul>
		<li><input type="checkbox" value="1"<?php if (array_key_exists('1', $related)){?> checked="checked"<?php } ?><?php if ($pageid == 1){?> disabled="disabled"<?php } ?> /> Home
		<?php echo $sitetree ?>
		</li>
	</ul>

<script type="text/javascript">
$j(function(){
	$j('#<?php echo $css_id_prefix;?>container .expander').live('click', function(){
		$expander = $j(this);
		$parent = $expander.parent();
		$children = $parent.find('ul:first');

		if ($children.length){
			if ($children.is(':hidden')){
				$children.show();
				$expander.attr('src', '<?php echo URI_PUBLIC . ADMIN_DIR ?>/images/collapse.png');
			} else {
				$children.hide();
				$expander.attr('src', '<?php echo URI_PUBLIC . ADMIN_DIR ?>/images/expand.png');
			}
		} else {
			params = $parent.attr('id').split('-');

			$j('#busy-' + params[1]).show();

			$j.get('<?php echo URI_PUBLIC . ADMIN_DIR ?>/?/plugin/related_pages/children/<?php echo $pageid; ?>/' + params[1] + '/' + params[2], function(data) {
				$parent.append(data);

				$j('#busy-' + params[1]).hide();

				$expander.attr('src', '<?php echo URI_PUBLIC . ADMIN_DIR ?>/images/collapse.png');
			});
		}
	});

	$j('#<?php echo $css_id_prefix;?>container input:checkbox').live('click', function(){
		action = $j(this).is(':checked') ? 'add' : 'delete';

		$j.get('<?php echo URI_PUBLIC . ADMIN_DIR ?>/?/plugin/related_pages/set_relation/' + action + '/<?php echo $pageid; ?>/' + $j(this).val(), function(data) {

		});
	});
});
</script>
<?php } ?>
</div>
