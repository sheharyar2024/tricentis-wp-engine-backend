<?php
new TricentisBackendLearnTypeTaxonomy();

class TricentisBackendLearnTypeTaxonomy{
	function __construct(){
		add_action( 'init', [ $this, 'register' ] );
	}

	function register(){
		$args = [
			'labels' => [
				'name' => 'Learn Types',
				'singular_name' => 'Learn Type',
			],
			'description' => __( '', 'tricentis-backend' ),
			'public' => true,
			'publicly_queryable' => false,
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'show_in_rest' => true,
			'show_in_graphql' => true,
			'hierarchical' => true,
			'graphql_single_name' => 'learntype',
			'graphql_plural_name' => 'learntypes',
			'show_tagcloud' => false,
			'show_admin_column' => true,
			'rewrite' => false,
		];

		register_taxonomy( 'learntype', [
			'learn',
		 ], $args );
	}
}
