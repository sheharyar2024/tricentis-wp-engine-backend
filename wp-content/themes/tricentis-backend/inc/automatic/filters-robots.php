<?php

/**
 * Add content to robots.txt file
 */
new TricentisBackendRobots();

class TricentisBackendRobots{

	function __construct(){
		add_filter( 'robots_txt', [ $this, 'xml_sitemap' ], 20, 2 );
	}

	/**
	 * Add in sitemap xml for yoast
	 */
	function xml_sitemap( $content, $public ){

		$home = rtrim( site_url(), '/' );

		$content .= "\n"."Sitemap: {$home}/sitemap_index.xml"."\n";

		$content .=  "\n"."Disallow:"." /*.pdf$"."\n";

		$content .=  "\n"."Disallow:"." /search/fr/*"."\n";

		$content .=  "\n"."Disallow:"." /search/de/*"."\n";

		$content .=  "\n"."Disallow:"." /page/*"."\n";

		$content .=  "\n"."Disallow:"." /de/page/*"."\n";

		$content .=  "\n"."Disallow:"." /fr/page/*"."\n";

		return $content;
	}

}
