<?php
	while( have_rows( 'bkgv', $params['id'] ) ): the_row();
		$mobile_image = get_sub_field( 'mobile_image' );
		$opacity = (int)get_sub_field( 'opacity' ) / 100;
		if( have_rows( 'video_sources' ) ):
?>
		<video autoplay muted loop playsinline class="background background--video">
			<?php while( have_rows( 'video_sources' ) ): the_row(); $video = get_sub_field( 'source' ); ?>
				<source src="<?php echo esc_url( $video['url'] ); ?>" type="<?php echo esc_attr( $video['mime_type' ] ); ?>">
			<?php endwhile; ?>
		</video>
		<?php if( get_sub_field( 'use_opacity' ) ): ?>
			<div class="background background--opacity" style="opacity: <?php echo $opacity; ?>"></div>
		<?php endif; ?>
	<?php endif; ?>
<?php endwhile; ?>