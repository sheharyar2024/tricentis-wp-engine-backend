<?php

class TricentisBackendFormField{
	/**
	 * display form field
	 * @param string $field_name Field group name
	 * @param array $params additional display parameters as noted below
	 */
	public static function display( $field_name = 'form', $params = [] ){
		if( have_rows( $field_name ) ):
			while( have_rows( $field_name ) ):
				the_row();
				include( get_template_directory().'/partials/form.php' );
			endwhile;
		endif;
	}
}