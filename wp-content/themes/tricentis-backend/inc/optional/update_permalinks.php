<?php
//https://stackoverflow.com/a/22527033

function change_permalinks( $permalink, $post ) {

    if(!defined('WP_FE_URL') || empty($permalink)){
        return $permalink;
    }
    
    $path = parse_url($permalink,PHP_URL_PATH);
    $get_query = parse_url($permalink,PHP_URL_QUERY);
    if(!empty($get_query)){
        $query = '?'.$get_query;
    }
    $permalink = WP_FE_URL.$path.$query;
    return $permalink;
}

add_filter('page_link', "change_permalinks", 10, 2);
add_filter('post_link', "change_permalinks", 10, 2);
add_filter('post_type_link', "change_permalinks", 10, 2);
/*
function customize_my_wp_admin_bar( WP_Admin_Bar $wp_admin_bar ) {
    if(defined('WP_FE_URL')){
        $node = $wp_admin_bar->get_node('view-site');
        $node->href = WP_FE_URL;
    }
}
add_action( 'admin_bar_menu', 'customize_my_wp_admin_bar', 999 );
*/