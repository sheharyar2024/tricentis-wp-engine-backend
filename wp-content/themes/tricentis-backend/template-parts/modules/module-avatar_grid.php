<div class="container-lg">
	<div class="row">
		<div class="col">

			<?php TricentisBackendSEOTextField::display(); ?>

			<?php if( '' != get_sub_field( 'description' ) ): ?>
				<div class="wysiwyg">
					<?php the_sub_field( 'description' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>

	<?php //note the ul and li here. we have been told li items are more accessible for icon grids as they normally espouse features ?>
	<ul class="row cards">
		<?php while( have_rows( 'icons' ) ):
			the_row();
			$cta_count = TricentisBackendActionGroupField::count();
			$card_classes = ( 1 === $cta_count )? ' card--single-link' : '';
		?>
			<li class="col col-12 col-md-6 col-lg-4">
				<div class="card <?php echo $card_classes; ?>" role="group">
					<div class="card__content">
						<div class="card__icon">
							<?php TricentisBackendIconGroupField::display(); ?>
						</div>
						<div class="card__title"><?php the_sub_field( 'title' ); ?></div>
						<div class="card__wysiwyg wysiwyg"><?php the_sub_field( 'description' ); ?></div>
					</div>
					<?php if( $cta_count > 0 ): ?>
						<div class="card__footer">
							<?php TricentisBackendActionGroupField::display(); ?>
						</div>
					<?php endif; ?>
				</div>
			</li>
		<?php endwhile; ?>
	</ul>

	<div class="row">
		<div class="col col-12">
			<?php TricentisBackendActionGroupField::display(); ?>
		</div>
	</div>
</div>
