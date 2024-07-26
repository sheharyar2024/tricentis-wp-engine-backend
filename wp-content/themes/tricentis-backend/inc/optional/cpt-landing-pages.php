<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_LandingPages();

class TricentisBackendCPT_LandingPages extends TricentisBackendCPT_Prototype{
	protected $key = 'landing_pages';
	protected $label = 'Campaign Landing Page';
	protected $plural_label = 'Campaign Landing pages';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => array('slug' => 'lp','with_front' => false),
		"query_var" => false,
		'menu_icon' => 'dashicons-megaphone',
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'graphql_single_name' => 'landingpage',
		'graphql_plural_name' => 'landingpages',
		"supports" => [
			"title",
			"page-attributes",
			"revisions",
		]
	];

}
