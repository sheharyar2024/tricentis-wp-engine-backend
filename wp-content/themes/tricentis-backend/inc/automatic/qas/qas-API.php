<?php
namespace Tricentis\qTestApi;

use WP_REST_Request;
use WP_REST_Server;

class qTestTrialApi {
	public const ROUTE_NAMESPACE = 'tricentis/v1';

	public static function initialize(): void {
		add_action( 'rest_api_init', [ __CLASS__, 'addApiEndpoint' ] );
	}
	/**
	 * Register REST endpoints for qTest Trials.
	 */
	public static function addApiEndpoint(): void {
		
		register_rest_route( self::ROUTE_NAMESPACE, 'qas_get_option', [
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => [ __CLASS__, 'qas_get_option_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'action'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'option'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'qas_form_validate_user', [
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => [ __CLASS__, 'qas_form_validate_user_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'field'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'value'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'action'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				
			],
		] );
		
		register_rest_route( self::ROUTE_NAMESPACE, 'qas_form_validate_domain', [
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => [ __CLASS__, 'qas_form_validate_domain_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'field'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'value'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'qas_form_signup_trial', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'qas_form_signup_trial_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'contactFName'          => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'contactLName'          => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'username'           	=> [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'password'           	=> [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'companyName'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'urlPrefix'           	=> [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'testTeamSize'          => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'companySize'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'industry'      	    => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'cid'       	    	=> [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'campaignId'       		=> [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'companyLocation'		=> [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'clusterId'				=> [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'isNotSendWelcomeEmail'	=> [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],								
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'qas_sp_get_gravatar', [
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => [ __CLASS__, 'qas_sp_get_gravatar_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'user_id'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],				
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'qas_sp_forgot_password', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'qas_sp_forgot_password_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'email'                => [
					'sanitize_callback' => static function ( $value ) {
						return strtolower( trim( sanitize_email( $value ) ) );
					},
					'required'          => true,
				],				
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'qas_sp_sign_up', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'qas_sp_sign_up_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'email'                => [
					'sanitize_callback' => static function ( $value ) {
						return strtolower( trim( sanitize_email( $value ) ) );
					},
					'required'          => true,
				],
				'name'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'password'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],				
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'qas_sp_set_password', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'qas_sp_set_password_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'email'                => [
					'sanitize_callback' => static function ( $value ) {
						return strtolower( trim( sanitize_email( $value ) ) );
					},
					'required'          => true,
				],
				'user_id'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'password'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],				
			],
		] );

		register_rest_route( self::ROUTE_NAMESPACE, 'qas_check_support_account', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ __CLASS__, 'qas_check_support_account_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'email'                => [
					'sanitize_callback' => static function ( $value ) {
						return strtolower( trim( sanitize_email( $value ) ) );
					},
					'required'          => true,
				],
				'name'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
			],
		] );
		
		register_rest_route( self::ROUTE_NAMESPACE, 'qtest_validate_username', [
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => [ __CLASS__, 'qtest_validate_username_API' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'username' => [
					'sanitize_callback' => static function ( $value ) {
						return strtolower( trim( sanitize_email( $value ) ) );
					},
					'required'          => false,
				],
			],
		] );

	}
	
	function qas_get_option_API( WP_REST_Request $request )
	{
		//Get values from request
		$action = $request->get_param( 'action' );
		$option = $request->get_param( 'option' );
		
		//Prepare value for api function
		$_GET['action'] = $action;
		$_GET['option'] = $option;
		
		//Call function
		$response = qas_get_option();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qas_form_validate_user_API( WP_REST_Request $request )
	{
		//Get values from request
		$action = $request->get_param( 'action' );
		$field = $request->get_param( 'field' );
		$value = $request->get_param( 'value' );
		
		//Prepare value for api function
		$_GET['action'] = $action;
		$_GET['field'] = $field;
		$_GET['value'] = $value;
		
		//Call function
		$response = qas_form_validate_user();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qas_form_validate_domain_API( WP_REST_Request $request )
	{
		//Get values from request
		$field = $request->get_param( 'field' );
		$value = $request->get_param( 'value' );
		
		//Prepare value for api function
		$_GET['field'] = $field;
		$_GET['value'] = $value;
		
		//Call function
		$response = qas_form_validate_domain();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qas_form_signup_trial_API( WP_REST_Request $request )
	{
		//Get values from request
		$contactFName = $request->get_param( 'contactFName' );
		$contactLName = $request->get_param( 'contactLName' );
		$username = $request->get_param( 'username' );
		$password = $request->get_param( 'password' );
		$companyName = $request->get_param( 'companyName' );
		$urlPrefix = $request->get_param( 'urlPrefix' );
		$testTeamSize = $request->get_param( 'testTeamSize' );
		$companySize = $request->get_param( 'companySize' );
		$industry = $request->get_param( 'industry' );
		$cid = $request->get_param( 'cid' );
		$campaignId = $request->get_param( 'campaignId' );
		$companyLocation = $request->get_param( 'companyLocation' );
		$clusterId = $request->get_param( 'clusterId' );
		$isNotSendWelcomeEmail = $request->get_param( 'isNotSendWelcomeEmail' );

		//Prepare lead array to send it to signup fuction
		$lead = array(
			"contactFName"=> $contactFName,
			"contactLName"=> $contactLName,
			"username"=> $username,
			"password"=> $password,
			"companyName"=> $companyName,
			"urlPrefix"=> $urlPrefix,
			"testTeamSize"=> $testTeamSize,
			"companySize"=> $companySize,
			"industry"=> $industry,
			"cid"=> $cid,
			"campaignId"=> $campaignId,
			"companyLocation"=> $companyLocation,
			"clusterId"=> $clusterId,
			"isNotSendWelcomeEmail"=> $isNotSendWelcomeEmail,
		);
		
		
		//Prepare value for api function
		$_POST['lead'] = $lead;
		
		//Call function
		$response = qas_form_signup_trial();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qas_sp_get_gravatar_API( WP_REST_Request $request )
	{
		//Get values from request
		$user_id = $request->get_param( 'user_id' );
		
		//Prepare value for api function
		$_GET['user_id'] = $user_id;
		
		//Call function
		$response = qas_sp_get_gravatar();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qas_sp_forgot_password_API( WP_REST_Request $request )
	{
		//Get values from request
		$email = $request->get_param( 'email' );
		
		//Prepare value for api function
		$_POST['email'] = $email;
		
		//Call function
		$response = qas_sp_forgot_password();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qas_sp_sign_up_API( WP_REST_Request $request )
	{
		//Get values from request
		$email = $request->get_param( 'email' );
		$name = $request->get_param( 'name' );
		$password = $request->get_param( 'password' );
		
		//Prepare value for api function
		$_POST['email'] = $email;
		$_POST['name'] = $name;
		$_POST['password'] = $password;
		
		//Call function
		$response = qas_sp_sign_up();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qas_sp_set_password_API( WP_REST_Request $request )
	{
		//Get values from request
		$email = $request->get_param( 'email' );
		$user_id = $request->get_param( 'user_id' );
		$password = $request->get_param( 'password' );
		
		//Prepare value for api function
		$_POST['email'] = $email;
		$_POST['user_id'] = $user_id;
		$_POST['password'] = $password;
		
		//Call function
		$response = qas_sp_set_password();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qas_check_support_account_API( WP_REST_Request $request )
	{
		//Get values from request
		$email = $request->get_param( 'email' );
		$name = $request->get_param( 'name' );
		
		//Prepare value for api function
		$_POST['email'] = $email;
		$_POST['name'] = $name;
		
		//Call function
		$response = qas_check_support_account();

		//return REST Output
		return rest_ensure_response( $response );
	}

	function qtest_validate_username_API( WP_REST_Request $request ) {

		//Get values from request
		$username = $request->get_param( 'username' );
		
		//Prepare value for qas_get_option function
		$_GET['username'] = $username;

		//Call function
		$response = qtest_validate_username();
	
		//return REST Output
		return rest_ensure_response( $response );
	}	

}

qTestTrialApi::initialize();


