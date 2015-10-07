

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
			polaroids[0].style.paddingBottom = (percent + 5) + "%";
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
	

