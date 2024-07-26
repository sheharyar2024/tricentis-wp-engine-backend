<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_News();

class TricentisBackendCPT_News extends TricentisBackendCPT_Prototype{
	protected $key = 'news';
	protected $label = 'Company News';
	protected $plural_label = 'Company News';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => false,
		"rewrite" => array('slug' => 'news','with_front' => false),
		"query_var" => false,
		'menu_icon' => 'dashicons-rss',
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'graphql_single_name' => 'news',
		'graphql_plural_name' => 'news',
		"supports" => [
			"title",
			"editor",
			"page-attributes",
			"revisions",
			"excerpt",
		]
	];

}
