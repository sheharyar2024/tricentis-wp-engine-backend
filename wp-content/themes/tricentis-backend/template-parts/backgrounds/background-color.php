<?php
	while( have_rows( 'bkgc', $params['id'] ) ): the_row();
		$location = get_sub_field( 'location' );
		$color = get_sub_field( 'color' );
		$classes = [];
		$classes[] = "background--{$color}";
		$classes[] = "background--{$location}";
?>
	<div class="background <?php echo implode( ' ', $classes ); ?>"></div>
<?php endwhile; ?>