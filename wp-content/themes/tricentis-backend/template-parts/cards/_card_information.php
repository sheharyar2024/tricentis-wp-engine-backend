<?php
$post_type = get_post_type();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( "card card--{$post_type}" ); ?>>
	<header class="entry-header">
		<?php
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		?>
		<div class="entry-meta">
			<?php
			tricentis_backend_posted_on();
			tricentis_backend_posted_by();
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php tricentis_backend_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-<?php the_ID(); ?> -->