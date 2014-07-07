$(function(){
	$('#part_0_content, #snippet_content, #layout_content, #file_content').each(function(){

		$this = $(this);

	    var myCodeMirror = CodeMirror.fromTextArea(
	        this,
	        {
	            mode: $this.hasClass('markdown')? 'gfm' : 'php',
	            matchBrackets: true,
	            lineWrapping: true
	        }
	    );
	});
});