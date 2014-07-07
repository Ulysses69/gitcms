<?php
/**
 * mbBlog
 * 
 * Simple blog plugin for WolfCMS.
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		MbblogController.php
 * @date		07/04/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

if(!defined("PLUGINS_ROOT")) // done to allow mbblog to run on 0.6.0
{
	define('PLUGINS_ROOT', CORE_ROOT.'/plugins');
}
if(!defined("MBBLOG"))
{
	define('MBBLOG', PLUGINS_ROOT.'/mbblog');
}

class MbblogController extends PluginController 
{
	const TABLE_NAME = 'mbblog';
	
	public $title;
	public $level = 0;
	public $slug;
	public $breadcrumb;
	public $result = 'list';
	public $mbvars = array();	

	// constructor function to setup class
    public function __construct() 
    {
    	// setup vars
    	$this->title = Plugin::getSetting('blogtitle', 'mbblog');
    	$this->breadcrumb = $this->title;
    	$this->slug = Plugin::getSetting('blogpath', 'mbblog').'/';
    
    	if(defined("CMS_BACKEND"))
    	{
    		AuthUser::load();
	        if ( ! AuthUser::isLoggedIn()) {
	            redirect(get_url('login'));
	        }
        	$this->setLayout('backend');
        	$this->assignToLayout('sidebar', new View('../../plugins/mbblog/views/<?php echo ADMIN_DIR; ?>/sidebar'));
		} else
		{
			$this->parent = Page::find('/');
			$this->setLayout('wolf');
		}
    }
    
    /**
     * content
     *
     * overwritten content function from Page
     * bit of a hack, but allows mbcontact to integrate seamlessly without having to create extra layouts / modifying your existing one etc...
    */
    public function content($part='body', $inherit=false)
    {
    	if($part == 'body')
    	{  	
    		if($this->result == 'view')
    		{
    			$viewPath = '../../plugins/mbblog/views/viewblog';
    		} elseif($this->result == 'list')
    		{
    			$viewPath = '../../plugins/mbblog/views/bloglist';
    		} else
    		{
    			$viewPath = '../../plugins/mbblog/views/noblog';
    		}    	
    		return new View($viewPath, $this->mbvars);
    	} else
    	{
    		return $this->parent->content($part, $inherit);
    	}   
    }    
    
    /**
     * index
     *
     * Loads the blog posts for front end or backend
  	 *
    */
    public function index($page='1')
    {	
		global $__CMS_CONN__;	
	
		$limit = Plugin::getSetting('postspp', 'mbblog');
		$totalrows = Record::countFrom('mbblog');
		
		if(isset($_GET['mbblog']) && defined("CMS_BACKEND"))
		{
			$page = $_GET['mbblog'];
		}
		
		if(!isset($page) || empty($page))
		{
			$page = 1;
		}
		
		$limitvalue = $page * $limit - ($limit);
		
		$sql = $__CMS_CONN__->prepare("SELECT * FROM `".TABLE_PREFIX."mbblog` ORDER BY `date` DESC LIMIT ".$limitvalue.", ".$limit);
		$sql->execute();
		$posts = $sql->fetchAll(PDO::FETCH_OBJ);
		$paging = array();

		use_helper('mbPager');
		$adminPrepend = (defined("CMS_BACKEND")) ? ADMIN_DIR.'/plugin/mbblog/?mbblog=' : '';
		$pageConfig = array(
							'page' => $page,
							'limit' => $limit,
							'totalrows' => $totalrows,
							'itemTpl' => "<a href='{pagelink}' class='{pageclass}'>{pagetext}</a>",
							'prepend' => '/'.$adminPrepend,
							'append' => ''
							);
		$pager = new mbPager($pageConfig);
		$paging = $pager->generate();
			
		$this->mbvars = array('posts' => $posts,
							  'dateformat' => Plugin::getSetting('dateformat', 'mbblog'),
							  'paging' => $paging);
			
			
    	if(defined("CMS_BACKEND"))
    	{
       		$this->display('mbblog/views/admin/index', $this->mbvars);
    	} else
    	{   			
			$this->executeFrontendLayout();
	    	exit;
	    }
    }
   
	/**
	 * view
	 *
	 * load an individual post
	*/
	public function view($urltitle)
	{
		if(empty($urltitle))
		{
			$this->result = false;
		} else
		{	
			global $__CMS_CONN__;
			
			$sql = $__CMS_CONN__->prepare("SELECT * FROM `".TABLE_PREFIX."mbblog` WHERE `urltitle` = '".$urltitle."'");
			$sql->execute();
			$post = $sql->fetch(PDO::FETCH_OBJ);

			if($post !== false)
			{
				$this->result = 'view';
				$this->mbvars = array('post' => $post,
					   				  'dateformat' => Plugin::getSetting('dateformat', 'mbblog'));				
			} else
			{
				$this->result = false;
			}
		}  
   
		$this->executeFrontendLayout();
		exit;   
	}
    
	// --------------------------------------------------------------------------
	// Admin functions
    
    /**
     * documentation
     *
     * Documentation function to load the docs for the admin area
    */    
    public function documentation()
    {
    	if(defined("CMS_BACKEND"))
    	{
    		AuthUser::load();
	        if ( ! AuthUser::isLoggedIn()) {
	            redirect(get_url('login'));
	        }
	        $this->display('mbblog/views/admin/docs');
    
    	} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
    }
    
    /**
     * settings
     *
     * Function to manage the settings within mbContact
    */
    public function settings()
    {
    	if(defined("CMS_BACKEND"))
    	{
    		AuthUser::load();
	        if ( ! AuthUser::isLoggedIn()) {
	            redirect(get_url('login'));
	        }
	        
	        if(isset($_POST['save']) && $_POST['save'] == 'Save Settings')
	        {
				Plugin::setAllSettings($_POST['setting'], 'mbblog');
				Flash::setNow('success', __('Settings have been saved!'));	       	
	        }
	        	        
	        $this->display('mbblog/views/admin/settings', array('settings' => Plugin::getAllSettings('mbblog')));
    	} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
    } 
    
	/**
	 * addPost
	 *
	*/
	public function addPost()
	{
    	if(defined("CMS_BACKEND"))
    	{
    		$viewArray = array('act' => 'add');
    	
			if(isset($_POST['post']) && count($_POST['post']) > 0)
			{
				if($this->checkErrors($_POST['post']))
				{
					$_POST['post']['date'] = time();
					
					// get the url title
					$_POST['post']['urltitle'] = $this->genUrlTitle($_POST['post']['posttitle']);
					if($_POST['post']['urltitle'] !== false)
					{
						$result = Record::insert("MbblogController", $_POST['post']);		
						if($result === true)
						{
							$id = Record::lastInsertId();
							Observer::notify('mbblog_after_add', $id);
							
							Flash::setNow('success', __('Post has been added!'));
							$this->index();
						} else
						{
							$flashError = __('Failed to add the post!');
						}
					} else
					{
						$flashError = __('There was an error creating the url title for the blog post.');
					}
				} else
				{
					$flashError = __('There were one or more errors with the data you entered!');
				}

				if($this->checkEmpty($flashError))
				{
					Flash::setNow('error', $flashError);
				}
				
				$viewArray['post'] = (object)$_POST['post'];				
			}
			
			$this->display('mbblog/views/admin/postform', $viewArray);
		
		} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
	}    
       
	/**
	 * deletePost
	 *
	 * @param int - post id number
	*/
	public function deletePost($id)
	{
    	if(defined("CMS_BACKEND"))
    	{
    		$result = Record::deleteWhere("MbblogController", "`id` = ".Record::escape($id));
			
			if($result === true)
			{
				Observer::notify('mbblog_after_del', $id);
				
				Flash::setNow('success', __('Post has been deleted!'));
			} else
			{
				Flash::setNow('error', __('Failed to delete the post!'));
			}
			$this->index();
		} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
	}
	
	
	/**
	 * editPost
	 *
	 * @param int - post to edit
	*/
	public function editPost($id)
	{
    	if(defined("CMS_BACKEND"))
    	{
	   		$viewArray = array('act' => 'edit');
    	
    		if(isset($_POST['post']) && count($_POST['post']) > 0)
    		{
				if($this->checkErrors($_POST['post']))
				{				
					// get the url title
					$_POST['post']['urltitle'] = $this->genUrlTitle($_POST['post']['posttitle']);
					if($_POST['post']['urltitle'] !== false)
					{
						$result = Record::update("MbblogController", $_POST['post'], "`id` = ".Record::escape($id));		
						if($result === true)
						{
							Observer::notify('mbblog_after_edit', $id);
							
							Flash::setNow('success', __('Post has been edited!'));
							$this->index();
						} else
						{
							$flashError = __('Failed to edit the post!');
						}
					} else
					{
						$flashError = __('There was an error creating the url title for the blog post.');
					}
				} else
				{
					$flashError = __('There were one or more errors with the data you entered!');
				}			
				
				if($this->checkEmpty($flashError))
				{
					Flash::setNow('error', $flashError);
				}
				
				$viewArray['post'] = (object)$_POST['post'];
    			$this->display('mbblog/views/admin/postform', $viewArray);
    		}
    		
    		if(!isset($viewArray['post']))
    		{
    			$post = Record::findByIdFrom('MbblogController', $id);
    		}    	
			$this->display('mbblog/views/admin/postform', array('act' => 'edit', 'post' => $post));
			
		} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
	}
	
	/**
	 * genUrlTitle
	 *
	 * @param string - post title
	 * @return string - urltitle
	*/
	public function genUrlTitle($title)
	{
		// get the url title
		$urltitle = strtolower($title);
		$urltitle = str_replace(" ", "-", $urltitle);
		$matches = array();
		preg_match_all("/[a-z0-9-]/", $urltitle, $matches);
		if(count($matches['0']) > 0)
		{
			return implode("", $matches['0']);
		} else
		{
			return false;
		}
	}	
	
	/**
	 * checkErrors
	 *
	 * check for errors with the add / edit posts
	*/
	protected function checkErrors($post)
	{
		$error = 0;
		
		// error checks
		if(!$this->checkEmpty($post['posttitle']))
		{
			$error++;
		}
		if(!$this->checkEmpty($post['author']))
		{
			$error++;
		}
		if(!$this->checkEmpty($post['body']))
		{
			$error++;
		}
		
		return ($error > 0) ? false : true;			 
	}
	
	// Check field isn't empty
	protected function checkEmpty($field)
	{
		if(isset($field) && !empty($field))
		{
			return true;
		}
		return false;
	}

	
	/**
	 * Redefine so we can have a public version of this function.
	*/
    public function executeFrontendLayout() {
        global $__CMS_CONN__;

        $sql = 'SELECT content_type, content FROM '.TABLE_PREFIX.'layout WHERE name = '."'$this->frontend_layout'";

        $stmt = $__CMS_CONN__->prepare($sql);
        $stmt->execute();

        if ($layout = $stmt->fetchObject()) {
        // if content-type not set, we set html as default
            if ($layout->content_type == '')
                $layout->content_type = 'text/html';

            // set content-type and charset of the page
            header('Content-Type: '.$layout->content_type.'; charset=UTF-8');

            // Provides compatibility with the Page class.
            // TODO - cleaner way of doing multiple inheritance?
            $this->url = CURRENT_URI;

            // execute the layout code
            eval('?>'.$layout->content);
        }
    }
}
    