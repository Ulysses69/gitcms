<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title><?php if(defined('CMS_TEST_MODE') && CMS_TEST_MODE == true){$local=' (Stage) ';}else{$local='';} ?><?php echo Setting::get('admin_title').' / '.$local . __('Login'); ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />  <link rel="shortcut icon" href="<?php echo URL_PUBLIC; ?>inc/img/icon.ico">
  <link rel="apple-touch-icon" href="<?php echo URL_PUBLIC; ?>inc/img/icon.png">
  <link href="<?php echo URL_PUBLIC.ADMIN_DIR; ?>/stylesheets/login.css" rel="Stylesheet" type="text/css" />
  <link href="<?php echo URL_PUBLIC.ADMIN_DIR; ?>/themes/<?php echo AMIN_THEME; ?>/styles.css" id="css_theme" media="screen" rel="Stylesheet" type="text/css" />
  <script src="javascripts/prototype.js" type="text/javascript"></script>
  <script src="javascripts/effects.js" type="text/javascript"></script>
</head>
<body id="login">
  <div id="dialog">
    <!-- <h1><?php echo __('Login').' - '.Setting::get('admin_title'); ?></h1> -->
<?php if (Flash::get('error') !== null) { ?>
        <div id="error" style="display: none"><?php echo Flash::get('error'); ?></div>
        <script type="text/javascript">Effect.Appear('error', {duration:.5});</script>
<?php } ?>
<?php if (Flash::get('success') != null) { ?>
    <div id="success" style="display: none"><?php echo Flash::get('success'); ?></div>
    <script type="text/javascript">Effect.Appear('success', {duration:.5});</script>
<?php } ?>
    <form action="<?php echo get_url('login/login'); ?>" method="post">
      <div id="login-username-div">
        <label for="login-username"><?php echo __('Username'); ?>:</label>
        <input id="login-username" class="medium" type="text" name="login[username]" value="" />
      </div>
      <div id="login-password-div">
        <label for="login-password"><?php echo __('Password'); ?>:</label>
        <input id="login-password" class="medium" type="password" name="login[password]" value="" />
      </div>
      <div class="clean"></div>
      <div style="margin-top: 6px">
        <input id="login-remember-me" type="checkbox" class="checkbox" name="login[remember]" value="checked" />
        <input id="login-redirect" type="hidden" name="login[redirect]" value="<?php echo $redirect; ?>" />
        <label class="checkbox" for="login-remember-me"><?php echo __('Remember me for 14 days'); ?></label>
      </div>
      <?php if(Plugin::isEnabled('form_core') == true){ ?>
		<?php
			include_once('../wolf/plugins/form_core/lib/your_computer_info.php');
			$spec = "IP: \n".$_SERVER['REMOTE_ADDR']."\n\n";
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) $spec .= "Client IP: \n".$_SERVER['HTTP_CLIENT_IP']."\n\n";
			$spec .= str_replace('</b>',"</b>\n",$full);
			$spec = str_replace('</p>',"</p>\n\n",$spec);
		?>
		<input name="specification" id="specification" size="30" type="hidden" value="<?php echo "\n\n".strip_tags($spec); ?>" />
      <?php } ?>
      <div id="login_submit">
        <input class="submit" type="submit" accesskey="s" value="<?php echo __('Login'); ?>" />
        <span>(<a href="<?php echo get_url('login/forgot'); ?>"><?php echo __('Forgot password?'); ?></a>)</span>
      </div>
    </form>
  </div>

	<script type="text/javascript" src="<?php echo URL_PUBLIC;?>inc/js/flash.detect.js"></script>
	<script type="text/javascript" src="<?php echo URL_PUBLIC;?>inc/js/javascript.cookies.js"></script>
	<script type="text/javascript">
		//<![CDATA[
		var clientplugins = '';
		var num_of_plugins = navigator.plugins.length;
		for (var i=0; i < num_of_plugins; i++) {
			list_number=i+1;
			if (clientplugins.indexOf(navigator.plugins[i].name) == -1){
			   clientplugins += navigator.plugins[i].name + '\n';
			}
		};
		var viewportwidth; var viewportheight; if (typeof window.innerWidth != 'undefined') { viewportwidth = window.innerWidth, viewportheight = window.innerHeight } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) { viewportwidth = document.documentElement.clientWidth, viewportheight = document.documentElement.clientHeight } else { viewportwidth = document.getElementsByTagName('body')[0].clientWidth, viewportheight = document.getElementsByTagName('body')[0].clientHeight };
		var js_full = 'Screen Resolution:\n';width = (screen.width) ? screen.width:'';height = (screen.height) ? screen.height:'';if (typeof(screen.deviceXDPI) == 'number'){width *= screen.deviceXDPI/screen.logicalXDPI;height *= screen.deviceYDPI/screen.logicalYDPI;};js_full += width + ' x ' + height + ' pixels\n\n';js_full += 'Page Resolution:\n' + viewportwidth + ' x ' + viewportheight + ' pixels\n\n' + 'Color Depth:\n' + screen.colorDepth + '\n\nJavaScript:\nEnabled\n\n';js_full += 'Flash:\n';if(FlashDetect.installed){js_full += FlashDetect.major + '.' + FlashDetect.minor + '.' + FlashDetect.revision + '\n\n';}else{js_full += 'Unavailable\n\n';};Set_Cookie( 'test', 'none', '', '/', '', '' );js_full += 'Cookies:\n';if (Get_Cookie('test')){cookie_set = true;Delete_Cookie('test', '/', '');js_full += 'Enabled';} else {cookie_set = false;js_full += 'Disabled';};js_full += '\n\nPlugins:\n' + clientplugins;document.getElementById('specification').value += js_full;

		//]]>
	</script>

  <!-- <p><?php echo __('website:').' <a href="'.URL_PUBLIC.'">'.URL_PUBLIC.'</a>'; ?></p> -->
  <script type="text/javascript" language="javascript" charset="utf-8">
  // <![CDATA[
  var loginUsername = document.getElementById('login-username');
  if (loginUsername.value == '') {
    loginUsername.focus();
  } else {
    document.getElementById('login-password').focus();
  }
  // ]]>
  </script>
</body>
</html>