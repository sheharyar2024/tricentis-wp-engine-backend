<?php
/**
 * This post type is used to run the learn module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_Learn();

class TricentisBackendCPT_Learn extends TricentisBackendCPT_Prototype{
	protected $key = 'learn';
	protected $label = 'Learn';
	protected $plural_label = 'Learn';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => array('slug' => 'learn','with_front' => false),
		"query_var" => false,
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'graphql_single_name' => 'learn',
		'menu_icon'   => 'dashicons-welcome-learn-more',
		'graphql_plural_name' => 'learn',
			"supports" => [
				"title",
				"page-attributes",
				"excerpt",
				"revisions",
				"thumbnail",
			]
	];

}
