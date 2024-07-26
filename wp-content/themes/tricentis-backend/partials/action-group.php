<div class="button-group button-group--align-<?php echo $alignment; ?>">
	<?php
	while( have_rows( 'actions' ) ): 
		the_row();
		/*
		switch( get_sub_field( 'function' ) ){

		}
		*/
		$link = get_sub_field( 'link' );
		$type = ( '' !== $override_type )? $override_type : get_sub_field( 'display' );
		$seo_text = get_sub_field( 'seo_text' );
		if( '' == $seo_text ){
			$seo_text = $link['title'];
		}
		$ada_text = '';
		if( '' != ( $ada_text = get_sub_field( 'ada_text' ) ) ){
			$ada_text = '<span class="screen-reader-text">' . esc_html( $ada_text ) . '</span>';
		}
		$link_attributes = tricentis_backend_link_attributes( $link, [
			'class' => 'button '.$type,
			'title' => $seo_text,
			] );
	?>
		<a <?php echo $link_attributes; ?>><?php echo esc_html( $link['title'] ) . $ada_text; ?></a>
	<?php endwhile; ?>
</div>
