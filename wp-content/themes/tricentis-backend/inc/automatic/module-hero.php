<?php
/**
 * Encapsulates logic to display the header, more can be added for special cases 
 * Default covers the hero module in page header and a default with filter
 * do_action( 'tricentis-backend/hero/display' );
 */
new TricentisBackendHero();
class TricentisBackendHero{

	function __construct(){
		add_action( 'tricentis-backend/hero/display', [ $this, 'display'] );
	}

	/**
	 * Determine what hero layout to display
	 */
	function display(){
		//This uses the page header -> hero
		if( have_rows( 'hero' ) ):
			while( have_rows( 'hero' ) ):
				the_row();
				get_template_part( 'template-parts/hero/layout', get_sub_field( 'hero_type' ) );
			endwhile;
		else:
			get_template_part( 'template-parts/hero/layout', apply_filters( 'tricentis-backend/hero/type', 'default' ) );
		endif;
	}

}