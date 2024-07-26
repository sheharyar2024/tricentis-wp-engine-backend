<?php

/**
 * This feature corresponds to an admin options page Theme Settings > Developer
 * Ties into certain wp hooks to allow users to enter custom scripts that will display in html
 */

new TricentisBackendCustomScripts();
class TricentisBackendCustomScripts{

	function __construct(){
		add_action( 'wp_head', [ $this, 'head' ], 20 );
		add_action( 'wp_body_open', [ $this, 'body' ], 20 );
		add_action( 'wp_footer', [ $this, 'foot' ], 20 );
	}

	/**
	 * Add content to wp_head
	 */
	function head(){
		the_field( 'developer_header_scripts', 'options' );
	}

	/**
	 * Add content after opening body tag
	 */
	function body(){
		the_field( 'developer_body_scripts', 'options' );
	}

	/**
	 * Add content to wp footer
	 */
	function foot(){
		the_field( 'developer_footer_scripts', 'options' );
	}
}