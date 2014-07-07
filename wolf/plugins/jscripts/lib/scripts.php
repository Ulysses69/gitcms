/* Add js class to document */
document.getElementsByTagName('body')[0].className+=' js';

var links = document.links;
var inputs = document.getElementsByTagName('input');

function hasClass(ele,cls) {
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
};

function addClass(ele,cls) {
	if (!this.hasClass(ele,cls)) ele.className += " "+cls;
};

function removeClass(ele,cls){
	if (hasClass(ele,cls)) {
		var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
		ele.className=ele.className.replace(reg,' ');
	}
};

function assignClickEvent(){
	for(var i =0; i < links.length; i++){
		links[i].onmousedown = findClick;
		//alert(links[i].nodeName);
	}
	for(var i =0; i < inputs.length; i++){
		inputs[i].onmousedown = findClick;
		//alert(inputs[i].nodeName);
	}
};

function findClick(e) {
	for(var i=0; i < links.length; i++){
		links[i] == this ? addClass(links[i],'click') : removeClass(links[i],'click');
	}
	for(var i=0; i < inputs.length; i++){
		inputs[i] == this ? addClass(inputs[i],'click') : removeClass(inputs[i],'click');
	}
};

assignClickEvent();
