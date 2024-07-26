<?php
namespace Tricentis\Api;

use Tricentis\ServiceNow;
use WP_REST_Request;
use WP_REST_Server;

class ToscaTrialApi {

	public const ROUTE_NAMESPACE = 'tricentis/v1';

	public static function initialize(): void {
		add_action( 'rest_api_init', [ __CLASS__, 'addRestEndpoint' ] );
	}

	/**
	 * Register REST endpoints for Tosca Trials.
	 */
	public static function addRestEndpoint(): void {
		// Register route to check if user exists or not by email address.
		register_rest_route( self::ROUTE_NAMESPACE, 'tosca-check-user', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'checkUser' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'email' => [
					'sanitize_callback' => static function ( $value ) {
						return strtolower( trim( sanitize_email( $value ) ) );
					},
					'required'          => true,
				],
				'path' => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'          => null,
				],
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'tosca-create-user', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'createUser' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'path'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'email'                => [
					'sanitize_callback' => static function ( $value ) {
						return strtolower( trim( sanitize_email( $value ) ) );
					},
					'required'          => true,
				],
				'salutation'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'firstName'            => [
					'sanitize_callback' => 'sanitize_text_field',
					'required'          => true,
				],
				'lastName'             => [
					'sanitize_callback' => 'sanitize_text_field',
					'required'          => true,
				],
				'country'              => [
					'sanitize_callback' => 'sanitize_text_field',
					'required'          => true,
				],
				'password'             => [
					'sanitize_callback' => 'sanitize_text_field',
					'required'          => true,
				],
				'passwordConfirmation' => [
					'sanitize_callback' => 'sanitize_text_field',
					'required'          => true,
				],
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'tosca-start-trial', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'startTrial' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'path'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'email' => [
					'sanitize_callback' => static function ( $value ) {
						return strtolower( trim( sanitize_email( $value ) ) );
					},
					'required'          => true,
				],
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'tosca-resend-verification', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'resendMarketoVerification' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'marketo_lead_id' => [
					'sanitize_callback' => 'absint',
					'required'          => true,
				],
			],
		] );
	}

	/**
	 * Validates email and checks if the user exists in ServiceNow and also verifies if they've had a recent trial.
	 *
	 * Return JSON should always include a `status` boolean (true if user can signup for a trial, false otherwise), a
	 * `userExists` boolean, and an `error` string will be present ONLY if `status` is false.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
	 */
	public static function checkUser( WP_REST_Request $request ) {
		$email = $request->get_param( 'email' );
		$path = $request->get_param( 'path' );

		if ( ! is_email( $email ) || ! self::isBusinessEmail( $email ) ) {
			return rest_ensure_response( [
				'status'     => false,
				'userExists' => false,
				'error'      => 'invalidEmail',
			] );
		}

		$response = [
			'status' => true,
		];

		$userData = ServiceNow::checkUser( $email, $path );

		if ( ! empty( $userData['user'] ) ) {
			$response['userExists'] = true;

			if ( $userData['user']['state'] === 'Unverified' ) {
				// User needs to verify their email address!
				$response['error'] = 'verifyEmailRequired';
				$response['mlid'] = $userData['user']['marketo_lead_id'] ?? null;
			} elseif ( ! empty( $userData['trial'] ) && ! ServiceNow::canHaveNewTrial( $userData['trial'] ) ) {
				// User has a current or recent trial!
				$response['status'] = false;
				$response['error'] = 'recentTrial';
			}
		} else {
			// No user! We're good to allow form fill.
			$response['userExists'] = false;
		}

		return rest_ensure_response( $response );
	}

	public static function createUser( WP_REST_Request $request ) {
		$path = $request->get_param( 'path' );

		$details = [
			'email'      => $request->get_param( 'email' ),
			'salutation' => $request->get_param( 'salutation' ),
			'first_name' => $request->get_param( 'firstName' ),
			'last_name'  => $request->get_param( 'lastName' ),
			'country'    => $request->get_param( 'country' ),
			'password'   => $request->get_param( 'password' ),
		];

		$response = [
			'status' => false,
		];

		if ( $details['password'] !== $request->get_param( 'passwordConfirmation' ) ) {
			$response['error'] = 'passwordMismatch';
		} elseif ( ! is_email( $details['email'] ) || ! self::isBusinessEmail( $details['email'] ) ) {
			$response['error'] = 'invalidEmail';
		} elseif ( empty( $details['first_name'] ) || empty( $details['last_name'] ) ) {
			$response['error'] = 'missingName';
		}

		if ( ! empty( $response['error'] ) ) {
			return rest_ensure_response( $response );
		}

		$userDetails = ServiceNow::createUser( $details, $path );

		if ( false === $userDetails ) {
			$response['error'] = 'userNotCreated';
		} else {
			$response['status'] = true;
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Starts a trial for a given email address. Email must belong to a ServiceNow account before it can start a trial.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
	 */
	public static function startTrial( WP_REST_Request $request ) {
		$path = $request->get_param( 'path' );
		$email = $request->get_param( 'email' );
		if ( ! is_email( $email ) || ! self::isBusinessEmail( $email ) ) {
			return rest_ensure_response( [
				'status' => false,
				'error'  => 'invalidEmail',
			] );
		}

		if ( ServiceNow::startTrial( $email, $path ) ) {
			return rest_ensure_response( [
				'status' => true,
			] );
		}

		return rest_ensure_response( [
			'status' => false,
			'error'  => '',
		] );
	}

	public static function resendMarketoVerification( WP_REST_Request $request ) {
		$marketoLeadId = (int) $request->get_param( 'marketo_lead_id' );
		if ( $marketoLeadId ) {
			$marketoApi = new \MarketoApi();
			$marketoApi->attachLeadToCampaign( [ $marketoLeadId ], 38024 );

			return rest_ensure_response( [
				'status' => true,
			] );
		}

		return rest_ensure_response( [
			'status' => false,
			'error'  => 'invalidLeadId',
		] );
	}

	/**
	 * Returns true if the email address is a valid business email. False otherwise. Uses the Marketo blacklist from
	 * PDG.
	 *
	 * @param string $email
	 *
	 * @return bool
	 */
	protected static function isBusinessEmail( string $email ): bool {
		$domainBlacklist = explode( ',', get_field('marketo_blacklist', 'option') );
		$domainBlacklist = array_filter( array_map( 'trim', $domainBlacklist ) );
		foreach ( $domainBlacklist as $domain ) {
			if ( strpos( $email, $domain ) !== false ) {
				return false;
			}
		}

		return true;
	}

}
//Disabled Tosca endpoints
ToscaTrialApi::initialize();
