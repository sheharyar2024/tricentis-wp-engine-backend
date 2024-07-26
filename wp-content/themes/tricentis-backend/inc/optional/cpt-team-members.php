<?php
/**
 * This post type is used to run the team member tabber modules
 * Default assumes that all fields are added through ACF
 */
new TricentisBackendCPT_TeamMembers();

class TricentisBackendCPT_TeamMembers extends TricentisBackendCPT_Prototype{
	protected $key = 'team_member';
	protected $label = 'Team Member';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => false,
		"rewrite" => array('slug' => 'team','with_front' => false),
		"query_var" => false,
		'menu_icon' => 'dashicons-groups',
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'graphql_single_name' => 'teamMember',
		'graphql_plural_name' => 'teamMembers',
		"supports" => [
			"title",
			//"editor",
			"page-attributes",
			"thumbnail",
			"excerpt",
			"revisions"
		]
	];

}
