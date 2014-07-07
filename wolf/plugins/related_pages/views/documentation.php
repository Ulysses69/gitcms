<!-- <h1>Documentation</h1> -->
<h2>Related Pages</h2>

<p>With the <em>Related Pages</em> plugin enabled, a new tab called 'Related' is created in the Edit Page administration screen.</p>

<h3>How to use</h3>

<p>When editing a page, click on the 'Related' tab.  Use the checkboxes on the site tree to add/remove relations wih the currently edited page.</p>

<p>To display the related pages on the published site, create a snippet called <strong>related</strong> and paste in the following code:</p>

<p><pre><code>&lt;?php

$relations = get_relations($this->id);

if (!empty($relations)){

	echo '&lt;ul&gt;';

	foreach ($relations as $related){
		echo '&lt;li&gt;' . $related->link() . '&lt;/li&gt';
	}

	echo '&lt;/ul&gt;';
}

?&gt;
</code></pre></p>

<p>In your pages/layouts add the snippet as usual:</p>

<p><code>&lt;?php $this->includeSnippet('related'); ?&gt;
</code></p>

<h3>About this plugin</h3>

<p>This plugin was created by <a href="http://www.andrewrowland.com/article/display/wolf-cms-related-pages-plugin">Andy Rowland</a> for the lovely <a href="http://wolfcms.com">Wolf CMS</a>.</p>

<p><a href="http://www.andrewrowland.com/wolfcms/related_pages.zip">Download the plugin</a> from my site.</p>

<p>Patches and suggestions are very welcome.  This code was knocked up in a few hours and does need some work!</p>