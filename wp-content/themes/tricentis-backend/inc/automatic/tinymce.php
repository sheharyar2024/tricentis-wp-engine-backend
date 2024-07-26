<?php

add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );

function tiny_mce_remove_unused_formats($init) {

	$init['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;Code=code;';
	
	return $init;
}

