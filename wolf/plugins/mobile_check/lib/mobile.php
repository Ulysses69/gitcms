/*** DO NOT EDIT. THIS FILE IS CMS-GENERATED. ***/

body, #head, #content, a {
	padding:0;
	margin:0;
	color:<?php echo $color_footer_text; ?>
}
body {
	<?php if($background_url != ''){ echo "background:url('".$background_url."') ".$color_body_bg.' '.$background_align;
	} else { ?>background:<?php echo $color_body_bg; } ?>;
    -webkit-text-size-adjust:100%;
}
<?php /* NOT WORKING - Mobile admin form doesn't handle transparent color as option */ $color_head_bg = 'transparent'; if($color_head_bg != 'transparent'){ ?>
#head {
	background:<?php echo $color_head_bg; ?>
}
<?php } ?>
h1, h2, .h2, h3, h4, p, .itemaddress, table<?php if($searchbox != 'false'){ ?>, #searchbox<?php } ?>, #content ul, #content ol {
	margin:0;
	padding:0 .5em .5em .5em;
	font-style:normal;
}
h1, h2, .h2, h3, h4, p, label, .itemaddress, table, th, td, #content ul, #content ol, #content li<?php if($searchbox != 'false'){ ?>, #searchbox<?php } ?> {
	color:<?php echo $color_main_text; ?>
}
h1 {
	font-weight:normal;
	padding:.5em;
	margin-bottom:.75em;
	border-bottom:solid 1px #ccc
}
<?php if($content_font != ''){ $font_elements = array(); ?>
<?php if($content_font_h1 == 'yes'){ $font_elements[] = 'h1'; } ?>
<?php if($content_font_h2 == 'yes'){ $font_elements[] = 'h2, .h2'; } ?>
<?php if($content_font_intro == 'yes'){ $font_elements[] = '.introduction'; } ?>
<?php if(sizeof($font_elements) > 0) { $elements = implode(', ', $font_elements); echo $elements.' {'; ?>
	<?php echo "font-family:'".str_replace('+', ' ', $content_font)."';"; ?>
	font-weight:normal;
}
<?php } ?>
<?php } ?>
h1 span {
	display: block;
	font-size: 50%;
}
h3 {
	font-size:100%
}
body, input {
	font:normal 0.96em arial, verdana, sans-serif
}
body, a, .selected li a, #head a, #sidemenu a, #logo, #nav li a, #nav li.selected li a, #sidemenu li a, #sidemenu li.selected li a {
	color:<?php echo $color_main_link; ?>
}
#content a, a {
	overflow:hidden;
	padding:5px
}
a {
	text-decoration:none
}
#content li {
	padding-bottom:.5em
}
#content a {
	color:<?php echo $color_main_link; ?>;
	margin:15px -5px
}
.tracker, #footer h2<?php if($searchbox != 'false'){ ?>, #searchbox label<?php } ?> {
	position:absolute;
	left:-90em
}
#logo {
	font-size:110%;
	text-align:<?php echo $logo_pos; ?>;
	<?php if(($logo_pos == 'left' || $homelogo != 'large') && $pagelogo != 'large'){ ?>
	padding:.7em 4em 0 1.1em;
	<?php } else if ($pagelogo == 'large'){ ?>
	padding:.7em 0 0 0;
	<?php } else { ?>
	padding:.7em 4em 0 4em;
	<?php } ?>
	min-height:1.9em;
	color:<?php echo $color_footer_text; ?>
}
#logo a {
	background:transparent !important;
	color:<?php echo $color_footer_text; ?> !important;
	border:none !important
}
#logo img {
<?php if($pagelogo == 'large'){ ?>
	max-width:240px;
	margin:5px 0;
<?php } else { ?>
	max-width:160px;
	margin:0 0 5px 0
<?php } ?>
	height:auto;
	border:0;
}



/* Prices */
.mobile .prices #content table {
	margin-top:-0.7em
}
.mobile .prices #content tr {
	position:relative;
	overflow:hidden;
}
.mobile .prices #content tr.titles {
	position:absolute;
	left:-20em;
}
.mobile .prices #content th,
.mobile .prices #content td {
	position:relative;
	display:block;
	clear:both;
	float:none;
	width:100%;
}



/* Handle iframes */
.embed {
	position: relative;
	height: 0;
	overflow: hidden;
	/* 4x3 Aspect Ratio */
	padding-bottom: 75%;
	/* 16x9 Aspect Ratio */
	padding-bottom: 56.25%;
}
.embed iframe {
	position: absolute;
	top:0;
	left: 0;
	width: 100%;
	height: 100%;
}



<?php if(($homelogo != 'small' && $logo != 'text') || $homelogo == 'large'){ ?>
#home-page #logo {
	padding:.7em 0 0 0;
	text-align:center;
}
#home-page #logo img {
	max-width:none;
	max-width:240px !important;
	height:auto;
	margin:5px 0
}
<?php } ?>


#menu, #nav {
	list-style:none;
	overflow:hidden;
	padding:0;
	margin:0
}
#nav {
	margin:0 0.5em;
}
#menu img {
	border:none;
	margin:0 0 -2px 0
}
#menu li {
	padding:5px 0;
	position:absolute
}
#footer {
	position:relative;
	margin:0;
	text-align:center;
	color:<?php echo $color_footer_text; ?>
}
#footer p {
	margin-bottom:1em;
	color:<?php echo $color_footer_text; ?>
}
#footer a {
	color:<?php echo $color_footer_link; ?>;
	padding:1em
}
small {
	font-size:60%;
}
small a {
	text-decoration:none;
	text-transform:capitalize;
	margin:0 -5px 0 -2px
}
p small span {
	display:block;
	clear:both;
	padding:0 .25em
}
#goback {
	top:.5em;
	left:.5em
}
#gomenu {
	top:.5em;
	right:.5em
}
.mobile #content {
	margin:.5em;
	overflow:hidden;
}
#content {
	padding:0 1em .5em 1em;
	background:#ffffff
}
#content:not(.legacy) {
	position:relative
}


<?php if($homecontent == 'disabled'){ ?>
#home-page.mobile #content {
	display:none;
}
<?php } ?>

#content ul, #content ol {
	margin:0 1em
}
#content li h2, #content li h3 {
	margin:.5em 0
}
#content * {
	padding-left:0;
	padding-right:0
}
#content a {
	color:<?php echo $color_main_link; ?>
}


fieldset {
	border:none;
	padding:0;
	margin:0
}
<?php if($searchbox != 'false'){ ?>
#searchbox {
	padding:.5em;
	margin:0 0 0 0
}

#searchbox input {
	float:left;
	font-size:115% !important;
	padding:.3em;
	margin:0 0 .5em 0;
	width:70%;
	border:none;
	border:solid 1px <?php echo $color_body_border; ?>
}
#searchbox input.submit {
	float:right;
	width:25%;
	margin:-1px 0 0 0;
	text-transform:capitalize;
	border:solid 1px <?php echo $color_button_bg; ?>
}
<?php } ?>
#content input.submit {
	padding:5px 8px;
	overflow:hidden;
	width:auto;
}
input.submit:hover {
	color: #fff !important;
}
.mobile #content, #menu li, #head a, #nav a, #sidemenu a, input, textarea {
	/*
	-webkit-appearance:none;
	*/
	border-radius:.3em;
	-moz-border-radius:.3em;
	-webkit-border-radius:.3em
}
/* .mobile input */
input[type='submit'],
input[type='search'] {
	-webkit-appearance:none;
}
#head a, .mobile #nav a, #sidemenu a, input.submit, input.submit:hover {
	cursor:pointer;
	color:<?php echo $color_button_link; ?>;
	background:<?php echo $color_button_bg; ?>;
	padding:5px 8px;
	text-decoration:none;
	border:1px solid <?php echo $color_button_border; ?>;
<?php if($color_button_opacity == 'semiopaque'){ ?>
	background:-moz-linear-gradient(top,rgba(<?php echo $color_button_bg_rgb; ?>,0.6) 10%,rgba(<?php echo $color_button_bg_rgb; ?>,0.9) 80%);
	background:-webkit-gradient(linear,left top,left bottom,color-stop(0.10,rgba(<?php echo $color_button_bg_rgb; ?>,0.6)),color-stop(0.80,rgba(<?php echo $color_button_bg_rgb; ?>,0.9)))
<?php } else { ?>
	background:<?php echo $color_button_bg_rgb; ?>
<?php } ?>
}
.mobile #nav ul, #sidemenu {
	text-align:left;
	list-style:none;
	padding:.5em;
	margin:0
}
.mobile #nav a, .mobile #sidemenu a {
	position:relative;
	display:block;
	padding:.6em 1.8em .6em .8em;
	margin:0 0 0.5em 0;
	text-decoration:none;
	font-size:110%;
	color:<?php echo $color_button_link; ?>;
    white-space:nowrap !important;
    text-overflow:ellipsis;
    overflow:hidden !important;
}
.mobile #nav a:after, #sidemenu a:after {
	content:"\203A";
	color:<?php echo $color_button_link; ?>;
    position:absolute;
    right:0.4em;
	font-family:arial;
	font-size:160%;
	margin:-0.26em 0;

}
#content img {
	max-width:100%;
	height:auto;
	border:none
}
#content .more {
	clear:both
}
#content ul, #content ol {
	margin-bottom:0;
	margin-left:1.2em;
	margin-top:0;
	padding:0 0 1em 0
}
#content ol {
	margin-left:2em
}
#content ul ul, #content ol ul {
	list-style:disc;
	margin:0 0 0 1em;
	padding:0.5em 0 0 0
}
#content li {
	padding:.3em
}
#top > h2, #top > h3 {
	margin-top:.5em
}
h2, li h3, .h2 {
	font-size:120%;
	font-weight:normal
}
li h3 {
	font-size:140%
}
body {
	font-size:100%
}
#content ul.open, #content ul.closed {
	list-style:none;
	margin:0 0 1em -5px;
	line-height:1em;
}
#content ul.open li, #content ul.closed li {
	margin:0 0 -0.4em 0;
}
.open h3, .closed h3 {
	display:inline;
	padding:0;
	margin:0 0.3em 0 0;
	font-size:100%
}
.open:not(.legacy) span, .closed:not(.legacy) span {
	display:inline-block;
	position:relative;
	overflow:hidden;
	width:.3em;
	height:1em
}
.open:not(.legacy) span:before, .closed:not(.legacy) span:before {
	content:" - ";
	text-align:center
}
/*
#businessHours {
	line-height:1em;
}
#businessHours li {
	margin:0 0 -0.4em 0;
}
#businessHours li span {
	margin: -0.4em 0; top: -0.2em;
}
*/
#top ul#sidemenu {
	padding:0 0 1em 2em;
	margin:0
}
#footer ul#sidemenu {
	padding:0 0 1em 0;
	margin:0 0.5em;
}
#excerpts li {
	margin:0 0 1em 0
}
#excerpts:not(.legacy) {
	float:none;
	position:relative;
	clear:both;
	overflow:hidden
}
.feed, .year {
	clear:both;
	margin-bottom:1em
}
li h2 {
	margin:0 0 -10px 0;
	padding:0;
	line-height:0
}
html:root li[data-date] > h2, html:root li[data-date] div > h2, html:root li[data-date] > h3, html:root li[data-date] div > h3 {
	line-height:normal;
	margin-bottom:-5px !important
}
.archived li {
	margin-bottom:1em
}
html:root li[data-date] div {
	margin-top:-1em !important
}
html:root li[data-date]:before {
	content:attr(data-date) "";
	position:relative;
	min-width:2em;
	margin:0 .6em 0 -2em;
	top:.2em;
	background:#ffffff;
	font-weight:normal;
	font-size:80%;
	float:left
}
html:root li[data-date] {
	float:none;
	position:relative;
	clear:both
}
html:root li[data-date] div {
	float:left;
	position:relative;
	overflow:hidden;
	margin:0 0 1em 0
}
html:root li[data-date] div h2, html:root li[data-date] div h3 {
	position:relative;
	padding:0;
	margin:-0.1em 0 0 0
}
html:root li[data-date] div h2 a, html:root li[data-date] div h3 a {
	position:relative;
	display:block;
	top:-2px
}
html:root li[data-date] div p {
	padding:0;
	margin:0
}
html:root .year li[data-date] div {
	margin-bottom:-1em !important
}
blockquote[data-cite]:after {
	content:attr(data-cite) "";
	position:relative;
	display:block;
	min-width:2em;
	color:<?php echo $color_main_text; ?>
}
#legal {
	font-size:80%;
	list-style:none;
	padding:1em 0;
	margin:0 .75em .5em .75em;
	border-top:solid 1px <?php echo $color_body_border; ?>;
	border-bottom:solid 1px <?php echo $color_body_border; ?>
}
#legal a {
	white-space:nowrap;
	margin:0;
	padding:0;
}
#legal li {
	display:inline;
	margin:0;
	padding:0.3em 0.55em;
}
thead td, th {
	font-weight:bold
}
.address {
	margin-bottom:1em
}
.schema span {
	display:block
}
#content ul.setThumbs {
	position:relative;
	list-style:none;
	padding:0 0 .1em 0;
	margin:0 0 0 -1em;
	text-align:center;
	overflow:hidden;
}
#content ul.setThumbs li {
	float:left;
	overflow:hidden;
	margin:0 0 .75em 1em;
	padding:0
}

#content .staff {
	position:relative;
	list-style:none;
	padding:0;
	margin:0 0 1em 0;
}
#content .staff li {
	padding:0;
	margin:0 0 1em 0;
}
.staff span {
	display:block;
	position:relative;
	overflow:hidden;
	text-indent:-0.6em;
}
.staff p {
	padding:0;
	margin:0;
}
.staff span.name {
	text-indent:0;
}
.regulations #content .staff li {
	padding:0;
	margin:0 0 1em 0;
}
.privacy #content .address,
.regulations #content p.address,
.regulations #content .staff li {
	border-left:solid 1px #ccc;
	padding-left:1em;
}
#content .address .address {
	border-left:none;
	padding-left:0;
}
.privacy #content .address .itemaddress {
	margin-left:-6px;
	padding-bottom:0;
}
.privacy #content .address .itememail {
	margin-bottom:0;
}
.regulations #content .staff,
.regulations #content p.address {
	margin-top:0.5em !important;
}



/* Support for li box classes */
#content ul.boxes,
#content ul.boxesx2,
#content ul.boxesx3,
#content ul.boxesx4 {
	list-style: none;
	padding: 0;
	position: relative;
	overflow: hidden;
}
#content ul.boxes li,
#content ul.boxesx2 li,
#content ul.boxesx3 li,
#content ul.boxesx4 li {
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	border: solid 1px #ccc;
	padding: 1em;
	margin: 0 0 2% 0;
	float: left;
}
#content ul.boxesx3 > li:nth-child(3n+1),
#content ul.boxesx4 > li:nth-child(4n+1) {
	clear: both;
}
.mobile #content ul.boxesx3 > li:nth-child(3n+1),
.mobile #content ul.boxesx4 > li:nth-child(4n+1) {
	clear: none;
}
#content ul.boxesx2,
#content ul.boxesx4,
.mobile #content ul.boxesx3,
.mobile #content ul.boxesx4 {
	margin: 0 0 0 -2%;
	width: 102%;
}
#content ul.boxesx2 li,
.mobile #content ul.boxesx3 li,
.mobile #content ul.boxesx4 li {
	margin: 0 0 2% 2%;
	width: 48%;
}
#content ul.boxesx3 {
	margin: 0 0 3.3% -3.3%;
	width: 103%;
}
#content ul.boxesx3 li {
	margin: 0 0 3.3% 3.3%;
	width: 30%;
}
#content ul.boxesx4 li {
	margin: 0 0 2% 2%;
	width: 23%;
}

#accessibility-go,
#cookie-go {
	display: none;
}


/* Handle announcements */
#announcements {
    text-overflow: ellipsis;
}


/* Handle images that need caching */
#cache {
	position: absolute;
	width: 1em;
	height: 1em;
	overflow: hidden;
}
#cache img {
	position: absolute;
	left: 1em;
}


/* Contact page buttons */
.mobile .group .phone,
.mobile .group .email {
	position: relative;
	overflow: hidden;
	float: left;
	width: 49%;
	padding: 0;
	margin: 0 1% 1em 0;
	font-size: 0.5em;
	height: 5em;
	line-height: 0;
	word-break: break-all;
	word-wrap: break-word;
	border-radius:.5em;
	-moz-border-radius:.5em;
	-webkit-border-radius:.5em;
}
.mobile .group .email {
	margin: 0 0 1em0 1%;
}
.mobile .group .phone a,
.mobile .group .email a {
	position: absolute;
	top: 0 !important;
	left: 0;
	z-index: 2;
	background: <?php echo $color_button_bg; ?>;
	color: #fff !important;
	margin: 0 0 0 0 !important;
	padding: 1.5em 0 !important;
	line-height: 0;
	width: 100%;
	overflow: hidden;
	height: 2em;
}
.mobile .group .phone a:before {
	content: 'Call';
	display: block;
	margin: 0 0 1.5em 0 !important;
	padding: 0.3em 0.5em;
	font-size: 3em;
	line-height: 0;
}
.mobile .group .email a:before {
	content: 'Email';
	display: block;
	margin: 0 0 1.5em 0 !important;
	padding: 0.3em 0.5em;
	font-size: 3em;
	line-height: 0;
}
.mobile .group .phone a:after,
.mobile .group .email a:after {
	content: "\203A";
	position: absolute;
	top: 0.47em;
	left: 85%;
	font-size: 4em;
	line-height: 0;
}


/* Landscape Mobile */
@media only screen and (min-width: 510px) and (max-width: 629px) {
.mobile #content ul.boxesx3,
.mobile #content ul.boxesx4 {
	margin: 0 0 3.3% -3.3%;
	width: 103%;
}
#content ul.boxesx2 li,
.mobile #content ul.boxesx3 li,
.mobile #content ul.boxesx4 li {
	margin: 0 0 3.3% 3.3%;
	width: 30%;
}
}


/* TO DO: Check if responsive non-mobile map will use link instead of embed */
/* Handled from googlemap plugin */ 
/*
.js #googlemap-print {
	display: none;
}
*/



/*
@media all and (min-width:1920px) {
	#top {
		zoom:120%;
	}
}
@media all and (min-width:2560px) {
	#top {
		zoom:140%;
	}
}
*/




<?php 
/* Simple Banners Support */
if(Plugin::isEnabled('simple_banners') == true && function_exists('updateMobileCSS')){
	simplebannerCSS();
}
?>




/* iPhone */
@media only screen and max-device-width 480px {
	#menu img {
		width:15px;
		height:auto;
	}
}

/* iPhone 4 */
@media only screen and max-device-width 480px and -webkit-min-device-pixel-ratio 2 {
	body {
		font-size:91%;
	}
	
	#menu img {
		width:15px;
		height:auto;
	}
}

/* iPad */
@media only screen and min-device-width 768px and max-device-width 1024px {
	#menu img {
		width:50%;
		height:auto;
	}
}





/* Portrait
@media screen and (orientation: portrait){
}
*/

/* Landscape
@media screen and (orientation: landscape){
}
*/





/* LARGE SCREENS
@media only screen  and (min-width: 1824px) {
}
*/





/* DESKTOPS and LAPTOPS
@media only screen  and (min-width: 1224px) {
}
*/





/* IPAD All inc Retina
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
}
*/

/* IPAD 3
@media only screen and (min-device-width:768px) and (max-device-width:1024px) and (-webkit-min-device-pixel-ratio:1.5){
}
*/

/* IPAD 2
@media only screen and (min-device-width:768px) and (max-device-width:1024px) and (-webkit-max-device-pixel-ratio:1.5){
}
*/

/* IPAD Retina
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) {
}
*/

/* IPAD Mini
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 1) {
}
*/






/* IPHONE 6 PLUS
@media only screen and (min-device-width: 414px) and (max-device-width: 736px) {
}
*/

/* IPHONE 6
@media only screen and (min-device-width: 375px) and (max-device-width: 667px) {
}
*/

/* IPHONE 5
@media only screen and (min-device-width: 320px) and (max-device-width: 568px) {
}
*/

/* IPHONE 4
@media only screen and (-webkit-min-device-pixel-ratio: 2) and (max-device-width: 480px){
}
*/

/* IPHONE 3
@media only screen and (min-device-width: 320px) and (max-device-width: 480px) and (-webkit-max-device-pixel-ratio: 1.5){
}
*/

/* IPHONE
@media only screen and (max-device-width: 480px){
}
*/






/* RETINA Device
@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and ( min--moz-device-pixel-ratio: 2), only screen and ( -o-min-device-pixel-ratio: 2/1), only screen and ( min-device-pixel-ratio: 2), only screen and ( min-resolution: 192dpi), only screen and ( min-resolution: 2dppx) {
}
*/

/* Smartphones
@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
}
*/




<?php echo $customcss; ?>