== WHAT IT IS ==

The Events plugin provides a backend interface to manage events and an API
to use event data on the front end.

Dependencies:
    - Wolf CMS 0.6.0+
    - PHP 5.2 or higher
	- MySQL (SQLite not supported)

If you wish to use Frog CMS 0.9.5 instead of Wolf CMS, you will need to apply
a patch to allow front-end controllers for plugins. This patch can be found at
http://morgan.net.au/labs/events

== HOW TO USE IT ==

Events can be created using the 'Events' tab in the admin section.

You can include a calendar on your front-end with the following PHP code:

<?php echo events_showEvents(); ?>

You can include a smaller mini-calendar like so:

<?php echo events_showEvents(true); ?>

This is useful to put into a Snippet, which you can include in your Layouts.

== NOTES ==

Please go to http://morgan.net.au/labs/events for more information and to
give comments/questions/suggestions.

== CHANGELOG ==

Version 0.1 (2009-09-29):
	- Initial release.
	- Support for creating events, categories, attractions and venues.
	- Front-end event listings.
	- Front-end calendar and mini-calendar.

== ROADMAP ==

Here are features we hope to add in the future:
	- RSS feeds for events
	- Google Maps for venue locations
	- Event/Attraction images
	- Rich text editor for descriptions
	- Different currency types
	- Publishing/hiding events
	- Link to box office
	- Recurring events

== LICENSE ==

Wolf CMS has made an exception to the GNU General Public License for plugins.
See the exception.txt file in the Wolf CMS distribution for details and the
full text.

The Events plugin is licenced under the MIT Licence.

Copyright (C) 2009 Morgan Creative <products@morgan.net.au>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
