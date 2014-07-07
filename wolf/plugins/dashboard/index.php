<?php
 
/*
* Dashboard - Frog CMS dashboard plugin
*
* Copyright (c) 2008-2009 Mika Tuupola
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/mit-license.php
*
* Project home:
* http://www.appelsiini.net/projects/dashboard
*
*/
 
define('DASHBOARD_LOG_EMERG', 0);
define('DASHBOARD_LOG_ALERT', 1);
define('DASHBOARD_LOG_CRIT', 2);
define('DASHBOARD_LOG_ERR', 3);
define('DASHBOARD_LOG_WARNING', 4);
define('DASHBOARD_LOG_NOTICE', 5);
define('DASHBOARD_LOG_INFO', 6);
define('DASHBOARD_LOG_DEBUG', 7);
define('DASHBOARD_ROOT', URI_PUBLIC.'wolf/plugins/dashboard');

 
Plugin::setInfos(array(
    'id' 			=> 'dashboard',
    'title' 			=> 'Dashboard',
    'description' 		=> 'Keep up to date what is happening with your site.',
    'version' 			=> '0.5.2.1',
    'license' 			=> 'MIT',
    'author' 			=> 'Mika Tuupola',
    'require_wolf_version' 	=> '0.5.5',
    'update_url' 		=> 'http://www.appelsiini.net/download/frog-plugins.xml',
    'website' 			=> 'http://www.appelsiini.net/projects/dashboard'
));
 
/* Stuff for backend. */
if (false !== strpos($_SERVER['PHP_SELF'], ADMIN_DIR)) {

    AutoLoader::addFolder(dirname(__FILE__) . '/models');
    AutoLoader::addFolder(dirname(__FILE__) . '/lib');

    Plugin::addController('dashboard', 'Dashboard', 'administrator', true);

    //if(!stristr($_SERVER['HTTP_HOST'],".local") && !stristr($_SERVER['HTTP_HOST'],"127.0.0.1")){
	    Observer::observe('page_edit_after_save', 'dashboard_log_page_edit');
	    Observer::observe('page_add_after_save', 'dashboard_log_page_add');
	    Observer::observe('page_delete', 'dashboard_log_page_delete');
	
	    /* These currently only work in MIT fork (Toad) or 0.9.5 version of Frog. */
	    Observer::observe('layout_after_delete', 'dashboard_log_layout_delete');
	    Observer::observe('layout_after_add', 'dashboard_log_layout_add');
	    Observer::observe('layout_after_edit', 'dashboard_log_layout_edit');
	
	    Observer::observe('snippet_after_delete', 'dashboard_log_snippet_delete');
	    Observer::observe('snippet_after_add', 'dashboard_log_snippet_add');
	    Observer::observe('snippet_after_edit', 'dashboard_log_snippet_edit');
	
	    Observer::observe('comment_after_delete', 'dashboard_log_comment_delete');
	    Observer::observe('comment_after_add', 'dashboard_log_comment_add');
	    Observer::observe('comment_after_edit', 'dashboard_log_comment_edit');
	    Observer::observe('comment_after_approve', 'dashboard_log_comment_approve');
	    Observer::observe('comment_after_unapprove', 'dashboard_log_comment_unapprove');
	
	    Observer::observe('plugin_after_enable', 'dashboard_log_plugin_enable');
	    Observer::observe('plugin_after_disable', 'dashboard_log_plugin_disable');
	
	    Observer::observe('admin_login_success', 'dashboard_log_admin_login');
	    Observer::observe('admin_login_failed', 'dashboard_log_admin_login_failure');
	    Observer::observe('admin_after_logout', 'dashboard_log_admin_logout');

	    Observer::observe('log_event', 'dashboard_log_event');
    //}

    function dashboard_log_page_add($page) {
        $linked_title = sprintf('<a href="%s">%s</a>',
                        get_url('page/edit/' . $page->id), $page->breadcrumb);
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Page <b>:breadcrumb</b> was created by '.$log_user_type.' :name',
                        array(':breadcrumb' => $linked_title,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
        //dashboard_alert($message,AuthUser::getRecord()->name);
        if(CMS_TEST_MODE != true){
			if(200 === ($status = dashboard_ping(URL_ABSOLUTE.'sitemap.xml')) ) {
				$message = "Google Sitemaps notified. Status code: $status.";
				dashboard_log_event($message, 'core');
			} else {
				$message = "Cannot notify Google Sitemaps. Status code: $status.";
				dashboard_log_event($message, 'core');
			}
		}
		//dashboard_save($page,'page_add');
    }

    function dashboard_log_page_edit($page) {
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $linked_title = sprintf('<a href="%s">%s</a>',
                        get_url('page/edit/' . $page->id), $page->breadcrumb);
        $message = __('Page <b>:breadcrumb</b> was revised by '.$log_user_type.' :name',
                        array(':breadcrumb' => $linked_title,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
        //dashboard_alert($message,AuthUser::getRecord()->name);
        //dashboard_save($page,'page_edit');
    }

    function dashboard_log_page_delete($page) {
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Page <b>:breadcrumb</b> was deleted by '.$log_user_type.' :name',
                        array(':breadcrumb' => $page->breadcrumb,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
        dashboard_alert($message,AuthUser::getRecord()->name);
        if(CMS_TEST_MODE != true){
			if(200 === ($status = dashboard_ping(URL_ABSOLUTE.'sitemap.xml')) ) {
				$message = "Google Sitemaps notified. Status code: $status.";
				dashboard_log_event($message, 'core');
			} else {
				$message = "Cannot notify Google Sitemaps. Status code: $status.";
				dashboard_log_event($message, 'core');
			}
		}
    }

    /* Layout */

    /* Frog triggers wrong event layout_after_edit ATM. */
    function dashboard_log_layout_delete($layout) {
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Layout <b>:breadcrumb</b> was deleted by '.$log_user_type.' :name',
                        array(':breadcrumb' => $layout->name,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
        //dashboard_alert($message,AuthUser::getRecord()->name);
    }

    function dashboard_log_layout_add($layout) {
        $linked_title = sprintf('<a href="%s">%s</a>',
                                    get_url('layout/edit/' . $layout->id), $layout->name);
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Layout <b>:breadcrumb</b> was created by '.$log_user_type.' :name',
                        array(':breadcrumb' => $linked_title,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
        //dashboard_alert($message,AuthUser::getRecord()->name);
    }

    function dashboard_log_layout_edit($layout) {
        $linked_title = sprintf('<a href="%s">%s</a>',
                                    get_url('layout/edit/' . $layout->id), $layout->name);
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Layout <b>:breadcrumb</b> was revised by '.$log_user_type.' :name',
                           array(':breadcrumb' => $linked_title,
                                 ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
        //dashboard_alert($message,AuthUser::getRecord()->name);
    }

    /* Snippet */

    function dashboard_log_snippet_delete($snippet) {
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Snippet <b>:breadcrumb</b> was deleted by '.$log_user_type.' :name',
                        array(':breadcrumb' => $snippet->name,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_snippet_add($snippet) {
        $linked_title = sprintf('<a href="%s">%s</a>',
                                    get_url('snippet/edit/' . $snippet->id), $snippet->name);
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Snippet <b>:breadcrumb</b> was created by '.$log_user_type.' :name',
                        array(':breadcrumb' => $linked_title,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
        //dashboard_alert($message,AuthUser::getRecord()->name);
    }

    function dashboard_log_snippet_edit($snippet) {
        /* If not function snippet */
		if($snippet->id != 3){		$linked_title = sprintf('<a href="%s">%s</a>',
                                    get_url('snippet/edit/' . $snippet->id), $snippet->name);
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Snippet <b>:breadcrumb</b> was revised by '.$log_user_type.' :name',
                        array(':breadcrumb' => $linked_title,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
        //dashboard_alert($message,AuthUser::getRecord()->name);
		}
    }

    function dashboard_log_comment_add($comment) {

        /*
TODO: It seems Page class here is NOT the model but the other Page class?
$page = Page::findByIdFrom('Page', $comment->page_id);
FIXME - This does not get called with SVN version of Frog?
TODO: Fetch page title.
*/
        $linked_title = sprintf('<a href="%s">%s</a>',
                                    get_url('plugin/comment/edit/' . $comment->id), 'posted a comment');
        $message = __(':name :breadcrumb.',
                        array(':name' => $comment->author_name,
                              ':breadcrumb' => $linked_title));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_comment_delete($comment) {

        /* TODO: Fetch page title. */
        $message = __(':admin_name deleted comment by :author_name.',
                        array(':author_name' => $comment->author_name,
                              ':admin_name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_comment_approve($comment) {

        /* TODO: Fetch page title. */
        $linked_title = sprintf('<a href="%s">%s</a>',
                                 get_url('plugin/comment/edit/' . $comment->id), 'comment');
        $message = __(':admin_name approved :breadcrumb by :author_name.',
                        array(':author_name' => $comment->author_name,
                              ':breadcrumb' => $linked_title,
                              ':admin_name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_comment_unapprove($comment) {

        /* TODO: Fetch page title. */
        $linked_title = sprintf('<a href="%s">%s</a>',
                                 get_url('plugin/comment/edit/' . $comment->id), 'comment');
        $message = __(':admin_name rejected :breadcrumb by :author_name.',
                        array(':author_name' => $comment->author_name,
                              ':breadcrumb' => $linked_title,
                              ':admin_name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_comment_edit($comment) {

        /* TODO: Fetch page title. */
        $linked_title = sprintf('<a href="%s">%s</a>',
                                    get_url('plugin/comment/edit/' . $comment->id), 'comment');
        $message = __(':admin_name edited :breadcrumb by :author_name.',
                        array(':author_name' => $comment->author_name,
                              ':breadcrumb' => $linked_title,
                              ':admin_name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_plugin_enable($plugin) {
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Plugin <b>:breadcrumb</b> was enabled by '.$log_user_type.' :name',
                        array(':breadcrumb' => $plugin,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_plugin_disable($plugin) {
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __('Plugin <b>:breadcrumb</b> was disabled by '.$log_user_type.' :name',
                        array(':breadcrumb' => $plugin,
                              ':name' => AuthUser::getRecord()->name));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_admin_login($username) {
		if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __($log_user_type.' <b>:name</b> logged in.',
                        array(':name' => $username));
        dashboard_log_event($message, 'core');
        if(Plugin::isEnabled('form_core') == true){
			$message .= $_POST['specification'];
		} else {
			$message .= " Logged IP: ".getenv('REMOTE_ADDR');
		}
        dashboard_alert($message,$username,' login');
    }

    function dashboard_log_admin_login_failure($username) {
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __($log_user_type.' <b>:name</b> failed logging in.',
                        array(':name' => $username));
        dashboard_log_event($message, 'core');
        if(Plugin::isEnabled('form_core') == true){
			$message .= $_POST['specification'];
		} else {
			$message .= " Logged IP: ".getenv('REMOTE_ADDR');
		}
        dashboard_alert($message,$username,' login failure');
    }

    function dashboard_log_admin_logout($username) {
        if(!AuthUser::hasPermission('client')) {
			$log_user_type = 'Administrator';
		} else {
			$log_user_type = 'Client';
		}
        $message = __($log_user_type.' <b>:name</b> logged out.',
                        array(':name' => $username));
        dashboard_log_event($message, 'core');
    }

    function dashboard_log_event($message, $ident='misc', $priority=DASHBOARD_LOG_NOTICE) {
        /* BC. Order of parameters was swapped in 0.4.0. */
        if (is_integer($ident)) {
            $warning = __('Message below from <b>:ident</b> uses old Dashboard API.',
                            array(':ident' => $priority));
            dashboard_log_event($warning, 'dashboard', DASHBOARD_LOG_WARNING);

            $data['ident'] = $priority;
            $data['priority'] = $ident;
        } else {
            $data['ident'] = $ident;
            $data['priority'] = $priority;
        }
        $data['message'] = $message;
        $entry = new DashboardLogEntry($data);
        $entry->save();
    }


    function dashboard_alert($notice,$username,$type='') {
        //if(!stristr($_SERVER['HTTP_HOST'],".local") && !stristr($_SERVER['HTTP_HOST'],"www.") && !stristr($_SERVER['HTTP_HOST'],"127.0.0.1")){
            $title = $_SERVER['HTTP_HOST'];
            mail("steven@bluehorizonsmedia.co.uk", $title, strip_tags($notice), "From: CMS$type Alert <cms@poppymedia.co.uk>");
            //dashboard_log_sql();
        //}
    }


    function dashboard_log_sql(){

		preg_match('/'.preg_quote('host=').'(.*?)'.preg_quote(';port').'/is', DB_DSN, $host); $host = $host[1];
		$user = DB_USER;
		$pass = DB_PASS;
		preg_match('/'.preg_quote('dbname=').'(.*?)'.preg_quote(';host=').'/is', DB_DSN, $dbname); $name = $dbname[1];

		backup_tables($host,$user,$pass,$name);
		
		// Backup the db OR just a table
		function backup_tables($host,$user,$pass,$name,$tables = '*'){
			
			$link = mysql_connect($host,$user,$pass);
			mysql_select_db($name,$link);
			
			// Get all of the tables
			if($tables == '*'){
				$tables = array();
				$result = mysql_query('SHOW TABLES');
				while($row = mysql_fetch_row($result)){
					$tables[] = $row[0];
				}
			} else {
				$tables = is_array($tables) ? $tables : explode(',',$tables);
			}
			
			// Cycle through
			foreach($tables as $table){
				$result = mysql_query('SELECT * FROM '.$table);
				$num_fields = mysql_num_fields($result);
				
				$return.= 'DROP TABLE '.$table.';';
				$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
				$return.= "\n\n".$row2[1].";\n\n";
				
				for ($i = 0; $i < $num_fields; $i++){
					while($row = mysql_fetch_row($result)){
						$return.= 'INSERT INTO '.$table.' VALUES(';
						for($j=0; $j<$num_fields; $j++){
							$row[$j] = addslashes($row[$j]);
							$row[$j] = ereg_replace("\n","\\n",$row[$j]);
							if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
							if ($j<($num_fields-1)) { $return.= ','; }
						}
						$return.= ");\n";
					}
				}
				$return.="\n\n\n";
			}

			// Set target dir one level up from public root
			$filepath = dirname($_SERVER{'DOCUMENT_ROOT'});
			
			// Save file
			//$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
			$handle = fopen($filepath.'.data','w+');
			fwrite($handle,$return);
			fclose($handle);
		}
	}

    function dashboard_ping($url_xml) {
		$status = 0;
		$google = 'www.google.com';
		if($fp=@fsockopen($google, 80)){
			$req = 'GET /webmasters/sitemaps/ping?sitemap='.
			urlencode($url_xml)." HTTP/1.1\r\n".
			"Host: $google\r\n".
			"User-Agent: Mozilla/5.0 (compatible; ".
			PHP_OS.") PHP/".PHP_VERSION."\r\n".
			"Connection: Close\r\n\r\n";
			fwrite($fp, $req);
			while(!feof($fp)){
				if(@preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m)){
					$status = intval( $m[1] );
					break;
				}
			}
			fclose($fp);
		}
		return($status);
	}

}
