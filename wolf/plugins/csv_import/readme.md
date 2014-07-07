CSV Import for Wolf CMS
======================

Plugin for importing **.csv**, **.tsv** and **.txt** data from
exported spreadsheet files. Data rows are converted into Wolf CMS
pages and parts.

This plugin provides a convenient way to import **Excel** and
**Open Office Calc** tables into Wolf CMS. All you need to do is:

1. Export the spreadsheet to one of supported formats _(csv,tsv,txt)_,
2. Upload the file to **[CMS_ROOT]/public** folder
3. Tweak some import settings like:
   - column **delimeter** character _(usually a comma, semicolon or tabulator)_
   - cell contents **enclosure** character _(usually double- or single-quote)_
   - **escape character** _(usually backslash but Excel seems to use double quote)_
   - **character encoding** _(like WINDOWS-1252, ISO-8859-2, etc.)_
   - imported file **locale** _(like pl_PL, en_US, de_AT, etc.)_
4. Adjusting those settings will most likely lead to valid table interpretation.
5. If everything is OK you can import new pages and page parts.

The plugin automatically assigns some columns values to Page properties.
Columns which cannot become page properties can be added as page parts.
If your table contains one of the following columns:

- slug - **required** _(and only rows with unique slugs will be imported)_
- title
- breadcrumb
- keywords
- description
- created_on
- published_on
- valid_until
- tags

..the imported Page properties will be set accordingly to those fields.
Any other properly named _(latin letters, digits, dash and underscore)_
columns will be added as **Page Parts**.


Installation
------------

CSV Import Plugin can be installed into your WolfCMS by uploading it to ***CMS_ROOT/wolf/plugins/csv_import/*** and enabling it in administration panel.

Changelog
---------

0.1.2

- valid_until field bugfix

0.1.1

- first release

License
-------

* GPLv3 license

Disclaimer
----------

While I make every effort to deliver quality plugins for Wolf CMS, I do not guarantee that they are free from defects. They are provided “as is," and you use it at your own risk. I'll be happy if you notice me of any errors.

I'm not really programmer nor web developer, however I like programming PHP and JavaScript. In fact I'm an [architekt](http://marekmurawski.pl).