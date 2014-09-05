<?php

$version = Plugin::getSetting('version', 'pricelist');
$price = Plugin::getSetting('price', 'pricelist');
$itempricelabel = Plugin::getSetting('itempricelabel', 'pricelist');
$itemprice2label = Plugin::getSetting('itemprice2label', 'pricelist');

?>
<!-- <h1><?php echo __('Pricelist'); ?></h1> -->
<!--
<p id="jquery_notice"><img align="top" alt="layout-icon" src="../../../wolf/plugins/pricelist/images/error_16.png" title="" class="node_image" />&nbsp;<strong>Note</strong>: It appears jQuery is not available. Please install and activate the <a href="http://github.com/tuupola/frog_jquery">jQuery plugin</a>.</p>
-->

<h2 id="price_form_anchor"><?php echo __('Add Item'); ?></h2>
<div id="price_form">
	<form action="<?php echo get_url('plugin/pricelist/save'); ?>" method="post">
		<table cellpadding="5" cellspacing="5" border="0" id="price_form_table"> 
		  <tr>
				<td>
					<label for="price_itemlabel"><?php echo __('Name'); ?></label><br />
					<input class="textbox" id="price_itemlabel" maxlength="255" name="price[itemlabel]" type="text" value="" />
				</td>
				<td class="desc">
					<label for="price_itemdesc"><?php echo __('Description'); ?></label><br />
					<input class="textbox" id="price_itemdesc" maxlength="255" name="price[itemdesc]" type="text" value="" />
				</td>
				<td class="price">
					<label for="price_itemprice"><?php echo $itempricelabel; ?></label><br />
					<input class="textbox" id="price_itemprice" maxlength="55" name="price[itemprice]" type="text" value="" />
				</td>
				<td class="price">
					<label for="price_itemprice2"><?php echo $itemprice2label; ?></label><br />
					<input class="textbox" id="price_itemprice2" maxlength="55" name="price[itemprice2]" type="text" value="" />
				</td>

				<!--
				<td>
					<label for="price_itemkey"><?php echo __('Token'); ?></label><br />
					<input class="textbox" id="price_itemkey" maxlength="55" name="price[itemkey]" type="text" value="" />
				</td>
				-->

		  </tr>
		</table>	

		<p class="buttons">
			<input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Add');?>" />
		</p>

	</form>
</div>

<div class="boxed">
<h2><?php echo __('Items'); ?></h2>
<?php if(sizeof($current_prices) > 0) { ?>
<table id="prices" class="index">
	<thead id="requests" class="node_heading">
	<tr>
		<th class="itemlabel"><?php echo __('Name'); ?></th>
		<th class="itemdesc"><?php echo __('Description'); ?></th>
		<th class="itemprice"><?php echo __('Prefix'); ?></th>
		<th class="itemprice"><?php echo $itempricelabel; ?></th>
		<th class="itemprice2"><?php echo $itemprice2label; ?></th>
		<th class="itemprice"><?php echo __('Suffix'); ?></th>
		<!-- <th class="itemtoken"><?php echo __('Token'); ?></th> -->
		<th class="action"><?php echo __('Action'); ?></th>
	</tr>
	</thead>
	<?php foreach ($current_prices as $price): ?>
	<?php if(isset($price->itemlabel_pref)){ $price_prefix = $price->itemlabel_pref; } else { $price_prefix = ''; } ?>
	<?php if(isset($price->itemlabel_suff)){ $price_sufffix = $price->itemlabel_suff; } else { $price_sufffix = ''; } ?>
	<tbody id="prices_<?php echo $price->id; ?>" class="node">
	<form action="<?php echo get_url('plugin/pricelist/update'); ?>" method="post">
	<input type="hidden" name="prices_id" value="<?php echo $price->id; ?>" />
	<tr>
	 <!-- <img align="middle" alt="layout-icon" src="../../../wolf/plugins/pricelist/images/price.png" title="" class="node_image" /> -->
		<td class="itemlabel"><input class="textbox" maxlength="255" name="<?php echo $price->id; ?>[itemlabel]" type="text" value="<?php echo $price->itemlabel; ?>" /></td>
		<td class="itemdesc"><input class="textbox" maxlength="255" name="<?php echo $price->id; ?>[itemdesc]" type="text" value="<?php echo $price->itemdesc; ?>" /></td>

		<td class="itemprice_pref"><input class="textbox" maxlength="255" name="<?php echo $price->id; ?>[itemlabel_pref]" type="text" value="<?php echo $price_prefix; ?>" /></td>

		<td class="itemprice"><input class="textbox" maxlength="255" name="<?php echo $price->id; ?>[itemprice]" type="text" value="<?php echo $price->itemprice; ?>" /></td>
		<td class="itemprice2"><input class="textbox" maxlength="255" name="<?php echo $price->id; ?>[itemprice2]" type="text" value="<?php echo $price->itemprice2; ?>" /></td>

		<td class="itemprice_suff"><input class="textbox" maxlength="255" name="<?php echo $price->id; ?>[itemlabel_suff]" type="text" value="<?php echo $price_sufffix; ?>" /></td>

		<!-- Token -->
		<!-- <td class="itemtoken">[price id="<?php echo $price->id; ?>"]</td> -->
		<td class="action">
		<!-- <a href="<?php echo get_url('plugin/pricelist/remove/'.$price->id); ?>" onclick="return confirm('Are you sure you wish to delete <?php echo $price->itemlabel; ?>?');"><img alt="Remove Price" src="../../../wolf/plugins/pricelist/images/icon-remove.gif" /></a> -->
		<button class="btn" type="submit" name="remove" onclick="return confirm('Are you sure you wish to delete <?php echo $price->itemlabel; ?>?');"><img alt="Remove Price" src="../../../wolf/plugins/pricelist/images/icon-remove.gif" /></button><button class="btn" type="submit" name="update" onclick="return confirm('Are you sure you wish to update <?php echo $price->itemlabel; ?>?');"><img alt="Update Price" src="../../../wolf/plugins/pricelist/images/icon-update.gif" /></button>
		</td>
	</tr>
	</form>
	</tbody>
	<?php endforeach ?>
</table>
<?php } else { ?>
	<p><em><?php echo __('There are no prices set up yet.'); ?></em></p>
<?php } ?>
</div>



<!-- Click existing prices to copy to new price
<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($) {
		$('#jquery_notice').hide();
		$('#price_itemlabel').focus();
		$('.itemlabel').click(function(){
			$('#price_itemlabel').val($(this).html());
			$('#price_itemprice').val($(this).siblings('.itemprice').html());
			$.scrollTo('#price_form_anchor', 400);
			$('#price_itemprice').focus();
			return false;
		});
		$('.itemprice').click(function(){
			$('#price_itemlabel').val($(this).siblings('.itemlabel').html());
			$('#price_itemprice').val($(this).html());
			$.scrollTo('#price_form_anchor', 400);
			$('#price_itemprice').focus();
			return false;
		});
	});
</script>
-->



<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($) {
		$('#jquery_notice').hide();
	});
</script>

