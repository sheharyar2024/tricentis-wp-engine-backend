<?php
/**
 * FIX - Sitemap URL's exception in headless plugin
 */
add_filter('headless_mode_will_redirect', 'headless_mode_will_redirect_exception', 10, 2);
function headless_mode_will_redirect_exception($bool, $new_url) {
    //if this URL belongs to sitemap then return false, mean no redirect.
    if(preg_match('~(-sitemap.xml|sitemap_index.xml|robots.txt)~', $new_url)){
        return false;
    }
    return true;
}
