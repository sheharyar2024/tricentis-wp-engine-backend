<?php
/**
 * Default gallery assumes design is an image slider centered with navigation arrows 
 * look in assets/js/image-gallery.js for corresponding slider code
 */
$images = get_sub_field( 'images' );
if( count( $images ) === 0 ){
	return;
}
?>
<div class="container-lg">
	<div class="row">
		<div class="col">
			<div class="image-slider">
				<?php foreach( $images as $image_id ): ?>
					<div class="image-slider__image">
						<?php echo wp_get_attachment_image( $image_id, 'full' ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>