<?php

namespace QAS;

class qTestConnector {
	protected $_host = 'https://qtest.qasymphony.com';
	protected $_token = '39c8e9953fe8ea40ff1c59876e0e2f28';
	protected $_headers = array();

	protected $_request_args = array();

	public function setHeaders( $headers ) {
		$this->_headers = $headers;
	}

	public function setRequestArgs( $args ) {
		$this->_request_args = $args;
	}


	public function __construct() {
		$this->setHeaders( array(
				'Content-type: application/json',
				'Authorization: ' . $this->_token
			)
		);
		$this->setRequestArgs( array(
				'timeout'   => 30,
				'headers'   => $this->_headers,
				'sslverify' => false
			)
		);
	}

	/**
	 * validate a username is exist in qTest or not
	 *
	 * @param array $data
	 *            the data to submit to qTest
	 *
	 * @return array
	 */
	public function validateUser( array $data ) {
		$json = array(
			'username' => $data['username']
		);

		$query = http_build_query( $json, '', '&' );
		$url   = $this->_host . '/api/validate/username?' . $query;
		$res   = wp_remote_get( $url, $this->_request_args );

		if ( is_array( $res ) ) {
			$resCode  = $res['response']['code'];
			$resBody  = json_decode( $res['body'], true );
			$response = array(
				'http_code' => $resCode,
				'decoded'   => $resBody
			);
		} else {
			$response = $res;
		}

		return $response;
	}

	public function validateClient( array $data ) {
		$json  = array(
			'urlPrefix' => strtolower( $data['subdomain'] )
		);
		$query = http_build_query( $json, '', '&' );
		$url   = $this->_host . '/api/validate/domain?' . $query;
		$res   = wp_remote_get( $url, $this->_request_args );

		if ( is_array( $res ) ) {
			$resCode  = $res['response']['code'];
			$resBody  = json_decode( $res['body'], true );
			$response = array(
				'http_code' => $resCode,
				'decoded'   => $resBody
			);
		} else {
			$response = $res;
		}

		return $response;
	}

	public function clientTrial( array $data ) {
		$now = \QAS\Utils::now();
		if ( isset( $data['testTeamSize'] ) ) {
			$returnValue = preg_split( '/(\D)/', $data['testTeamSize'], - 1 );
			for ( $i = count( $returnValue ) - 1; $i >= 0; $i -- ) {
				if ( is_numeric( $returnValue[ $i ] ) ) {
					$data['numberOfUsers'] = $returnValue[ $i ];
					break;
				}
			}
		}

		if(isset($data['urlPrefix'])) {
			$data['urlPrefix'] = strtolower( $data['urlPrefix'] );
		}
		if(isset($data['username'])) {
			$data['username'] = strtolower( $data['username'] );
		}

		$json = array(
			'data' => json_encode( $data )
		);

		$query = http_build_query( $json, '', '&' );
		$url   = $this->_host . '/api/client/trial?' . $query;
		$res   = \QAS\Utils::curlWrap( $url, '', 'POST', $this->_headers );

		$response = $res;

		return $response;
	}
}
