<?php
/**
 * Common security issues for WP
 *
 * Turn off xmlrpc - Pantheon also has a way to turn this off at the request level, but maybe we aren't on Pantheon 
 * Turn off rest authentication - Common way to hack into a site by brute forcing passwords
 */
if( !function_exists( 'NarwhalSecurity' ) ){
	function NarwhalSecurity(){
		return TricentisBackendSecurity::getInstance();
	}
	NarwhalSecurity();
}

class TricentisBackendSecurity{

	private static $instance = null;

	private $filter_values = array();

	public static function getInstance(){

		if ( self::$instance == null ){
			self::$instance = new TricentisBackendSecurity();
		}

		return self::$instance;
	}

	function __construct(){
		//turn off plugin and theme editor
		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}
	}

	public function disable_xmlrpc(){
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

	/**
	 *
	 * https://developer.wordpress.org/rest-api/frequently-asked-questions/#can-i-disable-the-rest-api
	 */
	public function require_rest_auth(){
		add_filter( 'rest_authentication_errors', [ $this, '_check_rest_auth' ] );
	}

	function _check_rest_auth( $result ){
		// If a previous authentication check was applied,
		// pass that result along without modification.
		if ( true === $result || is_wp_error( $result ) ) {
			return $result;
		}

		// No authentication has been performed yet.
		// Return an error if user is not logged in.
		if ( ! is_user_logged_in() ) {
			return new WP_Error(
				'rest_not_logged_in',
				__( 'You are not currently logged in.' ),
				array( 'status' => 401 )
			);
		}

		return $result;
	}

}