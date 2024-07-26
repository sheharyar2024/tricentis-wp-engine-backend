<?php

namespace Tricentis;

use WP_Error;

class ServiceNow {
	/**
	 * Returns true if the user exists in ServiceNow. False if user doesn't exist and null if there was an error/email
	 * was invalid.
	 *
	 * @param string $emailAddress Valid email address to check against ServiceNow.
	 *
	 * @return array Array containing user details (if found) and trials (if any). Null on failure.
	 */
	public static function checkUser( string $emailAddress, string $formUrl ): ?array {
		if ( ! is_email( $emailAddress ) ) {
			return null;
		}

		$path = 'checkUser?email=' . urlencode( $emailAddress );
		$response = self::makeRequest( $path, null, 'GET', $formUrl );

		// uncomment for debugging
		// error_log('ServiceNow checkUser response: ' . $emailAddress . ' ' . $formUrl . ' ' . print_r($response, true));

		if ( $response === false || ! is_array( $response ) ) {
			return null;
		}

		return $response;
	}

	/**
	 * @param array $userDetails
	 *
	 * @return array|false Array with new user details on success, false on failure.
	 */
	public static function createUser( array $userDetails, string $formUrl ) {

		$response = self::makeRequest( 'createUser', $userDetails, 'POST', $formUrl );
		// uncomment for debugging
		// error_log('createUser response: ' . print_r($response, true));
		return $response['result'] ? $response['details'] : false;
	}

	public static function startTrial( string $email, string $formUrl ): bool {
		$length = 14;

		if ( ! is_email( $email ) ) {
			return false;
		}

		$validUntilTimestamp = time() + ( DAY_IN_SECONDS * $length );

		$response = self::makeRequest( 'startTrial', [
			'email'       => $email,
			'valid_until' => date( 'Y-m-d H:i:s', $validUntilTimestamp ),
		], 'POST', $formUrl );
		// uncomment for debugging
		// error_log('startTrial response: ' . print_r($response, true));
		return (bool) $response['result'];
	}

	public static function verifyUser( $userId, $marketoLeadId ): bool {
		$response = self::makeRequest( 'verifyUser', [
			'user_id'         => $userId,
			'marketo_lead_id' => $marketoLeadId,
		] );

		return (bool) $response['result'];
	}

	public static function lastTrialStartDate( string $email ): ?string {
		if ( ! is_email( $email ) ) {
			return null;
		}

		$path = 'checkTrial?email=' . urlencode( $email );
		$response = self::makeRequest( $path, null, 'GET' );

		if ( ! empty( $response['trial'] ) ) {
			return $response['trial']['sys_created_on'];
		}

		return null;
	}

	public static function hadRecentTrial( string $email, $daysBetweenTrials = 44 ): bool {
		$lastTrial = self::lastTrialStartDate( $email );
		if ( null === $lastTrial ) {
			return false;
		}

		try {
			$lastTrialStartDate = new \DateTime( $lastTrial );
		} catch ( \Exception $e ) {
			// TODO: Log error decoding expiry date?
			// Current assumption for now is that they can have a trial if we cannot decode the date/time.
			return false;
		}

		$offset = DAY_IN_SECONDS * $daysBetweenTrials;

		$nextTrialValid = $offset + (int) $lastTrialStartDate->format( 'U' );

		// If current time is less than nextTrialValid, then user has had a recent trial, and we return true.
		return time() < $nextTrialValid;
	}

	/**
	 * Checks if the provided trial data will allow a user to have a new trial or not.
	 *
	 * @param array $trialData
	 * @param int   $daysBetweenTrials
	 *
	 * @return bool
	 */
	public static function canHaveNewTrial( array $trialData, int $daysBetweenTrials = 30 ): bool {
		$userActive = (bool) $trialData['u_active'];
		$trialExpired = (bool) $trialData['u_expires'];
		if ( $userActive === true && $trialExpired === false ) {
			// User has an active trial; ineligible for a new trial at this time!
			return false;
		}

		if ( ! empty( $trialData['u_valid_until'] ) ) {
			try {
				$lastTrialEndDate = new \DateTime( $trialData['u_valid_until'] );
			} catch ( \Exception $e ) {
				// TODO: Log error decoding expiry date?
				// Current assumption for now is that they can have a trial if we cannot decode the date/time.
				return true;
			}

			$offset = DAY_IN_SECONDS * $daysBetweenTrials;
			$nextTrialValid = $offset + (int) $lastTrialEndDate->format( 'U' );
			if ( $nextTrialValid > time() ) {
				// If nextTrialValid is greater than the current time, user is not eligible for a new trial yet.
				return false;
			}
		}

		return true;
	}

	protected static function makeRequest( $requestPath, $body = null, $method = 'POST', $formUrl ) {
		// retreives access token from ServiceNow
		$credentials = self::credentials($formUrl);

		if ( null === $credentials ) {
			// TODO: Throw error here?
			return false;
		}

		$args = [
			'method'  => $method,
			'headers' => [
				'Authorization' => 'Bearer ' . $credentials,
				'Content-Type'  => 'application/json',
			],
			'timeout' => 20,
		];

		if ( ! empty( $body ) ) {
			$args['body'] = json_encode( $body );
		}

		$response = wp_safe_remote_request( self::getBaseUrl($formUrl) . 'api/ttng2/trials/' . $requestPath, $args );

		// uncomment for debugging
		// error_log('ServiceNow makeRequest: ' . print_r($response, true));

		if ( $response instanceof WP_Error ) {
			// TODO: log error!
			return false;
		}

		if ( ! empty( $response['response']['code'] ) && $response['response']['code'] === 200 ) {
			$result = json_decode( $response['body'], true );
			if ( ! empty( $result['result'] ) && is_array( $result['result'] ) ) {
				return $result['result'];
			}

			return $result;
		}

		return false;
	}

	protected static function credentials($formUrl): ?string {
		$token = self::getToken($formUrl);
		
		$args = [
			'method'  => 'POST',
			'headers' => [
				'Content-Type'  => 'application/x-www-form-urlencoded',
			],
			'body' => [
				'grant_type' => 'refresh_token',
				'refresh_token' => $token,
				'client_id' => 'cff2aa1abc58e9103e7e928c5a9d2d8e',
				'client_secret' => 'B3,-evR*T9',
			],
			'timeout' => 20,
		];

		$response = wp_safe_remote_request( self::getBaseUrl($formUrl) . 'oauth_token.do', $args );
		$access_token = json_decode($response['body']) -> access_token;

		return $access_token;
	}

	/**
	 * Returns the correct oAuth access token based on current environment.
	 *
	 * @return string
	 */
	protected static function getToken($formUrl): string {
		// Live access token used for live and testing on mkto-test.tricentis.com
		if ( (isset( $_ENV['PANTHEON_ENVIRONMENT'] ) && $_ENV['PANTHEON_ENVIRONMENT'] === 'live') || ($formUrl === '/software-testing-tool-trial-demo/tosca-trial-live')) {
			// Live access token.
			return '5wHl74uaGhL6J7VvlPlXB9khW9YTmMdCIG3uqEbsRaicYxufKlj7HGJMUMgbFZOxHtizYTR1xvPoSKRe2hCcBw';
		}

		// ServiceNow dev token
		return 'WOkxRpS9pEOtXZUt6PfwEh1oGL8FqLnM9gJBg3OH5O5NJcRJlhuCtycqkJ6aRhODaYSO0I6Q85HybCvQl517cg';
	}

	/**
	 * Returns the correct base URL based on current environment.
	 *
	 * @return string
	 */
	protected static function getBaseUrl($formUrl): string {
		// Live base ServiceNow URL used for live and testing on mkto-test.tricentis.com
		if ( (isset( $_ENV['PANTHEON_ENVIRONMENT'] ) && $_ENV['PANTHEON_ENVIRONMENT'] === 'live') || ($formUrl === '/software-testing-tool-trial-demo/tosca-trial-live')) {
			// Live environment.
			return 'https://tricentiscsm.service-now.com/';
		}

		// ServiceNow dev base URL
		return 'https://tricentiscsmdev.service-now.com/';
	}

}
