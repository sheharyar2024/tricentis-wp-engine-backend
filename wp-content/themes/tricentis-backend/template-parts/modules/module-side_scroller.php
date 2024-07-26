<?php
$sections = count( get_sub_field( 'sections' ) );
?>
<div class="side-scroller" data-side-scroller>
	<div class="container-lg">
		<div class="row side-scroller__row">
			<div class="col col-12 col-md-4">

				<div class="side-scroller__sticky">
					<?php TricentisBackendSEOTextField::display(); ?>

					<?php if( '' != get_sub_field( 'description' ) ): ?>
						<div class="wysiwyg">
							<?php the_sub_field( 'description' ); ?>
						</div>
					<?php endif; ?>

					<?php TricentisBackendActionGroupField::display(); ?>

					<div class="side-scroller__navigation">
						<?php for( $x = 0; $x < $sections; $x++ ): ?>
							<div class="side-scroller__navigation-index" data-side-scroller-nav-index="<?php echo $x; ?>"></div>
						<?php endfor; ?>
					</div>
				</div>

			</div>
			<div class="col col-12 col-md-8">
				<?php
					$i = 0;
					while( have_rows( 'sections' ) ):
						the_row();
				?>
					<div class="side-scroller__section" data-side-scroller-section-index="<?php echo $i; ?>">
						<div class="side-scroller__section__media-container">
							<?php TricentisBackendMediaGroupField::display(); ?>
						</div>

						<div class="side-scroller__section__content-container">
							<div class="side-scroller__section-title">
								<?php the_sub_field( 'title' ); ?>
							</div>
							<div class="side-scroller__section-description wysiwyg">
								<?php the_sub_field( 'description' ); ?>
							</div>
							<div class="side-scroller__cta">
								<?php TricentisBackendActionGroupField::display(); ?>
							</div>
						</div>
					</div>
				<?php $i++; endwhile; ?>
			</div>
		</div>
	</div>
</div>