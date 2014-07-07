
	jQuery(document).ready(function($) {
		$('#jquery_notice').hide();
		$('#token_placeholder').focus();
		$('.placeholder_link').click(function(){
			$('#token_placeholder').val($(this).html());
			$('#token_literal').val($(this).siblings('.literal').html());
			$.scrollTo('#token_form_anchor', 400);
			$('#token_literal').focus();
			return false;
		});
		$('.literal').click(function(){
			$('#token_placeholder').val($(this).siblings('.placeholder_link').html());
			$('#token_literal').val($(this).html());
			$.scrollTo('#token_form_anchor', 400);
			$('#token_literal').focus();
			return false;
		});
	});
