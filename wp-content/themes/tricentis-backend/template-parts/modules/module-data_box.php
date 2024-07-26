<div class="container-lg">
	<div class="row">
		<div class="col">
			<div class="content">

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

	<!-- Data Boxes -->
	<?php if( have_rows('boxes') ): ?>
		<div class="row module--data-box__boxes">
			<?php while(have_rows('boxes')): the_row(); ?>
				<div class="col col-12 col-md-6">
					<div class="data-box">
						<div class="data-box__title"><?the_sub_field('title'); ?></div>
						<?php if( '' != get_sub_field( 'description' ) ): ?>
							<div class="wysiwyg data-box__wysiwyg">
								<?php the_sub_field( 'description' ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>

</div>
