<!-- <h1>Funky Cache Plugin</h1> -->
<p>
Current documentation available at <a href="http://www.appelsiini.net/projects/funky_cache">plugin homepage</a>.
</p>
<p>
<h3>Rewrite Rules</h3>
<p>
Caching relies on correctly set mod_rewrite rules. Below is .htaccess file generated according to your settings.
</p>
<code><pre>
<?php if (trim(URL_SUFFIX)) { ?>



php_flag magic_quotes_gpc off
AddDefaultCharset UTF-8
Options -Indexes +FollowSymLinks

DirectoryIndex index<?php echo funky_cache_suffix() ?> index.php

&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On
    # Set next line to your Wolf CMS root - if not in subdir, then just /
    RewriteBase /

    # Rewrite index to check for static.
    RewriteCond %{DOCUMENT_ROOT}<?php echo funky_cache_folder() ?>index<?php echo funky_cache_suffix() ?> -f
    RewriteRule ^$ <?php echo funky_cache_folder() ?>index<?php echo funky_cache_suffix() ?> [L,QSA]
        
    # Rewrite to check for cached page.
    RewriteCond %{REQUEST_METHOD} ^GET$
    RewriteCond %{DOCUMENT_ROOT}<?php echo funky_cache_folder() ?>%{REQUEST_URI} -f

<?php if (funky_cache_folder_is_root()): ?>
    RewriteRule ^(.*)$ $1 [L,QSA]
<?php else: ?>
    RewriteRule ^(.*)$ <?php echo funky_cache_folder() ?>$1 [L,QSA]
<?php endif; ?>

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-l
    # Main URL rewriting.
    RewriteRule ^(.*)$ index.php?THISPAGE=$1 [L,QSA]



&lt;/IfModule&gt;
<?php } else { ?>



DirectorySlash Off

php_flag magic_quotes_gpc off
AddDefaultCharset UTF-8
Options -Indexes +FollowSymLinks

DirectoryIndex index<?php echo funky_cache_suffix() ?> index.php

&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On
    # Set next line to your Wolf CMS root - if not in subdir, then just /
    RewriteBase /
    
    # Rewrite index to check for static.
    RewriteCond  %{DOCUMENT_ROOT}<?php echo funky_cache_folder() ?>index<?php echo funky_cache_suffix() ?> -f
    RewriteRule ^$ <?php echo funky_cache_folder() ?>index<?php echo funky_cache_suffix() ?> [L,QSA] 
        
    # Rewrite to check for cached page.
    RewriteCond %{REQUEST_METHOD} ^GET$
    RewriteCond %{DOCUMENT_ROOT}<?php echo funky_cache_folder() ?>%{REQUEST_URI}<?php echo funky_cache_suffix() ?> -f
    RewriteRule ^(.*)$ <?php echo funky_cache_folder() ?>$1<?php echo funky_cache_suffix() ?> [L,QSA]

    RewriteCond %{REQUEST_FILENAME} !-f
<?php if (!funky_cache_folder_is_root()): ?>
    RewriteCond %{REQUEST_FILENAME} !-d
<?php endif; ?>
    RewriteCond %{REQUEST_FILENAME} !-l
    # Main URL rewriting.
    RewriteRule ^(.*)$ index.php?THISPAGE=$1 [L,QSA]

&lt;/IfModule&gt;

<?php } ?>
</pre></code>
