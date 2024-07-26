<?php
/**
 * Content Security Policy
 */
function add_security_policy(){
?>
  <meta http-equiv="Content-Security-Policy" content="script-src 'self';"> 
<?php
}
//add_action('wp_head', 'add_security_policy');
/**
 * Set response header
 */
function set_response_headers(){
  header('X-Content-Type-Options: nosniff');
}
//add_action( 'send_headers', 'set_response_headers' );
