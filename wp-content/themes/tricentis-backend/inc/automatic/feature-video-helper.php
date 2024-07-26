<?php

/**
 * Class to help convert embedded video urls into more granular pieces for custom functionality
 */

if( !function_exists( 'TricentisBackendVideoHelper' ) ){
	function TricentisBackendVideoHelper(){
		return TricentisBackendVideoHelper::getInstance();
	}
}

TricentisBackendVideoHelper();

class TricentisBackendVideoHelper{
	private static $instance = null;

	private $filter_values = array();

	public static function getInstance(){

		if ( self::$instance == null ){
			self::$instance = new TricentisBackendVideoHelper();
		}

		return self::$instance;
	}

	protected $url = '';
	protected $id = '';
	protected $service = 'unknown';
	protected $image = '';

	function __construct(){
		add_filter( 'embed_oembed_html', [ $this, 'custom_player' ], 999, 3 );
		add_filter( 'video_embed_html', [ $this, 'custom_player' ], 999, 3 ); // Jetpack
	}

	/**
	 * Custom oembed player with button to play video
	 */
	function custom_player( $html, $url ){
		if( is_admin() ){
			return $html;
		}
		$this->load_from_iframe( $html );
		$image = $this->image();
		$html = preg_replace( '/src=\"/','loading="lazy" data-src="', $html );
		if( 'wistia' === $this->service ){
			$html = str_replace( 'wp-embedded-content', 'wp-embedded-content wistia_embed" name="wistia_embed', $html );
		}
		preg_match('/title="(.+?)"/', $html, $matches);
		$title = $matches[1];
		$args = [
			'html' => $html,
			'url' => $url,
			'image' => $image,
			'title' => $title,
			'id' => $this->id,
			'service' => $this->service,
		];
		ob_start();
		get_template_part( 'template-parts/video-embed', '', $args );
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}

	/**
	 * Setup based on embed url
	 */
	function load( $url ){
		$this->url = $url;
		//id is last part of url minus any query string
		$id = end( explode( '/', $url ) );
		$this->id = reset( explode( '?', $id ) );
		switch( true ){
			case strpos( $url, 'wistia' ) !== false:
				$this->service = 'wistia';
			break;
			case strpos( $url, 'vimeo' ) !== false:
				$this->service = 'vimeo';
			break;
			default:
				$this->service = 'youtube';
			break;
		}
		$this->image = '';
	}

	/**
	 * Load based on iframe embed ( from acf embed field or wp oembed )
	 */
	function load_from_iframe( $iframe ){
		preg_match('/src="(.+?)"/', $iframe, $matches);
		$this->load( $matches[1] );
	}

	/**
	 * returns video url
	 */
	function url( $strip_query_string = false ){
		if( $strip_query_string ){
			return reset( explode( '?', $this->url ) );
		}
		return $this->url;
	}

	/**
	 * returns video id
	 */
	function id(){
		return $this->id;
	}

	/**
	 * returns video service
	 */
	function service(){
		return $this->service;
	}

	/**
	 * Returns default video image from service
	 * Only use this if you need it as these lookups take time
	 */
	function image(){
		if( '' === $this->image ){
			switch( $this->service ){
				case 'wistia':
					$url = urlencode( $this->url );
					$data = json_decode( wp_remote_retrieve_body( wp_remote_get( "http://fast.wistia.com/oembed.json?url={$url}" ) ) );
					$this->image = $data->thumbnail_url;
				break;
				case 'vimeo':
					$data = json_decode( wp_remote_retrieve_body( wp_remote_get( "https://vimeo.com/api/v2/video/{$this->id}.json" ) ) );
					$this->image = $data[0]->thumbnail_large;
				break;
				case 'youtube':
					$this->image = "https://img.youtube.com/vi/{$this->id}/0.jpg";
				break;
			}
		}
		return $this->image;
	}
}