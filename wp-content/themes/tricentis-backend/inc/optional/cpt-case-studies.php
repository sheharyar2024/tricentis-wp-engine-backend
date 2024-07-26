<?php
/**
 * This post type is used to run the team member tabber modules
 * Default assumes that all fields are added through ACF
 */
new TricentisBackendCPT_CustomerSuccess();

class TricentisBackendCPT_CustomerSuccess extends TricentisBackendCPT_Prototype{
	protected $key = 'case_study';
	protected $label = 'Case Study';
    protected $plural_label = 'Case Studies';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => false,
		"rewrite" => array('slug' => 'case-studies','with_front' => false),
		"query_var" => false,
		'menu_icon' => 'dashicons-groups',
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'graphql_single_name' => 'caseStudy',
		'graphql_plural_name' => 'caseStudies',
		"supports" => [
			"title",
			//"editor",
			"page-attributes",
			"thumbnail",
			"excerpt",
			"revisions",
		]
	];

}
