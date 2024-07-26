<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_Events();

class TricentisBackendCPT_Events extends TricentisBackendCPT_Prototype{
	protected $key = 'events';
	protected $label = 'Events';
	protected $plural_label = 'Events';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => array('slug' => 'events','with_front' => false),
		"query_var" => false,
		'menu_icon' => 'dashicons-rss',
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'graphql_single_name' => 'event',
		'graphql_plural_name' => 'events',
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
