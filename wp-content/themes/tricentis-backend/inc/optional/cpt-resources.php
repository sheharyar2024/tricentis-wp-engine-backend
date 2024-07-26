<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_Resources();

class TricentisBackendCPT_Resources extends TricentisBackendCPT_Prototype{
	protected $key = 'resource';
	protected $label = 'Resource';
	protected $plural_label = 'Resources';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"rewrite" => array('slug' => 'resources','with_front' => false),
		"query_var" => false,
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'graphql_single_name' => 'resource',
		'graphql_plural_name' => 'resources',
			"supports" => [
				"title",
				"page-attributes",
				"excerpt",
                "editor",
				"revisions",
				"thumbnail",
			]
	];

}
