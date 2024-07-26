<?php
/**
 * This post type is used to run the logo grid and logo slider modules
 * Default assumes that all fields are added through ACF
 */
new TricentisBackendCPT_Logos();

class TricentisBackendCPT_Logos extends TricentisBackendCPT_Prototype{
	protected $key = 'logo';
	protected $label = 'Logo';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => false,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => false,
		"query_var" => false,
		'menu_icon' => 'dashicons-share',
		'show_in_rest' => true,
		'show_in_graphql' => true,
		'hierarchical' => true,
		'graphql_single_name' => 'logo',
		'graphql_plural_name' => 'logos',
		"supports" => [
			"title",
			"page-attributes",
		]
	];

}
