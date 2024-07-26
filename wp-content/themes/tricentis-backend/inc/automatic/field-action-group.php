<?php

/**
 * Support: Button Group field helpers
 * If you copied your fields correctly, you should have the correct setup which is a support field containing an alignment selection and button repeater
 * Each module should have a clone of that field in a group with an appropriate name - default is cta
 */
class TricentisBackendActionGroupField{
	/**
	 * determine if buttons are present in given context of ACF
	 * @param string $field_name Field group name
	 * @param array $params additional display parameters as noted below
	 */
	public static function present( $field_name = 'action_group', $params = [] ){
		$params += [
			'id' => false,
		];
		$ret = false;

		while( have_rows( $field_name, $params['id'] ) ):
			the_row();
			$actions = get_sub_field( 'actions' );
			if( is_array( $actions ) && count( $actions ) > 0 ){
				$ret = true;
			}
		endwhile;

		return $ret;
	}

	/**
	 * determine number of buttons to be displayed, useful for wrapping html or different functionality for 1 vs multiple buttons
	 * @param string $field_name Field group name
	 * @param array $params additional display parameters as noted below
	 */
	public static function count( $field_name = 'action_group', $params = [] ){
		$params += [
			'id' => false,
		];
		$ret = 0;
		while( have_rows( $field_name, $params['id'] ) ):
			the_row();
			$actions = get_sub_field( 'actions' );
			if( is_array( $actions ) ){
				$ret = count( $actions );
			}
		endwhile;

		return $ret;
	}

	/**
	 * display a group of buttons
	 * @param string $field_name Field group name
	 * @param array $params additional display parameters as noted below
	 */
	public static function display( $field_name = 'action_group', $params = [] ){
		$params += [
			'id' => false,
			'alignment' => '',
			'type' => '',
		];

		while( have_rows( $field_name, $params['id'] ) ):
			the_row();

			$alignment = ( '' != $params['alignment'] )? $params['alignment'] : get_sub_field( 'alignment' );
			$override_type = ( '' != $params['type'] )? $params['type'] : '';
			$actions = get_sub_field( 'actions' );

			if( is_array( $actions ) && count( $actions ) > 0 ){
				include( get_template_directory().'/partials/action-group.php' );
			}

		endwhile;
	}
}
