/* Create toggle link */
var link = document.createElement('a');
link.setAttribute('href', '#nav');
link.innerHTML = 'Menu';
link.setAttribute('id', 'toggle');
document.getElementById('head').insertBefore(link, document.getElementById('head').firstChild);

/* Move nav to top of body */
<?php if($navpos == 'top'){ ?>document.body.insertBefore(document.getElementById('nav'), document.body.firstChild);<?php } ?>
<?php if($navpos == 'header'){ ?>document.getElementById('head').parentNode.insertBefore(document.getElementById('nav'), document.getElementById('head').nextSibling);<?php } ?>

/* Move logo to top of head */
document.getElementById('head').insertBefore(document.getElementById('logo'), document.getElementById('head').firstChild);

var navigation = responsiveNav("#nav", {customToggle: "#toggle"});