/* CMS-Generated Update October 8, 2015, 7:48 am */

/* Check if browser is DOM and HTML5 Savvy */ 
if ('querySelectorAll' in document && 'addEventListener' in window) { 

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
		}
		for(var i =0; i < inputs.length; i++){
			inputs[i].onmousedown = findClick;
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

	// Wrap element with new element
	/*
	function wrap(el, wrapper) {
	    el.parentNode.insertBefore(wrapper, el);
	    wrapper.appendChild(el);
	}
	*/

	// Set global vars
	window.activeslide = 0;
	window.slidecount = 0;
	window.sliders;
	window.slidesHolder;
	window.polaroids;
	window.slides;
	window.spandepth;
	window.spans;
	window.img;

	function setSlide(){
		if(this.text == '&lsaquo;'){
			activeslide--;
		} else {
			activeslide++;
		}
		if(activeslide < 0){
			activeslide = slidecount - 1;
		}
		if(activeslide == slidecount){
			activeslide = 0;
		}	
		for(var p = 0; p < slidecount; p++){
			slides[p].className = '';
		}
		// Set selected div class to active and increase depth
		slides[activeslide].className = 'active';		
		slides[activeslide].style.zIndex = spandepth;
		setSpans();
	};

	function setSpans(){
		for(var s = 0; s < spans.length; s++){
		    spans[s].style.zIndex = spandepth++;
		    spans[s].onclick = setSlide;
		}
	};

	function imageHasLoaded(){
		// Convert ratio to percentage and divide height by number of images side by side
		var percent = Math.floor((img.height / img.width) * 100) / 2;

		// Add padding to slidesHolder using percentage, adding extra for polaroids
		slidesHolder.style.paddingBottom = percent + "%";
		polaroids = document.getElementsByClassName('slider polaroids');
		if(polaroids[0]){
			polaroids[0].style.paddingBottom = (percent + 3) + "%";
		}

		// Number of div items
		slides = slidesHolder.getElementsByTagName('div');
		slides[0].className = 'active';
		slidecount = slides.length;

		// Create spans
		if(slidecount > 1){
			slidesHolder.appendChild((((t = document.createElement('span')).className='prev'),t)).innerHTML = '&lsaquo;';
			slidesHolder.appendChild((((t = document.createElement('span')).className='next'),t)).innerHTML = '&rsaquo;';
			spandepth = slidecount + 2;
			for(var i = 0; i < slidecount; i++){
			    slidesHolder.getElementsByTagName('div')[i].style.zIndex = spandepth - i;
			}
			spans = slidesHolder.getElementsByTagName('span');
			setSpans();	
		}

		//wrap(slidesHolder.getElementsByTagName('img'), document.createElement('span'));

	};

	// Get image ratio from loading first slide image
	sliders = document.querySelectorAll('.slider');
	if(sliders[0]){
		slidesHolder = sliders[0];
		img = slidesHolder.getElementsByTagName('img')[0];
		src = img.src;
	    var image = new Image();
	    image.onload = function() {        
			imageHasLoaded();
	    };
	    image.src = src;
	};
	


				    var bannerHolder = 'banner';
				    var bannerPath = '/public/images/banner/';
				    var bannerSpeed = 3;
				    var bannerTransition = 0.5;
				    var banner = document.getElementById(bannerHolder);
				    var banners = '';
				    
				    if (banner){
				
						function hasClass(el = '', cls = '') {
							return el.className && new RegExp('(\s|^)' + cls + '(\s|$)').test(el.className);
						};
				
					var homeBanners = ['bridge.jpg','castle.jpg','cherry-blossom-pink-flowers-3.jpg','dolphin.jpg','egypt.jpg','jellyfish.jpg','kitens.jpg','stones.jpg','waterfall.jpg','yellow-flower.jpg'];
								 if (hasClass(banner, 'home')) { banners = homeBanners; bannerPath = '/public/images/banner/'; };
					
					    banner.getElementsByTagName('img')[0].style.position = 'relative';
					    var j = banners.length;
					    var current = 0;
					    var imgs = [];
					
						for (var i = 0; i < j; i++){
						    var img = document.createElement('img');
						    img.src = bannerPath + banners[i];
						    banner.appendChild(img);
						    imgs.push(img);
					      	imgs[i].style.position = 'absolute';
						  	imgs[i].style.transition = 'opacity ' + bannerTransition + 's ease-in';
						    imgs[i].style.opacity = 0;
						};
					
						setInterval(function(){
						  for (var i = 0; i < j; i++) {
						    imgs[i].style.opacity = 0;
						  }
						  current = (current != j - 1) ? current + 1 : 0;
						  imgs[current].style.opacity = 1;
						}, (bannerSpeed * 1000));

						setTimeout(function(){
						    banner.getElementsByTagName('img')[0].style.opacity = 0;
						}, ((bannerSpeed * 2) * 1000));
						
					};
				};
			if(typeof(Shadowbox) !== 'undefined'){
				Shadowbox.init({
				overlayOpacity: 0.8
				}, setupScripts);
			};
			function setupScripts(){
				Shadowbox.setup('a.gallery-group', {
					gallery: 'Gallery',
					continuous: true,
					counterType: 'skip'
				});
			};

				
			var marquee = new Array("<p data-date='1 Nov'>Excerpt 4</p>", "<p data-date='30 Oct'>Excerpt 3.</p>", "<p data-date='25 Oct'>Excerpt 2.</p>", "<p data-date='22 Jul'>Excerpt 1.</p>");
	
				
			var groupnum = 2;
			var groupreset = 0;
			var html = "";
			var mystyle = '';
			for (var i=0;i<marquee.length;i++){
				if(groupreset == 0){ html += "<div class='group'" + mystyle + ">"; }
				groupreset++;
				html += "<blockquote id='slice" + i + "'>";
				html += marquee[i];
				html += "</blockquote>";
				if(groupreset == groupnum){ html += "</div>"; groupreset = 0; }
			}
			document.getElementById("testimonials").innerHTML = html;
	
			var holder = document.getElementById("testimonials");
			var element = 'div'; /* .class or data- or tag */
			if(element.substring(0, 1) == "."){
				divs = holder.getElementsByClassName(element.slice(1));
			} else {
				divs = holder.getElementsByTagName(element);
			};
			var total = divs.length;
			var duration = 500; /* fade duration in millisecond */
			var hidetime = duration / 10; /* time to stay hidden (between fadeout and fadein) */
			var showtime = 3000; /* time to stay visible */
			
			var running = 0; /* Used to check if fade is running */
			var iEcount = 0; /* Element Counter */
	
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

	
		




		