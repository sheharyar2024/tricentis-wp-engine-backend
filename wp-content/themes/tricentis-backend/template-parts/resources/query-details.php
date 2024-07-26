<div class="col col-12 resource-archive-query resource-archive__query d-flex">
	<div class="resource-count resource-archive__count title"><?php echo sprintf( __( 'Showing %s out of %s Results for', 'tricentis-backend' ), $args['resources']->post_count, $args['resources']->found_posts ); ?>
		<span class="resource-selections resource-archive__selections title ml-2">
			<?php
				if( count( $args['selections'] ) > 0 ):
					echo '"', implode( '" "', $args['selections'] ), '"';
				endif;
			?>
		</span>
	</div>
	<div class="resource-clear resource-archive__clear">
		<a href="<?php echo esc_url( $args['clear_link'] ); ?>#ResourceArchive"><?php _e( 'Clear All', 'tricentis-backend' ); ?></a>
	</div>
</div>
