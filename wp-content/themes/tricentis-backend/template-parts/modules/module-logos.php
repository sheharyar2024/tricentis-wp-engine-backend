<?php
/**
 * General example of a configurable relationship template when using the configurable relationship example field
 */
$display_style = get_sub_field( 'display_style' );
$selection_method = get_sub_field( 'selection_type' );
$limit = get_sub_field( 'number_of_posts' );
if( (int)$limit <= 0 ){
	$limit = -1;
}
switch( $selection_method ){
	case 'query':
		//use any logic you want to here to limit query - it may make sense to display more choices in the ACF module to the user
		//https://developer.wordpress.org/reference/classes/wp_query/
		$args = [
			'post_status' => 'publish',
			'post_type' => ['logo'],	//make sure this matches your module
			'orderby' => 'menu_order date',	//default wp is by date, I like to use menu_order so user can have more control over order
			'exclude' => [ get_the_ID() ],	//if used on a single record, this helps prevent showing current page in list
			'posts_per_page' => $limit,
		];

		if( '' != ( $cat = get_sub_field( 'taxonomy' ) ) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'logo_tag',	//make sure this matches your module
					'field'    => 'term_id',
					'terms'    => $cat,
				),
			);
		}

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
	<?php switch( $display_style ): case 'grid': default: ?>
		<div class="row logos logos--<?php echo $display_style; ?>">
			<?php
			if( 'upload' == $selection_method ):
				while( have_rows( 'uploads' ) ): the_row();
					$title = get_sub_field( 'title' );
					$website = get_sub_field( 'website' );
					$image = get_sub_field( 'image' );
					$link = [
						'url' => $website,
						'target' => '_blank',
					];
				?>
				<div class="logo">
					<?php if( '' !== $website ): ?>
						<a <?php echo tricentis_backend_link_attributes( $link ); ?>><?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?></a>
					<?php else: ?>
						<?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?>
					<?php endif; ?>
				</div>
				<?php
				endwhile;
			else:
				foreach( $posts as $post ):
					setup_postdata( $GLOBALS['post'] =& $post );//sets up WP loop functions
					//Display each post, either using code here or ideally in a separate template part for reuse
					get_template_part( 'template-parts/cards/logo' );
				endforeach;
				wp_reset_postdata();//resets page data from our local loop
			endif;
			?>
		</div>
	<?php
		break;
		case 'slider':
			$logos_per_slide = get_sub_field( 'logos_per_slide' );
	?>
		<div class="js-logo-slider">
		<?php
		if( 'upload' == $selection_method ):
			$uploads = get_sub_field( 'uploads' );
			$rows = array_chunk( $uploads, $logos_per_slide );
			foreach( $rows as $row ){
				echo '<div>';
				echo '<div class="row logos-slide logos-slide--',$logos_per_slide,'">';
				foreach( $row as $upload ):
					$title = $upload['title'];
					$website = $upload['website'];
					$image = $upload['image'];
					$link = [
						'url' => $website,
						'target' => '_blank',
					];
				?>
				<div class="logo">
					<?php if( '' !== $website ): ?>
						<a <?php echo tricentis_backend_link_attributes( $link ); ?>><?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?></a>
					<?php else: ?>
						<?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?>
					<?php endif; ?>
				</div>
				<?php
				endforeach;
				echo '</div>';
				echo '</div>';
			}
		else:
			$rows = array_chunk( $posts, $logos_per_slide );
			
			foreach( $rows as $posts ):
				echo '<div>';
				echo '<div class="row logos-slide logos-slide--',$logos_per_slide,'">';
				foreach( $posts as $post ):
					setup_postdata( $GLOBALS['post'] =& $post );//sets up WP loop functions
					//Display each post, either using code here or ideally in a separate template part for reuse
					get_template_part( 'template-parts/cards/logo' );
				endforeach;
				echo '</div>';
				echo '</div>';
			endforeach;
			wp_reset_postdata();//resets page data from our local loop
		endif;
		?>
		</div>
	<?php break; ?>
	<?php endswitch; ?>
</div>