<?php
/**
 * This post type is used to run the authors module
 * Default assumes that all fields are added through ACF
 */
new TricentisBackendCPT_Authors();

class TricentisBackendCPT_Authors extends TricentisBackendCPT_Prototype{
	protected $key = 'author';
	protected $label = 'Author';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => false,
		"query_var" => false,
		'show_in_rest' => true,
		'show_in_graphql' => true,
		'graphql_single_name' => 'author',
		'graphql_plural_name' => 'authors',
		'menu_icon' => 'dashicons-welcome-learn-more',
		"supports" => [
			"title",
			"thumbnail",
		]
	];

}
