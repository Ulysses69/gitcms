<h2>Installation</h2>

First download the zip file containing mbBlog. <a href='http://www.mikebarlow.co.uk/downloads/mbblog.zip'>Zip Download</a><br />
Once downloaded, unzip the contents into the plugin folder of your Wolf Installation. (Default will be /wolf/plugins/).<br /><br />

Next copy the helper file (mbPager.php) from the "helper-place into Wolfs Helper Folder!" folder into your, as it says, wolf helpers folder, (Default is /wolf/helpers/).<br /><br />

Next login to the admin area of your WolfCMS installation and navigate to the the plugin list found under the Administration tab. Once there, just check the enable box next to mbBlog. This will run the installation which will setup the MySQL for you.<br /><br />

This next step is optional as some default values are entered but you may wish to change some of the settings mbBlog offers.<br />
To do so, click into the "Blog" tab which should now be available in your admin areas menu. Once there, in the right menu there is an button for the blog settings, from here you can then modify the mbBlog settings.<br /><br />

<h2>Using mbBlog</h2>

To start adding posts to your blog, first click the "Blog" tab which should now have appeared in the administration menu. From here, click the button on the right that's labeled "Add New Post". Using the form on the next page, you can then add your blog to your site.<br /><br />

As stated on the form, the Blog Intro is an optional field. This can be used to start of a long post. If a post is going to be made, but an introduction paragraph in that box and mbBlog will show that paragraph and a read more link on the blog list instead of the main body. Upon clicking into view the full post, the Blog Body will then be displayed instead of the Blog Intro.<br /><br />

Filters are not currently supported so <a href='http://www.w3schools.com' target='_blank'>html</a> will have to be used instead to format your blog post.<br /><br />

From the blog tab, you are also able to manage the posts already posted to your blog and manage the settings related to mbBlog.<br /><br />

<h2>Observer Points</h2>

mbBlog has support for some Observer Points. Currently there are only 3 notification points which are:<br /><br />

Observer::notify('mbblog_after_add', $id); // After a blog post has been successfully added<br />
Observer::notify('mbblog_after_edit', $id); // After a blog post has been successfully edited<br />
Observer::notify('mbblog_after_del', $id); // After a blog post has been successfully deleted<br /><br />

The variable passed ($id) is the ID number of the blog post in question.<br /><br />

<h2>Support</h2>

While I will attempt to provide support as much as possible, this is only a hobby project so I don't have all the time in the world to maintain the script and update it as much as I would like.<br />
If you appreciate what I do then and would like give a donation then that would be most welcome and can be done via the paypal button in the right menu at <a href='http://www.mikebarlow.co.uk/' target='_blank'>www.mikebarlow.co.uk</a>.
