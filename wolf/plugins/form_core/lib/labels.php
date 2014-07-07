<?php

$labels_size = count($labels);
for($i=0; $i < $labels_size; $i++){
	$class = $labels[$i].'_class';
	$$class = $class;
	if($formclass == ' small'){
		if (stristr($$class,'class=')) {
			$$class = str_replace('class="','class="tooltip ',$$class);
		} else { 
			$$class = ' class="tooltip"';
		}
	} else {
		$$class = '';
	}
}

?>