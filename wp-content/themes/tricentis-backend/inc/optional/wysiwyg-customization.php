<?php

/**
 * Customize individual parts of the tinymce wysiwyg across the board
 */

TricentisBackendTinyMCE();

class TricentisBackendTinyMCE{

	function __construct(){
		//add_filter( 'tiny_mce_before_init', [ $this, 'change_font_colors' ], 20 );
		//add_filter( 'tiny_mce_before_init', [ $this, 'change_font_sizes' ], 20 );
	}

	function change_font_colors( $init ) {

		$default_colours = '
			"000000", "Black",
			"FFFFFF", "White"
		';

		$custom_colours = '
			"181818", "Gray Dark",
			"FBFBFA", "Gray Light",
			"039E49", "Green",
			"026738", "Green Dark",
			"8BC740", "Green Lime",
			"F9AA1F", "Orange"
		';

		$init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']';
		$init['textcolor_rows'] = 6; // expand colour grid to 6 rows

		return $init;
	}

	function change_font_sizes( $init ){
		$init['fontsize_formats'] = "10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px";
		return $init;
	}

}
