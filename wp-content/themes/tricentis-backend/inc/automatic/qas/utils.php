<?php
namespace QAS;

class Utils {

	public static function now() {
		return gmdate( 'Y-m-d H:i:s', strtotime( 'now' ) );
	}

	public static function getArray( $key, array $arr, $default = null ) {
		$value = isset( $arr[ $key ] ) ? $arr[ $key ] : $default;

		return ( strcmp( 'email', strtolower( $key ) ) == 0 ) ? strtolower( $value ) : $value;
	}

	static public function isFreeEmail( $email ) {
		$freeDomains      = 'hotmail.com,gmail.com,zoho.com,aim.com,icloud.com,outlook.com,yahoo.com,mail.com,mail.ru,shortmail.com,inbox.com,facebook.com,myway.com';
		$excludingDomains = explode( ',', preg_replace( "/[^A-z,0-9,.,-]|[\[\]\^\`]|[\\\\]/", "", $freeDomains ) );

		$pattern     = '/.*@/i';
		$replacement = '';
		$domain      = preg_replace( $pattern, $replacement, $email );

		$isFreeEmail = false;
		if ( in_array( strtolower( $domain ), $excludingDomains ) ) {
			$isFreeEmail = true;
		}

		return $isFreeEmail;
	}

	static public function curlWrap( $url, $json = '', $action = 'GET', $headers = null ) {
		$response = array();
		$errors   = array();
		$ch       = curl_init();
		if ( defined( 'WP_PROXY_HOST' ) && defined( 'WP_PROXY_PORT' ) ) {
			curl_setopt( $ch, CURLOPT_PROXY, WP_PROXY_HOST . ':' . WP_PROXY_PORT );
		}

		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $ch, CURLOPT_MAXREDIRS, 15 );
		curl_setopt( $ch, CURLOPT_URL, $url );

		switch ( $action ) {
			case "POST":
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
				break;
			case "GET":
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
				break;
			case "PUT":
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
				break;
			case "DELETE":
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
				break;
			default:
				break;
		}

		if ( isset( $headers ) ) {
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		} else {
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
				'Content-type: application/json'
			) );
		}

		curl_setopt( $ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0" );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 180 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 180 );
		$output = curl_exec( $ch );

		$http_code             = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		$response['http_code'] = $http_code;
		$info                  = curl_getinfo( $ch );
		if ( curl_errno( $ch ) ) {
			$errors[]           = curl_errno( $ch );
			$response['err_no'] = curl_errno( $ch );
		}
		curl_close( $ch );

		$decoded = json_decode( $output, true );

		switch ( json_last_error() ) {
			case JSON_ERROR_NONE:
				break;
			case JSON_ERROR_DEPTH:
				$errors[] = array(
					'code'    => 'JSON_ERROR_DEPTH',
					'message' => 'JSON DECODE: Maximum stack depth exceeded'
				);
				break;
			case JSON_ERROR_STATE_MISMATCH:
				$errors[] = array(
					'code'    => 'JSON_ERROR_STATE_MISMATCH',
					'message' => 'JSON DECODE: Underflow or the modes mismatch'
				);
				break;
			case JSON_ERROR_CTRL_CHAR:
				$errors[] = array(
					'code'    => 'JSON_ERROR_CTRL_CHAR',
					'message' => 'JSON DECODE: Unexpected control character found'
				);
				break;
			case JSON_ERROR_SYNTAX:
				$errors[] = array(
					'code'    => 'JSON_ERROR_ERROR_SYNTAX',
					'message' => 'JSON DECODE: Syntax error, malformed JSON'
				);
				break;
			case JSON_ERROR_UTF8:
				$errors[] = array(
					'code'    => 'JSON_ERROR_UTF8',
					'message' => 'JSON DECODE: Malformed UTF-8 characters, possibly incorrectly encoded'
				);
				break;
			default:
				$errors[] = array(
					'code'    => 'JSON_ERROR_UNKNOWN',
					'message' => 'JSON DECODE: Unknown error'
				);
				break;
		}
		$response['decoded'] = $decoded;

		if ( $http_code == 500 && is_null( $decoded ) ) {
			$decoded = array(
				'code'    => 'JSON_ERROR_UNKNOWN',
				'message' => $output
			);
		}

		return $response;
	}
}
