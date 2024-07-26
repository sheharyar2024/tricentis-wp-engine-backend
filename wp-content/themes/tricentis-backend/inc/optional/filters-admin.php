<?php

/**
 * Various admin filters
 * Keep yoast low priority on edit page
 * Move excerpt to higher priority - depends on ACF
 * Limit number of revisions kept in database
 * Edit menu items
 */
new TricentisBackendAdminFilters();

class TricentisBackendAdminFilters{

	function __construct(){
		add_filter( 'wpseo_metabox_prio', [ $this, 'move_yoast_to_bottom' ] );

		//move excerpt higher on edit page
		add_action( 'admin_menu' , [ $this, 'remove_normal_excerpt' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_high_excerpt' ] );

		add_filter( 'wp_revisions_to_keep', [ $this, 'limit_revisions' ], 10, 2 );

		add_action( 'admin_menu' , [ $this, 'remove_menu_items' ] );

		//hide default editor
		add_action( 'init', [ $this, 'hide_default_editor' ] );

		//upload eps files
		//add_filter( 'upload_mimes', [ $this, 'upload_mimes' ] );
		//add_filter( 'wp_check_filetype_and_ext', [ $this, 'custom_wp_check_filetype_and_ext' ], 99, 4 );
	}

	/**
	 * Hiding editor for all pages makes module template look cleaner
	 * this also means we need to add an editor back to default template for content
	 */
	function hide_default_editor(){
		remove_post_type_support('page', 'editor');
		//remove_post_type_support('post', 'editor');
	}

	/**
	 * These menu items are not used
	 */
	function remove_menu_items(){
		//remove_menu_page( 'edit-comments.php' );
	}

	/**
	 * Only keep latest 50 revisions
	 * unlimited revisions can lead to database problems
	 */
	function limit_revisions( $num, $post ) {

		switch( $post->post_type ){

		}

		return 50;
	}

	/**
	 * move yoast to bottom of list
	 */
	function move_yoast_to_bottom() {
		return 'low';
	}

	/**
	 * Removes the regular excerpt box. We're not getting rid
	 * of it, we're just moving it above the wysiwyg editor
	 *
	 * @return null
	 */
	function remove_normal_excerpt() {
		remove_meta_box( 'postexcerpt' , 'post' , 'core' );
		remove_meta_box( 'postexcerpt' , 'page' , 'core' );
	}

	/**
	 * Add the excerpt meta box back in with a custom screen location
	 *
	 * @param  string $post_type
	 * @return null
	 */
	function add_high_excerpt( $post_type ) {
		switch( $post_type ){
			default:
			break;
			case 'noop':
			case 'post':
			case 'page':
				add_meta_box(
					'nw_postexcerpt',
					__( 'Excerpt', 'narwhal-digital' ),
					'post_excerpt_meta_box',
					$post_type,
					'acf_after_title',
					'low'
				);
			break;
		}
	}

	/**
	 * Add eps as an allowed extension
	 */
	function upload_mimes( $mime_types ){
		$mime_types[ 'eps' ] = 'application/postscript';
		return $mime_types;
	}

	/**
	 * Some servers may report different mime types for eps, this should allow multiple mime types as wp doesn't by default
	 */
	function custom_wp_check_filetype_and_ext( $filetype_and_ext, $file, $filename, $mimes ) {
		if(!$filetype_and_ext['ext'] || !$filetype_and_ext['type'] || !$filetype_and_ext['proper_filename']) {
			$extension = pathinfo($filename)['extension'];
			$mime_type = mime_content_type($file);
			$allowed_ext = array(
				'eps' => array(
					'application/postscript',
					'image/x-eps',
					'application/octet-stream',
					'application/encrypted',
					'application/CDFV2-encrypted',
					'application/zip',
				),
				'ai' => array('application/postscript'),
			);

			if($allowed_ext[$extension]) {
				if(in_array($mime_type, $allowed_ext[$extension])) {
					$filetype_and_ext['ext'] = $extension;
					$filetype_and_ext['type'] = $mime_type;
					$filetype_and_ext['proper_filename'] = $filename;
				}
			}
		}
		return $filetype_and_ext;
	}
}