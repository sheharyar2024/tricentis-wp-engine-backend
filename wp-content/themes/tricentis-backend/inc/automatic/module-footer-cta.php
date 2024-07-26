<?php
/**
 * Encapsulates logic to display the footer cta, more can be added for special cases 
 * do_action( 'tricentis-backend/footer-cta/display' );
 */
new TricentisBackendFooterCta();
class TricentisBackendFooterCta{

	function __construct(){
		add_action( 'tricentis-backend/footer-cta/display', [ $this, 'display'] );
	}

	/**
	 * Determine what hero layout to display
	 */
	function display(){
		$setting = get_field( 'footer_cta_settings' );
		switch( $setting ){
			case 'off':
			default:
			break;

			//page specific footer_cta
			case 'on':
				if( have_rows( 'footer_cta' ) ):
					while( have_rows( 'footer_cta' ) ):
						the_row();
						get_template_part( 'template-parts/footer-cta' );
					endwhile;
				endif;
			break;

			//global footer_cta from settings page
			case 'global':
				if( get_field( 'global_footer_cta_display', 'options' ) ):
					if( have_rows( 'global_footer_cta', 'options' ) ):
						while( have_rows( 'global_footer_cta', 'options' ) ):
							the_row();
							get_template_part( 'template-parts/footer-cta' );
						endwhile;
					endif;
				endif;
			break;
		}
	}

}