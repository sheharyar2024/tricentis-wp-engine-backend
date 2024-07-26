<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_Forms();

class TricentisBackendCPT_Forms extends TricentisBackendCPT_Prototype{
	protected $key = 'form';
	protected $label = 'Form';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => false,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => false,
		"query_var" => false,
		'menu_icon' => 'dashicons-edit-page',
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => true,
		'graphql_single_name' => 'form',
		'graphql_plural_name' => 'forms',
		"supports" => [
			"title",
			"page-attributes",
		]
	];

}
