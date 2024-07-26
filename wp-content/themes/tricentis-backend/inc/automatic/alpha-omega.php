<?php

new TricentisBackendAlphaOmega();

/**
 * Setup activation and deactivation functions
 */
class TricentisBackendAlphaOmega{

	function __construct(){
		add_action( 'after_switch_theme', [ $this, '_activation' ] );
		add_action( 'switch_theme', [ $this, '_deactivation' ] );
	}

	function _activation(){
		do_action( 'tricentis-backend/activate' );
	}

	function _deactivation(){
		do_action( 'tricentis-backend/deactivate' );
	}

}
