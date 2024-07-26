<?php
/**
 * This post type is used to run the team member tabber modules
 * Default assumes that all fields are added through ACF
 */
new TricentisBackendCPT_CustomerSuccess();

class TricentisBackendCPT_CustomerSuccess extends TricentisBackendCPT_Prototype{
	protected $key = 'customer_success';
	protected $label = 'Customer Success';
    protected $plural_label = 'Customer Success';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => false,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => false,
		"rewrite" => false,
		"query_var" => false,
		'menu_icon' => 'dashicons-groups',
		'show_in_graphql' => true,
		'hierarchical' => true,
		'graphql_single_name' => 'customerSuccess',
		'graphql_plural_name' => 'customerSuccessStories',
		"supports" => [
			"title",
			//"editor",
			"page-attributes",
			"thumbnail",
		]
	];

}
