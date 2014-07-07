Installation
=================

First download the zip file containing mbMenu. http://www.mikebarlow.co.uk/downloads/mbmenu.zip
Once downloaded, unzip the contents into the plugin folder of your Wolf Installation. (Default will be /wolf/plugins/).

Next login to the admin area of your WolfCMS installation and navigate to the the plugin list found under the Administration tab. Once there, just check the enable box next to mbMenu. This will run the installation which will setup the MySQL for you.

Using mbMenu
=================

To start using mbMenu, navigate to the new "Menus" tab which should now appear at the top of your admin (if it's not there, please check you have installed it correctly).

Once on the main mbMenu admin page, use the button in the right sidebar (Add New Menu) to create a new menu. Fill the form in with the menu name (for your reference), menu code (used to reference when displaying the menu.) and tick whether you want to make it active (this allows you to disable a menu without deleting it fully).

Once you've created your first menu you should be redirected to the main mbMenu admin page, your menu should now appear in the list. If it's there, you can then use the button in the right sidebar (Add New Menu Item) to add links to your menu.
When adding items to your menu you can either, use the text boxes to add custom internal / external links or use the drop down menu to select a content page to add. This will automatically work out the page title / page slug it needs to add to the menu.

Repeat the last step to keep adding items to your menu.

Once you've setup your menu, you will need to add some php code to your layout (accessed via the layouts tab in the admin). If you click into the item management ("manage" link on the main mbMenu admin page), there is some sample code at the bottom of that page which you can copy and paste into your layout to display the menu.
From here you can then modified what is echo'd via php to, for example, make the menu appear as a unordered list which can be styled.

Support
=================

While I will attempt to provide support as much as possible, this is only a hobby project so I don't have all the time in the world to maintain the script and update it as much as I would like.
If you appreciate what I do then and would like give a donation then that would be most welcome and can be done via the paypal button in the right menu at http://www.mikebarlow.co.uk/
