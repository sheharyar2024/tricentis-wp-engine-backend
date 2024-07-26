<?php
/**
 * General example of a configurable relationship template when using the configurable relationship example field
 */
$selection_method = get_sub_field( 'selection_type' );
switch( $selection_method ){
	case 'query':
		//use any logic you want to here to limit query - it may make sense to display more choices in the ACF module to the user
		//https://developer.wordpress.org/reference/classes/wp_query/
		$args = [
			'post_status' => 'publish',
			'post_type' => ['case_study'],	//make sure this matches your module
			'orderby' => 'menu_order date',	//default wp is by date, I like to use menu_order so user can have more control over order
			'exclude' => [ get_the_ID() ],	//if used on a single record, this helps prevent showing current page in list
			'posts_per_page' => get_sub_field( 'number_of_posts' ),
		];

		$posts = get_posts( $args );

	break;
	case 'manual':
		$posts = get_sub_field( 'posts' );
	break;
}
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
		<div class="col">
			<div class="js-case-study-slider">
				<?php
				foreach( $posts as $post ):
					setup_postdata( $GLOBALS['post'] =& $post );//sets up WP loop functions
					//Display each post, either using code here or ideally in a separate template part for reuse
					get_template_part( 'template-parts/cards/case_study' );
				endforeach;
				wp_reset_postdata();//resets page data from our local loop
				?>
			</div>
		</div>
	</div>
</div>