<?php

/**
 * Support: Background Options Helpers
 */
class TricentisBackendBackgroundOptionsField{

	/**
	 * Determine classes to pass to module for background
	 * @param string $field_name Field group name
	 * @param array $params additional display parameters as noted below
	 */
	public static function classes( $field_name = 'background', $params = [] ){
		$params += [
			'id' => false,
		];
		$ret = [];
	
		while( have_rows( $field_name, $params['id'] ) ):
			the_row();
			switch( get_sub_field( 'type' ) ){
				case 'color':
					while( have_rows( 'bkgc', $params['id'] ) ):
						the_row();
						$ret[] = 'has-background--' . get_sub_field( 'color');
					endwhile;
				break;
				case 'image':
					$ret[] = 'has-background--image';
				break;
				case 'video':
					$ret[] = 'has-background--video';
				break;
			}
		endwhile;
		return implode( ' ', $ret );
	}

	/**
	 * display a background
	 * @param string $field_name Field group name
	 * @param array $params additional display parameters as noted below
	 */
	public static function display( $field_name = 'background', $params = [] ){
		$params += [
			'id' => false,
		];

		while( have_rows( $field_name, $params['id'] ) ):
			the_row();
			get_template_part( 'template-parts/backgrounds/background', get_sub_field( 'type' ) );
		endwhile;
	}
}