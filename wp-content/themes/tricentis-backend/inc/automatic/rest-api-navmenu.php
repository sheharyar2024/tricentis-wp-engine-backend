<?php
/**
 * This code will extend Rest API for NavMenu plugin
 */
if ( is_plugin_active('wp-rest-api-v2-menus/wp-rest-api-v2-menus.php' ) ) {
	function wp_api_v2_menus__locale_info( $menu ) {
		$menu_id = $menu->items[0]->ID;
		$language_details = apply_filters( 'wpml_post_language_details', NULL, $menu_id );
		if(!empty($language_details))
			$menu->locale_info = $language_details;

		
		$nav_menu_term_id = apply_filters( 'wpml_object_id', $menu->term_id, 'nav_menu', FALSE, 'en' );
		$menu_locations = get_nav_menu_locations();
		if ( ! empty( $menu_locations ) && in_array( $nav_menu_term_id, $menu_locations, true ) ) {
			$location_key = array_search($nav_menu_term_id, $menu_locations);
			if(!empty($location_key))
				$menu->location_info = $location_key;
		}

		return $menu;
	}
	add_filter( 'wp_api_v2_menus__menu', 'wp_api_v2_menus__locale_info' );
}
