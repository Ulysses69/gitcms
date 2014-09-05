$j(document).ready(function() {

	//
	// Enabling Heading Toggle
	//

	$j("h2.group").each(function() {
		$j(this).parent().wrapInner("<div>");
		$j(this).appendTo($j(this).parent().parent());
		//$j(this).toggleClass('expand');
	});

	$j("h2.group").click(function() {
		$j(this).parent().find("div").toggle();
		$j(this).toggleClass('retracted');
	});

	// Hide on load
	$j(".styling h2.group").parent().find("div").toggle();
	$j(".styling h2.group").toggleClass('retracted');


	/*
	$j('legend table').hide();
	$j('legend').click(function() {
					$j(this).next().slideToggle('slow',function(){
							var id = $j(this).attr('id');
							var state;
							if ($j(this).is(':hidden')) {
								state = "closed";
							} else if ($j(this).is(':visible')) {
								state = "open";
							}
							$j.cookie(id, state);
							return false;
					 });  
	});
	
	$j('legend').each(function() {
		var id = $j(this).next().attr('id');
		if ($j.cookie(id) == "open")  $j(this).next().show();
	});
	*/





	//
	// Enabling miniColors
	//
	
	$j(".color-picker").miniColors({
		letterCase: 'uppercase',
		change: function(hex, rgb) {
			logData(hex, rgb);
		}
	});


});