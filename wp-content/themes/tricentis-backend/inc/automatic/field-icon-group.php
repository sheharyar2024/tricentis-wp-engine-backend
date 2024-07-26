<?php

class TricentisBackendIconGroupField{
	/**
	 * display icon group fields
	 * @param string $field_name Field group name
	 * @param array $params additional display parameters as noted below
	 */
	public static function display( $field_name = 'icon', $params = [] ){

		$params += [
			'id' => false,
		];
		while( have_rows( $field_name, $params['id'] ) ):
			the_row();
			include( get_template_directory().'/partials/icon-group.php' );
		endwhile;

	}
}