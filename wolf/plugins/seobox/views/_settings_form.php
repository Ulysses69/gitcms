<?php

$sitemaplink = Plugin::getSetting('sitemaplink', 'seobox');
$sitemaptitle = Plugin::getSetting('sitemaptitle', 'seobox');
$sitemapdescription = Plugin::getSetting('sitemapdescription', 'seobox');
$sitemapheadings = Plugin::getSetting('sitemapheadings', 'seobox');
$sitemaparchives = Plugin::getSetting('sitemaparchives', 'seobox');
$clientlocation = Plugin::getSetting('clientlocation', 'seobox');
$clientanalytics = htmlentities(Plugin::getSetting('clientanalytics', 'seobox'));
$clientanalyticspolicy = Plugin::getSetting('clientanalyticspolicy', 'seobox');
$clientanalyticsstatus = Plugin::getSetting('clientanalyticsstatus', 'seobox');
$clientanalyticssubdomain = Plugin::getSetting('clientanalyticssubdomain', 'seobox');
$clientanalyticslinks = Plugin::getSetting('clientanalyticslinks', 'seobox');
$clientanalyticsnoscript = Plugin::getSetting('clientanalyticsnoscript', 'seobox');
$noticestatus = Plugin::getSetting('noticestatus', 'seobox');
$noticedays = Plugin::getSetting('noticedays', 'seobox');
$noticelivecheck = Plugin::getSetting('noticelivecheck', 'seobox');
$bots = Plugin::getSetting('bots', 'seobox');
$clientanalyticsscreenstats = Plugin::getSetting('clientanalyticsscreenstats', 'seobox');
$clientanalyticsversion = Plugin::getSetting('clientanalyticsversion', 'seobox');

?>

<!-- <h2>SEO</h2> -->

<form action="<?php echo get_url('plugin/seobox/save_settings'); ?>" method="post">

<br />

    <fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Menu links'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label for="sitemaplink"><?php echo __('Title attribute'); ?></label></td>
                <td class="field">
				<select name="sitemaplink" id="sitemaplink">
				<?php
				$sitemaplink_array = array(
				array ('Disabled', ''),
				array ('Page Title', 'title'),
				array ('Page Description', 'description'),
				array ('Page Event', 'event'));
				foreach($sitemaplink_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $sitemaplink){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
                <td class="help"><?php echo __('Describe page which links point to.');?></td>
            </tr>
        </table>
        <!--
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Slug stopwords'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
                <td class="label"><label for="slugstopwords"><?php echo __('Under development'); ?></label></td>
        </tr>
        </table>
        -->
    </fieldset>

    <fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Sitemap page'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
        	<tr>
				<td class="label"><label for="sitemaptitle"><?php echo __('Link text'); ?></label></td>
				<td class="field">
				<select name="sitemaptitle" id="sitemaptitle">
				<?php
				$sitemaptitle_array = array(
				array ('Page Name', 'breadcrumb'),
				array ('Page Title', 'title'));
				foreach($sitemaptitle_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $sitemaptitle){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Text format for links in sitemap list.');?></td>
			</tr>
            <tr>
                <td class="label"><label for="sitemapdescription"><?php echo __('Link descriptions'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="sitemapdescription" id="sitemapdescription" value="on" class="checkbox"<?php if($sitemapdescription == "on"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('Display meta descriptions along with links.');?></td>
            </tr>
            <tr>
                <td class="label"><label for="sitemapheadings"><?php echo __('Links as headings'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="sitemapheadings" id="sitemapheadings" value="on" class="checkbox"<?php if($sitemapheadings == "on"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('Format links as heading tags.');?></td>
            </tr>
            <tr>
                <td class="label"><label for="sitemaparchives"><?php echo __('Display archives'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="sitemaparchives" id="sitemaparchives" value="on" class="checkbox"<?php if($sitemaparchives == "on"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('Display archive child page links.');?></td>
            </tr>

			<tr>
			<td colspan="4">
				<br>
			    <fieldset style="padding: 0.5em;">
			        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('New & Updated Notices'); ?></legend>
			        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
					<tr>
		                <td class="label"><label for="noticestatus"><?php echo __('Enable'); ?></label></td>
		                <td class="field">
						<input type="checkbox" name="noticestatus" id="noticestatus" value="on" class="checkbox"<?php if($noticestatus == "on"){echo " checked";}?>/>
						</td>
		                <td class="help"><?php echo __('Yes or No');?></td>
		            </tr>
		            <tr>
		                <td class="label"><label for="noticedays"><?php echo __('Days'); ?></label></td>
		                <td class="field">
						<input name="noticedays" id="noticedays" value="<?php echo $noticedays; ?>" />
						</td>
		                <td class="help"><?php echo __('Days to display notices.');?></td>
		            </tr>
		            <!--
					<tr>
		                <td class="label"><label for="noticelivecheck"><?php echo __('Check live date'); ?></label></td>
		                <td class="field">
						<input type="checkbox" name="noticelivecheck" id="noticelivecheck" value="on" class="checkbox"<?php if($noticelivecheck == "on"){echo " checked";}?>/>
						</td>
		                <td class="help"><?php echo __('Check since website went live.');?></td>
		            </tr>
		            -->
		            </table>
		        </fieldset>
            </td>
            </tr>

        </table>
    </fieldset>

    <!--
	<fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Schema'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
        </table>
    </fieldset>
    -->


    <fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Search Engines'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
                <td class="label"><label for="bots"><?php echo __('Index pages'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="bots" id="bots" value="allow" class="checkbox"<?php if($bots == "allow"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('Allow or Disallow robots. Uncheck when in test mode (default).');?></td>
            </tr>
        </table>
    </fieldset>


    <fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Analytics'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
                <td class="label"><label for="clientanalyticsstatus"><?php echo __('Enable'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="clientanalyticsstatus" id="clientanalyticsstatus" value="on" class="checkbox"<?php if($clientanalyticsstatus == "on"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('Yes or No');?></td>
            </tr>

            <tr>
                <td class="label"><label for="clientanalyticsversion"><?php echo __('Version'); ?></label></td>
                <td class="field">
				<select name="clientanalyticsversion" id="clientanalyticsversion">
				<?php
				$clientanalyticsversion_array = array(
				array ('Classic', 'classic'),
				array ('Universal (NEW)', 'universal'));
				foreach($clientanalyticsversion_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $clientanalyticsversion){
						echo "<option value=\"".str_replace('"',"'",$val)."\" selected>$text</option>";
					} else {
						echo "<option value=\"".str_replace('"',"'",$val)."\">$text</option>";
					}
				}
				?>
				</select>
				</td>
                <td class="help"><?php echo __('Analytics method.');?></td>
            </tr>

			<tr>
                <td class="label"><label for="clientanalyticslinks"><?php echo __('Events'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="clientanalyticslinks" id="clientanalyticslinks" value="on" class="checkbox"<?php if($clientanalyticslinks == "on"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('Additionally track events');?></td>
            </tr>
			<tr>
                <td class="label"><label for="clientanalyticsnoscript"><?php echo __('Non-Javascript'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="clientanalyticsnoscript" id="clientanalyticsnoscript" value="on" class="checkbox"<?php if($clientanalyticsnoscript == "on"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('Additionally track non-javascript');?></td>
            </tr>
			<tr>
                <td class="label"><label for="clientanalyticsscreenstats"><?php echo __('Screen Stats'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="clientanalyticsscreenstats" id="clientanalyticsscreenstats" value="on" class="checkbox"<?php if($clientanalyticsscreenstats == "on"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('Track screen dimensions and orientation');?></td>
            </tr>
			<tr>
                <td class="label"><label for="clientanalytics"><?php echo __('Analytics'); ?></label></td>
                <td class="field">
				<input name="clientanalytics" id="clientanalytics" value="<?php echo $clientanalytics; ?>" />
				</td>
                <td class="help"><?php echo __('Google <a href="https://www.google.com/analytics/settings/home" target="_blank">code or script</a>. Leave blank to disable.');?></td>
            </tr>
            <tr>
                <td class="label"><label for="clientlocation"><?php echo __('Location'); ?></label></td>
                <td class="field">
				<input name="clientlocation" id="clientlocation" value="<?php echo $clientlocation; ?>" />
				</td>
                <td class="help"><?php echo __('Client or company city.');?></td>
            </tr>


			<tr>
                <td class="label"><label for="clientanalyticssubdomain"><?php echo __('Subdomains'); ?></label></td>
                <td class="field">
				<input type="checkbox" name="clientanalyticssubdomain" id="clientanalyticssubdomain" value="on" class="checkbox"<?php if($clientanalyticssubdomain == "on"){echo " checked";}?>/>
				</td>
                <td class="help"><?php echo __('<a href="https://www.google.com/analytics/web/#management/Accounts/">Manage profile</a>');?></td>
                <!-- http://www.ericmobley.net/guide-to-tracking-multiple-subdomains-in-google-analytics/ -->
            </tr>



			<tr>
                <td class="label"><label for="clientanalyticspolicy"><?php echo __('Privacy policy'); ?></label></td>
                <td class="field">
				<textarea name="clientanalyticspolicy" id="clientanalyticspolicy"><?php echo $clientanalyticspolicy; ?></textarea>
				</td>
                <td class="help"><?php echo __('Google Analytics policy.');?></td>
            </tr>

        </table>
    </fieldset>


    <p class="buttons">
       <input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="Save and continue" value="Save" />
        <a href="<?php echo get_url('plugin/product'); ?>" id="site-cancel-page" class="button" title="Close without saving">Cancel</a>
    </p>

</form>