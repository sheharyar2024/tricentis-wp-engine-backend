<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_Faqs();

class TricentisBackendCPT_Faqs extends TricentisBackendCPT_Prototype{
	protected $key = 'faq';
	protected $label = 'FAQ';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => false,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => false,
		"query_var" => false,
		//'menu_icon' => 'dashicons-faqs',
		'show_in_graphql' => true,
		'hierarchical' => true,
		'graphql_single_name' => 'faq',
		'graphql_plural_name' => 'faqs',
		"supports" => [
			"title",
			"page-attributes",
		]
	];

}
