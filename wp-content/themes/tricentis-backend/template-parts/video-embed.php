<?php
extract( $args );
?>
<div class="responsive-embed js-embed" data-video-id="<?php echo esc_attr( $id ); ?>" data-video-service="<?php echo esc_attr( $service ); ?>">
	<?php echo $html; ?>
	<button class="responsive-embed__play-button" aria-label="<?php _e("Play Video", 'tricentis-backend' ); ?>">
		<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>">
	</button>
</div>