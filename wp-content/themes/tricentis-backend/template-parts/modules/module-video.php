<?php
/**
 * There are a lot of things that may be desired here from design 
 * By default we display content over an the image and the play button opens a modal 
 * Youtube, vimeo and wistia are supported by current js. If not all needed, please edit javascript to make it lighter
 */
$unique_id = 'Video'.$args['module_id'];
$image = get_sub_field( 'image' );
//this returns an embed code, need to process to get the url
$video_embed = get_sub_field( 'video_url' );
TricentisBackendVideoHelper()->load_from_iframe( $video_embed );
$video_id = TricentisBackendVideoHelper()->id();
$video_class = "js-".TricentisBackendVideoHelper()->service()."-video";
?>
<div class="container-lg">
	<div class="row">
		<div class="col">
			<div class="module--video__container">
				<div class="module--video__image">
					<?php if( $image ): 
						echo wp_get_attachment_image( $image['ID'], 'large' );
					else:
						$image = TricentisBackendVideoHelper()->image();
					?>
					<img src="<?php echo $image; ?>" alt="" loading="lazy">
					<?php endif; ?>
				</div>
				<div class="module--video__content">
					
					<?php TricentisBackendSEOTextField::display(); ?>
					
					<?php if( '' != get_sub_field( 'description' ) ): ?>
						<div class="wysiwyg">
							<?php the_sub_field( 'description' ); ?>
						</div>
					<?php endif; ?>
					
					<div class="module--video__play">
						<button id="<?php echo esc_attr( $unique_id ); ?>" class="module--<?php echo get_row_layout(); ?>__play__button <?php echo $video_class; ?>" data-video="<?php echo esc_attr($video_id); ?>">
							Play Video
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>