<?php
/**
 * This post type is used to run the testimonial module
 * Default assumes that all fields are added through ACF, post title is admin use only, menu order used for query sorting
 */
new TricentisBackendCPT_Partners();

class TricentisBackendCPT_Partners extends TricentisBackendCPT_Prototype{
	protected $key = 'partner';
	protected $label = 'Partner';
	protected $plural_label = 'Partners';
	protected $registration = [
		"public" => true,
		"publicly_queryable" => true,
		"has_archive" => false,
		"show_in_nav_menus" => false,
		"exclude_from_search" => false,
		"rewrite" => array('slug' => 'partners','with_front' => false),
		"query_var" => false,
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'taxonomies' => array('partnertype'),
		'graphql_single_name' => 'partner',
		'graphql_plural_name' => 'partners',
			"supports" => [
				"title",
				"page-attributes",
				"excerpt",
				"revisions",
				"thumbnail",
			]
	];

}

/**
 * Make Thumbnail required for partner page
 */
add_filter( 'wp_insert_post_data', function ( $data, $post_data ) {

	$post_id              = $post_data['ID'];
	$post_status          = $data['post_status'];
	$original_post_status = isset($post_data['original_post_status']) ? $post_data['original_post_status'] : '';
	$post_type			  = $post_data['post_type'];
	$excerpt 			  = $post_data['post_excerpt'];


	if ( $post_id && 'publish' === $post_status && 'publish' !== $original_post_status && $post_type == 'partner' ) {
		$post_type = get_post_type( $post_id );
		if ( (post_type_supports( $post_type, 'thumbnail' ) && ! has_post_thumbnail( $post_id )) ||  empty($excerpt)) {
			$data['post_status'] = 'draft';
		}
	}

	return $data;

}, 10, 2 );

add_action( 'admin_notices', function () {
	$post = get_post();
	if ( isset( $post->ID ) && 'publish' !== get_post_status( $post->ID ) && $post->post_type == 'partner' && (! has_post_thumbnail( $post->ID ) || empty($post->post_excerpt) ) ) { ?>
		<div id="message" class="error">
			<p>
				<strong><?php _e( 'Excerpt and Featured image are required to publish partner pages.' ); ?></strong>
			</p>
		</div>
	<?php
	}
} );
