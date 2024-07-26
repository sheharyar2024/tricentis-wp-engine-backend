<?php
/**
 * Disable XML RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
//XML changes update2