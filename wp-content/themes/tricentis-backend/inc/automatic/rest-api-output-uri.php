<?php
/**
 * This code will extend Rest API output and add uri for post types
 */
add_action( 'rest_api_init', 'create_api_posts_meta_field' );

function create_api_posts_meta_field() {
	register_rest_field(
		array('post', 'page', 'events', 'faq', 'landing_pages', 'news', 'partner', 'resource', 'team_member', 'testimonial', 'case_study', 'learn', 'explore_products', 'landing_pages'),
		'uri',
		array(
	       'get_callback'    => 'get_post_meta_for_api',
	       'schema'          => null,
	    )
	);
	/**
	 * Registering custom field for primary product id.
	 *
	 * This custom field will store the ID of the primary product ID.
	 */
	register_rest_field(
		array('post', 'learn'),
		'tri_general_products__primary_product_id',
		array(
	       'get_callback'    => 'get_post_meta_for_primary_product',
	       'schema'          => null,
	    )
	);
	/**
	 * Registering custom field for ACF relations.
	 * 
	 * The Post Object may have an associated ACF field that is a relation to other posts.
	 * These posts are fetched from the database without their meta fields.
	 * This custom field will map the post ID to the META of the post.
	 */
	register_rest_field(
		array('post', 'page', 'events', 'faq', 'landing_pages', 'news', 'partner', 'resource', 'team_member', 'testimonial', 'case_study', 'learn', 'explore_products', 'landing_pages'),
		'acf_resources_posts_meta',
		array(
	       'get_callback'    => 'get_acf_resources_posts_meta',
	       'schema'          => null,
	    )
	);
	register_rest_field(
		array('post', 'page', 'events', 'faq', 'landing_pages', 'news', 'partner', 'resource', 'team_member', 'testimonial', 'case_study', 'learn', 'explore_products', 'landing_pages'),
		'featured_media_src',
		array(
	       'get_callback'    => 'get_image_src',
	       'schema'          => null,
	    )
	);
	register_rest_field(
		array('post', 'page', 'events', 'faq', 'landing_pages', 'news', 'partner', 'resource', 'team_member', 'testimonial', 'case_study', 'learn', 'explore_products', 'landing_pages'),
		'flex_module_video_url',
		array(
	       'get_callback'    => 'get_flex_module_video_url',
	       'schema'          => null,
	    )
	);
	register_rest_field(
		array('post', 'page', 'events', 'faq', 'landing_pages', 'news', 'partner', 'resource', 'team_member', 'testimonial', 'case_study', 'learn', 'explore_products','landing_pages'),
		'post_type_terms',
		array(
	       'get_callback'    => 'get_post_type_terms',
	       'schema'          => null,
	    )
	);
}

function get_post_meta_for_api( $object ) {
	$url = $object['link'];
	if(empty($url)){
		$url = get_permalink($object['id']);
	}
	return !empty( $url ) ? str_ireplace( home_url(), '', $url ) : null;
}

function get_post_meta_for_primary_product( $object ) {
	$id = get_post_meta($object['id'], '_yoast_wpseo_primary_tri_general_products', true);

	return $id ? $id : null;
}

function get_acf_resources_posts_meta($object) {
	$modules = isset($object['acf']['modules']) && is_array($object['acf']['modules']) ? $object['acf']['modules'] : [];
	$resourcesModule = array_filter(
		$modules,
		function($module) {
			return $module['acf_fc_layout'] === 'resources_grid';
		}
	);

	$resourcesModule = array_values($resourcesModule);

	$sectionPosts = $object['acf']['resource_section']['posts'] ?? [];
	$modulePosts = $resourcesModule[0]['posts'] ?? [];

	if(!empty($sectionPosts) && !empty($modulePosts))
		$posts = array_merge($sectionPosts, $modulePosts);
	$mapArray = [];

	if(is_array($posts) && !empty($posts)){
		foreach($posts as $post) {
			$url = $post->link;
			if(empty($url)) {
				$url = get_permalink($post->ID);
			}
			// Add more fields as needed
			$mapArray[$post->ID] = (object) [
				'uri' => !empty($url) ? str_ireplace(home_url(), '', $url) : null,
			];
		}
	}

	return count($mapArray) > 0 ? $mapArray : null;
}

function get_image_src( $object, $field_name, $request ) {
	$media_id = $object['featured_media'];
	return get_image_src_func( $media_id );
}

function get_image_src_func( $media_id ) {

	$thumbnail = wp_get_attachment_image_src( $media_id, 'thumbnail', true);
	$thumbnail_url = $thumbnail[0];

	$medium = wp_get_attachment_image_src( $media_id, 'medium', true);
    $medium_url = $medium[0];

    $large = wp_get_attachment_image_src( $media_id, 'large', true);
    $large_url = $large[0];

	$url = wp_get_attachment_image_src( $media_id, 'full', true );
	$url = $url[0];

	$alt_text = get_post_meta($media_id, '_wp_attachment_image_alt', TRUE);

	return array(
		'thumbnail' => $thumbnail_url,
        'medium' => $medium_url,
        'large'  => $large_url,
		'url' => $url,
		'alt_text' => $alt_text,
    );
  }

//WPML REST API plugin - updating condition to get posts
add_filter('wpml_restapi_cpt_condition','wpml_restapi_cpt_condition_func');
function wpml_restapi_cpt_condition_func($get_post_types_args){
	return array('show_in_rest' => true);
}
add_filter('wpmlrestapi_get_translation','wpmlrestapi_get_translation_func',10, 3);

function wpmlrestapi_get_translation_func($translation, $thisPost, $language){
	$translation['status']= $thisPost->post_status;
	return $translation;
}

function get_flex_module_video_url( $object ) {
	$post_id = $object['id'];
	return flex_module_video_url_func($post_id);
}

function flex_module_video_url_func( $post_id ) {
	$video_urls = array();
		if( have_rows('modules', $post_id) ):
			while( have_rows('modules', $post_id) ): the_row();
				if( get_row_layout() == 'video' ):
					if( have_rows('video') ):
						while( have_rows('video') ) : the_row();
							$acf_field_name = 'video_url';
							$video_url_iframe = get_sub_field($acf_field_name);
							$urls_key = get_video_url_key($video_url_iframe);
							$video_url = get_sub_field($acf_field_name,false);
							$video_urls[$urls_key] = $video_url;
						endwhile;
					endif;
				else:
					$field_name = 'video_embed';
					$video_url_iframe = get_sub_field($field_name);
					if($video_url_iframe){
						$urls_key = get_video_url_key($video_url_iframe);
						$video_url = get_sub_field($field_name,false);
						$video_urls[$urls_key] = $video_url;
					}
				endif;
			endwhile;
		endif;
	return $video_urls;
}

function get_video_url_key($video_url_iframe){
	//Step1: get src from iframe
	preg_match('/src="([^"]+)"/', $video_url_iframe, $match);
	//Step2: parse URL
	$parsed  = parse_url($match[1]);
	//Step3: get URL path and replace backslash with underscore
	$urls_key = str_replace( '/','_',$parsed['path']);
	//Step4: Use $uls_key as array index
	return $urls_key;
}

function get_post_type_terms( $object) {
	$post_id = $object['id'];
	$taxonomies=get_taxonomies('','names');
	
	return wp_get_post_terms($post_id, $taxonomies);
}

add_filter( 'rest_prepare_revision', function( $response, $post ) {
	$data = $response->get_data();
  
	$data['acf'] = get_fields( $post->ID );
	$data['flex_module_video_url'] = flex_module_video_url_func( $post->ID );
	$data['featured_media_src'] =  get_image_src_func(get_post_thumbnail_id($post->post_parent));
	$template = get_post_meta( $post->post_parent, '_wp_page_template', true );
	$data['template'] =  $template;
	
	return rest_ensure_response( $data );
  }, 10, 2 );