<?php
/**
 * General example of a manual relationship template when using the manual relationship example field
 */
//get the selected posts from admin
$posts = get_sub_field( 'posts' );
?>
<div class="container-lg">

	<?php //display module level content in separate row ?>
	<div class="row">
		<div class="col">
			<?php TricentisBackendSEOTextField::display(); ?>

			<?php if( '' != get_sub_field( 'description' ) ): ?>
				<div class="wysiwyg">
					<?php the_sub_field( 'description' ); ?>
				</div>
			<?php endif; ?>

			<?php TricentisBackendActionGroupField::display(); ?>
		</div>
	</div>

	<?php //add a class to this row for special top/bottom margin ?>
	<div class="row">
		<?php
		foreach( $posts as $post ):
			setup_postdata( $GLOBALS['post'] =& $post );//sets up WP loop functions
			//Display each post, either using code here or ideally in a separate template part for reuse
			get_template_part( 'template-parts/cards/card' );
		endforeach;
		wp_reset_postdata();//resets page data from our local loop
		?>
	</div>
</div>