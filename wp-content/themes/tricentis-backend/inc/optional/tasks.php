<?php

new TricentisBackendTasks();

/**
 * This class is here for illustrative purposes in case you need to run a periodic process
 * Or a manual one via link
 */
class TricentisBackendTasks{

	function __construct(){
		$this->_setup_scheduled_tasks();
		add_action( 'admin_init', array( $this, '_manual_tasks' ) );
	}

	/**
	 * Example to setup scheduled process using wp "cron"
	 */
	function _setup_scheduled_tasks(){

		$tasks = apply_filters( 'tricentis-backend/tasks', [
			'some-process' => 'twicedaily',
		];

		foreach( $tasks as $task => $schedule ){
			$next_run = wp_next_scheduled( "tricentis-backend/{$task}" );
			if( false === $next_run ){
				wp_schedule_event( time(), $schedule, "tricentis-backend/{$task}" );
			}
		}

	}

	/**
	 * Setup a way to manually run a process
	 */
	function _manual_tasks(){
		if( !isset( $_GET['tricentis-backend-action'] ) ){
			return;
		}

		do_action( 'tricentis-backend/' . $_GET['tricentis-backend-action'] );
		wp_redirect( add_query_arg( 'tricentis-backend-action', false ) );
		exit;
	}
}
