var imglist = new Array (
"<h2>Slice1</h2><p>This slideshow will use a fade effect to fade out and in between holders.</p><p>This Example is a part of the Article.</p>",
"<h2>Slice2</h2><p>This slideshow will use a fade effect to fade out and in between holders.</p>",
"<h2>Slice3</h2><p>This Example is a part of the Article.</p>",
"<h2>Slice4</h2><p>This Example is part of the Article too.</p>"
)

var groupnum = 2;
var groupreset = 0;
var html = "";
var mystyle = '';
for (var i=0;i<imglist.length;i++){
	// Hide all but first group
	//if(i == groupnum){ mystyle = " style='display:none'"; }

	if(groupreset == 0){ html += "<div class='group'" + mystyle + ">"; }
	groupreset++;
	html += "<blockquote id='slice" + i + "'>";
	html += imglist[i];
	html += "</blockquote>";
	if(groupreset == groupnum){ html += "</div>"; groupreset = 0; }
}
document.getElementById("slideshow").innerHTML = html;




var holder = document.getElementById("slideshow");
var element = 'div'; /* .class or data- or tag */
//var element = '.group'; /* .class or data- or tag */
if(element.substring(0, 1) == "."){
	divs = holder.getElementsByClassName(element.slice(1));
} else {
	divs = holder.getElementsByTagName(element);
};
var total = divs.length;
var duration = 1000; /* fade duration in millisecond */
var hidetime = duration / 10; /* time to stay hidden */
var showtime = 3000; /* time to stay visible */

var running = 0 /* Used to check if fade is running */
var iEcount = 0 /* Element Counter */

//var iTotalE = holder.getElementsByTagName('div').length;

document.getElementsByClassName = function(cl) {
	var retnode = [];
	var myclass = new RegExp('\\b'+cl+'\\b');
	var elem = this.getElementsByTagName('*');
	for (var i = 0; i < elem.length; i++) {
		var classes = elem[i].className;
		if (myclass.test(classes)){
			retnode.push(elem[i]);
		}
	}
	return retnode;
};

function SetOpa(Opa) {
	holder.style.opacity = Opa;
	holder.style.MozOpacity = Opa;
	holder.style.KhtmlOpacity = Opa;
	holder.style.filter = 'alpha(opacity=' + (Opa * 100) + ');';
};

function StartFade() {
	if (running != 1) {
	running = 1;
	var i;
	for ( i = 0; i < total; i++ ) {
		if(i == 0){
			divs[i].style.display = "block";
		} else {
			divs[i].style.display = "none";
		}
	}
	setTimeout("fadeOut()", showtime);
	}
};

function fadeOut() {
	for (i = 0; i <= 1; i += 0.01) {
		setTimeout("SetOpa(" + (1 - i) +")", i * duration);
	}
	setTimeout("FadeIn()", (duration + hidetime));
};

function FadeIn() {
	for (i = 0; i <= 1; i += 0.01) {
		setTimeout("SetOpa(" + i +")", i * duration);
	}
	if (iEcount == total - 1) {
		iEcount = 0;
		for (i = 0; i < total; i++ ) {
			if(i == iEcount){
				divs[iEcount].style.display = "block";
			} else {
				divs[i].style.display = "none";
			}
		}
	 } else {
		for (i = 0; i < total; i++ ) {
			if(i == 0){
				divs[iEcount + 1].style.display = "block";
			} else {
				divs[iEcount].style.display = "none";
			}
		}
		iEcount = iEcount+1;
	}
	setTimeout("fadeOut()", (duration + showtime));
};
StartFade();