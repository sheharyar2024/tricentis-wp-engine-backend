<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_Testimonials();

class TricentisBackendCPT_Testimonials extends TricentisBackendCPT_Prototype{
	protected $key = 'testimonial';
	protected $label = 'Testimonial';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => false,
		"query_var" => false,
		'menu_icon' => 'dashicons-testimonial',
		'show_in_rest' => true,
		'show_in_graphql' => true,
		'hierarchical' => true,
		'graphql_single_name' => 'testimonial',
		'graphql_plural_name' => 'testimonials',
		"supports" => [
			"title",
			"page-attributes",
		]
	];

}
