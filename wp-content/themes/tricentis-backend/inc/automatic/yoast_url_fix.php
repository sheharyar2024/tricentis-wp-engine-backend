<?php
/**
 * Filters the Yoast URLs.
 *
 * @param string $canonical and opengraph url The current page's generated canonical URL.
 *
 * @return string The filtered canonical and opengraph URL.
 */
function yoast_canonical_url_fix( $url ) {
  if ( strripos( $url,"be.tricentis" ) ) {
    $url = str_replace("be.tricentis", "www.tricentis", $url);
  }
  if ( strripos( $url,"be-test.tricentis" ) ) {
    $url = str_replace("be-test.tricentis", "www.tricentis", $url);
  }
  if ( strripos( $url,"be-develop.tricentis" ) ) {
    $url = str_replace("be-develop.tricentis", "www.tricentis", $url);
  }
  return $url;
}

add_filter( 'wpseo_canonical', 'yoast_canonical_url_fix' );
add_filter('wpseo_opengraph_url', 'yoast_canonical_url_fix', 10, 1);