<?php 

namespace PDG;

class TrackEvent {
	const ACTION = 'pdg_track_event';
	const DEBUG = false;

	/**
	 * Setup hooks
	 */
	public static function initialize() {
		add_action( 'wp_ajax_nopriv_' . self::ACTION, [ __CLASS__, 'register_action' ] );
		add_action( 'wp_ajax_' . self::ACTION, [ __CLASS__, 'register_action' ] );
		add_action( 'rest_api_init', [ __CLASS__, 'rest_api_init' ] );
	}

	public static function rest_api_init() {
		register_rest_route( 'pdg/v1', '/track_event', array(
			'methods'  => ['GET', 'POST'],
			'callback' => [ __CLASS__, 'register_action' ],
			'permission_callback' => static function () {
				return true;
			}
		) );
	}

	public static function register_action() {
		if ( ! isset( $_REQUEST['serial_number'] ) ) {
			return [];
		}

		$type = 'click';

		if ( isset( $_REQUEST['type'] ) ) {
			$type = sanitize_text_field( $_REQUEST['type'] );
		}

		$content_position = '';

		if ( isset( $_REQUEST['content_position'] ) ) {
			$content_position = sanitize_text_field( $_REQUEST['content_position'] );
		}

		$serial_numbers = explode( ',', sanitize_text_field( $_REQUEST['serial_number'] ) );
		$source         = sanitize_text_field( $_REQUEST['source'] );
		$user_id        = sanitize_text_field( $_REQUEST['user_id'] );

		foreach($serial_numbers as $serial_number) {
			Tracking::addBySerialNumber( $serial_number, $type, $source, $user_id, $content_position );
		}
		return [];
	}

}

TrackEvent::initialize();
