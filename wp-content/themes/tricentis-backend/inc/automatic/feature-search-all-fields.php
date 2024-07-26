<?php

/**
* Extend WordPress search to include custom fields
* make sure we capture custom field content for search
*
* https://adambalee.com
*/
new TricentisBackendSearchAllFields();

class TricentisBackendSearchAllFields{

	function __construct(){
		if( !is_admin() || wp_doing_ajax() ){
			add_filter( 'posts_join', [ $this, 'cf_search_join' ], 30, 2 );
			add_filter( 'posts_where', [ $this, 'cf_search_where' ], 30, 2 );
			add_filter( 'posts_distinct', [ $this, 'cf_search_distinct' ], 30, 2 );
		}
	}

	/**
	* Join posts and postmeta tables
	*
	* http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
	*/
	function cf_search_join( $join, $query ) {
		global $wpdb;

		if ( $query->is_search ) {
			$join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
		}
		return $join;
	}

	/**
	 * Modify the search query with posts_where
	 *
	 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
	 */
	function cf_search_where( $where, $query ) {
	    global $pagenow, $wpdb;

		if ( $query->is_search ) {

			$where = preg_replace(
				"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)",
				$where
			);

		}

		return $where;
	}


	/**
	* Prevent duplicates
	*
	* http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
	*/
	function cf_search_distinct( $where, $query ) {
		global $wpdb;

		if ( $query->is_search ) {
			return "DISTINCT";
		}

		return $where;
	}

}