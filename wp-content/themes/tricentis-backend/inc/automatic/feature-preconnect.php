<?php

/**
 * This feature corresponds to an admin options page Theme Settings > Developer
 * Adds each domain entered as a preconnect/dns-prefetch according to web.dev - https://web.dev/uses-rel-preconnect/
 * Not every domain needs to be in there, but if lighthouse demands, it's a way to comply
 */

new TricentisBackendPreconnect();
class TricentisBackendPreconnect{

	function __construct(){
		add_action( 'wp_head', [ $this, 'head' ], 1 );
	}

	/**
	 * Add content to wp_head
	 */
	function head(){
		$domains = explode( PHP_EOL, get_field( 'developer_preconnect', 'options' ) );
		foreach( $domains as $domain ){
			$domain = trim( $domain );
			echo "<link rel='preconnect' href='{$domain}'><link rel='dns-prefetch' href='{$domain}'>";
		}
	}
}