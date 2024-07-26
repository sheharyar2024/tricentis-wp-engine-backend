<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_ExploreProducts();

class TricentisBackendCPT_ExploreProducts extends TricentisBackendCPT_Prototype{
	protected $key = 'explore_products';
	protected $label = 'Explore Product';
	protected $plural_label = 'Explore Products';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => array('slug' => 'explore-products','with_front' => false),
		"query_var" => false,
		'menu_icon' => 'dashicons-feedback',
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'graphql_single_name' => 'explore_product',
		'graphql_plural_name' => 'explore_products',
		"supports" => [
			"title",
			"editor",
			"page-attributes",
			"excerpt",
			"revisions",
			"thumbnail"
		]
	];

}
