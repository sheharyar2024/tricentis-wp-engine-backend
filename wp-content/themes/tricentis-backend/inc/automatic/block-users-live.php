<?php
if (isset($_ENV['PANTHEON_ENVIRONMENT']) && in_array($_ENV['PANTHEON_ENVIRONMENT'], array('live' ))) {
    add_action( 'admin_init', 'blockusers_init' );
    function blockusers_init() {
        $current_user = wp_get_current_user();

        if ( is_admin() && ! preg_match('/@narwhal|a\.chi@tricentis\.com|v\.kiddy@tricentis\.com|s\.sukserm@tricentis\.com|m\.cheptea@tricentis\.com/', strtolower($current_user->user_email)) > 0 && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
          if(defined('WP_FE_URL')){
            $url = WP_FE_URL;
          }else{
            $url =  home_url();
          }
            wp_redirect( $url );
            exit;
        }
    }
}