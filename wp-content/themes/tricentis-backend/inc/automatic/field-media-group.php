<?php

class TricentisBackendMediaGroupField{
	/**
	 * display media group
	 * @param string $field_name Field group name
	 * @param array $params additional display parameters as noted below
	 */
	public static function display( $field_name = 'media', $params = [] ){
		if( have_rows( $field_name ) ):
			while( have_rows( $field_name ) ):
				the_row();
				include( get_template_directory().'/partials/media-group.php' );
			endwhile;
		endif;
	}
}