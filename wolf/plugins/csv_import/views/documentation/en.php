<?php

/*
 * CSV Import Plugin for Wolf CMS
 * Import .csv, .tsv and .txt spreadsheet files into Wolf CMS pages and page parts.
 *
 * @package Plugins
 * @subpackage multiedit
 *
 * @author Marek Murawski <http://marekmurawski.pl>
 * @copyright Marek Murawski, 2013
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */

if (!defined('IN_CMS')) {
	exit();
}
?>


<p>
	This plugin helps you to edit multiple
	pages based on <strong>jQuery</strong>,
	so you don't have to wait for page reload and
	click <strong>"Save and continue editing"</strong>
	every 5 seconds.
	All changes are made (almost) instantly.
</p>
<p>
	It's especially useful for SEO purposes
	(like optimizing meta descriptions and titles)
	or quick editing large number of pages.
</p><br/>
<hr/>
<h3>MultiEdit in frontend </h3>
<p>
  To include MultiEdit in <b>frontend</b>, make sure you have <b>jQuery (1.4.2+)</b>
available in frontend (layout). Sample implementation:
</p>

<script src="https://gist.github.com/3899583.js?file=multiedit_frontend.php"></script>
</p>
<br/>
<hr/>
<p>Wolf CMS repository: <a href="http://www.wolfcms.org/repository/120">http://www.wolfcms.org/repository/120</a><br>
	Git repository: <a href="https://github.com/marekmurawski/multiedit">https://github.com/marekmurawski/multiedit</a>
</p>
