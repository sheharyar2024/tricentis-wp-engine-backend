<div class="social">

	<?php
	/**
	 * These are populated in theme settings > social media tab
	 * it is expected that an svg will be used for the icon, would need to change logic if that would be different
	 */
	if( have_rows( 'global_social_channels', 'options' ) ):
		while( have_rows( 'global_social_channels', 'options' ) ):
			the_row();
			$icon = get_sub_field( 'icon' );
			$link = [
				'url' => get_sub_fied( 'website' ),
				'target' => '_blank',
			];
	?>
		<a <?php echo tricentis_backend_link_attributes( $link, [ 'title' => get_sub_field( 'title' ) ] ); ?>><?php echo wp_get_attachment_image( $icon['ID'], 'full'); ?></a>
	<?php
		endwhile;
	endif; ?>

</div>