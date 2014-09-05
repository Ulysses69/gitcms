<?php
/**
 * mbMenu
 * 
 * Menu Management Plugin for WolfCMS
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		MbmenuController.php
 * @date		02/05/2010
 * 
*/// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

if(!defined("PLUGINS_ROOT")) // done to allow mbmenu to run on 0.6.0
{
	define('PLUGINS_ROOT', CORE_ROOT.'/plugins');
}
if(!defined("MBMENU"))
{
	define('MBMENU', PLUGINS_ROOT.'/mbmenu');
}

class MbmenuController extends PluginController 
{
	public $id;
	public $parent;
	public $result = 'list';
	public $mbvars = array();	

	// constructor function to setup class
	public function __construct() 
	{	   
		if(defined("CMS_BACKEND"))
		{
			AuthUser::load();
			if ( ! AuthUser::isLoggedIn()) {
				redirect(get_url('login'));
			}
			$this->setLayout('backend');
			$this->assignToLayout('sidebar', new View('../../plugins/mbmenu/views/admin/sidebar'));			
		} else
		{
			$this->parent = Page::find('/');
			$this->setLayout('wolf');
		}
	}

	/**
	 * index
	 *
	 * main admin menu page.
	*/	
	public function index()
	{
		if(defined("CMS_BACKEND"))
		{
			AuthUser::load();
			if ( ! AuthUser::isLoggedIn()) {
				redirect(get_url('login'));
			}
			
			$menus = mbmenu::findAllFrom('mbmenu');
			if(count($menus) === 0)
			{
				$menus = "There are no menu items in the database.";
			}					
			
			$this->display('mbmenu/views/admin/index', array('menus' => $menus));
	
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}
	
	
  	/**
	 * manage
	 *
	 * main admin list page
	*/	
	public function manage($id)
	{
		if(defined("CMS_BACKEND"))
		{
			AuthUser::load();
			if ( ! AuthUser::isLoggedIn()) {
				redirect(get_url('login'));
			}
			global $__CMS_CONN__;
		   
		   	$menu = mbmenu::findOneFrom('mbmenu', "`id` = ".mbmenu::escape($id));			
			$itemSQL = $__CMS_CONN__->prepare("SELECT * FROM `".TABLE_PREFIX."mbmenu_items` WHERE `menuid` = ".mbmenuItem::escape($id)."
												ORDER BY `linkparent` ASC, `linkorder` ASC");
			$itemSQL->execute();
			$items = $itemSQL->fetchAll(PDO::FETCH_OBJ);
			
			$menuItems = array();
			if(count($items) > 0)
			{
				foreach($items as $k => $v)
				{
					if($v->linkparent == 0)
					{
						$menuItems[$v->id] = $v;
					} elseif($v->linkparent > 0)
					{				
						if(isset($menuItems[$v->linkparent]->subitems))
						{
							$menuItems[$v->linkparent]->subitems[$v->id] = $v;
						} else
						{
							$menuItems[$v->linkparent]->subitems = array($v->id => $v);
						}
					}	
				}
			} else
			{
				$menuItems = "There are no menu items in this menu.";
			}
					
			$this->display('mbmenu/views/admin/manage', array('menuitems' => $menuItems, 'menu' => $menu));
	
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}  
	
 
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
			$this->display('mbmenu/views/admin/docs');
	
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}

// --------------------------------------------------------------------------
// Menu Functions

   /**
	* addMenu
	*
	* Add a new Menu
   */
   public function addMenu()
   {
		if(defined("CMS_BACKEND"))
		{
			$viewArray = array('act' => 'add');
		
			if(isset($_POST['menu']) && count($_POST['menu']))
			{
				if($this->checkEmpty($_POST['menu']['menutitle']) && 
				   $this->checkEmpty($_POST['menu']['menucode']))
				{
					$_POST['menu']['active'] = (isset($_POST['menu']['active'])) ? 1 : 0;
					$result = mbmenu::insert("mbmenu", $_POST['menu']);		
					if($result === true)
					{					
						Flash::setNow('success', __('Menu has been added!'));
						$this->index();
					} else
					{
						Flash::setNow('error', __('Failed to add the menu!'));
					}
				} else
				{
					Flash::setNow('error', __('Some fields were not filled in correctly!'));
				}
				
				$viewArray['menu'] = (object)$_POST['menu'];	
			} 
			
			$this->display('mbmenu/views/admin/menuform', $viewArray);
						
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}
	
   /**
	* editMenu
	*
	* Edit a Menu
   */
   public function editMenu($id)
   {
		if(defined("CMS_BACKEND"))
		{
			$viewArray = array('act' => 'edit');
		
			if(isset($_POST['menu']) && count($_POST['menu']))
			{
				if($this->checkEmpty($_POST['menu']['menutitle']) && 
				   $this->checkEmpty($_POST['menu']['menucode']))
				{
					$_POST['menu']['active'] = (isset($_POST['menu']['active'])) ? 1 : 0;
					$result = mbmenu::update("mbmenu", $_POST['menu'], "`id` = ".Record::escape($id));		
					if($result === true)
					{					
						Flash::setNow('success', __('Menu has been saved!'));
						$this->index();
					} else
					{
						Flash::setNow('error', __('Failed to save the menu!'));
					}
				} else
				{
					Flash::setNow('error', __('Some fields were not filled in correctly!'));
				}
				
				$viewArray['menu'] = (object)$_POST['menu'];	
			} 
			
			if(!isset($viewArray['menu']))
			{
				$viewArray['menu'] = mbmenu::findByIdFrom('mbmenu', $id);
			}
			
			$this->display('mbmenu/views/admin/menuform', $viewArray);
						
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}	
   

	/**
	 * deleteMenu
	 *
	 * @param int - menu id number
	*/
	public function deleteMenu($id)
	{
		if(defined("CMS_BACKEND"))
		{
			$result = mbmenu::deleteWhere("mbmenu", "`id` = ".Record::escape($id));			
			if($result === true)
			{	
				mbmenuItem::deleteWhere("mbmenuItem", "`menuid` = ".Record::escape($id));
				Flash::setNow('success', __('Menu has been deleted!'));
			} else
			{
				Flash::setNow('error', __('Failed to delete the Menu!'));
			}
			$this->index();
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}

// --------------------------------------------------------------------------
// Menu Items

	/**
	 * updateOrder
	 *
	 * Update the menu item order
	*/
	public function updateOrder()
	{
		if(isset($_POST['order']) && count($_POST['order']) > 0)
		{
			foreach($_POST['order'] as $itemid => $order)
			{
				mbmenuItem::update("mbmenuItem", array('linkorder' => $order), "`id` = ".Record::escape($itemid));
			}
	
			Flash::setNow('success', __('Menu order saved!'));
		}
		
		$this->manage($_POST['menuid']);
	}


   /**
	* addItem
	*
	* Add a new Menu Item
   */
   public function addItem()
   {
		if(defined("CMS_BACKEND"))
		{
			$viewArray = array('act' => 'add');
		
			if(isset($_POST['item']) && count($_POST['item']))
			{
				if($this->checkEmpty($_POST['item']['linktext']) && 
				   $this->checkEmpty($_POST['item']['linkurl']) &&
				   (isset($_POST['item']['menuid']) && $_POST['item']['menuid'] > 0))
				{
					$_POST['item']['active'] = (isset($_POST['item']['active'])) ? 1 : 0;
					
					foreach($_POST['item'] as $k => $v)
					{
						$_POST['item'][$k] = htmlspecialchars($v, ENT_QUOTES);
					}	
					
					$result = mbmenuItem::insert("mbmenuItem", $_POST['item']);		
					if($result === true)
					{					
						Flash::setNow('success', __('Menu Item has been added!'));
						$this->manage($_POST['item']['menuid']);
					} else
					{
						Flash::setNow('error', __('Failed to add the menu item!'));
					}
				} else
				{
					Flash::setNow('error', __('Some fields were not filled in correctly!'));
				}
				
				$viewArray['item'] = (object)$_POST['item'];	
			} 
			
			$viewArray['menus'] = mbmenu::getMenus();
			
			$this->display('mbmenu/views/admin/itemform', $viewArray);
						
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}

   /**
	* editItem
	*
	* edit a Menu Item
	* @param int - item id
   */
   public function editItem($id)
   {
		if(defined("CMS_BACKEND"))
		{
			$viewArray = array('act' => 'edit');
		
			if(isset($_POST['item']) && count($_POST['item']))
			{
				if($this->checkEmpty($_POST['item']['linktext']) && 
				   $this->checkEmpty($_POST['item']['linkurl']) &&
				   (isset($_POST['item']['menuid']) && $_POST['item']['menuid'] > 0))
				{
					$_POST['item']['active'] = (isset($_POST['item']['active'])) ? 1 : 0;
					
					foreach($_POST['item'] as $k => $v)
					{
						$_POST['item'][$k] = htmlspecialchars($v, ENT_QUOTES);
					}	
					
					$result = mbmenuItem::update("mbmenuItem", $_POST['item'], "`id` = ".Record::escape($id));		
					if($result === true)
					{					
						Flash::setNow('success', __('Menu Item has been saved!'));
						$this->manage($_POST['item']['menuid']);
					} else
					{
						Flash::setNow('error', __('Failed to save the menu item!'));
					}
				} else
				{
					Flash::setNow('error', __('Some fields were not filled in correctly!'));
				}
				
				$viewArray['item'] = (object)$_POST['item'];	
			} 
			
			$viewArray['menus'] = mbmenu::getMenus();
			
			if(!isset($viewArray['item']))
			{
				$viewArray['item'] = mbmenuItem::findByIdFrom('mbmenuItem', $id);
			}
			
			$this->display('mbmenu/views/admin/itemform', $viewArray);
						
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}
	
	/**
	 * deleteItem
	 *
	 * @param int - menu id number
	*/
	public function deleteItem($id)
	{
		if(defined("CMS_BACKEND"))
		{
			$menu = mbmenuItem::findOneFrom("mbmenuItem", "`id` = ".Record::escape($id));
			$result = mbmenuItem::deleteWhere("mbmenuItem", "`id` = ".Record::escape($id));			
			if($result === true)
			{	
				Flash::setNow('success', __('Menu Item has been deleted!'));
			} else
			{
				Flash::setNow('error', __('Failed to delete the Menu Item!'));
			}
			$this->manage($menu->menuid);
		} else
		{
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}
	}	


	/**
	 * getMenuItems
	 *
	 *  Ajax call for menu items
	*/
	public function getMenuItems()
	{
		$results = mbmenuItem::findAllFrom('mbmenuItem', "`linkparent` = 0 && `menuid` = ".mbmenuItem::escape($_POST['menuid']));
		$options = '<option value="0">No Parent</option>';
		
		if(count($results) > 0)
		{		
			foreach($results as $k => $v)
			{
				$options .= "<option value='".$v->id."'".(isset($_POST['linkparent']) && $_POST['linkparent'] == $v->id ? ' selected="selected"' : '').">".$v->linktext."</option>";
			}
		}
		echo $options;
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
	