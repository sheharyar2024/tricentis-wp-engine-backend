<?php
new TricentisBackendPartnerTypeTaxonomy();

class TricentisBackendPartnerTypeTaxonomy{
	function __construct(){
		add_action( 'init', [ $this, 'register' ] );
	}

	function register(){
		$args = [
			'labels' => [
				'name' => 'Partner Types',
				'singular_name' => 'Partner Type',
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
			'graphql_single_name' => 'partnertype',
			'graphql_plural_name' => 'partnertypes',
			'show_tagcloud' => false,
			'show_admin_column' => true,
			'rewrite' => false,
		];

		register_taxonomy( 'partnertype', [
			'partner',
		 ], $args );
	}
}
