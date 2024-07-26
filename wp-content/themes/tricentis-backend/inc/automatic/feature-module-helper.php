<?php
/**
 * Helper functions for working with module components, these aren't necessary to use modules, but it keeps them uniform
 */
class TricentisBackendModuleHelper{

	/**
	 * keep track of what number of module we are on 
	 * important for modules that might need unique ids for identifiers or anchors
	 */
	protected static $count = 0;
	/**
	 * set the module counter to a particular number
	 */
	public static function set_count( $count = 0 ){
		self::$count = (int)$count;
	}
	/**
	 * get current module counter
	 */
	public static function get_count(){
		return self::$count;
	}

	/**
	 * Output a list of fixed modules 
	 * These would be set up following the ACF examples -> display field with a group which is a prefixed module 
	 */
	public static function fixed_modules( $modules, $params = [] ){
		$params += [];
		extract( $params );

		foreach( $modules as $field => $module ){
			self::fixed_module( $field, $module, $params );
		}
	}

	/**
	 * Output a singular fixed module, allows more control over individual parameters
	 */
	public static function fixed_module( $name, $module, $params = [] ){
		$params += [
			'display' => get_field( 'display_' . $name ),
			'module_id' => self::$count,
			'module_settings' => [],
		];
		extract( $params );

		if( $display && have_rows( $name ) ):
			while( have_rows( $name ) ): the_row();
				include( get_template_directory().'/partials/module-begin.php' );
				get_template_part( 'template-parts/modules/module', $module, [ 'module_id' => $module_id ] );
				include( get_template_directory().'/partials/module-end.php' );
			endwhile;
			$module_id++;
		endif;

		self::$count = $module_id;
	}

}