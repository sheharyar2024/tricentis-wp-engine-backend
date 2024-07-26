<?php
/**
 * Default of this module is to have 1 large featured card and 4 smaller cards in a grid next to it.
 * There is also a four on 1 row option possible if allow featured is turned off
 */

	$cta = get_sub_field( 'cta' );

	$allow_featured = get_sub_field( 'allow_featured' );
	$posts_per_page = ( $allow_featured )? 5 : 4;
	$selection_method = get_sub_field( 'selection_method' );

	//determine if we are querying for data or using hand selected posts
	switch( $selection_method ){
		case 'query':
			$args = [
				'post_status' => 'publish',
				'post_type' => get_sub_field( 'allowed_types' ),
				'orderby' => 'menu_order date',
				'posts_per_page' => $posts_per_page,
				'exclude' => [ get_the_ID() ],
			];

			if( '' != ( $cat = get_sub_field( 'taxonomy' ) ) ){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $cat,
					),
				);
			}

			$records = get_posts( $args );

		break;
		case 'manual':
			$records = get_sub_field( 'posts' );
		break;
	}

	$num_posts = count( $records );
	if( 0 === $num_posts ){
		return;
	}

	//if have less than max, we shouldn't have a large card
	if( $num_posts < $posts_per_page ){
		$allow_featured = false;
	}

	//if we have more than max, trim the extra
	if( $num_posts > $posts_per_page ){
		$records = array_slice( $records, 0, $posts_per_page );
	}
?>
<div class="resources-grid">
	<div class="container-lg">
		<div class="row">
			<div class="col col-12 col-md-8">
				<?php TricentisBackendSEOTextField::display(); ?>
			</div>
			<div class="col col-12 col-md-4">
				<?php if( ( $link = get_sub_field( 'cta' ) ) ): ?>
					<a <?php echo tricentis_backend_link_attributes( $link ); ?>><?php echo esc_html( $link['title'] ); ?></a>
				<?php endif; ?>
			</div>
		</div>

		<div class="row">
			<?php
				if( $allow_featured ){
					//need 1 large card and 4 next to it
					$post = array_shift( $records );
					setup_postdata( $GLOBALS['post'] =& $post );
					get_template_part( 'template-parts/cards/card', 'large' );

					echo '<div class="col col-lg-6">';
					echo '<div class="row">';

					//this triggers side by side cards - missing lg breakdown
					$card_template = 'small';
				}else{
					$card_template = 'medium';
				}

				foreach( $records as $post ):
					setup_postdata( $GLOBALS['post'] =& $post );
					get_template_part( 'template-parts/cards/card', $card_template );
				endforeach;
				wp_reset_postdata();

				//close off additional column & row
				if( $allow_featured ){
					echo '</div>';
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>