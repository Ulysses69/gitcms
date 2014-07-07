$j(document).ready(function() {

	//
	// Enabling Heading Toggle
	//

	$j("legend").each(function() {
	  	//alert('wrap in div');
	    $j(this).parent().wrapInner("<div>");
	    $j(this).appendTo($j(this).parent().parent());
	});

	$j("legend").click(function() {
		//alert('toggle');
	    $j(this).parent().find("div").toggle();
	});


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