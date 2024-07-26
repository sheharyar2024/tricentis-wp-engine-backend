<?php
	while( have_rows( 'bkgi', $params['id'] ) ): the_row();
		$image = get_sub_field( 'image' );
		$mobile_image = get_sub_field( 'mobile_image' );
		$opacity = (int)get_sub_field( 'opacity' ) / 100;
?>
	<div class="background background--image">
		<?php echo wp_get_attachment_image( $image, 'full' ); ?>
	</div>
	<?php if( get_sub_field( 'use_opacity' ) ): ?>
		<div class="background background--opacity" style="opacity: <?php echo $opacity; ?>"></div>
	<?php endif; ?>
<?php endwhile; ?>