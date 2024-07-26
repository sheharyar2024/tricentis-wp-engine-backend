<?php
/**
 * Contains Alert feature - displays a site alert
 * Note there is a separate build procedure in case you want use the alert within another module as the ACF fields may conflict
 *
 * Use this action to build the alert while in the page scope
 * do_action( 'tricentis-backend/alert/build' );
 * Use this action to display the alert either in place or the build html within another module's scope
 * do_action( 'tricentis-backend/alert/display' );
 */
new TricentisBackendAlert();
class TricentisBackendAlert{
	protected $built = false;

	function __construct(){
		add_action( 'tricentis-backend/alert/display', [ $this, 'display' ] );
		add_action( 'tricentis-backend/alert/build', [ $this, 'build' ] );
	}

	/**
	 * Build html for later use
	 */
	function build(){
		ob_start();
		$this->display();
		$ret = ob_get_clean();
		$this->built = $ret;
	}

	/**
	 * Build and display alert content
	 */
	function display(){
		if( $this->built ){
			echo $this->built;
			return;
		}

		$setting = get_field( 'alert_settings' );
		switch( $setting ){
			case 'off':
			default:
			break;

			//page specific alert
			case 'on':
				if( have_rows( 'alert' ) ):
					while( have_rows( 'alert' ) ):
						the_row();
						get_template_part( 'template-parts/alert' );
					endwhile;
				endif;
			break;

			//global alert from settings page
			case 'global':
				if( get_field( 'global_alert_display', 'options' ) ):
					if( have_rows( 'global_alert', 'options' ) ):
						while( have_rows( 'global_alert', 'options' ) ):
							the_row();
							get_template_part( 'template-parts/alert' );
						endwhile;
					endif;
				endif;
			break;
		}
	}
}