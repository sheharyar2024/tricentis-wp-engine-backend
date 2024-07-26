<?php

function wp_json_encode_cors_header( $value ) {
	$origin = get_http_origin();
	//error_log(print_r($_SERVER, true));
	//$allowed_origins = [ 'tricentis-backend.local', 'local.tricentis.com', 'local.tricentis.com:3000', 'dev-tricentis-backend.pantheonsite.io', 'test-tricentis-backend.pantheonsite.io' , 'develop-tricentis-backend.pantheonsite.io','be.tricentis.com'];
  
	//if ( $origin && in_array( $origin, $allowed_origins ) ) {
	  //header('Content-Type: application/json');
	  //header( 'Access-Control-Allow-Origin: ' . esc_url_raw( $origin ) );
	  header( 'Access-Control-Allow-Origin: *' );
	  //header( 'Access-Control-Allow-Credentials: true' );
	  //header('Access-Control-Allow-Methods: GET');	
	//}  
	return wp_json_encode($value);

}
 
// Disable XML-RPC.
add_filter( 'xmlrpc_enabled', '__return_false' );
/*
// Enforce CORS on REST API.
add_action( 'rest_api_init', function () {

	remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
	add_filter( 'rest_pre_serve_request', function ( $value ) {
		// https://joshpress.net/access-control-headers-for-the-wordpress-rest-api/
		// Only allow GET requests, no authentication options. This heavily restricts the REST API.
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Methods: GET' );

		return $value;
	} );

}, 15 );

// Prevent iFraming site.
add_filter( 'wp_headers', function ( $headers ) {
	$headers['X-Frame-Options'] = 'SAMEORIGIN';

	return $headers;
} );
*/