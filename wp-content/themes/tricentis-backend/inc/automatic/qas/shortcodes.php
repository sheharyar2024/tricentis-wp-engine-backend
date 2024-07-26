<?php

function sc_ui_user_reviews( $attr, $content, $shortcode_tag ) {
	$attr = shortcode_atts( array(
		'name'       => '',
		'attachment' => 0,
		'title'      => '',
		'headline'   => '',
		'url'        => '',
		'rating'     => '',
		'date'       => '',
	), $attr, $shortcode_tag );
	// Shortcode callbacks must return content, hence, output buffering here.
	ob_start();

	if ( ! empty( $attr['url'] ) ) :
		?>

		<a class="gfour-review" href="<?php echo urldecode( $attr['url'] ); ?>" target="_blank" rel="noopener">
			<div class="rating <?php echo urldecode( $attr['rating'] ); ?>"></div>
			<h3 class="gfour-headline"><?php echo urldecode( $attr['headline'] ); ?></h3>
			<?php echo wpautop( wp_kses_post( $content ) ); ?>

			<div class="gfour-profile"
			     style="background-image:url(<?php echo wp_get_attachment_url( $attr['attachment'] ); ?>) ;"><?php echo wp_kses_post( wp_get_attachment_image( $attr['attachment'], array(
					50,
					50
				) ) ); ?></div>
			<div class="gfour-content">
				<h5 class="gfour-name"><b><?php echo urldecode( $attr['name'] ); ?></b>, <?php echo urldecode( $attr['title'] ); ?></h5>
                <h5 class="gfour-title">Read the Full Review</h5>
			</div>
		</a>

	<?php else : ?>

		<div class="gfour-review">
			<div class="rating <?php echo urldecode( $attr['rating'] ); ?>"></div>
			<h3 class="gfour-headline"><?php echo urldecode( $attr['headline'] ); ?></h3>
			<?php echo wpautop( wp_kses_post( $content ) ); ?>

			<?php if ( ! empty( $attr['attachment'] ) ) : ?>
				<div class="gfour-profile"
				     style="background-image:url(<?php echo wp_get_attachment_url( $attr['attachment'] ); ?>) ;"><?php echo wp_kses_post( wp_get_attachment_image( $attr['attachment'], array(
						50,
						50
					) ) ); ?></div>
			<?php endif; ?>

			<div class="gfour-content">
				<h5 class="gfour-name"><b><?php echo urldecode( $attr['name'] ); ?></b>, <?php echo urldecode( $attr['title'] ); ?></h5>
			</div>
		</div>

	<?php endif; ?>

	<?php
	return ob_get_clean();
}

add_shortcode( 'sc_user_reviews' , 'sc_ui_user_reviews' );
