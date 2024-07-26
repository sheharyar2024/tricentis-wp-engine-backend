<div class="container-lg">
	<div class="row">
		<div class="col">
			
			<?php TricentisBackendSEOTextField::display(); ?>
			
			<?php if( '' != get_sub_field( 'description' ) ): ?>
				<div class="wysiwyg">
					<?php the_sub_field( 'description' ); ?>
				</div>
			<?php endif; ?>
			
			<?php TricentisBackendFormField::display(); ?>
		</div>
	</div>
</div>