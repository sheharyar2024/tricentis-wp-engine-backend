<?php
/**
 * For more complex logic or a lot of options, it may be better to break this out into separate files
 * ex. include( "media-type-{$media_type}.php" );
 */
$media_type = get_sub_field( 'media_type' );
switch( $media_type ):
	case 'none':
	break;
	default:
		$image = get_sub_field( 'image' );
		echo wp_get_attachment_image( $image['ID'], 'large' );
	break;
	case 'embed':
		$video_embed = get_sub_field( 'video_embed' );
		echo '<div class="responsive-embed">' . $video_embed . '</div>';
	break;
	case 'post_image':
		the_post_thumbnail( 'full' );
	break;
	case 'form':
		TricentisBackendFormField::display();
	break;

endswitch;