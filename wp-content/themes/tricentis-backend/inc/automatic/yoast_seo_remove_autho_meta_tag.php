<?php
#https://developer.yoast.com/features/opengraph/api/changing-og-locale-output/#remove-the-oglocale-tag
function remove_author_presenter( $presenters ) {
  return array_map( function( $presenter ) {
      if ( ! $presenter instanceof Yoast\WP\SEO\Presenters\Meta_Author_Presenter ) {
          return $presenter;
      }
  }, $presenters );
}

add_action( 'wpseo_frontend_presenters', 'remove_author_presenter' );