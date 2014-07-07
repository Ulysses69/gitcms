Installation
=================

First download the zip file containing mbBlog. http://www.mikebarlow.co.uk/downloads/mbblog.zip
Once downloaded, unzip the contents into the plugin folder of your Wolf Installation. (Default will be /wolf/plugins/).

Next copy the helper file (mbPager.php) from the "helper-place into Wolfs Helper Folder!" folder into your, as it says, wolf helpers folder, (Default is /wolf/helpers/).

Next login to the admin area of your WolfCMS installation and navigate to the the plugin list found under the Administration tab. Once there, just check the enable box next to mbBlog. This will run the installation which will setup the MySQL for you.

This next step is optional as some default values are entered but you may wish to change some of the settings mbBlog offers.
To do so, click into the "Blog" tab which should now be available in your admin areas menu. Once there, in the right menu there is an button for the blog settings, from here you can then modify the mbBlog settings.

Using mbBlog
==============

To start adding posts to your blog, first click the "Blog" tab which should now have appeared in the administration menu. From here, click the button on the right that's labeled "Add New Post". Using the form on the next page, you can then add your blog to your site.

As stated on the form, the Blog Intro is an optional field. This can be used to start of a long post. If a post is going to be made, but an introduction paragraph in that box and mbBlog will show that paragraph and a read more link on the blog list instead of the main body. Upon clicking into view the full post, the Blog Body will then be displayed instead of the Blog Intro.

Filters are not currently supported so html will have to be used instead to format your blog post.

From the blog tab, you are also able to manage the posts already posted to your blog and manage the settings related to mbBlog.

Observer Points
==================

mbBlog has support for some Observer Points. Currently there are only 3 notification points which are:

Observer::notify('mbblog_after_add', $id); // After a blog post has been successfully added
Observer::notify('mbblog_after_edit', $id); // After a blog post has been successfully edited
Observer::notify('mbblog_after_del', $id); // After a blog post has been successfully deleted

The variable passed ($id) is the ID number of the blog post in question.

Support
=========

While I will attempt to provide support as much as possible, this is only a hobby project so I don't have all the time in the world to maintain the script and update it as much as I would like.
If you appreciate what I do then and would like give a donation then that would be most welcome and can be done via the paypal button in the right menu at http://www.mikebarlow.co.uk/
