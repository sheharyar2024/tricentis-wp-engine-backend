<?php
$content_side = get_sub_field( 'content_side' );
$row_classes = 'content-on-left';
if( 'right' === $content_side ){
	$row_classes = 'content-on-right';
}

$content_size = get_sub_field( 'content_size' );
switch( $content_size ){
	case 'size-3-4':
		$media_classes = 'col col-12 col-md-6 col-lg-3';
		$text_classes = 'col col-12 col-md-6 col-lg-9';
	break;
	case 'size-2-3':
		$media_classes = 'col col-12 col-md-6 col-lg-4';
		$text_classes = 'col col-12 col-md-6 col-lg-8';
	break;
	case 'size-7-12':
		$media_classes = 'col col-12 col-md-6 col-lg-5';
		$text_classes = 'col col-12 col-md-6 col-lg-7';
	break;
	case 'size-1-2':
	default:
		$media_classes = 'col col-12 col-sm-6';
		$text_classes = 'col col-12 col-sm-6';
	break;
	case 'size-5-12':
		$media_classes = 'col col-12 col-md-6 col-lg-7';
		$text_classes = 'col col-12 col-md-6 col-lg-5';
	break;
	case 'size-1-3':
		$media_classes = 'col col-12 col-md-6 col-lg-8';
		$text_classes = 'col col-12 col-md-6 col-lg-4';
	break;
	case 'size-1-4':
		$media_classes = 'col col-12 col-md-6 col-lg-9';
		$text_classes = 'col col-12 col-md-6 col-lg-3';
	break;
}

?>
<div class="container-lg">
	<div class="row module--left_right__row <?php echo $row_classes; ?>" role="group">

		<div class="media-container <?php echo $media_classes; ?>">
			<?php TricentisBackendMediaGroupField::display(); ?>
		</div>

		<div class="content-container <?php echo $text_classes; ?>">

			<?php TricentisBackendSEOTextField::display( 'prehead', [ 'class' => 'prehead' ]); ?>

			<?php TricentisBackendSEOTextField::display(); ?>

			<?php if( '' != get_sub_field( 'description' ) ): ?>
				<div class="wysiwyg">
					<?php the_sub_field( 'description' ); ?>
				</div>
			<?php endif; ?>

			<?php TricentisBackendActionGroupField::display(); ?>

		</div>
	</div>
</div>