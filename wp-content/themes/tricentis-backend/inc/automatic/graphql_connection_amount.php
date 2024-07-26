<?php
/**
 * Graphql increase query amount #https://www.wpgraphql.com/filters/graphql_connection_max_query_amount/
 */
add_filter( 'graphql_connection_max_query_amount', function ( int $max_amount, $source, array $args, $context, $info ) {
	return 3000;
}, 10, 5 );
