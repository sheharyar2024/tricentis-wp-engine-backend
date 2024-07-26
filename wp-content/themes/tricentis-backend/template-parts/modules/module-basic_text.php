<div class="container-lg">
	<div class="row">
		<div class="col">

			<?php TricentisBackendSEOTextField::display( 'prehead', [ 'class' => 'prehead' ]); ?>
			<?php TricentisBackendSEOTextField::display(); ?>

			<?php if( '' != get_sub_field( 'description' ) ): ?>
				<div class="wysiwyg">
					<?php the_sub_field( 'description' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>