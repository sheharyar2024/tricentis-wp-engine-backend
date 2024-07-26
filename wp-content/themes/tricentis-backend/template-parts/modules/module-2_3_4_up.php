<?php

$block_count = count( get_sub_field('blocks') );
switch( $block_count ){
	case 4:
		$block_classes = ' col-12 col-sm-6 col-md-3';
	break;
	case 3:
		$block_classes = ' col-12 col-sm-6 col-md-3';
	break;
	default:
		$block_classes = ' col-12 col-sm-6 col-md-4';
	break;
}
?>
<div class="container-lg">
	<div class="row">
		<div class="col">
			<?php TricentisBackendSEOTextField::display(); ?>
		</div>
	</div>

	<?php if( have_rows( 'blocks' ) ): ?>
		<div class="row blocks">
			<?php while( have_rows( 'blocks' ) ): the_row();
				$link = get_sub_field('link');
				$image = get_sub_field('image');
				$link_attributes = tricentis_backend_link_attributes( $link, [
					'class' => 'block',
				] );
			?>
			<div class="col <?= $block_classes ?>">
				<a <?php echo $link_attributes; ?>>
					<div class="block__image">
						<?= wp_get_attachment_image( $image, 'medium' ); ?>
					</div>
					<div class="block__title"><?php echo $link['title']; ?></div>
				</a>
			</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>