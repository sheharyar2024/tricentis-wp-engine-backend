<?php
	$allow_featured = (bool)$args['allow_featured'];
	$posts_per_page = ( $allow_featured )? 5 : 4;

	$resources = new WP_Query( [
		'post_type' => $args['type'],
		'posts_per_page' => $posts_per_page,
		'post_status' => 'publish',
		'orderby' => [
			'menu_order' => 'DESC',
			'date' => 'DESC',
		],
	] );
	if( $resources->have_posts() ):
		$num_posts = $resources->post_count;
		//if have less than max, we shouldn't have a large card
		if( $num_posts < $posts_per_page ){
			$allow_featured = false;
		}
?>
<div class="resource-archive__section col col-12">
	<div class="row">
		<div class="resource-archive__title-section col col-12 d-flex justify-content-between align-items-center">
			<div class="title"><?php echo esc_html( $args['section_label'] ); ?></div>
			<a class="button button--link" href="<?php echo esc_url( $args['link'] ); ?>#ResourceArchive"><?php echo esc_html( $args['view_all_label'] ); ?></a>
		</div>

		<?php
			if( $allow_featured ){
				//need 1 large card and 4 next to it
				$card_template = 'large';
				while( $resources->have_posts() ):
					$resources->the_post();
					get_template_part( 'template-parts/cards/card', $card_template );

					if( 'large' === $card_template ){
						echo '<div class="col col-lg-6">';
						echo '<div class="row resources-grid__card-subcontainer">';
					}

					//this triggers side by side cards - missing lg breakdown
					$card_template = 'small';
				endwhile;

				//close off additional column & row
				if( $allow_featured ){
					echo '</div>';
					echo '</div>';
				}

			}else{
				while( $resources->have_posts() ):
					$resources->the_post();
					get_template_part( 'template-parts/cards/card', 'archive' );
				endwhile;
			}
			wp_reset_postdata();
		?>

	</div>
</div>
<?php endif; ?>
