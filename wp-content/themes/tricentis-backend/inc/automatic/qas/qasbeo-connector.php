<?php

namespace QAS;

class qbeoConnector {
	protected $_host = 'https://4qcf6g7vuc.execute-api.ap-northeast-1.amazonaws.com/prod/qas-ws/mrkt';
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

	public function mktClientTrialInfo( array $data ) {
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
		if ( isset( $data['password'] ) ) {
			$data['authkey']  = base64_encode( $data['password'] );
			$data['password'] = null;
			unset( $data['password'] );
		}

		$data['env'] = isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ? $_ENV['PANTHEON_ENVIRONMENT'] : '';

		$postData = array(
			'data' => $data
		);

		$url = $this->_host;
		$res = \QAS\Utils::curlWrap( $url, json_encode( $postData ), 'POST', $this->_headers );

		$response = $res;

		return $response;
	}
}
