<?php

/* Don't display formbody content if low-profile formsize is true or $showmailinglist is false */
//if(($formsize != true || $showmailinglist != false) && $mailinglist != '') {
if($formsize != true || $showmailinglist != false) {
	


?>

			
			<fieldset id="additionalinterest">
				<legend>Stay informed</legend>
				<label for="thismailinglist" id="mailinglist">
				<?php 
				if($mailing_list != '') { $mailtext = $mailinglist; } else { $mailtext = $mailing_list; }
				
				if(isset($_POST["mailinglist"])){ $mailinglist = htmlentities($_POST["mailinglist"]); } else { $mailinglist = ''; }
				//$mailtext = $mailing_list;
				?>
				<input id="thismailinglist" type="checkbox" name="mailinglist" value="yes" title="Join the mailing list" class="checkbox"<?php if($mailinglist == "yes"){echo " checked";}?>/><?php echo $mailtext; ?></label>
			</fieldset>

			<?php if(!defined('MAILINGLISTCHECKBOX')) define("MAILINGLISTCHECKBOX", "INCLUDED"); ?>

<?php } ?>