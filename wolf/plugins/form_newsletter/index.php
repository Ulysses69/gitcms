<?php


Plugin::setInfos(array(
	'id'					=> 'form_newsletter',
	'title'					=> 'Form - For Suite 26 Newsletters',
	'version'				=> '12.8.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'				=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'			=> '0.9.3')
);
Behavior::add('Form', '');
function newsletterSuite26Form($buttonlabel="Subscribe",$parentpage,$action="",$fid=""){

		$formid = "newsletter-form"; ?>

		<form method="post" action="<?php echo $action; ?>" id="<?php echo $formid; ?>">
			<input type="hidden" name="fid" value="<?php echo $fid; ?>" />
			<label for="contEmailAddress" class="emailField">Email Address<input type="text" name="contEmailAddress" id="contEmailAddress" autocompletetype="email" /></label>
			<label for="contFirstName" class="nameField">First Name<input type="text" name="contFirstName" id="contFirstName" autocompletetype="given-name" /></label>
			<label for="contLastName" class="nameField">Last Name<input type="text" name="contLastName" id="contLastName" autocompletetype="family-name" /></label>
			<input type="submit" value="<?php echo $buttonlabel; ?>" class="submit" />
		</form>

<?php } ?>