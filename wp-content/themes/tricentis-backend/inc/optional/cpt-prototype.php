<?php

/**
 * Pass excerpt through appropriate post type excerpt filter 
 * originally, in the prototype class, but that means an excerpt goes through every post type's filters 
 * moved outside so only goes through filter of matching post type
 */
add_filter( 'get_the_excerpt', 'narwhal_post_type_excerpt', 20, 2 );
function narwhal_post_type_excerpt( $excerpt, $post ){
	$post_type = get_post_type( $post );
	return apply_filters( "tricentis-backend/{$post_type}/excerpt", $excerpt, $post );
}

class TricentisBackendCPT_Prototype{
	protected $key = '';
	protected $label = '';
	protected $plural_label = '';
	protected $registration = [];

	function __construct(){
		if( '' === $this->key ){
			error_log( get_class( $this ) . ' does not have a valid key defined.' );
			return;
		}

		if( $this->plural_label === '' ){
			$this->plural_label = $this->label . 's';
		}

		add_action( 'init', [ $this, 'register_cpt' ] );

		add_filter( "tricentis-backend/{$this->key}/card-label", [ $this, 'front_end_label' ] );
		add_filter( "tricentis-backend/hero/{$this->key}/prehead", [ $this, 'front_end_label' ] );
		add_filter( "tricentis-backend/modules/{$this->key}/default-value", [ $this, 'module_default_value' ], 20, 2 );
	}

	/**
	 * This is the label that is used on the front end when describing this post type
	 * Usually used in a card meta area or detail page
	 */
	function front_end_label(){
		return __( $this->label, "tricentis-backend" );
	}

	/**
	 * General function to override ACF values in modules for custom post types 
	 */
	function module_default_value( $default, $field ){
		switch( $field['name'] ){
			case 'related_resources_allow_featured':
				return 0;
			break;
			case 'related_resources_allowed_types':
				return [ $this->post_type ];
			break;
			case 'related_resources_cta':
				$resources_url = get_post_type_archive_link( $this->post_type );
				return [
					'url' => add_query_arg( 'type', $this->post_type, $resources_url ) . '#ResourceArchive',
					'title' => sprintf( __( 'See All %s', 'tricentis-backend' ), $this->post_type_obj->labels->name ),
				];
			break;
		}
		return $default;
	}

	/**
	* Register the post type with wp. Defaults are found here, but these items can be overwritten using class registration variable or by rewriting the whole method 
	*/
	function register_cpt() {

		$labels = [
			"name" => __( $this->plural_label, "tricentis-backend" ),
			"singular_name" => __( $this->label, "tricentis-backend" ),
		];

		$args = $this->registration += [
			"label" => __( $this->plural_label, "tricentis-backend" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"delete_with_user" => false,
			"show_in_rest" => false,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => true,
			"query_var" => true,
			"menu_icon" => "dashicons-admin-post",
			"supports" => [
				"title",
				"thumbnail",
			]
		];

		register_post_type( $this->key, $args );
	}
}